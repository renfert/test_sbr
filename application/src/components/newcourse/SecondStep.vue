<template>
  <div v-if="displayContentSecondStep">
    <div class="card-box card-course mt-5">
      <module-list :course-id="courseId"></module-list>
    </div>
    <!-- Module create modal -->
    <module-create :course-id="courseId"></module-create>
  </div>
</template>

<script>
import ModuleList from '@/components/modules/ModuleList';
import ModuleCreate from '@/components/modules/ModuleCreate';
import { eventBus } from '@/components/newcourse/App';

export default {
  components: {
    ModuleList,
    ModuleCreate
  },
  data: () => {
    return {
      displayContentSecondStep: false,
      courseId: ''
    };
  },
  mounted() {
    /* When a new course was created */
    eventBus.$on('new-course', (response) => {
      this.courseId = response;
    });

    /* Access second step */
    eventBus.$on('access-second-step', () => {
      this.displayContentSecondStep = true;
    });

    /* Access first step */
    eventBus.$on('access-first-step', () => {
      this.displayContentSecondStep = false;
    });

    /* Access third step */
    eventBus.$on('access-third-step', () => {
      this.displayContentSecondStep = false;
    });
  }
};
</script>
