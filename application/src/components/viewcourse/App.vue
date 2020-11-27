<template>
  <div>
    <button class="kc_fab_main_btn corazon" @click="hamburgerClick" id="fab">
      <i class="ti-menu"></i>
    </button>
    <topbar></topbar>
    <navigation></navigation>
  </div>
</template>

<script>
import Vue from 'vue';
import Topbar from '@/components/viewcourse/Topbar';
import VueHead from 'vue-head';
import Navigation from '@/components/viewcourse/Navigation';

import { mapState } from 'vuex';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    Navigation,
    Topbar
  },

  data: () => {
    return {
      mobile: 'retracted'
    };
  },
  created() {
    eventBus.$on('change-leftbar-class', () => {
      this.mobile === 'retracted'
        ? (this.mobile = 'opened')
        : (this.mobile = 'retracted');
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  head: {
    title: {
      inner: 'View course'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  methods: {
    hamburgerClick() {
      eventBus.$emit('change-leftbar-class');
    }
  }
};
</script>

<style scoped>
.el-container {
  border: none !important;
}

.v-model {
  z-index: 300 !important;
}

/* Let's get this party started */
::-webkit-scrollbar {
  display: none;
}
</style>
