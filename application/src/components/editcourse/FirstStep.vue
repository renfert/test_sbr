<template>
  <div
    v-loading="loading"
    :class="displayContentFirstStep == false ? 'hide' : 'main'"
  >
    <form class="card-box" id="form-first-step">
      <div class="form-wizard-content show" data-tab-content="info">
        <el-row :gutter="24" class="m-b-40">
          <el-col :sm="12" :xs="24">
            <!-- Course id -->
            <input class="hide" type="text" v-model="course.id" name="id" />
            <!-- Course name -->
            <label>{{ lang['name'] }} *</label>
            <el-input
              class="m-b-20"
              name="title"
              v-model="course.name"
            ></el-input>

            <!-- Course category -->
            <label class="col-form-label">{{ lang['category'] }}</label>
            <el-select class="mb-5" v-model="course.category">
              <el-option
                value="1"
                :label="lang['without-category']"
              ></el-option>
              <el-option
                v-for="item in categories"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              ></el-option>
            </el-select>

            <!-- Advanced configurations button -->
            <el-button
              class="sbr-purple"
              size="small"
              @click.prevent="modal = true"
            >
              {{ lang['advanced-settings'] }}
              <i class="el-icon-setting"></i>
            </el-button>
          </el-col>

          <!-- Course image -->
          <el-col :sm="12" :xs="24">
            <label class="col-form-label"
              >{{ lang['image'] }} (1900x1200 px)</label
            >
            <upload
              v-if="course.image != ''"
              :src-img="course.image"
              :src-name="course.imageName"
              do-upload="true"
              box-height="200"
              return-name="photo"
              input-name="file"
              bucket-key="uploads/course"
              acceptable=".png,.jpg,.jpeg"
            ></upload>
          </el-col>
        </el-row>

        <el-row :gutter="40">
          <!-- Course description -->
          <el-col :sm="12" :xs="24">
            <textarea
              class="hide"
              v-model="course.description"
              name="description"
            ></textarea>
            <label class="col-form-label">{{ lang['description'] }}</label>
            <wysiwyg v-model="course.description" />
          </el-col>
          <!-- Course video preview -->
          <el-col :sm="12" :xs="24">
            <label class="col-form-label">{{ lang['video-preview'] }}</label>
            <upload
              v-if="course.previewVideo != ''"
              :src-img="course.previewVideo"
              :src-name="course.previewVideoName"
              do-upload="true"
              box-height="200"
              return-name="preview"
              input-name="filePreview"
              bucket-key="uploads/preview"
              acceptable=".mp4,.mov"
            ></upload>
          </el-col>
        </el-row>
      </div>

      <!-----------------------
        Modal advanced settings
      ------------------------>
      <el-dialog
        :visible.sync="modal"
        :title="lang['advanced-settings']"
        center
        width="40%"
        top="5vh"
      >
        <el-tabs v-model="activeTab">
          <!----------
            Dates tab
          ------------>
          <el-tab-pane :label="lang['dates']" name="dates" class="mt-4">
            <!-- Course release date -->
            <div class="form-group">
              <label class="col-form-label">{{ lang['start-date'] }}</label>
              <div class="input-group">
                <el-date-picker
                  v-model="course.releaseDate"
                  name="release_date"
                  type="date"
                  format="yyyy/MM/dd"
                  value-format="yyyy-MM-dd"
                  placeholder="Pick a day"
                ></el-date-picker>
              </div>
            </div>
            <!-- Course expiration date -->
            <div class="form-group">
              <label class="col-form-label">{{ lang['end-date'] }}</label>
              <div class="input-group">
                <el-date-picker
                  v-model="course.expirationDate"
                  name="expiration_date"
                  type="date"
                  format="yyyy/MM/dd"
                  value-format="yyyy-MM-dd"
                  placeholder="Pick a day"
                ></el-date-picker>
              </div>
            </div>

            <!-- Course validity -->
            <div class="form-group">
              <label class="col-form-label">{{ lang['validity-time'] }}</label>
              <div class="input-group">
                <div style="display: flex; flex-direction: column">
                  <el-switch
                    v-model="useValidity"
                    active-color="#009CD8"
                    inactive-color="#9E9C9C"
                  ></el-switch>
                  <br />
                  <el-input-number
                    v-if="useValidity"
                    :min="1"
                    name="validity"
                    v-model="course.validity"
                  ></el-input-number>
                </div>
              </div>
            </div>
          </el-tab-pane>

          <!----------
            Payment tab
          ------------>
          <el-tab-pane :label="lang['sales']" name="sales" class="mt-4">
            <label class="col-form-label">{{
              lang['free-course-question']
            }}</label>
            <br />
            <el-switch
              active-color="#009cd8"
              v-model="freeCourse"
              :active-text="lang['yes']"
              :inactive-text="lang['no']"
            ></el-switch>
            <hr />
            <!-- Price -->
            <div class="form-group" v-if="freeCourse == false">
              <label class="col-form-label">{{ lang['price'] }}</label>
              <div class="input-group">
                <money
                  name="price"
                  v-model="course.price"
                  class="price"
                  v-bind="money"
                  >12323</money
                >
              </div>
              <br />
              <div class="form-group">
                <label class="col-form-label">{{
                  lang['select-payment-platform']
                }}</label>
                <el-select
                  v-model="course.paymentPlatform"
                  placeholder="Select"
                  name="paymentPlatform"
                >
                  <el-option label="mercadopago" value="mercadopago">
                    <span style="float: left; color: #8492a6; font-size: 13px">
                      <img
                        style="width: 70px"
                        src="@/assets/img/apps/mercadopago.png"
                        alt="en"
                      />
                    </span>
                  </el-option>
                  <el-option label="paypal" value="paypal">
                    <span style="float: left; color: #8492a6; font-size: 13px">
                      <img
                        style="width: 70px"
                        src="@/assets/img/apps/paypal.png"
                        alt="en"
                      />
                    </span>
                  </el-option>
                </el-select>
              </div>
              <div class="form-group">
                <label class="col-form-label">{{
                  lang['select-currency']
                }}</label>
                <br />

                <!------------------------
                  Mercadopago information
                ------------------------->
                <div v-if="course.paymentPlatform == 'mercadopago'">
                  <!-- If currency is already set -->
                  <el-alert
                    v-if="globalCurrency != null"
                    :title="
                      lang['mercado-pago-currency-information'] +
                      lang['this-course-will-be-sold'] +
                      globalCurrency
                    "
                    type="info"
                    effect="dark"
                    :closable="false"
                    show-icon
                  ></el-alert>
                  <!-- If currency is not set -->
                  <el-alert
                    v-else
                    type="info"
                    effect="dark"
                    :closable="false"
                    show-icon
                  >
                    <p class="text-white">
                      <b>{{ lang['configure-your-mercadopago-account'] }}</b>
                    </p>
                    <p>
                      <router-link
                        target="_blank"
                        class="text-white"
                        to="/integrations"
                      >
                        {{ lang['click-to-configure-mercadopago'] }}
                      </router-link>
                    </p>
                  </el-alert>
                </div>
                <!-- End Mercado pago information -->

                <el-select
                  v-else
                  name="currency"
                  v-model="course.currency"
                  placeholder="Select"
                >
                  <el-option label="USD" value="USD"></el-option>
                  <el-option label="BRL" value="BRL"></el-option>
                  <el-option label="EUR" value="EUR"></el-option>
                  <el-option label="MXN" value="MXN"></el-option>
                  <el-option label="COP" value="COP"></el-option>
                  <el-option label="CLP" value="CLP"></el-option>
                  <el-option label="ARS" value="ARS"></el-option>
                  <el-option label="PEN" value="PEN"></el-option>
                  <el-option label="UYU" value="UYU"></el-option>
                  <el-option label="BOB" value="BOB"></el-option>
                </el-select>
              </div>
            </div>
          </el-tab-pane>

          <!----------
            Others tab
          ------------>
          <el-tab-pane label="Others" name="third" class="mt-4">
            <div class="row">
              <!-- Course reviews -->
              <div class="col-xl-4 col-md-4">
                <label for="exampleInputEmail1">{{ lang['reviews'] }}</label>
                <div class="input-group">
                  <el-switch
                    name="reviews"
                    v-model="course.reviews"
                    active-color="#009CD8"
                    inactive-color="#9E9C9C"
                  ></el-switch>
                </div>
              </div>

              <!-- Course spotlight  -->
              <div class="col-xl-4 col-md-4">
                <label for="exampleInputEmail1">{{ lang['spotlight'] }}</label>
                <div class="input-group">
                  <el-switch
                    name="spotlight"
                    v-model="course.spotlight"
                    active-color="#009CD8"
                    inactive-color="#9E9C9C"
                  ></el-switch>
                </div>
              </div>

              <!-- Course certificate  -->
              <div class="col-xl-4 col-md-4">
                <label for="exampleInputEmail1">
                  {{ lang['certificate'] }}
                </label>
                <div class="input-group">
                  <el-switch
                    v-model="useCertificate"
                    active-color="#009CD8"
                    inactive-color="#9E9C9C"
                  ></el-switch>
                </div>
              </div>
            </div>

            <h4 v-if="useCertificate == true" class="text-center mt-5">
              Select your template
            </h4>
            <div class="row" v-if="useCertificate == true">
              <div class="col-xl-4 col-md-4">
                <p class="text-center">Classic</p>
                <input
                  :checked="course.certificate == 'classic' ? true : false"
                  id="classic"
                  type="radio"
                  name="certificate"
                  value="classic"
                />
                <label for="classic">
                  <img
                    style="max-width: 100%"
                    class="img-responsive"
                    src="@/assets/img/general/certificate/classic_template.png"
                    alt
                  />
                </label>
              </div>

              <div class="col-xl-4 col-md-4">
                <p class="text-center">Tech</p>
                <input
                  :checked="course.certificate == 'tech' ? true : false"
                  id="tech"
                  type="radio"
                  name="certificate"
                  value="tech"
                />
                <label for="tech">
                  <img
                    style="max-width: 100%"
                    class="img-responsive"
                    src="@/assets/img/general/certificate/tech_template.png"
                    alt
                  />
                </label>
              </div>

              <div class="col-xl-4 col-md-4">
                <p class="text-center">Artistic</p>
                <input
                  :checked="course.certificate == 'artistic' ? true : false"
                  id="artistic"
                  type="radio"
                  name="certificate"
                  value="artistic"
                />
                <label for="artistic">
                  <img
                    style="max-width: 100%"
                    class="img-responsive"
                    src="@/assets/img/general/certificate/artistic_template.png"
                    alt
                  />
                </label>
              </div>
            </div>
          </el-tab-pane>
        </el-tabs>

        <el-button
          @click.prevent="
            modal = false;
            editCourse(false);
          "
          class="sbr-primary mt-5"
          >{{ lang['save-button'] }}</el-button
        >
      </el-dialog>
    </form>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import Vue from 'vue';
