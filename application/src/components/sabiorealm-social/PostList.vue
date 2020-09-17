<template>
  <div>
    <el-card class="box-card" style="max-width: 570px;margin-bottom: 10px" v-for="(publication,index) in publications"
             :key="index">
      <div slot="header" class="clearfix">
        <el-row>
          <el-col :md="3">
            <router-link class="pr-4" to="/profile">
              <el-avatar
                :src="$getUrlToContents() + 'avatar/' + user.avatar + ''"
              />
            </router-link>
          </el-col>
          <el-col :md="6" class="p-t-10">
            <b><span class="link">{{ user.name }}</span></b><br>
          </el-col>
        </el-row>
      </div>
      <div v-html="publication.description">
      </div>
      <br>
      <el-row>
        <p style="color: rgba(43,33,40,0.66)">
          <el-button @click="doPublicationLike(publication.id)" type="success" circle><i class="fas fa-thumbs-up"></i>
          </el-button>
          {{ new Date(publication.created).toLocaleString(new Date().getTimezoneOffset(), {dateStyle: "full"}) }}
        </p>
      </el-row>
      <el-row>
        <el-input :placeholder="lang['publication-comment']" v-model="comment[index]">

          <span slot="suffix" v-if="comment[index]">
            <i @click="saveComment()" class="fas fa-paper-plane over" style="margin-top: 10px;font-size:large;"
               :title="lang['publish']"></i>
          </span>
        </el-input>
      </el-row>
      <br>
    </el-card>

  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';

import wysiwyg from 'vue-wysiwyg';
import {mapState} from "vuex";

export const eventBus = new Vue();

Vue.use(VueHead);

Vue.use(wysiwyg, {});
export default {
  props: ['publications'],
  data: () => {
    return {
      comment: []
    };
  },
  components: {},
  created() {
    this.$verifyAdministratorPrivileges();
  },
  computed: {

    ...mapState(['lang', 'user']),
  },
  methods: {
    async saveComment() {
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      form.append('comment', this.comment);
      form.append('social_publication_id', 1);
      const data = await this.$request.post('http://localhost/sbr_rep/SocialNetwork/saveComment', form);
      console.log(data);
    },
    // eslint-disable-next-line camelcase
    doPublicationLike(publication_id) {
      console.log(publication_id);
      const form = new FormData();
      form.append('social_publication_id', publication_id);
      form.append('myuser_id', this.user.id);
      this.$request.post('http://localhost/sbr_rep/SocialNetwork/doLike', form).then((response) => {
        console.log(response.data);
      });
    }
  }
};
</script>

<style type="text/scss">

.image {
  border-radius: 100%;
}

.link {
  color: #0c7cd5;
  font-size: medium;
}

.over:hover {
  transition: 1.2s;
  color: #009cd8;
  //font-size: large;
  cursor: pointer;
}
</style>