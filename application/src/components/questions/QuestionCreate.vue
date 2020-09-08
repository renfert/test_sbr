<template>
  <!--  Modal new question -->
  <div>
    <el-dialog
      :visible.sync="modalCreateQuestion"
      :title="lang['create-new-question']"
      center
      top="5vh"
    >
      <form id="form-question" @submit.prevent="verifyIfExistCorrectAnswer()">
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <!-- Question id -->
            <input
              type="number"
              class="hide"
              v-model="questionId"
              name="questionId"
            />
            <!-- Question type -->
            <h4>{{ lang['question-type'] }}</h4>
            <br />
            <el-radio-group @change="updateAnswersList()" v-model="type">
              <el-radio name="type" :label="1">{{
                lang['descriptive']
              }}</el-radio>
              <el-radio name="type" :label="2">{{
                lang['multiple-choice']
              }}</el-radio>
              <el-radio name="type" :label="3">{{ lang['free'] }}</el-radio>
            </el-radio-group>
          </div>
          <div class="form-group col-xl-6 col-md-6">
            <!-- Question weight -->
            <h4>{{ lang['question-weight'] }}</h4>
            <br />
            <div class="block">
              <input
                type="number"
                class="hide"
                name="weight"
                v-model="weight"
              />
              <el-rate v-model="weight"></el-rate>
            </div>
          </div>
        </div>
        <hr />
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <input class="hide" type="text" name="examId" :value="examId" />
            <!-- Question -->
            <h4>{{ lang['write-your-question'] }} *</h4>
            <el-input
              rows="4"
              type="textarea"
              v-model="question"
              required
              name="question"
            ></el-input>
            <br />
            <br />
            <div v-if="type == 2">
              <answer-list :question-id="questionId"></answer-list>
              <br />
              <el-button
                class="sbr-purple"
                type="primary"
                @click.prevent="createNewAnswerEvent()"
                size="small"
                >{{ lang['add-new-answer'] }}</el-button
              >
            </div>
          </div>
          <div class="form-group col-xl-6 col-md-6">
            <!-- Question image -->
            <h4>{{ lang['question-image'] }}</h4>
            <upload
              :key="componentKey"
              do-upload="true"
              box-height="100"
              return-name="questionImageName"
              input-name="file"
              bucket-key="uploads/question"
              acceptable=".png,.jpg,.jpeg"
            ></upload>
          </div>
        </div>
        <div class="form-row" v-if="type == 2">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Automatic feedback -->
            <h4>{{ lang['automatic-feedback'] }}</h4>
            <el-input
              rows="5"
              type="textarea"
              v-model="automaticFeedback"
              name="feedback"
              class="textarea-question"
            ></el-input>
          </div>
        </div>
        <br />
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              class="sbr-primary"
              v-loading="loading"
              native-type="submit"
              >{{ lang['save-button'] }}</el-button
            >
          </div>
        </div>
      </form>
    </el-dialog>
  </div>
  <!-- End  modal new module -->
</template>

<script>
import AnswerList from '@/components/answers/AnswerList';
import Upload, { eventUpload } from '@/components/helper/HelperUpload';
import { eventBus } from '@/components/newcourse/App';
import { mapState } from 'vuex';

export default {
  components: {
    AnswerList,
    Upload
  },
  data: () => {
    return {
      question: '',
      questionId: '',
      weight: 1,
      type: 1,
      modalCreateQuestion: false,
      loading: false,
      automaticFeedback: '',
      checked: '',
      examId: '',
      componentKey: 0
    };
  },
  mounted() {
    eventBus.$on('open-question-modal', (response) => {
      this.questionId = response.questionId;
      this.examId = response.examId;
      this.modalCreateQuestion = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    updateAnswersList() {
      if (this.type === 2) {
        eventBus.$emit('new-answer');
      }
    },
    createNewAnswerEvent() {
      eventBus.$emit('open-answer-modal', this.questionId);
    },
    editQuestion() {
      this.loading = true;
      const form = document.getElementById('form-question');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'question',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.actionsToBePerformedAfterRegistration();
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    verifyIfExistCorrectAnswer() {
      if (this.type !== 2) {
        this.editQuestion();
      } else {
        const formData = new FormData();
        const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
          'verify',
          'correctAnswerExist'
        );
        formData.set('questionId', this.questionId);
        this.$request.post(urlToBeUsedInTheRequest, formData).then(
          (response) => {
            if (response.data === true) {
              this.editQuestion();
            } else {
              this.unansweredQuestion();
            }
          },
          () => {
            this.$errorMessage();
          }
        );
      }
    },
    forceRerender() {
      this.componentKey += 1;
    },

    actionsToBePerformedAfterRegistration() {
      this.forceRerender();
      eventUpload.$emit('clear');
      this.question = '';
      this.weight = 1;
      this.type = 1;
      this.automaticFeedback = '';
      this.modalCreateQuestion = false;
      eventBus.$emit('new-question');
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.el-divider--vertical {
  height: auto !important;
}
</style>
