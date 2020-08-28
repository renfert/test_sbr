<template>
  <!--  Modal new lesson -->
  <div>
    <el-dialog :visible.sync="modalEditDownloadable" :title="lang['edit-lesson']" center top="5vh">
      <form id="form-lesson-downloadable-edit" @submit.prevent="edit()">
        <div class="form-row">
          <!-- Lesson id -->
          <input type="number" class="hide" name="lessonId" :value="lessonId" />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{lang["name"]}} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Downloadable file upload -->
            <label class="col-form-label">Downloadable file *</label>
            <upload
              :key="componentKey"
              v-if="this.realName != ''"
              :src-name="this.downloadableName"
              :src-real-name="this.realName"
              :src-img="this.previewImg"
              do-upload="true"
              box-height="200"
              return-name="path"
              input-name="file"
              bucket-key="uploads/content"
              acceptable=".jpg,.png,.docx,.xlsx,.doc,.pptx,.pdf,.zip,.mp4,.mp3,.mov"
            ></upload>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              v-loading="loading"
              native-type="submit"
              class="sbr-primary"
            >{{lang["save-button"]}}</el-button>
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
import Upload from "@/components/helper/HelperUpload";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventUpload } from "@/components/helper/HelperUpload";
import { mapState } from "vuex";
import { eventBus } from "@/components/newcourse/App";

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  components: {
    Upload
  },
  data: () => {
    return {
      name: "",
      downloadableName: "",
      previewImg: "",
      lessonId: "",
      realName: "",
      modalEditDownloadable: false,
      loading: false,
      componentKey: 0
    };
  },
  mounted() {
    eventBus.$on(
      "edit-lesson-4",
      function(response) {
        this.modalEditDownloadable = true;
        this.lessonId = response[0]["id"];
        this.name = response[0]["title"];
        this.realName = response[0]["real_name"];
        this.downloadableName = response[0]["path"];
        this.previewImg =
          "" + this.$getUrlToContents() + "content/" + response[0]["path"];
        this.forceRerender();
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    /* Edit a lesson */
    edit: function() {
      this.loading = true;
      var form = document.getElementById("form-lesson-downloadable-edit");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest("lesson", "edit");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
          this.successMessage();
          this.actionsToBePerformedAfterEdit();
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    forceRerender: function() {
      this.componentKey += 1;
    },
    actionsToBePerformedAfterEdit: function() {
      this.modalEditDownloadable = false;
      eventBus.$emit("new-lesson");
      eventUpload.$emit("clear");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
