<template>
  <div :class="displayContentFirstStep == false ? 'hide' : 'main'">
    <form id="form-first-step">
      <div class="form-wizard-content show" data-tab-content="info">
        <div class="row">
          <div class="col-12">
            <div class="card-box" v-loading="loading">
              <div class="form-row">
                <div class="form-group col-12 col-md-6">
                  <!-- Course id -->
                  <input class="hide" type="text" v-model="courseId" name="id" />

                  <!-- Course name -->
                  <label class="col-form-label">{{ lang["name"] }} *</label>
                  <el-input
                    @change="editCourse(false)"
                    name="title"
                    :class="invalidField ? 'invalid-field' : ''"
                    v-model="name"
                  ></el-input>

                  <!-- Course category -->
                  <label class="col-form-label">{{ lang["category"] }}</label>
                  <el-select class="mb-5" v-model="category">
                    <el-option value="1" :label="lang['without-category']"></el-option>
                    <el-option
                      v-for="item in categories"
                      :key="item.id"
                      :label="item.name"
                      :value="item.id"
                    ></el-option>
                  </el-select>

                  <!-- Advanced configurations button -->
                  <el-button @click.prevent="modal = true" size="small" class="sbr-purple">
                    {{ lang["advanced-settings"] }}
                    <i class="el-icon-setting"></i>
                  </el-button>
                </div>

                <!-- Course description -->
                <div class="form-group col-xl-6 col-md-6">
                  <textarea class="hide" v-model="description" name="description"></textarea>
                  <label class="col-form-label">
                    {{
                    lang["description"]
                    }}
                  </label>
                  <wysiwyg v-model="description" />
                </div>
              </div>

              <div class="form-row">
                <!-- Course image -->
                <div class="form-group col-xl-6 col-md-6">
                  <label class="col-form-label">{{ lang["image"] }}</label>
                  <upload
                    v-if="srcImg != ''"
                    :src-img="srcImg"
                    :src-name="srcName"
                    do-upload="true"
                    box-height="200"
                    return-name="photo"
                    input-name="file"
                    bucket-key="uploads/course"
                    acceptable=".png,.jpg"
                  ></upload>
                </div>
                <!-- Course video preview -->
                <div class="form-group col-xl-6 col-md-6">
                  <label class="col-form-label">
                    {{
                    lang["video-preview"]
                    }}
                  </label>
                  <upload
                    v-if="srcPreviewName != ''"
                    :src-img="srcPreview"
                    :src-name="srcPreviewName"
                    do-upload="true"
                    box-height="200"
                    return-name="preview"
                    input-name="file"
                    bucket-key="uploads/preview"
                    acceptable=".mp4,.mov"
                  ></upload>
                </div>
              </div>
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
          <label class="col-form-label">{{ lang["start-date"] }}</label>
          <div class="input-group">
            <el-date-picker
              v-model="releaseDate"
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
          <label class="col-form-label">{{ lang["end-date"] }}</label>
          <div class="input-group">
            <el-date-picker
              v-model="expirationDate"
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
          <label class="col-form-label">{{ lang["validity-time"] }}</label>
          <div class="input-group">
            <div style="display:flex;flex-direction:column;">
              <el-switch v-model="validityAllowed" active-color="#009CD8" inactive-color="#9E9C9C"></el-switch>
              <br />
              <el-input-number v-if="validityAllowed" :min="1" name="validity" v-model="validity"></el-input-number>
            </div>
          </div>
        </div>

        <!-- Price -->
        <div class="form-group">
          <label class="col-form-label">{{ lang["price"] }}</label>
          <div class="input-group">
            <money name="price" v-model="price" class="text-field" v-bind="money">12323</money>
          </div>
        </div>

        <div class="row">
          <!-- Course reviews -->
          <div class="col-xl-4 col-md-4">
            <label for="exampleInputEmail1">{{ lang["reviews"] }}</label>
            <div class="input-group">
              <el-switch
                name="reviews"
                v-model="reviews"
                active-color="#009CD8"
                inactive-color="#9E9C9C"
              ></el-switch>
            </div>
          </div>

          <!-- Course spotlight  -->
          <div class="col-xl-4 col-md-4">
            <label for="exampleInputEmail1">{{ lang["spotlight"] }}</label>
            <div class="input-group">
              <el-switch
                name="spotlight"
                v-model="spotlight"
                active-color="#009CD8"
                inactive-color="#9E9C9C"
              ></el-switch>
            </div>
          </div>

          <!-- Course certificate  -->
          <div class="col-xl-4 col-md-4">
            <label for="exampleInputEmail1">{{ lang["certificate"] }}</label>
            <div class="input-group">
              <el-switch v-model="certificate" active-color="#009CD8" inactive-color="#9E9C9C"></el-switch>
            </div>
          </div>
        </div>

        <h4 v-if="certificate == true" class="text-center mt-5">Select your template</h4>
        <div class="row" v-if="certificate == true">
          <div class="col-xl-4 col-md-4">
            <p class="text-center">Classic</p>
            <input
              :checked="certificateValue == 'classic' ? true : false"
              id="classic"
              type="radio"
              name="certificate"
              value="classic"
            />
            <label for="classic">
              <img
                style="max-width:100%"
                class="img-responsive"
                src="@/assets/img/general/certificate/classic_template.png"
                alt
              />
            </label>
          </div>

          <div class="col-xl-4 col-md-4">
            <p class="text-center">Tech</p>
            <input
              :checked="certificateValue == 'tech' ? true : false"
              id="tech"
              type="radio"
              name="certificate"
              value="tech"
            />
            <label for="tech">
              <img
                style="max-width:100%"
                class="img-responsive"
                src="@/assets/img/general/certificate/tech_template.png"
                alt
              />
            </label>
          </div>

          <div class="col-xl-4 col-md-4">
            <p class="text-center">Artistic</p>
            <input
              :checked="certificateValue == 'artistic' ? true : false"
              id="artistic"
              type="radio"
              name="certificate"
              value="artistic"
            />
            <label for="artistic">
              <img
                style="max-width:100%"
                class="img-responsive"
                src="@/assets/img/general/certificate/artistic_template.png"
                alt
              />
            </label>
          </div>
        </div>
        <el-button
          @click.prevent="
            modal = false;
            editCourse(false);
          "
          class="sbr-primary mt-5"
        >{{ lang["save-button"] }}</el-button>
      </el-dialog>
    </form>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import wysiwyg from "vue-wysiwyg";
