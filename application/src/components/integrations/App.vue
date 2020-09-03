<template>
  <div class="content-page">
    <div class="card-box">
      <h4 class="fw-700 mb-5">{{ lang['integrations'] }}</h4>
      <template>
        <!-- Desktop -->
        <div class="desktop-tabs">
          <el-tabs v-model="tab" tab-position="left" style="height: 350px">
            <el-tab-pane name="gtm" label="Google tag manager">
              <google-tag-manager></google-tag-manager>
            </el-tab-pane>

            <el-tab-pane name="fb" label="Facebook pixel">
              <facebook-pixel></facebook-pixel>
            </el-tab-pane>

            <el-tab-pane name="ga" label="Google analytics">
              <google-analytics></google-analytics>
            </el-tab-pane>

            <el-tab-pane name="mp" label="Mercado pago">
              <mercado-pago></mercado-pago>
            </el-tab-pane>
          </el-tabs>
        </div>

        <!-- Mobile -->
        <div class="mobile-tabs">
          <el-tabs v-model="tab" tab-position="top" style="height: 350px">
            <el-tab-pane name="gtm" label="Google tag manager">
              <google-tag-manager></google-tag-manager>
            </el-tab-pane>

            <el-tab-pane name="fb" label="Facebook pixel">
              <facebook-pixel></facebook-pixel>
            </el-tab-pane>

            <el-tab-pane name="ga" label="Google analytics">
              <google-analytics></google-analytics>
            </el-tab-pane>

            <el-tab-pane name="mp" label="Mercado pago">
              <mercado-pago></mercado-pago>
            </el-tab-pane>
          </el-tabs>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import GoogleTagManager from '@/components/integrations/GoogleTagManager';
import GoogleAnalytics from '@/components/integrations/GoogleAnalytics';
import MercadoPago from '@/components/integrations/MercadoPago';
import FacebookPixel from '@/components/integrations/FacebookPixel';
import VueHead from 'vue-head';
import { mapState } from 'vuex';

Vue.use(VueHead);

export default {
  data: () => {
    return {
      tab: 'gtm'
    };
  },
  created() {
    this.$verifyAdministratorPrivileges();
  },
  computed: {
    ...mapState(['lang'])
  },
  head: {
    title: {
      inner: 'Integrations'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  components: {
    GoogleTagManager,
    GoogleAnalytics,
    MercadoPago,
    FacebookPixel
  }
};
</script>

<style scoped>
.mobile-tabs {
  display: none;
}
@media only screen and (max-width: 600px) {
  .desktop-tabs {
    display: none;
  }
  .mobile-tabs {
    display: initial;
  }
}
</style>
