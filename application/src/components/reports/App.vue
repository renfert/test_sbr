<template>
  <div class="m-b-40">
    <!-- Generate report button -->
    <div class="center">
      <img
        class="not-found-image m-b-20"
        src="@/assets/img/general/ux/report.svg"
      />
      <br />
      <el-button
        @click.prevent="openReport()"
        type="primary"
        class="sbr-primary"
      >
        {{ lang['generate-report'] }}
      </el-button>
      <div v-if="data != null" class="card-box m-t-40">
        <report-table :data="data"></report-table>
      </div>
    </div>
    <!-- End generate report button -->

    <!-- Generate report modal -->
    <el-dialog width="60%" top="5vh" :visible.sync="modal">
      <div slot="title" class="center">
        <h3>{{ lang['generate-report'] }}</h3>
      </div>
      <div class="center">
        <!-- Steps -->
        <first-step v-if="step == 'first'"></first-step>
        <second-step v-else></second-step>
        <br />
        <!-- Control buttons -->
        <el-button
          @click.prevent="nextStep()"
          v-if="step == 'first'"
          type="primary"
          class="sbr-primary"
          >{{ lang['next-step-button'] }} <i class="el-icon-right"></i
        ></el-button>
        <div v-else>
          <!-- Preivous button -->
          <el-button
            @click.prevent="step = 'first'"
            type="primary"
            class="sbr-primary"
            ><i class="el-icon-back"></i> {{ lang['previous-step-button'] }}
          </el-button>

          <!-- Generate report button -->

          <el-button
            @click.prevent="generateReport()"
            type="primary"
            class="sbr-purple"
            >{{ lang['generate-report'] }} <i class="el-icon-data-analysis"></i
          ></el-button>
        </div>
      </div>
    </el-dialog>
    <!-- End generate report modal -->
  </div>
</template>

<script>
import Vue from 'vue';
import FirstStep from '@/components/reports/FirstStep';
import SecondStep from '@/components/reports/SecondStep';
import ReportTable from '@/components/reports/Table';
import { mapState } from 'vuex';
import { DataTables, DataTablesServer } from 'vue-data-tables';
export const eventBus = new Vue();

Vue.use(DataTables);
Vue.use(DataTablesServer);
export default {
  components: {
    FirstStep,
    SecondStep,
    ReportTable
  },
  data: () => {
    return {
      modal: false,
      step: 'first',
      firstStepOption: null,
      data: null,
      report: {
        type: '',
        id: ''
      }
    };
  },
  mounted() {
    // Option selected in the first step
    eventBus.$on('first-step-option', (response) => {
      this.firstStepOption = response;
    });

    // Group report
    eventBus.$on('select-group-report', (response) => {
      this.report.type = 'group';
      this.report.id = response;
    });

    // Student report
    eventBus.$on('select-student-report', (response) => {
      this.report.type = 'student';
      this.report.id = response;
    });

    // Course report
    eventBus.$on('select-course-report', (response) => {
      this.report.type = 'course';
      this.report.id = response;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    generateReport() {
      if (this.firstStepOption === 'exam') {
        this.generateExamReport();
        this.modal = false;
      }
    },
    generateExamReport() {
      // Specific group
      if (this.report.type === 'group') {
        const formData = new FormData();
        formData.set('groupId', this.report.id);

        // General exam report
        const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
          'reports',
          'getExamsReportsByGroup'
        );
        this.$request
          .post(urlToBeUsedInTheRequest, formData)
          .then((response) => {
            this.data = response.data;
            if (response.data == null) {
              const h = this.$createElement;
              this.$notify({
                message: h(
                  'i',
                  { style: 'color: teal' },
                  '' + this.lang['no-data-for-this-report'] + ''
                )
              });
            }
          });
      }
    },
    nextStep() {
      if (this.firstStepOption !== null) {
        this.step = 'second';
      } else {
        this.$message({
          title: this.lang.error,
          message: this.lang['please-select-option'],
          type: 'error',
          duration: 2000
        });
      }
    },
    openReport() {
      this.modal = true;
    }
  }
};
</script>

<style scoped>
.card-box {
  cursor: pointer !important;
}
.active_box {
  box-shadow: 0px 0px 10px 0px #009cd8 !important;
}
</style>
