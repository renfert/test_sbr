<template>
  <div class="main">
    <!-- Default checked -->
    <div
      v-for="element in answers"
      :key="element.id"
      class="custom-control custom-checkbox"
    >
      <input
        v-model="data"
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
    <input
      class="hide"
      v-if="data == ''"
      value="1"
      type="number"
      :name="'answer[' + questionId + '][1]'"
    />
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      answers: null,
      answer: '',
      data: []
    };
  },
  mounted() {
    this.getAnswers();
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
  },
  watch: {
    questionId() {
      this.getAnswers();
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
