<template>
  <!--  Modal new lesson -->
  <div>
    <el-dialog :visible.sync="modalCreateHtml" :title="lang['create-new-lesson']" center top="5vh">
      <form id="form-lesson-html" @submit.prevent="create()">
        <div class="form-row">
          <!-- Module id -->
          <input type="number" class="hide" name="moduleId" :value="moduleId" />
          <input type="text" class="hide" name="type_mylesson_id" value="7" />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{lang["name"]}} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Video upload -->
            <label class="col-form-label">Zip file *</label>
            <upload
              do-upload="true"
              box-height="200"
              return-name="path"
              input-name="file"
              bucket-key="uploads/html"
              acceptable=".zip"
            ></upload>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              class="sbr-primary"
              v-loading="loading"
              native-type="submit"
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
      htmlName: "",
      previewImg: "",
      realName: "",
      modalCreateHtml: false,
      loading: false
    };
  },
  mounted() {
    eventBus.$on(
      "new-html",
      function() {
        this.modalCreateHtml = true;
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
      var form = document.getElementById("form-lesson-html");
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
        }
      );
    },
    actionsToBePerformedAfterRegistration() {
      this.name = "";
      this.modalCreateHtml = false;
      eventBus.$emit("new-lesson");
      eventUpload.$emit("clear");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
