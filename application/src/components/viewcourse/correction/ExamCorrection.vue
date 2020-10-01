<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      center
      width="50%"
      top="5vh"
      :title="lang['correction']"
    >
      <div class="text-center mb-3">
        <el-radio-group v-model="content">
          <el-radio-button label="1">{{ lang['overview'] }}</el-radio-button>
          <el-radio-button label="2">{{ lang['questions'] }}</el-radio-button>
        </el-radio-group>
      </div>

      <!-- Exam correction overview -->
      <exam-correction-overview
        :student-id="studentId"
        v-if="content == '1' && approval != '' && studentId != ''"
        :approval="approval"
        :exam-id="examId"
      ></exam-correction-overview>

      <!-- Exam correction questions -->
      <exam-correction-questions
        :student-id="studentId"
        :exam-id="examId"
        v-else
      ></exam-correction-questions>
    </el-dialog>
  </div>
</template>

<script>
import Vue from 'vue';
import ExamCorrectionOverview from '@/components/viewcourse/correction/ExamCorrectionOverview';
import ExamCorrectionQuestions from '@/components/viewcourse/correction/ExamCorrectionQuestions';

import { mapState } from 'vuex';

export const eventCorrection = new Vue();

export default {
  components: {
    ExamCorrectionOverview,
    ExamCorrectionQuestions
  },
  data: () => {
    return {
      modal: false,
      examId: '',
      studentId: '',
      approval: '',
      content: '1'
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  mounted() {
    eventCorrection.$on('open-exam-correction', (data) => {
      const examId = data.examId;
      this.content = '1';
      this.examId = data.examId;
      this.studentId = data.studentId;
      this.getExam(examId);
      this.modal = true;
    });

    eventCorrection.$on('finish-correction', () => {
      this.getExam(this.examId);
    });
  },
  methods: {
    getExam(examId) {
      const formData = new FormData();
      formData.set('examId', examId);

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest('exam', 'get');
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.approval = response.data[0].approval;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
