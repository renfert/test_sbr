<template>
  <div class="content-page">
    <el-card class="box-card" style="max-width: 570px">
      <div slot="header" class="clearfix">
        <el-row>
          <el-col :md="3">
            <img src="https://www.w3schools.com/howto/img_avatar.png" class="image" width="50" height="50px">
          </el-col>
          <el-col :md="6" class="p-t-10">

            <b><span class="link">Camilo</span></b><br>
            <i style="color: rgba(43,33,40,0.66)">{{ new Date().toDateString() }}</i>
          </el-col>
        </el-row>

      </div>

      <wysiwyg v-model="description"/>
      <br>
      <el-button type="primary" round>Publicar</el-button>
    </el-card>
    <br>
    <el-card class="box-card" style="max-width: 570px">
      <div slot="header" class="clearfix">
        <img src="https://www.w3schools.com/howto/img_avatar.png" class="image" width="50" height="50px">
        &nbsp;
        <b><span class="link">Camilo</span></b>
      </div>
      <div>
        <span>Mi nuevo post</span>
      </div>
      <br>
      <el-row>

        <p style="color: rgba(43,33,40,0.66)"><el-button type="success" circle><i class="fas fa-thumbs-up"></i></el-button> {{ new Date().toDateString() }}</p>
      </el-row>

      <el-row>
        <el-input placeholder="Ingresar respuestas" v-model="response">
          <i class="fas fa-paper-plane" slot="suffix" style="margin-top: 10px"></i></el-input>
      </el-row>
    </el-card>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';

import wysiwyg from 'vue-wysiwyg';

export const eventBus = new Vue();

Vue.use(VueHead);

Vue.use(wysiwyg, {});
export default {
  data: () => {
    return {
      description: '',
      response: ''
    };
  },
  components: {},
  created() {
    this.$verifyAdministratorPrivileges();
  }
};
</script>
<style>

.image {
  border-radius: 100%;
}

.link {
  color: #0c7cd5;
  font-size: medium;
}
</style>
