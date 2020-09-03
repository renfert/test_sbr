<template>
  <div class="col-12">
    <admin-dashboards v-if="user.role == 1"></admin-dashboards>
    <instructor-dashboards v-if="user.role == 2"></instructor-dashboards>
    <student-dashboards v-if="user.role == 3"></student-dashboards>
  </div>
</template>

<script>
import AdminDashboards from '@/components/dashboards/roles/Admin';
import InstructorDashboards from '@/components/dashboards/roles/Instructor';
import StudentDashboards from '@/components/dashboards/roles/Student';

import { mapState } from 'vuex';

export default {
  components: {
    AdminDashboards,
    InstructorDashboards,
    StudentDashboards
  },
  data: () => {
    return {};
  },
  computed: {
    ...mapState(['user'])
  }
};
</script>

<style lang="scss" scoped>
.chart {
  width: 100%;
  height: 300px;
}
</style>
