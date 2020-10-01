<template>
  <!-- Course info -->
  <div id="price-card" class="ed_view_box style_3">
    <div class="property_video sm">
      <div class="thumb">
        <img
          class="pro_img img-fluid w100"
          src="https://sbrfiles.s3.amazonaws.com/images/cover.png"
          alt="7.jpg"
        />
        <div class="overlay_icon">
          <a
            v-if="preview"
            id="play-video"
            class="video-play-button"
            @click.prevent="videoOverlay = true"
            href="#"
          >
            <span></span>
          </a>
          <div
            v-if="preview != null"
            id="video-overlay"
            class="video-overlay"
            :class="videoOverlay == true ? 'open' : ''"
          >
            <a @click.prevent="closeVideo()" class="video-overlay-close"
              >&times;</a
            >
            <div id="player-container" class="player-container">
              <video id="preview" v-if="preview" controls>
                <source
                  :src="$getUrlToContents() + 'preview/' + preview + ''"
                  type="video/mp4"
                />
              </video>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ed_view_price pl-4 m-b-40">
      <span>{{ lang['current-price'] }}</span>
      <span v-if="price == null" class="facts-1">{{
        lang['free-course']
      }}</span>
      <h2 v-else :style="primaryColor" class="theme-cl">
        {{ this.currency }} {{ price }}
      </h2>
    </div>

    <div class="ed_view_link">
      <!----------------------
        Free course
      ----------------------->
      <div v-if="price == null">
        <!-- Active session -->
        <div v-if="session == true">
          <!-- Already registered -->
          <div v-if="registeredUser == true">
            <router-link
              :style="primaryColorBg"
              class="btn btn-theme enroll-btn"
              :to="'/viewcourse/' + courseId"
            >
              {{ lang['go-to-course'] }}
              <i class="ti-angle-right"></i>
            </router-link>
          </div>

          <!-- Unregistered user -->
          <div v-else>
            <a
              :style="primaryColorBg"
              href="javascript:void(0)"
              @click.prevent="enrollFreeCourse()"
              class="btn btn-theme enroll-btn"
            >
              {{ lang['enroll-now'] }}
              <i class="ti-angle-right"></i>
            </a>
          </div>
        </div>

        <!-- Inactive session -->
        <div v-else>
          <a
            :style="primaryColorBg"
            href="javascript:void(0)"
            @click.prevent="openLeadModal()"
            class="btn btn-theme enroll-btn"
          >
            {{ lang['enroll-now'] }}
            <i class="ti-angle-right"></i>
          </a>
        </div>
      </div>

      <!----------------------
        Paid course
      ----------------------->
      <div v-else>
        <!-- Active session -->
        <div v-if="session == true">
          <!-- Already registered -->
          <div v-if="registeredUser == true">
            <router-link
              :style="primaryColorBg"
              class="btn btn-theme enroll-btn"
              :to="'/viewcourse/' + courseId"
            >
              {{ lang['go-to-course'] }}
              <i class="ti-angle-right"></i>
            </router-link>
          </div>

          <!-- Unregistered user -->
          <div v-else>
            <!-- Mercado pago -->
            <div v-if="paymentPlatform == 'mercadopago'">
              <form
                :action="this.$getCurrentDomainName() + 'payment/process'"
                method="POST"
                v-if="preferenceId != null"
              >
                <script
                  v-if="link != null"
                  :src="link"
                  :data-preference-id="preferenceId"
                  type="application/javascript"
                ></script>
              </form>
            </div>
            <!-- Paypal -->
            <div v-else>
              <div id="pbutton1">
                <paypal-button
                  name="pbutton1"
                  v-if="courseId"
                  :currency="currency"
                  :price="price"
                  :course-id="this.courseId"
                ></paypal-button>
              </div>
            </div>
          </div>
        </div>

        <!-- inactive session -->
        <div v-else>
          <a
            @click.prevent="openAccountModal()"
            :style="primaryColorBg"
            href="javascript:void(0)"
            class="btn btn-theme enroll-btn"
          >
            {{ lang['enroll-now'] }}
            <i class="ti-angle-right"></i>
          </a>
        </div>
      </div>
    </div>

    <!----------------------
      Create account modal
    ----------------------->
    <el-dialog
      :visible.sync="modal"
      :title="lang['create-account']"
      center
      top="5vh"
    >
      <div v-if="createAnAccount" class="fade-in">
        <el-alert
          show-icon
          :title="lang['create-account-to-continue']"
          type="info"
        ></el-alert>
        <form
          id="form-account"
          @submit.prevent="createNewAccount()"
          v-loading="loading"
          class="form-login text-center border border-light p-5"
        >
          <input
            required
            type="text"
            name="name"
            class="form-control mb-4"
            :placeholder="lang['name']"
          />

          <input
            required
            type="email"
            name="email"
            class="form-control mb-4"
            placeholder="E-mail"
          />

          <input
            v-model="password"
            required
            type="password"
            name="password"
            class="form-control mb-4"
            :placeholder="lang['password']"
          />

          <input
            v-model="confirmPassword"
            required
            type="password"
            class="form-control mb-4"
            :placeholder="lang['confirm-password']"
          />

          <input type="text" name="role" value="3" class="hide" />

          <!-- Sign in button -->
          <button
            :style="primaryColorBg"
            class="btn btn-theme account-btn"
            type="submit"
          >
            {{ lang['create-account'] }}
          </button>

          <div class="options text-center">
            <p class="pt-1">
              {{ lang['already-have-account'] }}
              <a
                :style="primaryColor"
                href="javascript:void(0)"
                @click="
                  createAnAccount = false;
                  login = true;
                "
                >Log In</a
              >
            </p>
          </div>
        </form>
      </div>

      <!-- Login -->
      <div v-if="login" class="fade-in">
        <form
          @submit.prevent="doLogin"
          id="form-login"
          v-loading="loading"
          class="form-login text-center border border-light p-5"
        >
          <el-alert
            @close="wrongPasswordOrUser = false"
            :title="lang['wrong-password']"
            type="error"
            v-if="wrongPasswordOrUser == true"
            show-icon
          ></el-alert>
          <br />
          <!-- Email -->
          <input
            type="email"
            name="email"
            id="defaultLoginFormEmail"
            class="form-control mb-4"
            placeholder="E-mail"
          />
          <!-- Password -->
          <input
            type="password"
            id="defaultLoginFormPassword"
            name="password"
            class="form-control mb-4"
            placeholder="Password"
          />

          <div class="d-flex justify-content-around">
            <div>
              <!-- Forgot password -->
              <a
                :style="primaryColor"
                href="javascript:void(0)"
                @click="modalRecover = true"
                >Forgot password?</a
              >
            </div>
          </div>

          <!-- Sign in button -->
          <button
            :style="primaryColorBg"
            class="btn btn-theme account-btn"
            type="submit"
          >
            Sign in
          </button>

          <!-- Register -->
          <p>
            {{ lang['not-a-member'] }}
            <a
              :style="primaryColor"
              @click="
                login = false;
                createAnAccount = true;
              "
              href="javascript:void(0)"
              >{{ lang['register'] }}</a
            >
          </p>
        </form>
      </div>

      <div v-loading="loadingPayment" v-if="proceedToPayment" class="fade-in">
        <div class="row">
          <div class="col-8 mt-3">
            <h2 class="fw-600" :style="primaryColor">
              {{ lang['congratulations'] }}
            </h2>
            <h5 class="fw-600">{{ lang['you-are-logged-in-now'] }}</h5>
            <!-- Mercadopago -->
            <div v-if="paymentPlatform == 'mercadopago'">
              <form
                v-if="preferenceId != null"
                :action="this.$getCurrentDomainName() + 'payment/process'"
                method="POST"
              >
                <script
                  v-if="link != null"
                  :src="link"
                  :data-preference-id="preferenceId"
                  type="application/javascript"
                ></script>
              </form>
            </div>

            <!-- Paypal -->
            <div v-else>
              <div id="pbutton2">
                <paypal-button
                  name="pbutton2"
                  v-if="courseId"
                  :currency="currency"
                  :price="price"
                  :course-id="this.courseId"
                ></paypal-button>
              </div>
            </div>
          </div>

          <div class="col-4">
            <img
              style="
                width: 80%;
                margin-right: 0px;
                margin-left: calc(20% + 41px);
                margin-top: -35%;
              "
              src="@/assets/img/general/ux/payment_proceed.png"
              alt="payment_proceed"
            />
          </div>
        </div>
      </div>
    </el-dialog>
    <lead-create :course-id="this.courseId"></lead-create>
  </div>
