<template>
  <div>
    <el-divider class="mb-5">
      <i class="el-icon-edit"></i>
    </el-divider>

    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <el-tabs :tab-position="tabPosition" v-else>
      <el-tab-pane v-for="(element, index) in questions" :key="element.id">
        <span v-if="element.score == null && roleId != 3" slot="label">
          <i class="mdi mdi-buffer"></i>
          Question {{parseInt(index) + parseInt(1)}}
        </span>

        <span v-else slot="label">Question {{parseInt(index) + parseInt(1)}}</span>

        <!-- Correction button -->
        <el-row v-if="element.type_question_id != 2 && roleId != 3 && element.score == null">
          <div class="float-right">
            <el-button
              class="sbr-primary"
              @click.prevent="openRateModal(element.feedback, element.score, element.id)"
              icon="el-icon-edit"
              circle
            ></el-button>
          </div>
        </el-row>

        <div class="col-12">
          <span>Question weight</span>
          <el-rate disabled :value="parseInt(element.weight)"></el-rate>
          <h3 class="sbr-text-primary">{{element.question}}</h3>
          <hr />

          <!-- Description answer -->
          <div v-if="element.type_question_id == 1">
            <h3 class="sbr-text-primary">{{lang["answer"]}}</h3>
            <exam-correction-student-answer
              :student-id="studentId"
              :question-type="1"
              :question-id="element.id"
            ></exam-correction-student-answer>
          </div>

          <div v-if="element.type_question_id == 2">
            <!-- Checked alternatives -->
            <el-row>
              <el-col :span="24">
                <h5 class="sbr-text-primary">{{lang["checked-alternatives"]}}</h5>
                <exam-correction-student-answer
                  :student-id="studentId"
                  :question-type="2"
                  :question-id="element.id"
                ></exam-correction-student-answer>
              </el-col>
            </el-row>
          </div>

          <!-- Free question  -->
          <div v-if="element.type_question_id == 3">
            <h3 class="sbr-text-primary">{{lang["answer"]}}</h3>
            <exam-correction-student-answer
              :student-id="studentId"
              :question-type="3"
              :question-id="element.id"
            ></exam-correction-student-answer>
          </div>
        </div>

        <!-- Correction modal -->
        <el-dialog
          append-to-body
          :visible.sync="modal"
          :title="lang['rate-question']"
          center
          width="40%"
          top="5vh"
        >
          <form id="form-rate">
            <h3 class="sbr-text-primary">{{lang['feedback']}}</h3>
            <el-input type="textarea" :rows="5" v-model="feedback" name="feedback"></el-input>
            <div class="block mb-4">
              <h3 class="sbr-text-primary">{{lang['score']}}</h3>
              <el-input-number :step="10" v-if="score != null" v-model="score" :min="0" :max="100"></el-input-number>
            </div>
            <el-button
              class="sbr-btn sbr-primary"
              @click.prevent="saveEvaluation"
              type="primary"
              size="medium"
            >{{lang["save-button"]}}</el-button>
          </form>
        </el-dialog>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import ExamCorrectionStudentAnswer from "@/components/viewcourse/correction/ExamCorrectionStudentAnswer";

import { eventCorrection } from "@/components/viewcourse/correction/ExamCorrection";
import { FacebookLoader } from "vue-content-loader";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  components: {
    ExamCorrectionStudentAnswer,
    FacebookLoader
  },
  props: ["exam-id", "student-id"],
  mixins: [domains, alerts],
  data: () => {
    return {
      questions: [],
      counter: 0,
      modal: false,
      feedback: "",
      score: null,
      roleId: "",
      questionId: "",
      loadingContent: false,
      tabPosition: "left"
    };
  },
  mounted() {
    this.verifyScreenWidth();
    this.getExamQuestions();
    this.getUserProfile();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    verifyScreenWidth() {
      if (screen.width <= 512) {
        this.tabPosition = "top";
      }
    },
    getExamQuestions: function() {
      this.loadingContent = true;
      var formData = new FormData();
      formData.set("examId", this.examId);
      formData.set("studentId", this.studentId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "corrections",
        "listingQuestions"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.questions = response.data;
          setTimeout(
            function() {
              this.loadingContent = false;
            }.bind(this),
            1000
          );
        },
        /* Error callback */
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
          this.roleId = response.data["myrole_id"];
        }.bind(this)
      );
    },
    saveEvaluation: function() {
      this.loading = true;
      var formData = new FormData();
      formData.set("feedback", this.feedback);
      formData.set("score", this.score);
      formData.set("questionId", this.questionId);
      formData.set("studentId", this.studentId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "question",
        "correction"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.modal = false;
          eventCorrection.$emit("finish-correction");
          this.getExamQuestions();
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    openRateModal: function(feedback, score, questionId) {
      if (score == undefined) {
        this.score = 0;
      } else {
        this.score = parseInt(score);
      }
      this.feedback = feedback;
      this.questionId = questionId;
      this.modal = true;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
