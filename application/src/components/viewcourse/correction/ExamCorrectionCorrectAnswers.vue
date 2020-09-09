<template>
  <div>
    <div
      v-for="element in answers"
      :key="element.id"
      class="custom-control custom-checkbox"
    >
      <input
        :checked="element.correct == 'correct' ? true : false"
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
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      answers: null,
      answer: ''
    };
  },
  mounted() {
    this.getAnswers();
  },
  computed: {
    ...mapState(['lang'])
  },
  props: ['question-id'],
  methods: {
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
    }
  }
};
</script>
