<template>
  <div class="main" v-loading="loading">
    <!--  Modal edit question -->
    <div>
      <el-dialog :visible.sync="modalEditQuestion" :title="lang['edit-question']" center top="5vh">
        <form id="form-edit-question" @submit.prevent="editQuestion()">
          <div class="form-row">
            <div class="form-group col-xl-6 col-md-6">
              <!-- Question id -->
              <input type="number" class="hide" v-model="questionId" name="questionId" />
              <!-- Question type -->
              <h4>{{lang["question-type"]}}</h4>
              <br />
              <el-radio-group @change="updateAnswersList()" v-model="type">
                <el-radio name="type" :label="1">{{lang["descriptive"]}}</el-radio>
                <el-radio name="type" :label="2">{{lang["multiple-choice"]}}</el-radio>
                <el-radio name="type" :label="3">{{lang["free"]}}</el-radio>
              </el-radio-group>
            </div>
            <div class="form-group col-xl-6 col-md-6">
              <!-- Question weight -->
              <h4>{{lang["question-weight"]}}</h4>
              <br />
              <div class="block">
                <input type="number" class="hide" name="weight" v-model="weight" />
                <el-rate v-model="weight"></el-rate>
              </div>
            </div>
          </div>
          <hr />
          <div class="form-row">
            <div class="form-group col-xl-6 col-md-6">
              <input class="hide" type="text" name="examId" :value="examId" />
              <!-- Question -->
              <h4>{{lang["write-your-question"]}} *</h4>
              <el-input rows="4" type="textarea" v-model="question" required name="question"></el-input>
              <br />
              <div v-if="type == 2">
                <answer-list :question-id="questionId"></answer-list>
                <br />
                <el-button
                  class="sbr-primary"
                  type="primary"
                  @click.prevent="createNewAnswerEvent()"
                  size="medium"
                >{{lang["add-new-answer"]}}</el-button>
              </div>
            </div>
            <div class="form-group col-xl-6 col-md-6">
              <!-- Question image -->
              <h4>{{lang["question-image"]}}</h4>
              <upload
                v-if="this.previewImg != ''"
                :key="componentKey"
                :src-name="this.questionImageName"
                :src-img="this.previewImg"
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
              <h4>{{lang["automatic-feedback"]}}</h4>
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
                type="primary"
              >{{lang["save-button"]}}</el-button>
            </div>
          </div>
        </form>
      </el-dialog>
    </div>
    <!-- End  modal new module -->
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import AnswerList from "@/components/answers/AnswerList";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import Upload from "@/components/helper/HelperUpload";

import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  components: {
    AnswerList,
    Upload
  },
  data: () => {
    return {
      modalEditQuestion: false,
      loading: false,
      questionId: "",
      question: "",
      type: 1,
      weight: "",
      automaticFeedback: "",
      questionImageName: "",
      previewImg: "",
      examId: ""
    };
  },
  mounted() {
    eventBus.$on(
      "new-open-modal-edit-question",
      function(response) {
        this.questionId = response["questionId"];
        this.question = response["question"];
        this.type = parseInt(response["type"]);
        this.weight = parseInt(response["weight"]);
        this.automaticFeedback = response["feedback"];
        this.questionImageName = response["image"];
        this.previewImg =
          this.getUrlToContents() + "question/" + response["image"] + "";
        this.examId = response["examId"];
        this.modalEditQuestion = true;
        this.forceRerender();
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    createNewAnswerEvent: function() {
      eventBus.$emit("open-answer-modal", this.questionId);
    },
    updateAnswersList: function() {
      if (this.type == 2) {
        eventBus.$emit("new-answer");
      }
    },
    editQuestion: function() {
      var form = document.getElementById("form-edit-question");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "question",
        "edit"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.actionsToBePerformedAfterEdit();
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    forceRerender: function() {
      this.componentKey += 1;
    },
    actionsToBePerformedAfterEdit() {
      this.modalEditQuestion = false;
      eventBus.$emit("new-question");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.textarea-question {
  height: 100px !important;
}

.module-name {
  max-width: 30ch;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.box-no-results {
  background-color: #f5f5f7;
}

.text-no-results {
  margin-top: 10%;
}

#accordion > .card {
  margin-bottom: 2%;
}

.btn-link {
  margin: 0px !important;
  padding: 0px !important;
  font-size: 13px;
  font-family: "Poppins", sans-serif;
  font-weight: 600;
}

.btn.link:hover {
  text-decoration: none !important;
}

.card-header {
  padding: 10px !important;
}

.btn-eadtools-rounded {
  border-radius: 50%;
  cursor: pointer;
  display: inline-block;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
  position: relative;
  height: 40px;
  width: 40px;
  background-color: #d696ef;
  z-index: 2;
  border: none;
  color: white;
  margin: 0 0.2rem;
}

.sortable-drag {
  opacity: 0;
}

.flip-list-move {
  transition: transform 0.5s;
}

.ghost {
  border-left: 6px solid rgb(0, 183, 255);
  border-radius: 5px;
  opacity: 0.5;
}

.card {
  margin-bottom: 15px;
}

.handle {
  cursor: move;
}

li {
  list-style-type: none;
}

.lesson {
  text-align: center;
  text-transform: uppercase;
  font-size: 10px;
}

.lesson span {
  font-family: "Poppins", sans-serif;
  margin-top: 3em;
  font-size: 1em;
}
</style>
