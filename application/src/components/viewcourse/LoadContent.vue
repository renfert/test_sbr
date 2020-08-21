<template>
  <el-container>
    <el-main>
      <facebook-loader
        v-if="loading == true"
        :speed="2"
        width="400"
        height="200"
        style="margin-left:15%;margin-top:5%;"
        primaryColor="#f0f0f0"
        secondaryColor="#d9d9d9"
      ></facebook-loader>
      <div class="content" v-else>
        <!-- Video -->
        <div class="player-container" v-if="showVideo">
          <vue-plyr>
            <video
              preload="none"
              v-on:ended="finishLesson()"
              :src="this.getUrlToContents() + 'content/'+path+''"
            ></video>
          </vue-plyr>
        </div>

        <!-------- 
        Audio 
        ---------->
        <div class="player-container" v-if="showAudio">
          <vue-plyr>
            <video
              preload="none"
              v-on:ended="finishLesson()"
              :src="this.getUrlToContents() + 'content/'+path+''"
            ></video>
          </vue-plyr>
        </div>

        <!------------------ 
          Videoconference
        ----------------->
        <div class="videoconference-container" v-if="showVideoConf">
          <!-- Title -->
          <h2 class="card-title text-center">{{title}}</h2>
          <h3 class="card-title h6 pl-5 pr-5 text-center">{{description}}</h3>
          <hr class="my-4 rgba-white-light" />

          <div class="row gap-10">
            <div class="col-12 col-md-4 text-center">
              <div>
                <img src="@/assets/img/general/ux/calendar.png" class="content-icons mb-3" />
                <h4>{{lang["date"]}}: {{date}}</h4>
              </div>
            </div>

            <div class="col-12 col-md-4 text-center">
              <div>
                <img src="@/assets/img/general/ux/webinar.png" class="content-icons" />
                <br />
                <br />
                <el-button class="sbr-primary" size="medium">
                  <a
                    @click="finishLesson()"
                    :href="url"
                    target="_blank"
                    class="text-white"
                  >{{lang["enter"]}}</a>
                </el-button>
              </div>
            </div>

            <div class="col-12 col-md-4 text-center">
              <div>
                <img class="content-icons mb-3" src="@/assets/img/general/ux/clock.png" />
                <h4>{{lang["schedule"]}}: {{time}}</h4>
              </div>
            </div>
          </div>
        </div>

        <!---------- 
          Webinar 
        ------------->
        <div class="webinar-container" v-if="showWebinar">
          <!-- Title -->
          <h2 class="card-title text-center">{{title}}</h2>
          <h3 class="card-title h6 pl-5 pr-5 text-center">{{description}}</h3>
          <hr class="my-4 rgba-white-light" />

          <div class="row gap-10">
            <div class="col-12 col-md-4 text-center">
              <div>
                <img src="@/assets/img/general/ux/calendar.png" class="content-icons mb-3" />
                <h4>{{lang["date"]}}: {{date}}</h4>
              </div>
            </div>

            <div class="col-12 col-md-4 text-center">
              <div>
                <img src="@/assets/img/general/ux/webinar.png" class="content-icons" alt="clock" />
                <br />
                <br />
                <el-button class="sbr-primary" size="medium">
                  <a
                    class="text-white"
                    @click="finishLesson()"
                    :href="url"
                    target="_blank"
                  >{{lang["enter"]}}</a>
                </el-button>
              </div>
            </div>

            <div class="col-12 col-md-4 text-center">
              <div>
                <img src="@/assets/img/general/ux/clock.png" class="content-icons mb-3" />
                <h4>{{lang["schedule"]}}: {{time}}</h4>
              </div>
            </div>
          </div>
        </div>

        <!--------------------- 
          Downloadable content 
        ----------------------->
        <div class="webinar-container" v-if="showDownloadable">
          <!-- Title -->
          <h2 class="card-title text-center">{{title}}</h2>
          <hr class="my-4 rgba-white-light" />

          <div class="text-center gap-10">
            <img src="@/assets/img/general/ux/download.png" class="content-icons mb-3" />
            <br />
            <el-button class="sbr-primary" size="medium">
              <a
                @click="finishLesson()"
                :href="this.getUrlToContents() + 'content/'+path+''"
                download
                class="text-white"
              >{{lang["download"]}}</a>
            </el-button>
          </div>
        </div>

        <!--------------- 
          Html content 
        ------------------>
        <div class="html-container" v-if="showHtml">
          <!-- Title -->
          <h2 class="card-title h2 text-center">{{title}}</h2>
          <hr class="my-4 rgba-white-light" />
          <iframe
            style="width:100%;height:500px;"
            :src="this.getUrlToContents() + path + '/index.html'"
            frameborder="0"
          ></iframe>
        </div>

        <!-------------- 
          Pdf content 
        ---------------->
        <div class="pdf-container" v-if="showPDf">
          <iframe
            width="100%"
            height="500px"
            allowfullscreen
            webkitallowfullscreen
            :src="getCurrentDomainName() + 'ViewerJS/index.html#' + this.getUrlToContents() + 'content/' + path"
            frameborder="0"
            :key="componentKey"
          ></iframe>
        </div>

        <!--------- 
          Exam 
        ----------->
        <div v-if="showExam">
          <!-- Title -->
          <h2 class="card-title text-center">{{title}}</h2>
          <div class="row d-flex justify-content-center text-center">
            <div class="col-xl-7 pb-2">
              <el-tag
                type="danger"
                v-if="parseInt(overview['yourScore']) < parseInt(approval) && overview['waitingEvaluationQuestions'] == 0"
              >{{lang['not-passed']}}</el-tag>

              <el-tag
                type="success"
                v-if="parseInt(overview['yourScore']) >= parseInt(approval) && overview['waitingEvaluationQuestions'] == 0"
              >{{lang['passed']}}</el-tag>

              <el-tag
                type="warning"
                v-if="overview['waitingEvaluationQuestions'] != 0"
              >{{lang['exam-in-progress']}}</el-tag>
            </div>
          </div>
          <hr class="my-4 rgba-white-light" />

          <div class="row gap-10">
            <div class="col-12 col-md-4 text-center">
              <div>
                <img class="content-icons mb-3" src="@/assets/img/general/ux/clock.png" alt="clock" />
                <h4>{{lang["exam-duration"]}}: {{time}}</h4>
              </div>
            </div>

            <div class="col-12 col-md-4 text-center">
              <div>
                <img
                  class="content-icons"
                  src="@/assets/img/general/ux/pencil.png"
                  v-if="parseInt(userRetests) == 0"
                />

                <img
                  class="content-icons"
                  src="@/assets/img/general/ux/retest.png"
                  v-if="parseInt(userRetests) < parseInt(retest) && parseInt(userRetests) != 0 && parseInt(overview['yourScore']) < parseInt(approval) && parseInt(overview['waitingEvaluationQuestions']) == 0"
                  @click="openExamModal(lessonId)"
                />

                <img
                  class="content-icons"
                  src="@/assets/img/general/ux/correction.png"
                  v-if="parseInt(userRetests) == parseInt(retest) || parseInt(overview['yourScore']) >= parseInt(approval) "
                />

                <br />

                <!-- Start exam button -->
                <el-button
                  size="medium"
                  class="sbr-primary mt-3"
                  v-if="parseInt(userRetests) == 0"
                  @click="openExamModal(lessonId)"
                >{{lang["start-exam"]}}</el-button>

                <!-- Start retest button -->
                <el-button
                  size="medium"
                  class="sbr-primary mt-3"
                  v-if="parseInt(userRetests) < parseInt(retest) && parseInt(userRetests) != 0 && parseInt(overview['yourScore']) < parseInt(approval) && parseInt(overview['waitingEvaluationQuestions']) == 0"
                  @click="openExamModal(lessonId)"
                >{{lang["start-retest"]}}</el-button>

                <!-- Correction button -->
                <el-button
                  size="medium"
                  class="sbr-primary mt-3"
                  v-if="parseInt(userRetests) == parseInt(retest) || parseInt(overview['yourScore']) >= parseInt(approval)"
                  @click="openCorrection(lessonId)"
                >{{lang["see-exam-correction"]}}</el-button>
              </div>
            </div>

            <div class="col-12 col-md-4 text-center">
              <div>
                <img class="content-icons mb-3" src="@/assets/img/general/ux/attempts.png" />
                <h4>{{lang["attempts"]}}: {{userRetests}} / {{retest}}</h4>
              </div>
            </div>
          </div>

          <!-- Modal exam -->
          <exam></exam>

          <!-- Correction exam -->
          <exam-correction></exam-correction>

          <!-- Finished exam modal -->
          <el-dialog
            :visible.sync="modal"
            center
            :title="lang['exam-finished']"
            width="50%"
            top="30vh"
          >
            <div class="text-center">
              <img
                class="content-icons mb-3"
                src="@/assets/img/general/ux/correction.png"
                alt="download"
              />
              <br />
              <el-button
                @click.prevent="openCorrection(lessonId)"
                href="javascript:void(0)"
                class="sbr-primary"
              >{{lang["see-result"]}}</el-button>
            </div>
          </el-dialog>
        </div>
      </div>
    </el-main>
  </el-container>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VuePlyr from "vue-plyr";
