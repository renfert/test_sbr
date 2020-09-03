<template>
  <div :class="displayContentFirstStep == false ? 'hide' : 'main'">
    <form id="form-first-step">
      <div class="form-wizard-content show" data-tab-content="info">
        <div class="card-course">
          <div class="form-row">
            <div class="form-group col-12 col-md-6">
              <!-- Course id -->
              <input class="hide" type="text" v-model="course.id" name="id" />
              <!-- Course name -->
              <label class="col-form-label">{{ lang['name'] }} *</label>
              <el-input name="title" v-model="course.name"></el-input>
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
                >{{ lang['advanced-settings'] }}</el-button
              >
            </div>

            <!-- Course description -->
            <div class="form-group col-xl-6 col-md-6">
              <textarea
                class="hide"
                v-model="course.description"
                name="description"
              ></textarea>
              <label class="col-form-label">{{ lang['description'] }}</label>
              <wysiwyg v-model="course.description" />
            </div>
          </div>

          <div class="form-row">
            <!-- Course image -->
            <div class="form-group col-xl-6 col-md-6">
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
            </div>
            <!-- Course video preview -->
            <div class="form-group col-xl-6 col-md-6">
              <label class="col-form-label">{{ lang['video-preview'] }}</label>
              <upload
                do-upload="true"
                box-height="200"
                return-name="preview"
                input-name="filePreview"
                bucket-key="uploads/preview"
                acceptable=".mp4,.mov"
              ></upload>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal advanced settings -->
      <el-dialog
        :visible.sync="modal"
        :title="lang['advanced-settings']"
        center
        width="40%"
        top="5vh"
      >
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

        <!-- Price -->
        <div class="form-group">
          <label class="col-form-label">{{ lang['price'] }}</label>
          <div class="input-group">
            <money
              name="price"
              v-model="course.price"
              class="text-field"
              v-bind="money"
              >12323</money
            >
          </div>
        </div>

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
            <label for="exampleInputEmail1">{{ lang['certificate'] }}</label>
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

        <el-button
          class="sbr-primary mt-5"
          @click.prevent="modal = false"
          type="primary"
          size="medium"
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
  hideModules: { image: true }
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
        mode: 'create'
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
      }
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  created() {
    this.getCategories();
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
  methods: {
    createCourse() {
      const form = document.getElementById('form-first-step');
      const formData = new FormData(form);
      formData.set('mycategory_id', this.category);

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