import Upload from "@/components/helper/HelperUpload";
import HelperProgress from "@/components/helper/HelperProgress.vue";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { Money } from "v-money";
import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";

Vue.use(wysiwyg, {});
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  components: {
    Upload,
    Money,
    HelperProgress
  },
  data: () => {
    return {
      modal: false,
      name: "",
      price: "",
      invalidField: false,
      categories: {},
      certificates: {},
      description: "",
      reviews: false,
      spotlight: false,
      certificate: false,
      certificateValue: "",
      multiple: false,
      releaseDate: "",
      expirationDate: "",
      validity: "",
      validityAllowed: false,
      category: "",
      displayContentFirstStep: true,
      courseMode: "edit",
      courseId: "",
      srcImg: "",
      srcName: "",
      srcPreview: "",
      srcPreviewName: "",
      loading: false,
      loadingContent: true,
      money: {
        decimal: ",",
        thousands: ".",
        prefix: " ",
        suffix: " ",
        precision: 2,
        masked: false
      }
    };
  },
  created() {
    this.courseId = this.$route.params.id;
    this.getCategories();
    this.getCourse();
  },
  computed: {
    ...mapState(["lang"])
  },
  mounted() {
    /* Access first step */
    eventBus.$on("access-first-step", () => {
      this.contentShow = true;
    });

    /*  Access second step */
    eventBus.$on("access-second-step", () => {
      this.editCourse();
    });

    /*  Access Third step */
    eventBus.$on("access-third-step", () => {
      this.courseMode == "create" ? this.createCourse() : this.editCourse();
    });
  },
  methods: {
    getCourse() {
      var formData = new FormData();
      formData.set("courseId", this.courseId);

      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "get");
      axios
        .post(urlToBeUsedInTheRequest, formData)
        .then(response => {
          // success callback
          this.name = response.data["title"];
          this.category = response.data["mycategory_id"];
          this.description = response.data["description"];
          this.validity = response.data["validity"];
          this.srcName = response.data["photo"];
          this.srcImg =
            this.getUrlToContents() + "course/" + response.data["photo"] + "";

          this.srcPreviewName = response.data["preview"];
          this.srcPreview =
            this.getUrlToContents() +
            "preview/" +
            response.data["preview"] +
            "";

          response.data["price"] == null
            ? (this.price = "")
            : (this.price = response.data["price"]);

          response.data["validity"] == null
            ? (this.validityAllowed = false)
            : (this.validityAllowed = true);

          if (
            response.data["release_date"] == null ||
            response.data["release_date"] == "" ||
            response.data["release_date"] == "0000-00-00"
          ) {
            this.releaseDate = "";
          } else {
            this.releaseDate = response.data["release_date"];
          }

          if (
            response.data["expiration_date"] == null ||
            response.data["expiration_date"] == "" ||
            response.data["expiration_date"] == "0000-00-00"
          ) {
            this.expirationDate = "";
          } else {
            this.expirationDate = response.data["expiration_date"];
          }

          response.data["spotlight"] == null
            ? (this.spotlight = false)
            : (this.spotlight = true);
          response.data["reviews"] == null
            ? (this.reviews = false)
            : (this.reviews = true);

          response.data["certificate"] == null
            ? (this.certificate = false)
            : (this.certificate = true);
          this.certificateValue = response.data["certificate"];

          this.modal = true;
          this.fixAdvancedModal();
        })
        .catch(() => {
          this.errorMessage();
        });
    },
    getCategories() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "category",
        "listing"
      );
      axios
        .get(urlToBeUsedInTheRequest)
        .then(response => {
          // success callback
          this.categories = response.data;
        })
        .catch(() => {
          this.errorMessage();
        });
    },
    fixAdvancedModal: function() {
      this.loading = true;
      setTimeout(() => {
        this.modal = false;
        this.loading = false;
      }, 500);
    },
    editCourse(update) {
      this.loading = true;
      setTimeout(() => {
        var form = document.getElementById("form-first-step");
        var formData = new FormData(form);
        formData.set("mycategory_id", this.category);
        var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
          "course",
          "edit"
        );
        axios
          .post(urlToBeUsedInTheRequest, formData)
          .then(() => {
            this.loading = false;
            if (update != false) {
              this.displayContentFirstStep = false;
            }
          })
          .catch(() => {
            this.errorMessage();
          });
      }, 2000);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.main {
  transition-timing-function: ease-in-out;
}

/* Default sizes */
.form-row > .col,
.form-row > [class*="col-"] {
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

input[type="radio"] {
  display: none;
}
input[type="radio"]:checked + label {
  border: 5px solid royalblue;
}
</style>
