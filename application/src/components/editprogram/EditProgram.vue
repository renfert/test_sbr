<template>
  <div>
    <h4>{{lang["edit-program"]}}</h4>
    <br />
    <form @submit.prevent="edit()" id="form-program" v-loading="loading">
      <input name="programId" class="hide" type="text" v-model="programId" />
      <el-tabs tab-position="top">
        <!--------------------
        Basic information tab
        ----------------------->
        <el-tab-pane label="Basic information">
          <div class="row gap5">
            <div class="col-10">
              <div class="form-group">
                <label>{{lang['name']}}</label>
                <el-input required name="title" :placeholder="lang['name']" v-model="programTitle"></el-input>
              </div>
              <div class="form-group">
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
                <textarea class="hide" v-model="programDescription" name="description"></textarea>
                <label class="col-form-label">{{lang["description"]}}</label>
                <wysiwyg v-model="programDescription" />
              </div>
            </div>
          </div>
        </el-tab-pane>
        <!--------------------
        Courses tab
        ----------------------->
        <el-tab-pane label="Courses">
          <div class="mt-5">
            <div>
              <el-form :inline="true" class="demo-form-inline">
                <el-form-item>
                  <el-select v-model="course" placeholder="Course">
                    <el-option
                      v-for="element in coursesList"
                      :key="element.key"
                      :label="element.label"
                      :value="element.key"
                    ></el-option>
                  </el-select>
                </el-form-item>
                <el-form-item>
                  <el-button
                    class="sbr-btn sbr-secondary"
                    @click.prevent="addCourse()"
                    type="primary"
                  >{{lang["add-course"]}}</el-button>
                </el-form-item>
              </el-form>
              <div class="mb-5">
                <ul class="list-group">
                  <draggable ghost-class="ghost" @end="repositioning">
                    <transition-group type="transition" name="flip-list">
                      <li
                        v-for="element in coursesProgram"
                        :key="element.id"
                        class="list-group-item d-flex justify-content-between align-items-center sortable"
                      >
                        <div>
                          <i
                            style="cursor:pointer !important;"
                            class="remove-course el-icon-delete sbr-text-danger mr-5"
                          ></i>
                          <input
                            class="courses-position hide"
                            :value="element.id"
                            :name="'courses['+parseInt(element.position)+']'"
                          />
                          {{element.title}}
                        </div>
                      </li>

                      <li
                        class="list-group-item d-flex justify-content-between align-items-center sortable"
                        v-for="element in selectedCourses"
                        :key="element.id"
                      >
                        <div v-html="element.text"></div>
                      </li>
                    </transition-group>
                  </draggable>
                </ul>
              </div>
            </div>
          </div>
        </el-tab-pane>
        <!--------------------
        Image tab
        ----------------------->
        <el-tab-pane label="Image">
          <div class="row gap5">
            <div class="col-md-6 col-12">
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
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import draggable from "vuedraggable";
import HelperProgress from "@/components/helper/HelperProgress.vue";
import wysiwyg from "vue-wysiwyg";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import ElementUI from "element-ui";
import Upload from "@/components/helper/HelperUpload";
import $ from "jquery";

import { mapState } from "vuex";

Vue.use(wysiwyg, {
  hideModules: { image: true, code: true, table: true, hyperlink: true }
});

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

      course: "",
      coursesList: [],
      coursesProgram: [],
      selectedCourses: [],

      cont: 0,

      loading: false
    };
  },
  components: {
    Upload,
    draggable,
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
    repositioning: function() {
      $(".courses-position").each(function(index) {
        $(this).attr("name", "courses[" + index + "]");
      });
    },
    addCourse: function() {
      let course = this.coursesList.find(element => element.key == this.course);

      let obj = {
        id: this.course,
        text:
          "\
            <i style='cursor:pointer !important;' class='remove-course el-icon-delete sbr-text-danger mr-5'></i>\
            <input class='courses-position hide' name='courses[" +
          this.cont +
          "]' value='" +
          this.course +
          "'>\
            " +
          course.label +
          "\
          "
      };
      this.cont++;
      this.selectedCourses.push(obj);
    },
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
          response.data.forEach(element => {
            this.cont = parseInt(element.position) + 1;
          });
          this.coursesProgram = response.data;
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
</style>