import wysiwyg from 'vue-wysiwyg';
import Upload from '@/components/helper/HelperUpload';
import HelperProgress from '@/components/helper/HelperProgress.vue';

import { Money } from 'v-money';
import { eventBus } from '@/components/newcourse/App';
import { mapState } from 'vuex';

Vue.use(wysiwyg, {
  hideModules: { image: true, code: true }
});

export default {
  components: {
    Upload,
    Money,
    HelperProgress
  },
  data: () => {
    return {
      modal: false,
      course: {
        id: '',
        name: '',
        price: '',
        description: '',
        reviews: false,
        spotlight: false,
        certificate: '',
        releaseDate: '',
        expirationDate: '',
        validity: '',
        category: '',
        image: '',
        imageName: '',
        previewVideoName: '',
        previewVideo: '',
        currency: '',
        paymentPlatform: ''
      },
      useValidity: false,
      useCertificate: false,
      categories: [],
      certificates: [],
      displayContentFirstStep: true,
      loading: false,
      money: {
        decimal: ',',
        thousands: '.',
        prefix: ' ',
        suffix: ' ',
        precision: 2,
        masked: false
      },
      activeTab: 'dates',
      freeCourse: true,
      globalCurrency: ''
    };
  },
  created() {
    this.course.id = this.$route.params.id;
    this.getCategories();
    this.getCourse();
    this.getGlobalCurrency();
  },
  computed: {
    ...mapState(['lang'])
  },
  mounted() {
    eventBus.$on('access-first-step', () => {
      this.displayContentFirstStep = true;
    });

    eventBus.$on('access-second-step', () => {
      this.editCourse();
    });

    eventBus.$on('access-third-step', () => {
      this.editCourse();
    });
  },
  beforeDestroy() {
    eventBus.$off('access-first-step', this.listener);
    eventBus.$off('access-second-step', this.listener);
    eventBus.$off('access-third-step', this.listener);
  },
  methods: {
    getGlobalCurrency() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );

      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.globalCurrency = response.data.currency;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getCourse() {
      const formData = new FormData();
      formData.set('courseId', this.course.id);

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'get'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.course.name = response.data.title;
          this.course.category = response.data.mycategory_id;
          this.course.description = response.data.description;
          this.course.validity = response.data.validity;
          this.course.imageName = response.data.photo;
          this.course.currency = response.data.currency;
          this.course.paymentPlatform = response.data.payment_platform;
          this.course.image =
            this.$getUrlToContents() + 'course/' + response.data.photo + '';

          this.course.previewVideoName = response.data.preview;
          this.course.previewVideo =
            this.$getUrlToContents() + 'preview/' + response.data.preview + '';

          if (response.data.price == null) {
            this.course.price = '';
          } else {
            this.course.price = response.data.price;
            this.freeCourse = false;
          }

          response.data.validity == null
            ? (this.useValidity = false)
            : (this.useValidity = true);

          if (response.data.release_date == null) {
            this.course.releaseDate = '';
          } else {
            this.course.releaseDate = response.data.release_date;
          }

          if (response.data.expiration_date == null) {
            this.course.expirationDate = '';
          } else {
            this.course.expirationDate = response.data.expiration_date;
          }

          response.data.spotlight == null
            ? (this.course.spotlight = false)
            : (this.course.spotlight = true);
          response.data.reviews == null
            ? (this.course.reviews = false)
            : (this.course.reviews = true);

          response.data.certificate == null
            ? (this.useCertificate = false)
            : (this.useCertificate = true);
          this.course.certificate = response.data.certificate;

          this.modal = true;
          this.fixAdvancedModal();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getCategories() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'category',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.categories = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    fixAdvancedModal() {
      this.loading = true;
      setTimeout(() => {
        this.modal = false;
        this.loading = false;
      }, 500);
    },
    editCourse(update) {
      this.loading = true;
      setTimeout(() => {
        const form = document.getElementById('form-first-step');
        const formData = new FormData(form);
        const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
          'course',
          'edit'
        );
        formData.set('mycategory_id', this.course.category);
        this.$request.post(urlToBeUsedInTheRequest, formData).then(
          () => {
            this.loading = false;
            if (update !== false) {
              this.displayContentFirstStep = false;
            }
          },
          () => {
            this.$errorMessage();
          }
        );
      }, 2000);
    }
  }
};
</script>

<style lang="scss" scoped>
.main {
  transition-timing-function: ease-in-out;
}

/* Default sizes */
.form-row > .col,
.form-row > [class*='col-'] {
  padding-right: 20px !important;
  padding-left: 20px !important;
}

.form-row {
  padding: 0px !important;
}

.form-wizard-wrapper .form-wizard-content {
  background-color: #fff;
  padding-top: 50px;
  color: #777777;
  left: 0;
  right: 0;
  bottom: 0;
  top: 0;
}

/* End default sizes */

input[type='radio'] {
  display: none;
}
input[type='radio']:checked + label {
  border: 5px solid royalblue;
}

.v-money.price {
  -webkit-appearance: none;
  background-color: #fff;
  background-image: none;
  border-radius: 4px;
  border: 1px solid #dcdfe6;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  color: #606266;
  display: inline-block;
  font-size: inherit;
  height: 40px;
  line-height: 40px;
  outline: 0;
  padding: 0 15px;
  -webkit-transition: border-color 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);
  transition: border-color 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);
  width: 100%;
}
</style>
