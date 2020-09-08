<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['create-new-answer']"
      center
      width="30%"
      top="5vh"
    >
      <form id="form-answer" @submit.prevent="createAnswer()">
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <input
              type="number"
              class="hide"
              v-model="questionId"
              name="questionId"
            />
            <h4>{{ lang['answer'] }}</h4>
            <el-input
              type="textarea"
              rows="5"
              required
              v-model="answer"
              name="answer"
            ></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              v-loading="loading"
              class="sbr-primary"
              native-type="submit"
              >{{ lang['save-button'] }}</el-button
            >
          </div>
        </div>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import { eventBus } from '@/components/newcourse/App';
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      questionId: '',
      answer: '',
      modal: false,
      loading: false
    };
  },
  mounted() {
    eventBus.$on('open-answer-modal', (questionId) => {
      this.modal = true;
      this.questionId = questionId;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    createAnswer() {
      this.loading = true;

      const form = document.getElementById('form-answer');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'answer',
        'create'
      );

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.loading = false;
          this.modal = false;
          document.getElementById('form-answer').reset();
          eventBus.$emit('new-answer');
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<style scoped>
.textarea-question {
  height: 100px !important;
}

.el-divider--vertical {
  height: auto !important;
}
</style>
