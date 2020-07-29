<template>
  <!--  Modal new lesson -->
  <div>
    <el-dialog :visible.sync="modalCreatePdf" :title="lang['create-new-lesson']" center top="5vh">
      <form id="form-lesson-pdf" @submit.prevent="create()">
        <div class="form-row">
          <!-- Module id -->
          <input type="number" class="hide" name="moduleId" :value="moduleId" />
          <input type="text" class="hide" name="type_mylesson_id" value="3" />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{lang["name"]}} *</label>
            <el-input required v-model="name" name="title" class="v-step-9"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Pdf upload -->
            <label class="col-form-label">Pdf *</label>
            <upload
              class="v-step-10"
              do-upload="true"
              box-height="200"
              return-name="path"
              input-name="file"
              bucket-key="uploads/content"
              acceptable=".pdf"
            ></upload>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              class="sbr-btn sbr-primary v-step-11"
              v-loading="loading"
              native-type="submit"
            >{{lang["save-button"]}}</el-button>
          </div>
        </div>
      </form>
    </el-dialog>

    <!-------- 
        Pdf tour
    ---------->
    <v-tour name="pdf-tour" :options="tourOptions" :steps="steps"></v-tour>
  </div>
  <!-- End  modal new module -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import Upload from "@/components/helper/HelperUpload";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VueTour from "vue-tour";

import { eventBus } from "@/components/newcourse/App";
import { eventUpload } from "@/components/helper/HelperUpload";
import { mapState } from "vuex";

require("vue-tour/dist/vue-tour.css");

Vue.use(VueTour);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  props: ["module-id"],
  components: {
    Upload
  },
  data: function() {
    return {
      name: "",
      modalCreatePdf: false,
      loading: false,
      tourOptions: {
        useKeyboardNavigation: true,
        labels: {
          buttonSkip: "",
          buttonPrevious: "",
          buttonNext: "",
          buttonStop: ""
        }
      },
      steps: [
        {
          target: ".v-step-9",
          header: {
            title: ""
          },
          params: {
            placement: "bottom",
            highlight: true
          },
          content: ""
        },
        {
          target: ".v-step-10",
          header: {
            title: ""
          },
          params: {
            placement: "bottom",
            highlight: true
          },
          content: ""
        },
        {
          target: ".v-step-11",
          header: {
            title: ""
          },
          params: {
            placement: "bottom",
            highlight: true
          },
          content: ""
        }
      ]
    };
  },
  mounted() {
    /* Tour labels */
    this.tourOptions.labels.buttonSkip = this.lang["skip-tour"];
    this.tourOptions.labels.buttonPrevious = this.lang["previous-step-button"];
    this.tourOptions.labels.buttonNext = this.lang["next-step-button"];
    this.tourOptions.labels.buttonStop = this.lang["finish"];

    /* Tour step 0 - Pdf name */
    this.steps[0].header.title = this.lang["add-new-lesson"];
    this.steps[0].content = this.lang["tour-course-add-pdf-name"];

    /* Tour step 0 - Pdf file */
    this.steps[1].header.title = this.lang["add-new-lesson"];
    this.steps[1].content = this.lang["tour-course-add-pdf-file"];

    /* Tour step 0 - Save */
    this.steps[2].header.title = this.lang["add-new-lesson"];
    this.steps[2].content = this.lang["tour-course-pdf-save"];

    eventBus.$on(
      "new-pdf",
      function() {
        this.$tours["second-step-tour-add-content-modal"].finish();
        this.modalCreatePdf = true;

        setTimeout(() => {
          if (this.$route.query.tour == "true") {
            this.$tours["pdf-tour"].start();
          }
        }, 1500);
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    /* Create a new lesson */
    create: function() {
      this.$tours["pdf-tour"].finish();
      this.loading = true;
      var form = document.getElementById("form-lesson-pdf");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "lesson",
        "create"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
          this.successMessage();
          this.actionsToBePerformedAfterRegistration();
          this.loading = false;
          setTimeout(() => {
            if (this.$route.query.tour == "true") {
              this.$tours["tour-3-step"].start();
            }
          }, 1000);
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    actionsToBePerformedAfterRegistration() {
      this.name = "";
      this.modalCreatePdf = false;
      eventBus.$emit("new-lesson");
      eventUpload.$emit("clear");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
