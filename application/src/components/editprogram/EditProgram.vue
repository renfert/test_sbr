<template>
  <div>
    <div class="card-program">
      <h4>{{lang["edit-program"]}}</h4>
      <br />
      <form @submit.prevent="edit()" id="form-program" v-loading="loading">
        <input name="programId" class="hide" type="text" v-model="programId" />
        <el-tabs tab-position="top">
          <el-tab-pane label="Basic information">
            <div class="row gap5">
              <div class="col-10">
                <div class="form-group">
                  <!-- Program name -->
                  <label>{{lang['name']}}</label>
                  <el-input
                    required
                    name="title"
                    :placeholder="lang['name']"
                    v-model="programTitle"
                  ></el-input>
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
                  <textarea class="hide" v-model="programDescription" name="description"></textarea>
                  <label class="col-form-label">{{lang["description"]}}</label>
                  <wysiwyg v-model="programDescription" />
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
                  v-model="coursesProgram"
                  :data="coursesList"
                ></el-transfer>
              </div>
            </div>
          </el-tab-pane>
          <el-tab-pane label="Image">
            <div class="row gap5">
              <div class="col-6">
                <upload
                  v-if="srcImg != ''"
                  :src-img="srcImg"
                  :src-name="srcName"
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
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import HelperProgress from "@/components/helper/HelperProgress.vue";
import wysiwyg from "vue-wysiwyg";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import Upload from "@/components/helper/HelperUpload";

import { mapState } from "vuex";

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
      programId: "",
      programTitle: "",
      programDescription: "",
      srcImg: "",
      srcName: "",
      release: "",
      expiration: "",
      description: "",
      coursesList: [],
      coursesProgram: [],
      loading: false
    };
  },
  components: {
    Upload,
    HelperProgress
  },
  created() {
    this.programId = this.$route.params.id;
  },
  mounted() {
    this.getProgram();
    this.getCourses();
    this.getProgramCourses();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getProgram: function() {
      var formData = new FormData();
      formData.set("programId", this.programId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("program", "get");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          // success callback
          this.programTitle = response.data[0]["title"];
          this.programDescription = response.data[0]["description"];
          this.srcName = response.data[0]["photo"];
          this.srcImg =
            this.getUrlToContents() +
            "program/" +
            response.data[0]["photo"] +
            "";

          this.expiration = response.data[0]["expiration_date"];
          this.release = response.data[0]["release_date"];
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
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
    edit: function() {
      var form = document.getElementById("form-program");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("program", "edit");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        function() {
          // success callback
          this.successMessage();
        }.bind(this),
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getProgramCourses: function() {
      var formData = new FormData();
      formData.set("programId", this.programId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "program",
        "getProgramCourses"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          // success callback
          response.data.forEach(element => {
            let courseId = element.id;
            this.coursesProgram.push(courseId);
          });
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.card-program {
  padding: 5%;
}
</style>
