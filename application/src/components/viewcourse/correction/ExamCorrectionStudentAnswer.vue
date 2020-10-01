<template>
  <div>
    <!-- Descriptive answer -->
    <div v-if="questionType == 1">
      <div v-for="element in studentAnswer" :key="element.id">
        <el-input
          v-if="element.answer != '' && element.answer != null"
          :value="element.answer"
          type="textarea"
          :rows="5"
        ></el-input>
        <el-tag v-else type="danger mb-2">{{ lang['answer-empty'] }}</el-tag>
        <div>
          <hr />
          <!-- Progress -->
          <div v-if="element.score != null">
            <h3 class="sbr-text-primary">{{ lang['score'] }}</h3>
            <el-progress :percentage="parseInt(element.score)"></el-progress>
          </div>

          <div v-else>
            <el-tag type="warning mb-2">{{
              lang['question-in-process-of-evaluation']
            }}</el-tag>
          </div>

          <!-- Feedback -->
          <div v-if="element.feedback != null && element.feedback != 'null'">
            <h3 class="sbr-text-primary">{{ lang['feedback'] }}</h3>
            <el-input
              type="textarea"
              :rows="5"
              :value="element.feedback"
            ></el-input>
            <!-- Feedback useful or not -->
            <div v-if="element.feedback_useful == null && user.role == 3">
              <a
                @click.prevent="avaliateFeedback('yes')"
                class="text-success pr-2"
              >
                <i class="far fa-thumbs-up"></i>
              </a>

              <a @click.prevent="avaliateFeedback('no')" class="text-danger">
                <i class="far fa-thumbs-down"></i>
              </a>
            </div>
          </div>

          <div v-else>
            <div
              v-if="
                element.automaticFeedback != null &&
                element.automaticFeedback != ''
              "
            >
              <h3 class="sbr-text-primary">{{ lang['feedback'] }}</h3>
              <el-input
                type="textarea"
                :rows="5"
                :value="element.automaticFeedback"
              ></el-input>
              <!-- Feedback useful or not -->
              <div v-if="element.feedback_useful == null && user.role == 3">
                <a
                  @click.prevent="avaliateFeedback('yes')"
                  class="text-success pr-2"
                >
                  <i class="far fa-thumbs-up"></i>
                </a>

                <a @click.prevent="avaliateFeedback('no')" class="text-danger">
                  <i class="far fa-thumbs-down"></i>
                </a>
              </div>
            </div>
            <div v-else>
              <el-tag type="info">{{ lang['no-feedbacks'] }}</el-tag>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Multiple answer -->
    <div v-if="questionType == 2">
      <div
        v-for="element in answers"
        :key="element.id"
        class="custom-control custom-checkbox"
      >
        <input
          :checked="verifyIsAnswerIsCorrect(element.id)"
          :value="element.id"
          :name="'answer[' + questionId + '][' + element.id + ']'"
          type="checkbox"
          class="custom-control-input"
          :id="'answer' + element.id"
        />
        <label class="custom-control-label" :for="'answer' + element.id">{{
          element.answer
        }}</label>
      </div>
      <hr />

      <!-- Progress -->
      <div>
        <h3 class="sbr-text-primary">{{ lang['score'] }}</h3>
        <el-progress v-if="score != null" :percentage="score"></el-progress>
      </div>

      <!-- Feedback -->
      <div v-if="feedback != null">
        <h3 class="sbr-text-primary">{{ lang['feedback'] }}</h3>
        <el-input type="textarea" :rows="5" :value="feedback"></el-input>
        <!-- Feedback useful or not -->
        <div v-if="feedbackUseful == null && user.role == 3">
          <a
            href="javascript:void(0)"
            @click.prevent="avaliateFeedback('yes')"
            class="text-success pr-2"
          >
            <i class="far fa-thumbs-up"></i>
          </a>

          <a
            href="javascript:void(0)"
            @click.prevent="avaliateFeedback('no')"
            class="text-danger"
          >
            <i class="far fa-thumbs-down"></i>
          </a>
        </div>
      </div>

      <div v-else>
        <div v-if="automaticFeedback != null && automaticFeedback != ''">
          <h3 class="sbr-text-primary">{{ lang['feedback'] }}</h3>
          <el-input
            type="textarea"
            :rows="5"
            :value="automaticFeedback"
          ></el-input>
          <!-- Feedback useful or not -->
          <div v-if="feedbackUseful == null && user.role == 3">
            <a
              href="javascript:void(0)"
              @click.prevent="avaliateFeedback('yes')"
              class="text-success pr-2"
            >
              <i class="far fa-thumbs-up"></i>
            </a>

            <a
              href="javascript:void(0)"
              @click.prevent="avaliateFeedback('no')"
              class="text-danger"
            >
              <i class="far fa-thumbs-down"></i>
            </a>
          </div>
        </div>
        <div v-else>
          <el-tag type="info">{{ lang['no-feedbacks'] }}</el-tag>
        </div>
      </div>
    </div>

    <!-- Free answer -->
    <div v-if="questionType == 3">
      <div v-for="element in studentAnswer" :key="element.id">
        <a
          v-if="element.answer != '' && element.answer != null"
          download
          :href="'' + $getUrlToContents() + 'answers/' + element.answer"
          >{{ lang['download-answer'] }} <i class="el-icon-bottom"></i
        ></a>

        <el-tag v-else type="danger mb-2">{{ lang['answer-empty'] }}</el-tag>
        <div>
          <hr />
          <!-- Progress -->
          <div v-if="element.score != null">
            <h3 class="sbr-text-primary">{{ lang['score'] }}</h3>
            <el-progress :percentage="parseInt(element.score)"></el-progress>
          </div>

          <div v-else>
            <el-tag type="warning mb-2">{{
              lang['question-in-process-of-evaluation']
            }}</el-tag>
          </div>

          <!-- Feedback -->
          <div v-if="element.feedback != null && element.feedback != 'null'">
            <h3 class="sbr-text-primary">{{ lang['feedback'] }}</h3>
            <el-input
              type="textarea"
              :rows="5"
              :value="element.feedback"
            ></el-input>
            <!-- Feedback useful or not -->
            <div v-if="element.feedback_useful == null && user.role == 3">
              <a
                href="javascript:void(0)"
                @click.prevent="avaliateFeedback('yes')"
                class="text-success pr-2"
              >
                <i class="far fa-thumbs-up"></i>
              </a>
              <a
                href="javascript:void(0)"
                @click.prevent="avaliateFeedback('no')"
                class="text-danger"
              >
                <i class="far fa-thumbs-down"></i>
              </a>
            </div>
          </div>

          <div v-else>
            <div v-if="element.automaticFeedback != null">
              <h3 class="sbr-text-primary">{{ lang['feedback'] }}</h3>
              <el-input
                type="textarea"
                :rows="5"
                :value="element.automaticFeedback"
              ></el-input>
              <!-- Feedback useful or not -->
              <div v-if="element.feedback_useful == null && user.role == 3">
                <a href class="text-success pr-2">
                  <i class="far fa-thumbs-up"></i>
                </a>
                <a href class="text-danger">
                  <i class="far fa-thumbs-down"></i>
                </a>
              </div>
            </div>
            <div v-else>
              <el-tag type="info">{{ lang['no-feedbacks'] }}</el-tag>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { eventCorrection } from '@/components/viewcourse/correction/ExamCorrection';
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      studentAnswer: [],
      answers: [],
      feedback: '',
      automaticFeedback: '',
      score: null,
      feedbackUseful: null
    };
  },
  mounted() {
    this.getStudentAnswer();
    eventCorrection.$on('finish-correction', () => {
      this.getStudentAnswer();
    });
  },
  props: ['question-id', 'question-type', 'student-id'],
  computed: {
    ...mapState(['lang', 'user'])
  },
  methods: {
    getStudentAnswer() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'answer',
        'getStudentAnswer'
      );
      formData.set('questionId', this.questionId);
      formData.set('studentId', this.studentId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.studentAnswer = response.data;
          this.feedback = response.data[0].feedback;
          this.automaticFeedback = response.data[0].automaticFeedback;
          this.score = parseInt(response.data[0].score);
          this.feedbackUseful = response.data[0].feedback_useful;
          this.getAnswers();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    avaliateFeedback(avaliation) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'question',
        'avaliateFeedback'
      );
      formData.set('questionId', this.questionId);
      formData.set('avaliation', avaliation);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$message({
            message: this.lang['thanks-for-your-avaliation'],
            type: 'success'
          });
          this.getStudentAnswer();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getAnswers() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'answer',
        'listing'
      );
      formData.set('questionId', this.questionId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.answers = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    verifyIsAnswerIsCorrect(answerId) {
      let checked = false;
      this.studentAnswer.forEach((element) => {
        if (answerId === element.answer) {
          checked = true;
        }
      });
      return checked;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.custom-checkbox .custom-control-label::before {
  border-radius: 0.25rem;
  top: -1%;
}

.custom-control {
  position: relative;
  display: block;
  min-height: 1.5rem;
  padding-left: 1.5rem;
  padding-bottom: 2rem;
}

.custom-checkbox .custom-control-input:checked ~ .custom-control-label::after {
  top: -1%;
}
</style>
