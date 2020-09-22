<template>
  <div>
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
        <vac
          @finish="finishExam()"
          :end-time="new Date().getTime() + time"
          v-if="time != ''"
        >
          <span
            class="sbr-text-primary fw-600"
            slot="process"
            slot-scope="{ timeObj }"
          >
            <img
              style="width: 50px"
              src="@/assets/img/general/ux/gifs/clock.gif"
              alt=""
            />
            <br />
            {{ `${timeObj.h}:${timeObj.m}:${timeObj.s}` }}
          </span>
          <span slot="finish">{{ lang['your-time-is-over'] }}</span>
          <span slot-scope="{ state }" v-if="state == 'finised'">{{
            state
          }}</span>
        </vac>

        <div class="controls">
          <el-button
            class="sbr-primary"
            @click="prevQuestion()"
            type="primary"
            icon="el-icon-arrow-left"
            >Previous question</el-button
          >
          <el-button class="sbr-primary" @click="nextQuestion()" type="primary">
            Next question
            <i class="el-icon-arrow-right"></i>
          </el-button>

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
            >{{ lang['finish-exam'] }}</el-button
          >
        </div>
      </div>

      <div slot="title" v-else>
        <h3>{{ lang['process-exam'] }}</h3>
      </div>

      <form id="form-exam" :key="componentKey" v-if="examOn">
        <input type="text" class="hide" name="examId" v-model="examId" />
        <div
          style="margin-top: -40px !important"
          :class="index == questionsControl ? '' : 'hide'"
          class="questions"
          v-for="(element, index) in questions"
          :key="index"
        >
          <div
            class="current-question"
            :class="index == questionsControl ? '' : 'hide'"
          >
            <h3 class="text-center">
              Question {{ index + 1 }} / {{ numberOfQuestions }}
            </h3>
            <br />
            <h3 class="text-eadtools">{{ element.question }}</h3>
            <div class="demo-image__preview">
              <el-image
                v-if="element.image != null && element.image != ''"
                :src="'' + $getUrlToContents() + 'question/' + element.image"
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
                <textarea
                  :name="'answer[' + element.id + ']'"
                  class="form-control"
                  rows="10"
                ></textarea>
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
                  :return-name="'answer[' + element.id + ']'"
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
        <img
          src="https://sbrfiles.s3.amazonaws.com/gifs/loader4.gif"
          style="width: 50%"
          alt
        />
      </div>
    </el-dialog>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import Vue from 'vue';
import VuePlyr from 'vue-plyr';
import vueAwesomeCountdown from 'vue-awesome-countdown';
import AnswersList from '@/components/viewcourse/AnswersList';
import HelperProgress from '@/components/helper/HelperProgress';
import Upload from '@/components/helper/HelperUpload';
import $ from 'jquery';

import { eventBus } from '@/components/viewcourse/App';
import { mapState } from 'vuex';

Vue.use(vueAwesomeCountdown, 'vac');
Vue.use(VuePlyr, {
  plyr: {
    fullscreen: { enabled: true }
  },
  emit: ['ended']
});

export default {
  components: {
    AnswersList,
    HelperProgress,
    Upload
  },
  data: () => {
    return {
      modal: false,
      questions: [],
      time: '',
      examId: '',
      lessonStatus: '',
      lessonType: '',
      questionsControl: 0,
      numberOfQuestions: '',
      descriptionAnswer: '',
      fileName: '',
      icon: 'fas fa-cloud-upload-alt',
      message: 'Upload a file',
      answerImage: '',
      retest: '',
      componentKey: 0,
      loading: false,
      examOn: true,

      showFinishExamButton: false
    };
  },
  mounted() {
    eventBus.$on('open-exam-modal', (data) => {
      this.questionsControl = 0;
      this.showFinishExamButton = false;

      this.clear();

      this.modal = true;
      this.examId = data.lessonId;
      this.lessonStatus = data.lessonStatus;
      this.lessonType = data.lessonType;
      this.getExam(data.lessonId);
      this.getQuestions(data.lessonId);
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    clear() {
      $(document).ready(() => {
        $('#form-exam').find('input:file,textarea').val('');
      });
    },
    forceRerender() {
      this.componentKey += 1;
    },
    finishExam() {
      this.examOn = false;
      const form = document.getElementById('form-exam');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'exam',
        'finish'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          const data = {
            lessonId: this.examId,
            lessonStatus: this.lessonStatus,
            lessonType: this.lessonType
          };

          setTimeout(() => {
            eventBus.$emit('exam-finished');
            eventBus.$emit('load-lesson', data);

            eventBus.$emit('update-progress-bar');
            eventBus.$emit('update-modules');

            this.forceRerender();
          }, 6000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getExam(examId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'get'
      );
      formData.set('lessonId', examId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.time = parseInt(response.data.time) * 60000;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    nextQuestion() {
      if (this.questionsControl !== this.numberOfQuestions - 1) {
        this.questionsControl = this.questionsControl + 1;
        this.showFinishExamButton = false;
      }

      if (this.questionsControl === this.numberOfQuestions - 1) {
        this.showFinishExamButton = true;
      }
    },
    prevQuestion() {
      if (this.questionsControl !== 0) {
        this.questionsControl = this.questionsControl - 1;
        this.showFinishExamButton = false;
      }
    },
    getQuestions(examId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'question',
        'listing'
      );
      formData.set('examId', examId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.questions = response.data;
          this.numberOfQuestions = response.data.length;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.exam-header {
  color: black;
  font-family: 'Poppins', sans-serif !important;
  font-size: 2em;
}

.controls {
  padding: 10px;
}

.answers {
  padding-top: 3%;
}
</style>
