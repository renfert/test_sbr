<template>
  <div>
    <div v-for="element in answers" :key="element.id" class="custom-control custom-checkbox">
      <input
        :checked="element.correct == 'correct' ? true : false"
        :value="element.id"
        :name="'answer['+questionId+']['+element.id+']'"
        type="checkbox"
        class="custom-control-input"
        :id="'answer'+element.id"
      />
      <label class="custom-control-label" :for="'answer'+element.id">{{element.answer}}</label>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);
export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      lang: {},
      answers: null,
      answer: ""
    };
  },
  mounted() {
    this.getAnswers();
  },
  computed: {
    ...mapState(["lang"])
  },
  props: ["question-id"],
  methods: {
    getAnswers: function() {
      var formData = new FormData();
      formData.set("questionId", this.questionId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "answer",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          /* Success callback */
          this.answers = response.data;
          //this.reorder();
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
