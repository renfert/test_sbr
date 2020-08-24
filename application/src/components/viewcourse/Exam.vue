<template>
  <div>
    <lang></lang>
    <el-dialog
      :visible.sync="modal"
      center
      width="50%"
      top="5vh"
      :show-close="false"
      :close-on-click-modal="false"
      :close-on-press-escape="false"
    >
      <div slot="title" class="exam-header" v-if="examOn">
        <vac :end-time="new Date().getTime() + time" v-if="time != ''">
          <span slot="process" slot-scope="{ timeObj }">{{ `Lefttime: ${timeObj.m}:${timeObj.s}` }}</span>
          <span slot="finish">{{lang["your-time-is-over"]}}</span>
          <span slot-scope="{ state }" v-if="state == 'finised' ? finishExam() : ''">{{state}}</span>
        </vac>

        <div class="controls">
          <el-button-group>
            <el-button
              class="sbr-primary"
              @click="prevQuestion();"
              type="primary"
              icon="el-icon-arrow-left"
            >Previous question</el-button>
            <el-button class="sbr-primary" @click="nextQuestion();" type="primary">
              Next question
              <i class="el-icon-arrow-right"></i>
            </el-button>
          </el-button-group>
          <br />
          <br />

          <el-button
            v-loading="loading"
            :disabled="loading"
            class="sbr-purple"
            @click.prevent="finishExam()"
            v-if="showFinishExamButton"
            native-type="submit"
            type="success"
          >{{lang["finish-exam"]}}</el-button>
        </div>
      </div>

      <div slot="title" v-else>
        <h3>{{lang["process-exam"]}}</h3>
      </div>

      <form id="form-exam" :key="componentKey" v-if="examOn">
        <input type="text" class="hide" name="examId" v-model="examId" />
        <div
          style="margin-top:-40px !important;"
          :class="index == questionsControl ? '' : 'hide'"
          class="questions"
          v-for="(element , index) in questions"
          :key="index"
        >
          <div class="current-question" :class="index == questionsControl ? '' : 'hide'">
            <h3 class="text-center">Question {{index + 1}} / {{numberOfQuestions}}</h3>
            <br />
            <h3 class="text-eadtools">{{element.question}}</h3>
            <div class="demo-image__preview">
              <el-image
                v-if="element.image != null && element.image != ''"
                :src="''+getUrlToContents()+'question/' + element.image"
                fit="scale-down"
              >
                <div slot="error" class="image-slot">
                  <i class="el-icon-picture-outline"></i>
                </div>
              </el-image>
            </div>

            <el-divider>
              <i class="el-icon-edit"></i>
            </el-divider>

            <div class="answers">
              <!-- Descriptive -->
              <div class="descriptive" v-if="element.type_question_id == 1">
                <textarea :name="'answer['+element.id+']'" class="form-control" rows="10"></textarea>
              </div>

              <!-- Multiple -->
              <div class="multiple" v-if="element.type_question_id == 2">
                <answers-list :question-id="element.id"></answers-list>
              </div>

              <!-- Free -->
              <div class="free" v-if="element.type_question_id == 3">
                <upload
                  do-upload="true"
                  box-height="200"
                  :return-name="'answer['+element.id+']'"
                  input-name="file"
                  bucket-key="uploads/answers"
                  acceptable=".*"
                ></upload>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div v-else class="text-center">
        <img src="https://sbrfiles.s3.amazonaws.com/gifs/loader4.gif" style="width:50%;" alt />
      </div>
    </el-dialog>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import Lang from "@/components/helper/HelperLang";
import { eventLang } from "@/components/helper/HelperLang";
import { eventBus } from "@/components/viewcourse/App";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VuePlyr from "vue-plyr";
import vueAwesomeCountdown from "vue-awesome-countdown";
import AnswersList from "@/components/viewcourse/AnswersList";
import HelperProgress from "@/components/helper/HelperProgress";
import Upload from "@/components/helper/HelperUpload";
import $ from "jquery";

locale.use(lang);
Vue.use(VueAxios, axios);
Vue.use(ElementUI);
Vue.use(vueAwesomeCountdown, "vac");
Vue.use(VuePlyr, {
  plyr: {
    fullscreen: { enabled: true }
  },
  emit: ["ended"]
});
export default {
  components: {
    Lang,
    AnswersList,
    HelperProgress,
    Upload
  },
  mixins: [domains, alerts],
  data: () => {
    return {
      lang: {},
      modal: false,
      questions: [],
      time: "",
      examId: "",
      lessonStatus: "",
      lessonType: "",
      questionsControl: 0,
      numberOfQuestions: "",
      descriptionAnswer: "",
      fileName: "",
      icon: "fas fa-cloud-upload-alt",
      message: "Upload a file",
      answerImage: "",
      retest: "",
      componentKey: 0,
      loading: false,
      examOn: true,

      showFinishExamButton: false
    };
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );

    eventBus.$on(
      "open-exam-modal",
      function(data) {
        this.questionsControl = 0;
        this.showFinishExamButton = false;

        this.clear();

        this.modal = true;
        this.examId = data["lessonId"];
        this.lessonStatus = data["lessonStatus"];
        this.lessonType = data["lessonType"];
        this.getExam(data["lessonId"]);
        this.getQuestions(data["lessonId"]);
      }.bind(this)
    );
  },

  methods: {
    clear: function() {
      $(document).ready(function() {
        $("#form-exam")
          .find("input:file,textarea")
          .val("");
      });
    },
    forceRerender: function() {
      this.componentKey += 1;
    },
    finishExam() {
      this.examOn = false;
      var form = document.getElementById("form-exam");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("exam", "finish");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          var data = {
            lessonId: this.examId,
            lessonStatus: this.lessonStatus,
            lessonType: this.lessonType
          };

          setTimeout(
            function() {
              eventBus.$emit("exam-finished");
              eventBus.$emit("load-lesson", data);

              eventBus.$emit("update-progress-bar");
              eventBus.$emit("update-modules");

              this.forceRerender();
            }.bind(this),
            6000
          );
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getExam: function(examId) {
      var formData = new FormData();
      formData.set("lessonId", examId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "get");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          /* Success callback */
          this.time = parseInt(response.data["time"]) * 60000;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    nextQuestion: function() {
      if (this.questionsControl != this.numberOfQuestions - 1) {
        this.questionsControl = this.questionsControl + 1;
        this.showFinishExamButton = false;
      }

      if (this.questionsControl == this.numberOfQuestions - 1) {
        this.showFinishExamButton = true;
      }
    },
    prevQuestion: function() {
      if (this.questionsControl != 0) {
        this.questionsControl = this.questionsControl - 1;
        this.showFinishExamButton = false;
      }
    },
    getQuestions: function(examId) {
      var formData = new FormData();
      formData.set("examId", examId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "question",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.questions = response.data;
          this.numberOfQuestions = response.data.length;
        },
        /* Error callback */
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
.exam-header {
  color: black;
  font-family: "Poppins", sans-serif !important;
  font-size: 2em;
}

.controls {
  padding: 10px;
}

.answers {
  padding-top: 3%;
}
</style>
