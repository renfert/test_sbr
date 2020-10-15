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
  mounted() {
    const compability = document.createElement('script');
    compability.setAttribute(
      'src',
      'https://cdn.eadtools.com/library/plugins/ViewerJS/compatibility.js'
    );
    compability.async = true;
    document.head.appendChild(compability);

    const pdf = document.createElement('script');
    pdf.setAttribute(
      'src',
      'https://cdn.eadtools.com/library/plugins/ViewerJS/pdf.js'
    );
    pdf.async = true;
    document.head.appendChild(pdf);

    const pdfWorker = document.createElement('script');
    pdfWorker.setAttribute(
      'src',
      'https://cdn.eadtools.com/library/plugins/ViewerJS/pdf.worker.js'
    );
    pdfWorker.async = true;
    document.head.appendChild(pdfWorker);

    const pdfJsVersion = document.createElement('script');
    pdfJsVersion.setAttribute(
      'src',
      'https://cdn.eadtools.com/library/plugins/ViewerJS/pdfjsversion.js'
    );
    pdfJsVersion.async = true;
    document.head.appendChild(pdfJsVersion);

    const textLayerBuilder = document.createElement('script');
    textLayerBuilder.setAttribute(
      'src',
      'https://cdn.eadtools.com/library/plugins/ViewerJS/text_layer_builder.js'
    );
    textLayerBuilder.async = true;
    document.head.appendChild(textLayerBuilder);

    const uiUtils = document.createElement('script');
    uiUtils.setAttribute(
      'src',
      'https://cdn.eadtools.com/library/plugins/ViewerJS/ui_utils.js'
    );
    uiUtils.async = true;
    document.head.appendChild(uiUtils);

    const webodf = document.createElement('script');
    webodf.setAttribute(
      'src',
      'https://cdn.eadtools.com/library/plugins/ViewerJS/webodf.js'
    );
    webodf.async = true;
    document.head.appendChild(webodf);
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

/* Let's get this party started */
::-webkit-scrollbar {
  display: none;
}
</style>
