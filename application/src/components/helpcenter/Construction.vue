<template>
  <div class="mt-5 text-center pr-5 pl-5">
    <el-row :gutter="40">
      <el-col :sm="12" :xs="24">
        <div style="width: 100%; background-color: red">
          <h1>teste</h1>
        </div>
      </el-col>
      <el-col :sm="12">
        <div style="width: 100%; background-color: green">
          <h1>teste</h1>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  computed: {
    ...mapState(['lang'])
  }
};
</script>