</template>

<script>
import Vue from 'vue';
import LeadCreate, { eventLead } from '@/components/leads/LeadCreate';
import PaypalButton from '@/components/payment/Paypal';
import VuePlyr from 'vue-plyr';
import { mapState } from 'vuex';
import { eventLogin } from '@/components/login/Login';

const md5 = require('md5');

Vue.use(VuePlyr, {
  plyr: {
    fullscreen: { enabled: true }
  },
  emit: ['ended']
});

export default {
  data: () => {
    return {
      session: false,
      registeredUser: false,
      userId: '',
      modal: false,
      createAnAccount: true,
      login: false,
      loading: false,
      loadingPayment: false,
      password: '',
      confirmPassword: '',
      proceedToPayment: false,

      videoOverlay: false,

      preferenceId: null,
      wrongPasswordOrUser: false,
      mpAccessToken: '',
      link: null
    };
  },
  components: {
    LeadCreate,
    PaypalButton
  },
  props: [
    'description',
    'color',
    'price',
    'course-id',
    'course-title',
    'preview',
    'payment-platform',
    'currency'
  ],
  mounted() {
    this.checkEnrolledUser();
    this.checkActiveSession();
    this.getUserProfile();
    this.priceCardSticky();
  },
  methods: {
    enrollFreeCourse() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'enrollUserIntoCourse'
      );
      formData.set('courseId', this.courseId);
      formData.set('userId', this.userId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$router.push('/viewcourse/' + this.courseId + '');
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    priceCardSticky() {
      window.addEventListener('scroll', () => {
        const header = document.getElementById('price-card');
        const playerContainer = document.getElementById('player-container');
        const h = document.documentElement;
        const b = document.body;
        const st = 'scrollTop';
        const sh = 'scrollHeight';
        const percent =
          ((h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight)) * 100;
        header.classList.toggle('sticky', percent > 20);
        if (playerContainer) {
          playerContainer.classList.toggle('sticky', percent > 20);
        }
      });
    },
    getMpAccessToken() {
      this.loadingPayment = true;
      // Get credentials
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'getIntegrations'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.createMpPreference(
            this.courseTitle,
            this.price,
            this.courseId,
            response.data.mp_access_token
          );
          this.loadingPayment = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    createMpPreference(courseTitle, coursePrice, courseId, token) {
      // Mercado pago SDK
      const mercadopago = require('mercadopago');

      mercadopago.configure({
        sandbox: false,
        access_token: token
      });

      const preference = {
        items: [
          {
            title: courseTitle,
            unit_price: parseInt(
              coursePrice.split('.').join('').split(',').join('.')
            ),
            quantity: 1
          }
        ],
        payment_methods: {
          installments: 1
        },
        external_reference: courseId
      };

      // Create a preference
      mercadopago.preferences.create(preference).then((res) => {
        /* Mexico */
        if (res.response.site_id === 'MLM') {
          this.link =
            'https://www.mercadopago.com.mx/integrations/v1/web-payment-checkout.js';
        }

        /* Argetina */
        if (res.response.site_id === 'MLA') {
          this.link =
            'https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js';
        }

        /* Uruguay */
        if (res.response.site_id === 'MLU') {
          this.link =
            'https://www.mercadopago.com.uy/integrations/v1/web-payment-checkout.js';
        }

        /* Colombia */
        if (res.response.site_id === 'MCO') {
          this.link =
            'https://www.mercadopago.com.co/integrations/v1/web-payment-checkout.js';
        }

        /* Chile */
        if (res.response.site_id === 'MLC') {
          this.link =
            'https://www.mercadopago.cl/integrations/v1/web-payment-checkout.js';
        }

        /* Brasil */
        if (res.response.site_id === 'MLB') {
          this.link =
            'https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js';
        }

        /* Peru */
        if (res.response.site_id === 'MPE') {
          this.link =
            'https://www.mercadopago.com.pe/integrations/v1/web-payment-checkout.js';
        }

        /* Venezuela */
        if (res.response.site_id === 'MLV') {
          this.link =
            'https://www.mercadopago.com.ve/integrations/v1/web-payment-checkout.js';
        }

        this.preferenceId = res.response.id;
        this.savePreferenceId(md5(res.response.id));
      });

      localStorage.setItem('purchase_reference', courseId);
    },
    savePreferenceId(preferenceId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'savePreferenceId'
      );
      formData.set('preferenceId', preferenceId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {},
        () => {
          this.$errorMessage();
        }
      );
    },
    createNewAccount() {
      if (this.password === this.confirmPassword) {
        this.loading = true;
        const form = document.getElementById('form-account');
        const formData = new FormData(form);
        const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
          'user',
          'create'
        );
        this.$request.post(urlToBeUsedInTheRequest, formData).then(
          (response) => {
            if (response.data === false) {
              this.$userAlreadyExists();
              this.loading = false;
            } else {
              this.doLoginFromCreateAccountModal();
            }
          },
          () => {
            this.$errorMessage();
          }
        );
      } else {
        this.$diferentPasswords();
      }
    },

    doLoginFromCreateAccountModal() {
      this.loading = true;
      const form = document.getElementById('form-account');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'Login',
        'doLogin'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          if (response.data === true) {
            this.login = false;
            this.createAnAccount = false;
            this.proceedToPayment = true;
            this.checkActiveSession();
            eventLogin.$emit('new-login');
          } else {
            this.wrongPasswordOrUser = true;
          }
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    closeVideo() {
      this.videoOverlay = false;
      const video = document.getElementById('preview');
      video.pause();
    },
    doLogin() {
      this.loading = true;
      const form = document.getElementById('form-login');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'Login',
        'doLogin'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          if (response.data === true) {
            this.login = false;
            this.createAnAccount = false;
            this.proceedToPayment = true;
            this.checkActiveSession();
            eventLogin.$emit('new-login');
          } else {
            this.wrongPasswordOrUser = true;
          }
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    openAccountModal() {
      this.modal = true;
    },
    openLeadModal() {
      eventLead.$emit('open-lead-modal');
    },
    createCustomClass() {
      /* Create custom classes */
      const style = document.createElement('style');
      style.type = 'text/css';
      style.innerHTML =
        '.video-play-button span {display: block;position: relative;z-index: 3;width: 0;height: 0;border-left: 32px solid ' +
        this.color +
        ';border-top: 22px solid transparent;border-bottom: 22px solid transparent;}.mercadopago-button{background-color: ' +
        this.color +
        ' !important;text-transform:uppercase !important;}.property_video:before {background: ' +
        this.color +
        ";left: 0;right: 0;top: 0;position: absolute;content: '';bottom: 0;opacity: 0.7;border-radius: 1rem;}";
      document.getElementsByTagName('head')[0].appendChild(style);
    },
    checkEnrolledUser() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'userIsInCourse'
      );
      formData.set('courseId', this.courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.registeredUser = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getUserProfile() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getUserProfile'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.userId = response.data.id;
      });
    },
    checkActiveSession() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'mysessions',
        'activeSession'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.session = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  },
  watch: {
    color() {
      this.createCustomClass();
    },
    courseId() {
      this.checkEnrolledUser();
      if (this.price !== null && this.paymentPlatform === 'mercadopago') {
        this.getMpAccessToken();
      }
    }
  },

  computed: {
    primaryColorBg() {
      return {
        'background-color': this.color
      };
    },
    primaryColor() {
      return {
        color: this.color
      };
    },
    ...mapState(['lang'])
  }
};
</script>

