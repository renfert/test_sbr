<template>
  <div :class="contentShow == false ? 'hide' : 'main'">
    <form id="form-first-step">
      <div class="form-wizard-content show" data-tab-content="info">
        <div class="card-course">
          <div class="form-row">
            <div class="form-group col-12 col-md-6">
              <!-- Course id -->
              <input class="hide" type="text" v-model="courseId" name="id" />
              <!-- Course name -->
              <label class="col-form-label">{{lang["name"]}} *</label>
              <el-input name="title" :class="invalidField ? 'invalid-field' : '' " v-model="name"></el-input>
              <!-- Course category -->
              <label class="col-form-label">{{lang["category"]}}</label>
              <el-select class="mb-5" v-model="category">
                <el-option :value="1" :label="lang['default-category']"></el-option>
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
              >{{lang["advanced-settings"]}}</el-button>
            </div>

            <!-- Course description -->
            <div class="form-group col-xl-6 col-md-6">
              <textarea class="hide" v-model="description" name="description"></textarea>
              <label class="col-form-label">{{lang["description"]}}</label>
              <wysiwyg v-model="description" />
            </div>
          </div>

          <div class="form-row">
            <!-- Course image -->
            <div class="form-group col-xl-6 col-md-6">
              <label class="col-form-label">{{lang["image"]}} (1900x1200 px)</label>
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
              <label class="col-form-label">{{lang["video-preview"]}}</label>
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
          <label class="col-form-label">{{lang["start-date"]}}</label>
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
          <label class="col-form-label">{{lang["end-date"]}}</label>
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
          <label class="col-form-label">{{lang["validity-time"]}}</label>
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
          <label class="col-form-label">{{lang["price"]}}</label>
          <div class="input-group">
            <money name="price" v-model="price" class="text-field" v-bind="money">12323</money>
          </div>
        </div>

        <div class="row">
          <!-- Course reviews -->
          <div class="col-xl-4 col-md-4">
            <label for="exampleInputEmail1">{{lang["reviews"]}}</label>
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
            <label for="exampleInputEmail1">{{lang["spotlight"]}}</label>
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
            <label for="exampleInputEmail1">{{lang["certificate"]}}</label>
            <div class="input-group">
              <el-switch v-model="certificate" active-color="#009CD8" inactive-color="#9E9C9C"></el-switch>
            </div>
          </div>
        </div>

        <h4 v-if="certificate == true" class="text-center mt-5">Select your template</h4>
        <div class="row" v-if="certificate == true">
          <div class="col-xl-4 col-md-4">
            <p class="text-center">Classic</p>
            <input id="classic" type="radio" name="certificate" value="classic" />
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
            <input id="tech" type="radio" name="certificate" value="tech" />
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
            <input id="artistic" type="radio" name="certificate" value="artistic" />
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
          class="sbr-primary mt-5"
          @click.prevent="modal = false"
          type="primary"
          size="medium"
        >{{lang["save-button"]}}</el-button>
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
import ElementUI from "element-ui";

import { Money } from "v-money";
import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";

Vue.use(wysiwyg, {
  hideModules: { image: true }
});

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  components: {
    Upload,
    Money,
    HelperProgress
  },
  data: function() {
    return {
      modal: false,
      name: "",
      price: "",
      invalidField: false,
      categories: {},
      certificates: {},
      description: "",
      reviews: false,
      spotlight: true,
      certificate: false,
      releaseDate: "",
      expirationDate: "",
      validity: "",
      validityAllowed: false,
      category: 1,
      contentShow: true,
      courseMode: "create", // Course mode can be create or edit mode
      courseId: "",
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
  computed: {
    ...mapState(["lang"])
  },
  created() {
    this.getCategories();
  },
  mounted() {
    /* Show this content */
    eventBus.$on(
      "access-first-step",
      function() {
        this.contentShow = true;
      }.bind(this)
    );

    /*  Access second step */
    eventBus.$on(
      "access-second-step",
      function() {
        if (this.name == "") {
          this.invalidField = true;
          this.requiredInputNameMessage();
          eventBus.$emit("response-access-second-step", false);
        } else {
          this.courseMode == "create" ? this.createCourse() : this.editCourse();
          eventBus.$emit("response-access-second-step", true);
        }
      }.bind(this)
    );

    /*  Access Third step */
    eventBus.$on(
      "access-third-step",
      function() {
        if (this.name == "") {
          this.invalidField = true;
          this.requiredInputNameMessage();
          eventBus.$emit("response-access-third-step", false);
        } else {
          this.courseMode == "create" ? this.createCourse() : this.editCourse();
          eventBus.$emit("response-access-third-step", true);
        }
      }.bind(this)
    );
  },
  methods: {
    createCourse: function() {
      var form = document.getElementById("form-first-step");
      var formData = new FormData(form);
      formData.set("mycategory_id", this.category);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "course",
        "create"
      );
      const config = {
        headers: {
          "Content-Type": "text/html"
        }
      };
      axios.post(urlToBeUsedInTheRequest, formData, config).then(
        response => {
          this.actionsToBePerformedAfterRegistration(response.data);
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }
      );
    },
    getCategories() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "category",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          this.categories = response.data;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }
      );
    },
    editCourse: function() {
      var form = document.getElementById("form-first-step");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "edit");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.actionsToBePerformedAfterEdit();
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }
      );
    },
    actionsToBePerformedAfterRegistration(courseId) {
      eventBus.$emit("new-course", courseId);
      this.contentShow = false;
      this.courseId = courseId;
      this.courseMode = "edit";
    },
    requiredInputNameMessage() {
      this.$notify({
        title: this.lang["error"],
        message: this.lang["required-name"],
        type: "error",
        duration: 3500
      });
    },
    actionsToBePerformedAfterEdit() {
      this.contentShow = false;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.form-wizard-wrapper .form-wizard-content {
  background-color: #fff;
  color: #777777;
  left: 0;
  right: 0;
  bottom: 0;
  top: 0;
}
</style>
