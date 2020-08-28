<template>
  <div>
    <el-dialog :visible.sync="modal" :title="lang['create-new-answer']" center top="5vh">
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
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";

export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      answer: "",
      modal: false,
      loading: false,
      questionId: ""
    };
  },
  mounted() {
    eventBus.$on("open-answer-modal", questionId => {
      this.modal = true;
      this.questionId = questionId;
    });
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    createAnswer() {
      this.loading = true;
      let form = document.getElementById("form-answer");
      let formData = new FormData(form);
      let urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "answer",
        "create"
      );

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.loading = false;
          this.modal = false;
          document.getElementById("form-answer").reset();
          eventBus.$emit("new-answer");
        },
        () => {
          this.errorMessage();
        }
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style  scoped>
.textarea-question {
  height: 100px !important;
}

.el-divider--vertical {
  height: auto !important;
}
</style>
