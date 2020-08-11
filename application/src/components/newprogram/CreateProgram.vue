<template>
  <div>
    <div class="card-program" v-if="showContent == true">
      <h4>{{lang["create-program"]}}</h4>
      <br />
      <form @submit.prevent="create()" id="form-program" v-loading="loading">
        <el-tabs tab-position="top">
          <el-tab-pane label="Basic information">
            <div class="row gap5">
              <div class="col-10">
                <div class="form-group">
                  <!-- Program name -->
                  <label>{{lang['name']}}</label>
                  <el-input required name="title" :placeholder="lang['name']" v-model="name"></el-input>
                </div>
                <div class="form-group">
                  <!-- Program release date -->
                  <label>{{lang['start-date']}}</label>
                  <br />
                  <el-date-picker
                    name="release_date"
                    v-model="release"
                    type="date"
                    format="yyyy/MM/dd"
                    value-format="yyyy-MM-dd"
                    placeholder="Pick a day"
                  ></el-date-picker>
                </div>
                <div class="form-group">
                  <!-- Program expiration date -->
                  <label>{{lang['end-date']}}</label>
                  <br />
                  <el-date-picker
                    name="expiration_date"
                    v-model="expiration"
                    type="date"
                    format="yyyy/MM/dd"
                    value-format="yyyy-MM-dd"
                    placeholder="Pick a day"
                  ></el-date-picker>
                </div>
                <div class="form-group">
                  <!-- Program description -->
                  <textarea class="hide" v-model="description" name="description"></textarea>
                  <label class="col-form-label">{{lang["description"]}}</label>
                  <wysiwyg v-model="description" />
                </div>
              </div>
            </div>
          </el-tab-pane>
          <el-tab-pane label="Courses">
            <div class="row gap5">
              <div class="col-12">
                <el-transfer
                  filterable
                  :titles="['Courses', 'Program']"
                  v-model="courses"
                  :data="coursesList"
                ></el-transfer>
              </div>
            </div>
          </el-tab-pane>
          <el-tab-pane label="Image">
            <div class="row gap5">
              <div class="col-6">
                <upload
                  do-upload="true"
                  box-height="200"
                  return-name="photo"
                  input-name="file"
                  bucket-key="uploads/program"
                  acceptable=".png,.jpg,.jpeg"
                ></upload>
              </div>
            </div>
          </el-tab-pane>
        </el-tabs>
        <br />
        <el-button native-type="submit" class="sbr-btn sbr-primary">{{lang["save-button"]}}</el-button>
      </form>
    </div>
    <helper-progress></helper-progress>
    <program-created
      :class="programId == '' ? 'hide' : 'main'"
      :program-name="name"
      :program-id="programId"
    ></program-created>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import { eventLang } from "@/components/helper/HelperLang";
import ProgramCreated from "@/components/newprogram/ProgramCreated";
import HelperProgress from "@/components/helper/HelperProgress.vue";
import wysiwyg from "vue-wysiwyg";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import Upload from "@/components/helper/HelperUpload";

Vue.use(wysiwyg, {
  hideModules: { image: true, code: true, table: true, hyperlink: true }
});

locale.use(lang);
Vue.use(ElementUI);
Vue.use(VueAxios, axios);
export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      lang: {},
      name: "",
      release: "",
      expiration: "",
      description: "",
      courses: [],
      coursesList: [],
      loading: false,
      modal: false,
      programId: "",
      programName: "",
      showContent: true
    };
  },
  components: {
    Upload,
    ProgramCreated,
    HelperProgress
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );

    this.getCourses();
  },
  methods: {
    getCourses: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "program",
        "getCourses"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          this.coursesList = response.data;
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    create: function() {
      this.loading = true;
      var form = document.getElementById("form-program");
      var formData = new FormData(form);
      formData.set("courses", this.courses);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "program",
        "create"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.programId = response.data;
          this.loading = false;
          this.showContent = false;
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },

    reloadPage: function() {
      location.reload();
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.img-program {
  width: 30%;
  margin-left: 35%;
}
.card-program {
  padding: 5%;
}
</style>
