<template>
  <div>
    <div class="row">
      <purchase-in-process
        v-if="purchaseStatus == 'pending'"
      ></purchase-in-process>
      <purchase-success v-if="purchaseStatus == 'success'"></purchase-success>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import PurchaseInProcess from '@/components/purchase/PurchaseInProcess';
import PurchaseSuccess from '@/components/purchase/PurchaseSuccess';

import { mapState } from 'vuex';

export const eventBus = new Vue();

Vue.use(VueHead);
export default {
  data: () => {
    return {
      purchaseStatus: null
    };
  },
  components: {
    PurchaseInProcess,
    PurchaseSuccess
  },
  computed: {
    ...mapState(['lang'])
  },
  created() {
    this.purchaseStatus = this.$route.params.status;
  },
  head: {
    title: {
      inner: 'Purchase'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>

<style></style>