<style scoped>
/* =============
   Layout
============= */
.thumb {
  background-color: #ffffff;
  border-radius: 3px;
  -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.1);
  box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.1);
  padding-bottom: 0px;
  padding-left: 0px;
  padding-right: 0px;
  padding-top: 0px;
  width: 100%;
  margin-top: 0 !important;
}

.ed_view_box {
  width: 25%;
  border: 4px solid #f4f8fa;
  display: block;
  position: fixed;
  border-radius: 0.5rem;
  background: #fff;
  padding: 12px;
  top: 0;
  margin: 120px 2% 0% 0%;
  transition: 1s;
}

.ed_title {
  margin-right: 15% !important;
}

.ed_view_box.style_3 {
  padding: 0px 0px 10px 0px;
  border-radius: 0.5rem;
}

.ed_view_box.sticky {
  position: fixed !important;
  animation: smoothScroll 1.5s forwards;
  top: 0;
  margin: 75px 2% 0% 0%;
  z-index: 20000;
}

.btn {
  display: inline-block;
  font-weight: 400;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  border: 1px solid transparent;
  padding: 12px 25px;
  font-size: 1rem;
  line-height: 1.25;
  border-radius: 0.25rem;
  transition: all 0.15s ease-in-out;
  border: 2px solid transparent;
  cursor: pointer;
}

