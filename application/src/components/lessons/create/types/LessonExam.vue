<template>
  <div>
    <el-dialog :visible.sync="modalCreateExam" :title="lang['create-new-exam']" center top="5vh">
      <div class="form-row" style="margin-top:-30px !important;">
        <div class="form-group col-xl-12 col-md-12">
          <ul>
            <li @click.prevent="accessFirstStep()">
              <a class="form-wizard-link" :class="active == 1 ? 'active' : '' " href="#">
                <span>{{lang["basic-information"]}}</span>
              </a>
            </li>
            <li @click.prevent="accessSecondStep()">
              <a class="form-wizard-link" :class="active == 2 ? 'active' : '' " href="#">
                <span>{{lang["questions"]}}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="card-box" v-if="showExamFirstStep">
        <form id="form-lesson-exam" @submit.prevent="createExam()">
          <div class="form-row">
            <!-- Module id -->
            <input type="number" class="hide" name="moduleId" :value="moduleId" />
            <!-- Lesson id -->
            <input type="number" class="hide" name="lessonId" :value="examId" />
            <!-- Type lesson -->
            <input type="text" name="type_mylesson_id" value="8" class="hide" />
            <!-- Exam status -->
            <input type="text" name="status" value="temporary" class="hide" />
            <div class="form-group col-xl-12 col-md-12">
              <!-- Lesson name -->
              <label class="col-form-label">{{lang["name"]}} *</label>
              <el-input required v-model="name" name="title"></el-input>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-xl-12 col-md-12">
              <!-- Lesson duration -->
              <label class="col-form-label">{{lang["duration"]}}</label>
              <br />
              <el-input-number name="time" v-model="duration"></el-input-number>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-xl-12 col-md-12">
              <!-- Lesson approval -->
              <label class="col-form-label">{{lang["approval"]}}</label>
              <br />
              <el-input-number name="approval" v-model="approval" :min="0" :max="100"></el-input-number>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-xl-12 col-md-12">
              <!-- Lesson retest -->
              <label class="col-form-label">{{lang["number-of-re-tests"]}}</label>
              <br />
              <el-input-number :min="1" name="retest" v-model="retest"></el-input-number>
            </div>
          </div>
        </form>
      </div>

      <div v-if="showexamSecondStep">
        <question-list :exam-id="this.examId"></question-list>
        <el-button
          v-loading="loading"
          class="sbr-btn sbr-primary"
          @click.prevent="changeExamStatus()"
          type="primary"
          size="medium"
        >{{lang["save-button"]}}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import QuestionList from "@/components/questions/QuestionList";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  components: {
    QuestionList
  },
  props: ["module-id"],
  data: () => {
    return {
      lang: {},
      name: "",
      approval: "",
      duration: "",
      retest: "",
      modalCreateExam: false,
      loading: false,
      active: 1,
      examMode: "create",
      showexamSecondStep: false,
      showExamFirstStep: true,
      examId: ""
    };
  },
  mounted() {
    eventBus.$on(
      "new-exam",
      function() {
        this.modalCreateExam = true;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    changeExamStatus() {
      var formData = new FormData();
      formData.set("examId", this.examId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "lesson",
        "changeExamStatus"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
          this.actionsToBePErformedAfterChangeStatus();
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    accessFirstStep() {
      this.active = 1;
      this.showExamFirstStep = true;
      this.showexamSecondStep = false;
    },
    accessSecondStep() {
      if (this.name == "") {
        this.requiredNameMessage();
      } else {
        this.active = 2;
        this.showExamFirstStep = false;
        this.showexamSecondStep = true;
        if (this.examMode == "create") {
          this.createExam();
          this.examMode = "edit";
        } else {
          this.editExam();
        }
      }
    },
    createExam: function() {
      this.loading = true;
      var form = document.getElementById("form-lesson-exam");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "lesson",
        "create"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          /* Success callback */
          this.actionsToBePerformedAfterRegistration(response.data);
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    editExam: function() {
      this.loading = true;
      var form = document.getElementById("form-lesson-exam");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "edit");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },

    requiredNameMessage() {
      this.$notify({
        title: this.lang["error"],
        message: this.lang["required-name"],
        type: "error",
        duration: 3500
      });
    },
    actionsToBePerformedAfterRegistration(examId) {
      this.examId = examId;
      this.showExamFirstStep = false;
      this.showexamSecondStep = true;
      eventBus.$emit("new-lesson");
    },
    actionsToBePErformedAfterChangeStatus() {
      this.name = "";
      this.examMode = "create";
      this.approval = "";
      this.duration = "";
      this.retest = "";
      (this.examId = ""), (this.showExamFirstStep = true);
      this.showexamSecondStep = false;
      this.active = 1;
      this.modalCreateExam = false;
      eventBus.$emit("new-lesson");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.el-step__title {
  font-size: 5px !important;
}

.form-wizard-wrapper ul {
  background-color: #373c41;
  z-index: 1;
  width: 100%;
  border-radius: 4px;
  display: flex;
  justify-content: center;
  padding: 0;
}

.form-wizard-wrapper ul li {
  list-style-type: none;
  width: 50%;
  text-align: center;
  display: flex;
  justify-content: center;
  height: 40px;
  cursor: pointer;
}

.form-wizard-wrapper .form-wizardmove-button {
  position: absolute;
  left: 0;
  top: 0px;
  bottom: 0px;
  border-radius: 4px;
  background-color: #00a9b4;
  -webkit-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -moz-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -ms-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -o-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
}

.form-wizard-wrapper ul li a {
  display: block;
  width: 100%;
  color: white;
  text-decoration: none;
  font-size: 1em;
  line-height: 2;
  font-family: "Poppins", sans-serif;
  padding: 5px;
}

.form-wizard-wrapper ul li a.active {
  display: block;
  left: 0;
  top: 0px;
  bottom: 0px;
  border-radius: 4px;
  width: 100%;
  color: white;
  text-decoration: none;
  font-size: 1em;
  line-height: 2;
  font-family: "Poppins", sans-serif;
  background-color: #00a9b4;
  -webkit-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -moz-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -ms-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -o-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
}

.form-wizard-wrapper ul li a span {
  position: relative;
  z-index: 1;
  font-size: 0.85rem;
  line-height: 2;
  font-style: normal;
  font-family: "Poppins", sans-serif;
}

/* ----------------- End default sizes ----- */

/* ------------- Max 1024px ---------------- */
@media only screen and (max-width: 1024px) {
  .form-wizard-wrapper ul {
    width: 100%;
    margin-top: -11%;
  }

  .form-wizard-wrapper ul li a {
    font-size: 0.8em;
  }

  .form-wizard-wrapper ul li a.active {
    font-size: 0.8em;
    margin-top: 0;
  }
}

/* ------------- End max 1024px ---------------- */

@media only screen and (min-width: 1400px) {
  .form-wizard-wrapper ul {
    width: 100%;
  }
}
</style>
