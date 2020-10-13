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
        <span v-if="element.score == null && user.role != 3" slot="label">
          <i class="mdi mdi-buffer"></i>
          Question {{ parseInt(index) + parseInt(1) }}
        </span>

        <span v-else slot="label"
          >Question {{ parseInt(index) + parseInt(1) }}</span
        >

        <!-- Correction button -->
        <el-row
          v-if="
            element.type_question_id != 2 &&
            user.role != 3 &&
            element.score == null
          "
        >
          <div class="float-right">
            <i
              @click.prevent="
                openRateModal(element.feedback, element.score, element.id)
              "
              class="el-icon-edit-outline table-icon table-icon-primary blob"
            ></i>
          </div>
        </el-row>

        <div class="col-12">
          <h4>{{ lang['question-weight'] }}</h4>
          <el-rate disabled :value="parseInt(element.weight)"></el-rate>
          <h3 class="fw-500">{{ element.question }}</h3>
          <hr />

          <!-- Description answer -->
          <div v-if="element.type_question_id == 1">
            <h3 class="sbr-text-primary fw-600">{{ lang['answer'] }}</h3>
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
                <h5 class="sbr-text-primary">
                  {{ lang['checked-alternatives'] }}
                </h5>
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
            <h3 class="sbr-text-primary">{{ lang['answer'] }}</h3>
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
          width="30%"
          top="10vh"
        >
          <form id="form-rate">
            <h3 class="sbr-text-primary">{{ lang['feedback'] }}</h3>
            <el-input
              type="textarea"
              :rows="5"
              v-model="feedback"
              name="feedback"
            ></el-input>
            <div class="block mb-4">
              <h3 class="sbr-text-primary">{{ lang['score'] }}</h3>
              <el-input-number
                :step="10"
                v-if="score != null"
                v-model="score"
                :min="0"
                :max="100"
              ></el-input-number>
            </div>
            <el-button
              class="sbr-btn sbr-primary"
              @click.prevent="saveEvaluation"
              type="primary"
              size="medium"
              >{{ lang['save-button'] }}</el-button
            >
          </form>
        </el-dialog>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import ExamCorrectionStudentAnswer from '@/components/viewcourse/correction/ExamCorrectionStudentAnswer';

import { eventCorrection } from '@/components/viewcourse/correction/ExamCorrection';
import { FacebookLoader } from 'vue-content-loader';
import { mapState } from 'vuex';

export default {
  components: {
    ExamCorrectionStudentAnswer,
    FacebookLoader
  },
  props: ['exam-id', 'student-id'],
  data: () => {
    return {
      questions: [],
      counter: 0,
      modal: false,
      feedback: '',
      score: null,
      questionId: '',
      loadingContent: false,
      tabPosition: 'left'
    };
  },
  mounted() {
    this.verifyScreenWidth();
    this.getExamQuestions();
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  methods: {
    verifyScreenWidth() {
      if (screen.width <= 512) {
        this.tabPosition = 'top';
      }
    },
    getExamQuestions() {
      this.loadingContent = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'corrections',
        'listingQuestions'
      );
      formData.set('examId', this.examId);
      formData.set('studentId', this.studentId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.questions = response.data;
          setTimeout(() => {
            this.loadingContent = false;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    saveEvaluation() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'question',
        'correction'
      );
      formData.set('feedback', this.feedback);
      formData.set('score', this.score);
      formData.set('questionId', this.questionId);
      formData.set('studentId', this.studentId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.modal = false;
          eventCorrection.$emit('finish-correction');
          this.getExamQuestions();
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    openRateModal(feedback, score, questionId) {
      if (score === undefined) {
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

<style scoped>
.blob {
  border-radius: 50%;
  margin: 10px;
  height: 20px;
  width: 20px;

  box-shadow: 0 0 0 0 #009cd8;
  transform: scale(1);
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% {
    transform: scale(1);
    box-shadow: 0 0 0 0 #009cd8;
  }

  70% {
    transform: scale(1);
    box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
  }

  100% {
    transform: scale(1);
    box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
  }
}
</style>
