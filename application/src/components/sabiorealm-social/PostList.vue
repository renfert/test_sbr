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
          <el-button @load="getLike(publication.id)" @click="doPublicationLike(publication.id,$event)"
                     circle><i class="fas fa-thumbs-up"
                               style="color:#4a5568"></i>
          </el-button>
          {{ new Date(publication.created).toLocaleString(new Date().getTimezoneOffset(), {dateStyle: "full"}) }}
        </p>
      </el-row>
      <el-row>
        <el-col :md="24">

          <el-input @keyup.enter.native="saveComment(publication.id,index)"
                    :placeholder="lang['publication-comment']"
                    v-model="comment[index]">

          <span slot="suffix" v-if="comment[index]">
            <i @click="saveComment(publication.id,index)" class="fas fa-paper-plane over"
               style="margin-top: 10px;font-size:large;"
               :title="lang['publish']"></i>

          </span>
            <span slot="suffix" v-if="loading">
          <i class="el-icon-loading center" style="font-size: 25px;margin-top: 10px;font-size:large;color: #009cd8;"></i>
          </span>
          </el-input>
        </el-col>
        <el-col :md="1">
        </el-col>
      </el-row>
      <br>
      <SubCommentary :publication_id="publication.id"/>
    </el-card>

  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';

import wysiwyg from 'vue-wysiwyg';
import {mapState} from 'vuex';
import SubCommentary from '@/components/sabiorealm-social/SubCommentary';

export const eventBus = new Vue();

Vue.use(VueHead);

Vue.use(wysiwyg, {});
export default {
  props: ['publications'],
  data: () => {
    return {
      comment: [],
      update: [],
      loading: false
    };
  },
  components: {SubCommentary},
  created() {
    this.$verifyAdministratorPrivileges();
  },
  computed: {

    ...mapState(['lang', 'user'])
    // eslint-disable-next-line vue/no-async-in-computed-properties

  },
  methods: {
    // eslint-disable-next-line camelcase
    async saveComment(publication_id, index) {
      this.loading = true;
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      form.append('comment', this.comment[index]);
      form.append('social_publication_id', publication_id);
      this.comment[index] = '';
      await this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'saveComment'), form);
      this.loading = false;
    },
    // eslint-disable-next-line camelcase
    getLike(publication_id, event) {
      // eslint-disable-next-line vue/no-async-in-computed-properties
      const form = new FormData();
      form.append('social_publication_id', publication_id);
      form.append('myuser_id', this.user.id);
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'checkIfLike')).then((response) => {
        // console.log(response);
      });
      return true;
    },
    // eslint-disable-next-line camelcase
    doPublicationLike(publication_id) {
      // event.currentTarget.children[0].style.color = 'rgb(255, 255, 255)';
      event.currentTarget.style.backgroundColor = '#67C23A';
      event.currentTarget.children[0].style.color = 'white';
      // console.log(event);
      const form = new FormData();
      form.append('social_publication_id', publication_id);
      form.append('myuser_id', this.user.id);
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'doLike'), form).then((response) => {
        // console.log(response.data);
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
