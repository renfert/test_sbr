<template>
  <div :class="displayContentFirstStep == false ? 'hide' : 'main'">
    <form id="form-first-step">
      <div class="form-wizard-content show card-box" data-tab-content="info">
        <el-row :gutter="24" class="m-b-40">
          <el-col :sm="12" :xs="24">
            <!-- Course id -->
            <input class="hide" type="text" v-model="course.id" name="id" />
            <!-- Course name -->
            <label class="col-form-label"
              >{{ lang['name'] }} <span style="color: red">*</span></label
            >
            <el-input name="title" v-model="courseName"></el-input>
            <!-- Course category -->
            <label class="col-form-label">{{ lang['category'] }}</label>
            <el-select class="mb-5" v-model="course.category">
              <el-option
                :value="1"
                :label="lang['default-category']"
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
              >{{ lang['advanced-settings'] }}
            </el-button>
          </el-col>

          <el-col :sm="12" :xs="24">
            <label class="col-form-label"
              >{{ lang['image'] }} (1900x1200 px)</label
            >
            <upload
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
          <el-col :sm="12" :xs="24">
            <textarea
              class="hide"
              v-model="course.description"
              name="description"
            ></textarea>
            <label class="col-form-label">{{ lang['description'] }}</label>
            <wysiwyg v-model="course.description" />
          </el-col>

          <el-col :sm="12" :xs="24">
            <label class="col-form-label">{{ lang['video-preview'] }}</label>
            <upload
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

      <!-- Modal advanced settings -->
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
            <label class="col-form-label">
              {{ lang['free-course-question'] }}
            </label>
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
                  >12323
                </money>
              </div>
              <br />
              <div class="form-group">
                <label class="col-form-label">
                  {{ lang['select-payment-platform'] }}
                </label>
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
                <label class="col-form-label">
                  {{ lang['select-currency'] }}
                </label>
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
                        >{{ lang['click-to-configure-mercadopago'] }}
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
          <el-tab-pane :label="lang['others']" name="third" class="mt-4">
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
                <label for="exampleInputEmail1">{{
                  lang['certificate']
                }}</label>
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
                <input id="tech" type="radio" name="certificate" value="tech" />
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
          class="sbr-primary mt-5"
          @click.prevent="modal = false"
          type="primary"
          size="medium"
          >{{ lang['save-button'] }}
        </el-button>
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

export const eventFirstStep = new Vue();

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
      course: {
        id: '',
        name: '',
        price: '',
        description: '',
        reviews: false,
        spotlight: false,
        releaseDate: '',
        expirationDate: '',
        validity: '',
        category: 1,
        mode: 'create',
        currency: '',
        paymentPlatform: ''
      },
      modal: false,
      categories: [],
      certificates: [],
      useCertificate: false,
      useValidity: false,
      displayContentFirstStep: true,
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
  computed: {
    ...mapState(['lang']),
    courseName: {
      get() {
        return this.course.name;
      },
      set(value) {
        eventFirstStep.$emit('verifyCourseName', value);
        this.course.name = value;
      }
    }
  },
  watch: {
    freeCourse(newVal, oldVal) {
      if (newVal === true) {
        this.course.price = '';
        this.course.paymentPlatform = '';
        this.course.currency = '';
      }
    }
  },
  created() {
    this.getCategories();
    this.getGlobalCurrency();
  },

  mounted() {
    eventBus.$on('access-first-step', () => {
      this.displayContentFirstStep = true;
    });

    eventBus.$on('access-second-step', () => {
      this.course.mode === 'create' ? this.createCourse() : this.editCourse();
    });

    eventBus.$on('access-third-step', () => {
      this.course.mode === 'create' ? this.createCourse() : this.editCourse();
    });
  },
  beforeDestroy() {
    eventBus.$off('access-first-step', this.listener);
    eventBus.$off('access-second-step', this.listener);
    eventBus.$off('access-third-step', this.listener);
  },
  methods: {
    createCourse() {
      const form = document.getElementById('form-first-step');
      const formData = new FormData(form);
      formData.set('mycategory_id', this.course.category);

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'create'
      );

      const config = {
        headers: {
          'Content-Type': 'text/html'
        }
      };

      this.$request.post(urlToBeUsedInTheRequest, formData, config).then(
        (response) => {
          eventBus.$emit('new-course', response.data);
          this.displayContentFirstStep = false;
          this.course.id = response.data;
          this.course.mode = 'edit';
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
    editCourse() {
      const form = document.getElementById('form-first-step');
      const formData = new FormData(form);
      formData.set('mycategory_id', this.course.category);

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'edit'
      );

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.displayContentFirstStep = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<style scoped>
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