.property_video .thumb .pro_img {
  width: 100%;
  object-fit: cover;
}

@keyframes smoothScroll {
  0% {
    transform: translateY(100%);
  }
  100% {
    transform: translateY(0%);
  }
}

.ed_view_box .property_video.sm {
  margin-bottom: 1rem;
}

.property_video {
  position: relative;
}

.ed_view_box.style_3 .property_video .thumb,
.ed_view_box.style_3 .property_video:before {
  border-radius: 0 !important;
}

ed_view_box.style_3 .property_video .thumb,
.ed_view_box.style_3 .property_video:before {
  border-radius: 0;
}

.property_video.sm .thumb .pro_img {
  min-height: 220px;
  max-height: 220px;
}

.ed_view_price,
.ed_view_features,
.ed_view_link {
  display: block;
  margin-bottom: 1rem;
  padding-left: 10px;
}

.ed_view_price span {
  font-size: 13px;
}

.ed_view_price,
.ed_view_features,
.ed_view_link {
  display: block;
  margin-bottom: 1rem;
  padding-left: 10px;
}

.ed_view_link .enroll-btn {
  width: 80%;
  margin: 1.5rem auto 0;
  display: flex;
  height: 54px;
  font-weight: 600;
  border-radius: 50px;
  color: #fff !important;
  align-items: center;
  justify-content: center;
}

