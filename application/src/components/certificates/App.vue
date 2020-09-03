<template>
  <div class="content-page">
    <certificates-list></certificates-list>
  </div>
</template>

<script>
import CertificatesList from '@/components/certificates/CertificatesList.vue';
import Vue from 'vue';
import VueHead from 'vue-head';

Vue.use(VueHead);

export default {
  components: {
    CertificatesList
  },
  head: {
    title: {
      inner: 'Certificates'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
