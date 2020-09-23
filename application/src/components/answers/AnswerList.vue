<template>
  <div>
    <el-tag class="mb-3" v-if="answersList != null">{{
      lang['correct-answer-information']
    }}</el-tag>

    <bullet-list-loader
      class="mt-3"
      v-if="content == false"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></bullet-list-loader>

    <div v-else>
      <ul class="list-group">
        <draggable
          v-model="answersList"
          ghost-class="ghost"
          @end="reorderAnswerPositions"
        >
          <transition-group type="transition" name="flip-list">
            <li
              v-for="element in answersList"
              :key="element.id"
              class="list-group-item d-flex justify-content-between align-items-center sortable"
            >
              <div
                :id="element.id"
                class="custom-control custom-checkbox answer"
              >
                <input
                  @change="markAsCorrectAnswer($event, element.id)"
                  :checked="element.correct != null ? true : false"
                  type="checkbox"
                  :name="'check' + element.id"
                  class="custom-control-input"
                  :id="'correct' + element.id"
                />
                <label
                  class="custom-control-label"
                  :for="'correct' + element.id"
                >
                  <span class="answer-text">{{ element.answer }}</span>
                </label>
              </div>
              <div class="action-buttons float-right">
                <el-button
                  size="mini"
                  @click.prevent="
                    openEditAnswerModal(element.id, element.answer)
                  "
                  class="sbr-primary"
                  icon="el-icon-edit"
                  circle
                ></el-button>

                <el-button
                  size="mini"
                  @click.prevent="deleteAnswer(element.id)"
                  slot="reference"
                  class="sbr-danger"
                  icon="el-icon-delete"
                  circle
                ></el-button>

                <el-button
                  class="handle sbr-neutral"
                  size="mini"
                  icon="el-icon-rank"
                  circle
                ></el-button>
              </div>
            </li>
          </transition-group>
        </draggable>
      </ul>
    </div>

    <!---------------------
      Modal to edit answer
    ----------------------->
    <div>
      <el-dialog
        :visible.sync="modal"
        append-to-body
        :title="lang['edit-answer']"
        center
        top="5vh"
        width="30%"
      >
        <form id="form-edit-answer" @submit.prevent="editAnswer()">
          <div class="form-row">
            <!-- Answer id -->
            <input
              type="number"
              class="hide"
              name="answerId"
              v-model="answerId"
            />
            <div class="form-group col-xl-12 col-md-12">
              <!-- Answer -->
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
                class="sbr-btn sbr-primary"
                native-type="submit"
                size="medium"
                >{{ lang['save-button'] }}</el-button
              >
            </div>
          </div>
        </form>
      </el-dialog>
    </div>
    <!---------------------
      End modal to edit answer
    ----------------------->
  </div>
</template>

<script>
import draggable from 'vuedraggable';
import $ from 'jquery';

import { eventBus } from '@/components/newcourse/App';
import { BulletListLoader } from 'vue-content-loader';
import { mapState } from 'vuex';

export default {
  components: {
    draggable,
    BulletListLoader
  },
  data: () => {
    return {
      answersList: null,
      correctAnswer: '',

      answer: '',
      answerId: '',

      modal: false,
      loading: false,
      content: false
    };
  },
  props: ['question-id'],
  mounted() {
    eventBus.$on('new-answer', () => {
      this.getAnswers(this.questionId);
    });

    eventBus.$on('new-open-modal-edit-question', (response) => {
      this.getAnswers(response.questionId);
    });

    this.getAnswers(this.questionId);
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    editAnswer() {
      const form = document.getElementById('form-edit-answer');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'answer',
        'edit'
      );

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getAnswers(this.questionId);
          this.modal = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    markAsCorrectAnswer(e, id) {
      let status;
      e.target.checked === true ? (status = 'correct') : (status = null);

      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'answer',
        'changeStatus'
      );
      formData.set('answerId', id);
      formData.set('status', status);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {},
        () => {
          this.$errorMessage();
        }
      );
    },
    openEditAnswerModal(id, answer) {
      this.answerId = id;
      this.answer = answer;
      this.modal = true;
    },
    deleteAnswer(id) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'answer',
        'delete'
      );
      formData.set('answerId', id);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getAnswers(this.questionId);
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    reorderAnswerPositions() {
      const ar = [];
      const formData = new FormData();

      $('.answer').each((index) => {
        const id = $(this).attr('id');
        ar.push({ id: id, index: index });
      });

      $.each(ar, (index, value) => {
        formData.set('answer[' + value.id + ']', value.index);
      });

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'answer',
        'reorder'
      );

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {},
        () => {
          this.$errorMessage();
        }
      );
    },
    getAnswers(questionId) {
      this.content = false;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'answer',
        'listing'
      );
      formData.set('questionId', questionId);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.reorderAnswerPositions();
          this.answersList = response.data;
          this.content = true;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<style lang="scss" scoped>
.answer-text {
  display: block;
  width: 100px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.custom-control-label {
  padding-top: 4px !important;
}

#accordion > .card {
  margin-bottom: 2%;
}

.btn-link {
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
  border-left: 6px solid rgb(0, 183, 255);
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
