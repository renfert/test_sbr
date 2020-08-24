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
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ModuleList from "@/components/modules/ModuleList";
import ModuleCreate from "@/components/modules/ModuleCreate";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

Vue.use(VueAxios, axios);

import { eventBus } from "@/components/newcourse/App";

export default {
  mixins: [domains, alerts],
  components: {
    ModuleList,
    ModuleCreate
  },
  data: () => {
    return {
      displayContentSecondStep: false,
      courseId: ""
    };
  },
  mounted() {
    /* When a new course was created */
    eventBus.$on("new-course", response => {
      this.courseId = response;
    });

    /* Access second step */
    eventBus.$on("access-second-step", () => {
      this.displayContentSecondStep = true;
    });

    /* Access first step */
    eventBus.$on("access-first-step", () => {
      this.displayContentSecondStep = false;
    });

    /* Access third step */
    eventBus.$on("access-third-step", () => {
      this.displayContentSecondStep = false;
    });
  }
};
</script>
