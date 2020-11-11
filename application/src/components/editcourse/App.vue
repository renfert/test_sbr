<template>
  <div class="content-page">
    <div class="form-wizard-wrapper">
      <wizard-nav></wizard-nav>
      <div class="form-wizard-content-wrapper">
        <first-step></first-step>
        <second-step></second-step>
        <third-step></third-step>
      </div>
    </div>

  </div>
</template>
<script>
import WizardNav from '@/components/newcourse/WizardNav';
import FirstStep from '@/components/editcourse/FirstStep';
import SecondStep from '@/components/editcourse/SecondStep';
import ThirdStep from '@/components/editcourse/ThirdStep';
import Vue from 'vue';
import VueHead from 'vue-head';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  data() {
    return {

    };
  },
  created() {
    this.$blockStudentAccess();
  },
  head: {
    title: {
      inner: 'Edit course'
    },
    meta: [
      {name: 'charset', content: 'utf-8'},
      {name: 'viewport', content: 'width=device-width, initial-scale=1.0'},
      {name: 'author', content: 'Sabiorealm'}
    ]
  },
  components: {
    WizardNav,
    FirstStep,
    SecondStep,
    ThirdStep
  },
  methods: {
  }
};
</script>

<style scoped>
.form-wizard-wrapper {
  position: relative !important;
}
</style>
