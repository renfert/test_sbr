<template>
  <div v-if="displayContentSecondStep">
    <div class="card-box card-course mt-5">
      <module-list :course-id="this.$route.params.id"></module-list>
    </div>
    <module-create :course-id="this.$route.params.id"></module-create>
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
      displayContentSecondStep: false
    };
  },
  mounted() {
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
