<template>
  <div>
    <el-dialog
      :visible.sync="modalCreateAnswer"
      :title="lang['create-new-answer']"
      center
      top="5vh"
    >
      <form id="form-answer" @submit.prevent="createAnswer()">
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Question id -->
            <input type="number" class="hide" v-model="questionId" name="questionId" />
            <!-- Answer -->
            <h4>{{lang["answer"]}}</h4>
            <el-input type="textarea" rows="5" required v-model="answer" name="answer"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              v-loading="loading"
              class="sbr-primary"
              native-type="submit"
            >{{lang["save-button"]}}</el-button>
          </div>
        </div>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      answer: "",
      modalCreateAnswer: false,
      loading: false,
      questionId: ""
    };
  },
  mounted() {
    /* Get new answer click event */
    eventBus.$on(
      "open-answer-modal",
      function(questionId) {
        this.modalCreateAnswer = true;
        this.questionId = questionId;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    createAnswer: function() {
      this.loading = true;
      var form = document.getElementById("form-answer");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "answer",
        "create"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.actionsToBePerformedAfterRegistration();
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }
      );
    },
    actionsToBePerformedAfterRegistration() {
      (this.answer = ""), (this.modalCreateAnswer = false);
      eventBus.$emit("new-answer");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.textarea-question {
  height: 100px !important;
}

.el-divider--vertical {
  height: auto !important;
}
</style>
