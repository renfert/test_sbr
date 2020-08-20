<template>
  <!--  Modal new lesson -->
  <div>
    <el-dialog :visible.sync="modalEditPdf" :title="lang['edit-lesson']" center top="5vh">
      <form id="form-lesson-pdf-edit" @submit.prevent="edit()">
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
            <!-- Pdf upload -->
            <label class="col-form-label">Pdf *</label>
            <upload
              :key="componentKey"
              v-if="this.realName != ''"
              :src-name="this.pdfName"
              :src-real-name="this.realName"
              :src-img="this.previewImg"
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
              v-loading="loading"
              native-type="submit"
              class="sbr-primary"
            >{{lang["save-button"]}}</el-button>
          </div>
        </div>
      </form>
    </el-dialog>
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

import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";
import { eventUpload } from "@/components/helper/HelperUpload";

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  components: {
    Upload
  },
  data: () => {
    return {
      name: "",
      pdfName: "",
      previewImg: "",
      realName: "",
      modalEditPdf: false,
      loading: false,
      lessonId: "",
      componentKey: 0
    };
  },
  mounted() {
    eventBus.$on(
      "edit-lesson-3",
      function(response) {
        this.modalEditPdf = true;
        this.lessonId = response[0]["id"];
        this.name = response[0]["title"];
        this.realName = response[0]["real_name"];
        this.pdfName = response[0]["path"];
        this.previewImg =
          "" + this.getUrlToContents() + "content/" + response[0]["path"];
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
      var form = document.getElementById("form-lesson-pdf-edit");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "edit");
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

    actionsToBePerformedAfterEdit() {
      this.modalEditPdf = false;
      eventBus.$emit("new-lesson");
      eventUpload.$emit("clear");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
