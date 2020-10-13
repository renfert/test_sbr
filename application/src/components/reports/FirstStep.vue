<template>
  <div class="center">
    <h3 class="m-b-40">{{ lang['report-type'] }}</h3>
    <el-row :gutter="20" type="flex" justify="center">
      <!-- Exams reports -->
      <el-col :xs="24" :md="12">
        <div
          @click="selectOption('exam')"
          class="card-box"
          :class="firstStep == 'exam' ? 'active_box' : ''"
        >
          <h4>{{ lang['exams'] }}</h4>
          <img
            class="not-found-image"
            src="@/assets/img/general/ux/exams.svg"
          />
        </div>
      </el-col>
      <!-- End exams reports -->

      <!-- Courses reports
      <el-col :xs="24" :md="12">
        <div
          :class="firstStep == 'general' ? 'active_box' : ''"
          @click="selectOption('general')"
          class="card-box"
        >
          <h4>Disponivel em breve</h4>
          <img
            class="not-found-image m-b-20"
            src="@/assets/img/general/ux/graduation_cap.svg"
          />
        </div>
      </el-col> -->
    </el-row>
  </div>
</template>

<script>
import { eventBus } from '@/components/reports/App';
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      firstStep: ''
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    selectOption(option) {
      this.firstStep = option;
      eventBus.$emit('first-step-option', option);
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
.el-row {
  padding: 0% 10%;
}
</style>
