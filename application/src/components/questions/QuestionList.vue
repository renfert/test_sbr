<template>
  <div class="main">
    <div class="card-box" v-if="loadingContent == true">
      <facebook-loader
        :speed="2"
        width="700"
        height="200"
        primaryColor="#f0f0f0"
        secondaryColor="#d9d9d9"
      ></facebook-loader>
    </div>

    <div v-else>
      <div v-if="questionList != null">
        <div class="card-box">
          <el-row class="mb-5">
            <el-col :span="5">
              <h4>{{lang["question-list"]}}</h4>
            </el-col>
            <el-col :span="1">
              <el-tooltip
                class="item"
                effect="dark"
                :content="lang['create-first-question']"
                placement="top"
              >
                <el-button
                  @click.prevent="createNewQuestionEvent()"
                  class="sbr-btn sbr-purple ml-3"
                  icon="el-icon-plus"
                  circle
                ></el-button>
              </el-tooltip>
            </el-col>
          </el-row>

          <draggable v-model="questionList" ghost-class="ghost" @end="finishRepositioning">
            <transition-group type="transition" name="flip-list">
              <div class="sortable" v-for="element in questionList" :key="element.id">
                <li class="module" :id="element.id">
                  <div class="question-box">
                    <!-- Edit question -->
                    <el-button
                      class="sbr-btn sbr-primary mr-1"
                      @click.prevent="openEditQuestionModal(element.id,element.question,element.type_question_id, element.weight, element.feedback,element.image)"
                      size="mini"
                      icon="el-icon-edit"
                      circle
                    ></el-button>

                    <!-- Delete question -->
                    <template>
                      <el-popconfirm
                        confirmButtonText="Ok"
                        cancelButtonText="No, Thanks"
                        placement="right"
                        :title="lang['question-delete-question']"
                        @onConfirm="deleteQuestion(element.id)"
                      >
                        <el-button
                          class="sbr-btn sbr-danger mr-1"
                          slot="reference"
                          icon="el-icon-delete"
                          circle
                        ></el-button>
                      </el-popconfirm>
                    </template>

                    <!-- Move question -->
                    <el-button class="handle sbr-btn sbr-neutral mr-1" icon="el-icon-rank" circle></el-button>

                    <el-divider direction="vertical"></el-divider>

                    <a class="lesson-title" slot="reference">{{element.question}}</a>
                  </div>
                </li>
              </div>
            </transition-group>
          </draggable>
        </div>
      </div>
      <!-- End accordion -->

      <div class="card-box box-no-results" v-else>
        <div class="row">
          <div class="col-1"></div>
          <div class="col-6">
            <div class="text-no-results">
              <el-button
                class="sbr-btn sbr-purple"
                @click.prevent="createNewQuestionEvent()"
                type="primary"
                size="medium"
              >{{lang["create-first-question"]}}</el-button>
            </div>
          </div>
          <div class="col-4">
            <img class="image-no-results" src="@/assets/img/general/ux/no_questions.png" alt />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import draggable from "vuedraggable";
import $ from "jquery";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/newcourse/App";
import { FacebookLoader } from "vue-content-loader";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  components: {
    draggable,
    FacebookLoader
  },
  props: ["exam-id"],
  data: () => {
    return {
      lang: {},
      questionList: null,
      moduleId: "",
      moduleTitle: "",
      moduleReleaseDate: "",
      moduleRequired: "",
      loadingContent: false,
      counter: 1,
      questionId: "",
      question: "",
      type: "",
      weight: "",
      automaticFeedback: "",
      questionImage: ""
    };
  },
  mounted() {
    eventBus.$on(
      "new-question",
      function() {
        this.getQuestions(this.examId);
      }.bind(this)
    );

    this.getQuestions(this.examId);
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    createNewAnswerEvent: function() {
      eventBus.$emit("open-answer-modal");
    },
    finishRepositioning: function() {
      this.reorderQuestionPositions();
    },

    createNewQuestionEvent: function() {
      var formData = new FormData();
      formData.set("examId", this.examId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "question",
        "createTemporary"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          var data = {
            questionId: response.data,
            examId: this.examId
          };
          eventBus.$emit("open-question-modal", data);
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },

    editQuestion: function() {
      var form = document.getElementById("form-module");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("module", "edit");
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

    openEditQuestionModal: function(
      id,
      question,
      type,
      weight,
      feedback,
      image
    ) {
      var questionInformation = {
        questionId: id,
        question: question,
        type: type,
        weight: weight,
        feedback: feedback,
        image: image,
        examId: this.examId
      };
      eventBus.$emit("new-open-modal-edit-question", questionInformation);
    },

    deleteQuestion: function(id) {
      var formData = new FormData();
      formData.set("questionId", id);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "question",
        "delete"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getQuestions(this.course);
          this.successMessage();
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },

    reorderQuestionPositions: function() {
      var ar = [];
      $(".module").each(function(index) {
        var id = $(this).attr("id");
        ar.push({ id: id, index: index });
      });
      var formData = new FormData();
      $.each(ar, function(index, value) {
        formData.set("module[" + value.id + "]", value.index);
      });
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "module",
        "reorder"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getQuestions: function(examId) {
      this.loadingContent = true;
      var formData = new FormData();
      formData.set("examId", examId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "question",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.questionList = response.data;
          setTimeout(
            function() {
              this.loadingContent = false;
            }.bind(this),
            1000
          );
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    actionsToBePerformedAfterEdit() {
      this.getQuestions(this.course);
      this.modal = false;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.image-no-results {
  margin-top: 15%;
}

.question-box {
  box-shadow: 0px 0px 5px 0px #aca9a9;
  padding: 15px;
  border-radius: 30px;
  margin: 2% 10% 2% 5%;
}

.question-title {
  font-family: "Poppins", sans-serif !important;
  font-weight: 400;
  font-size: 16px;
  margin-left: 5px;
  max-width: 30ch;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.box-no-results {
  background-color: #f6f9fa;
}

.text-no-results {
  margin-top: 35%;
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
  border-left: 6px solid #00c0fd;
  border-radius: 5px;
  opacity: 0.5;
}

.card {
  margin-bottom: 15px;
}

.handle {
  cursor: move !important;
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