.account-btn {
  width: 60%;
  margin: 1.5rem auto 0;
  display: flex;
  height: 44px;
  font-weight: 600;
  border-radius: 50px;
  color: #fff !important;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem !important;
}

span.facts-1 {
  background: rgba(33, 177, 124, 0.13);
  color: #21b17c;
}

.ed_view_price span {
  padding: 3px 8px;
  font-size: 13px;
  position: relative;
  background: #f4f5f7;
  border-radius: 0 2px 2px 0;
  display: inline-block;
  margin-right: 0.8rem;
}

span.facts-1:before {
  border-left-color: rgba(33, 177, 124, 0.13);
}

.ed_view_price span:before {
  border-top: 12px solid transparent;
  border-left: 10px solid #eaedf3;
  border-bottom: 13px solid transparent;
  content: '';
  height: 0;
  position: absolute;
  top: 0;
  right: -10px;
  width: 0;
}

.ed_view_price span:after {
  background-color: #fff;
  border-radius: 50%;
  content: '';
  height: 4px;
  position: absolute;
  top: 10px;
  right: -5px;
  width: 4px;
}

/* =============
   Fonts
============= */
h1,
h2,
h3,
h4,
h5,
h6 {
  font-family: 'Poppins', sans-serif;
  word-break: break-word !important;
  color: #2d3954;
}

h1 {
  line-height: 40px;
  font-size: 36px;
}

h2 {
  line-height: 36px;
  font-size: 30px;
}

h3 {
  line-height: 30px;
  font-size: 24px;
}

h4 {
  line-height: 26px;
  font-size: 21px;
}

a {
  color: #4a5682;
  text-decoration: none;
  background-color: transparent;
  -webkit-text-decoration-skip: objects;
}

/* =============
  video overlay
============= */

.player-container {
  width: 560px;
  display: block;
  margin: 0 auto;
  margin-top: 10%;
}

.player-container.sticky {
  max-width: 100%;
  display: block;
  margin: 0 auto;
  margin-top: 0%;
}

.player-container video {
  max-width: 100%;
}

.video-play-button {
  position: absolute;
  z-index: 10;
  margin-top: 0%;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
  box-sizing: content-box;
  display: block;
  width: 32px;
  height: 44px;
  /* background: #fa183d; */
  border-radius: 50%;
  padding: 18px 20px 18px 28px;
}

.video-play-button:before {
  content: '';
  position: absolute;
  z-index: 0;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
  display: block;
  width: 80px;
  height: 80px;
  background: white;
  opacity: 0.5;
  border-radius: 50%;
  animation: pulse-border 1500ms ease-out infinite;
}

.video-play-button:after {
  content: '';
  position: absolute;
  z-index: 1;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
  display: block;
  width: 80px;
  height: 80px;
  background: white;
  border-radius: 50%;
  transition: all 200ms;
}

.video-play-button:hover:after {
  background-color: darken(#09aec7, 10%);
}

.video-play-button img {
  position: relative;
  z-index: 3;
  max-width: 100%;
  width: auto;
  height: auto;
}

@keyframes pulse-border {
  0% {
    transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1.5);
    opacity: 0;
  }
}

.video-overlay {
  position: fixed;
  z-index: -1;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.8);
  opacity: 0;
  transition: all ease 500ms;
}

.video-overlay.open {
  position: fixed;
  z-index: 1000;
  opacity: 1;
}

.video-overlay-close {
  position: absolute;
  z-index: 1000;
  top: 20%;
  right: 10%;
  font-size: 36px;
  line-height: 1;
  font-weight: 400;
  color: #fff;
  text-decoration: none;
  cursor: pointer;
  transition: all 200ms;
}

.video-overlay-close:hover {
  color: #09aec7;
}

.video-overlay iframe {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
  /* width: 90%; */
  /* height: auto; */
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.75);
}

/* =============
  Mobile
============= */
@media only screen and (max-width: 600px) {
  .ed_view_box {
    display: block;
    position: relative;
    border-radius: 0.5rem;
    background: #fff;
    padding: 12px;
    margin-bottom: 30px;
    margin-top: 0%;
    transition: 1s;
    width: 100%;
  }

  .ed_title {
    margin-right: 0% !important;
  }

  .player-container {
    width: 100%;
  }
}
</style>
