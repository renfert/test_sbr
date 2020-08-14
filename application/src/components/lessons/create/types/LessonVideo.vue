<template>
  <!--  Modal new lesson -->
  <div>
    <el-dialog
      :visible.sync="modalCreateLesson"
      :title="lang['create-new-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-video" @submit.prevent="create()">
        <div class="form-row">
          <!-- Module id -->
          <input type="number" class="hide" name="moduleId" :value="moduleId" />
          <input type="text" class="hide" name="type_mylesson_id" value="1" />

          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{lang["name"]}} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Video upload -->
            <label class="col-form-label">Video *</label>
            <upload
              do-upload="true"
              box-height="200"
              return-name="path"
              input-name="file"
              bucket-key="uploads/content"
              acceptable=".mp4,.mov,.avi"
            ></upload>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button class="sbr-btn sbr-primary" native-type="submit">{{lang["save-button"]}}</el-button>
          </div>
        </div>
      </form>
    </el-dialog>
  </div>
  <!-- End  modal new lesson -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import Upload from "@/components/helper/HelperUpload";

import { eventBus } from "@/components/newcourse/App";
import { eventUpload } from "@/components/helper/HelperUpload";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
export default {
  mixins: [domains, alerts],
  props: ["module-id"],
  components: {
    Upload
  },
  data: () => {
    return {
      name: "",
      modalCreateLesson: false,
      loading: false
    };
  },
  mounted() {
    /* Get new video click event */
    eventBus.$on(
      "new-video",
      function() {
        this.modalCreateLesson = true;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    /* Create a new lesson */
    create: function() {
      this.loading = true;
      var form = document.getElementById("form-lesson-video");
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
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    actionsToBePerformedAfterRegistration() {
      this.name = "";
      this.modalCreateLesson = false;
      eventBus.$emit("new-lesson");
      eventUpload.$emit("clear");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
