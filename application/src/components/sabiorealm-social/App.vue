<template>
  <div>
    <div class="row">
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Card name</span>
          <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
        </div>
        <div v-for="o in 4" :key="o" class="text item">
          {{ 'List item ' + o }}
        </div>
      </el-card>
    </div>
  </div>

</template>

<script>

import Vue from 'vue';
import VueHead from 'vue-head';

Vue.use(VueHead);
export default {

  created() {
  },
  methods: {}
};
</script>

<style scoped>

</style>