import Exam from "@/components/viewcourse/Exam";
import ExamCorrection from "@/components/viewcourse/correction/ExamCorrection";
import verify from "@/mixins/verify";

import { eventCorrection } from "@/components/viewcourse/correction/ExamCorrection";
import { eventBus } from "@/components/viewcourse/App";
import { FacebookLoader } from "vue-content-loader";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);
Vue.use(VuePlyr, {
  plyr: {
    fullscreen: { enabled: true }
  },
  emit: ["ended"]
});

export default {
  mixins: [domains, alerts, verify],
  data: () => {
    return {
      title: "",
      path: "",
      date: "",
      time: "",
      description: "",
      url: "",
      approval: "",
      retest: "",
      userRetests: "",
      lessonId: "",
      lessonStatus: "",

      componentKey: 0,

      showVideo: false,
      showAudio: false,
      showPDf: false,
      showDownloadable: false,
      showExam: false,
      showWebinar: false,
      showVideoConf: false,
      showHtml: false,
      overview: "",

      courseId: "",
      studentId: "",

      modal: false,
      loading: true
    };
  },
  components: {
    Exam,
    ExamCorrection,
    FacebookLoader
  },
  created() {
    this.courseId = this.$route.params.id;
    this.verifyCourseReleased(this.courseId);
    this.verifyCourseExpiration(this.courseId);
  },
  mounted() {
    this.getUserProfile();

    eventBus.$on(
      "load-lesson",
      function(data) {
        this.loading = true;
        this.lessonId = data["lessonId"];
        this.lessonStatus = data["lessonStatus"];
        this.getLesson(data["lessonId"]);

        if (data["lessonType"] == 3 || data["lessonType"] == 7) {
          this.finishLesson();
        }
      }.bind(this)
    );

    eventBus.$on(
      "exam-finished",
      function() {
        this.modal = true;
        this.getExamOverview();
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    finishLesson: function() {
      if (this.lessonStatus != "finished") {
        var formData = new FormData();
        formData.set("lessonId", this.lessonId);
        formData.set("studentId", this.studentId);
        var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
          "lesson",
          "finish"
        );
        axios.post(urlToBeUsedInTheRequest, formData).then(
          () => {
            /* Success callback */
            eventBus.$emit("update-progress-bar");
            eventBus.$emit("update-modules");
          },
          /* Error callback */
          function() {
            this.errorMessage();
          }.bind(this)
        );
        this.$notify({
          title: this.lang["lesson-finished"],
          position: "bottom-left",
          type: "success"
        });
      }
    },

    forceRerender: function() {
      this.componentKey += 1;
    },

    getUserRetest: function(examId) {
      var formData = new FormData();
      formData.set("lessonId", examId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "lesson",
        "getUserRetest"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          /* Success callback */
          this.userRetests = response.data[0]["retest"];
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },

    getExamOverview: function() {
      var formData = new FormData();
      formData.set("examId", this.lessonId);
      formData.set("studentId", this.studentId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "exam",
        "getExamOverview"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.overview = response.data[0];
        },

        function() {
          this.errorMessage();
        }.bind(this)
      );
    },

    getUserProfile() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.studentId = response.data["id"];
        }.bind(this)
      );
    },

    getLesson: function(lessonId) {
      var formData = new FormData();
      formData.set("lessonId", lessonId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "get");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          /* Success callback */
          this.title = response.data["title"];
          this.description = response.data["description"];
          this.path = response.data["path"];
          this.date = response.data["date"];
          this.time = response.data["time"];
          this.url = response.data["url"];
          this.approval = response.data["approval"];
          this.retest = response.data["retest"];

          this.renderLesson(response.data["type_mylesson_id"]);
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    openExamModal: function(examId) {
      var data = {
        lessonId: examId,
        lessonType: this.lessonType,
        lessonStatus: this.lessonStatus
      };
      eventBus.$emit("open-exam-modal", data);
    },
    openCorrection: function(examId) {
      var data = {
        examId: examId,
        studentId: this.studentId
      };
      this.modal = false;
      eventCorrection.$emit("open-exam-correction", data);
    },
    renderLesson: function(lessonType) {
      this.hideAllLessons();
      switch (lessonType) {
        case "1":
          this.showVideo = true;
          break;
        case "2":
          this.showAudio = true;
          break;
        case "3":
          this.forceRerender();
          this.showPDf = true;
          break;
        case "4":
          this.showDownloadable = true;
          break;
        case "5":
          this.showVideoConf = true;
          break;
        case "6":
          this.showWebinar = true;
          break;
        case "7":
          this.showHtml = true;
          break;
        case "8":
          this.showExam = true;
          this.getUserRetest(this.lessonId);
          this.getExamOverview();
          break;
      }

      setTimeout(
        function() {
          this.loading = false;
        }.bind(this),
        1000
      );
    },
    hideAllLessons: function() {
      this.showVideo = false;
      this.showAudio = false;
      this.showPDf = false;
      this.showDownloadable = false;
      this.showExam = false;
      this.showWebinar = false;
      this.showVideoConf = false;
      this.showHtml = false;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
video {
  max-width: 100%;
}
.card-title {
  color: #9e9c9c;
}

.content-icons {
  width: 50px;
}
</style>
