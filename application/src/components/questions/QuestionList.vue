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
            <el-col :span="12" :xs="24" :sm="24">
              <el-tooltip
                class="item"
                effect="dark"
                :content="lang['create-first-question']"
                placement="top"
              >
                <el-button
                  @click.prevent="createNewQuestionEvent()"
                  class="sbr-purple ml-3"
                  icon="el-icon-plus"
                  circle
                ></el-button>
              </el-tooltip>
              {{ lang['question-list'] }}
            </el-col>
          </el-row>

          <draggable
            v-model="questionList"
            ghost-class="ghost"
            @end="reorderQuestionPositions()"
          >
            <transition-group type="transition" name="flip-list">
              <div
                class="sortable"
                v-for="element in questionList"
                :key="element.id"
              >
                <li class="module" :id="element.id">
                  <div class="question-box">
                    <!-- Edit question -->
                    <el-button
                      class="sbr-primary mr-1"
                      @click.prevent="
                        openEditQuestionModal(
                          element.id,
                          element.question,
                          element.type_question_id,
                          element.weight,
                          element.feedback,
                          element.image
                        )
                      "
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
                          class="sbr-danger mr-1"
                          slot="reference"
                          size="mini"
                          icon="el-icon-delete"
                          circle
                        ></el-button>
                      </el-popconfirm>
                    </template>

                    <!-- Move question -->
                    <el-button
                      size="mini"
                      class="handle sbr-neutral mr-1"
                      icon="el-icon-rank"
                      circle
                    ></el-button>

                    <el-divider direction="vertical"></el-divider>

                    <a class="lesson-title" slot="reference">{{
                      element.question
                    }}</a>
                  </div>
                </li>
              </div>
            </transition-group>
          </draggable>
        </div>
      </div>
      <!-- End accordion -->

      <div class="text-center mt-5" v-else>
        <img
          class="image-no-results mb-4"
          src="@/assets/img/general/ux/questions.svg"
          alt
        />
        <br />
        <el-button
          size="small"
          class="sbr-purple"
          @click.prevent="createNewQuestionEvent()"
          type="primary"
          >{{ lang['create-first-question'] }}</el-button
        >
      </div>
      <hr class="mb-5 mt-5" />
    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable';
import $ from 'jquery';

import { eventBus } from '@/components/newcourse/App';
import { FacebookLoader } from 'vue-content-loader';
import { mapState } from 'vuex';

export default {
  components: {
    draggable,
    FacebookLoader
  },
  props: ['exam-id'],
  data: () => {
    return {
      questionList: null,
      moduleId: '',
      moduleTitle: '',
      moduleReleaseDate: '',
      moduleRequired: '',
      loadingContent: false,
      counter: 1,
      questionId: '',
      question: '',
      type: '',
      weight: '',
      automaticFeedback: '',
      questionImage: ''
    };
  },
  mounted() {
    eventBus.$on('new-question', () => {
      this.getQuestions(this.examId);
    });

    this.getQuestions(this.examId);
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    createNewAnswerEvent() {
      eventBus.$emit('open-answer-modal');
    },
    createNewQuestionEvent() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'question',
        'createTemporary'
      );
      formData.set('examId', this.examId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          const data = {
            questionId: response.data,
            examId: this.examId
          };
          eventBus.$emit('open-question-modal', data);
        },
        () => {
          this.$errorMessage();
        }
      );
    },

    editQuestion() {
      const form = document.getElementById('form-module');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'module',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getQuestions(this.course);
          this.modal = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },

    openEditQuestionModal(id, question, type, weight, feedback, image) {
      const questionInformation = {
        questionId: id,
        question: question,
        type: type,
        weight: weight,
        feedback: feedback,
        image: image,
        examId: this.examId
      };
      eventBus.$emit('new-open-modal-edit-question', questionInformation);
    },

    deleteQuestion(id) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'question',
        'delete'
      );
      formData.set('questionId', id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getQuestions(this.course);
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },

    reorderQuestionPositions() {
      const ar = [];
      $('.module').each((index, element) => {
        const id = $(element).attr('id');
        ar.push({ id: id, index: index });
      });

      const formData = new FormData();
      $.each(ar, (index, value) => {
        formData.set('module[' + value.id + ']', value.index);
      });

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'module',
        'reorder'
      );

      this.$request.post(urlToBeUsedInTheRequest, formData);
    },
    getQuestions(examId) {
      this.loadingContent = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'question',
        'listing'
      );
      formData.set('examId', examId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.questionList = response.data;
          setTimeout(() => {
            this.loadingContent = false;
          }, 1000);
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
.image-no-results {
  width: 15%;
}

.question-box {
  box-shadow: 0px 0px 5px 0px #aca9a9;
  padding: 15px;
  border-radius: 30px;
  margin: 2% 10% 2% 5%;
}

.question-title {
  font-family: 'Poppins', sans-serif !important;
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
  font-family: 'Poppins', sans-serif;
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
  font-family: 'Poppins', sans-serif;
  margin-top: 3em;
  font-size: 1em;
}
</style>
