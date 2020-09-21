<template>
  <div class="content-page">
    <el-card class="box-card" style="max-width: 570px" v-on:keydown.enter.native="publish()">
      <div slot="header" class="clearfix">
        <el-row>
          <el-col :md="3">

            <el-avatar
              :src="$getUrlToContents() + 'avatar/' + user.avatar+''"
            />
          </el-col>
          <el-col :md="12" class="p-t-10">

            <b><span class="link">{{ user.name }}</span></b><br>
            <i
              style="color: rgba(43,33,40,0.66)">{{
                new Date().toLocaleString(new Date().getTimezoneOffset(), {dateStyle: "full"})
              }}</i>
          </el-col>
        </el-row>

      </div>

      <wysiwyg v-model="publication"/>
      <br>
      <el-button @click="publish()" type="primary" round>{{ lang['publish'] }}</el-button>
    </el-card>
    <br>
    <PostList :publications="publications"/>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import {mapState} from 'vuex';
import PostList from '@/components/sabiorealm-social/PostList';

export const eventBus = new Vue();

Vue.use(VueHead);
export default {
  data: () => {
    return {
      publication: '',
      comment: [],
      publications: []
    };
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  components: {PostList},
  created() {
    this.getOnlineUsers();
    this.$verifyAdministratorPrivileges();
    this.getPublications();
  },
  mounted() {

    setInterval(() => {
      this.getPublications();
    }, 2300);
  },
  methods: {
    async publish() {
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      form.append('description', this.publication);
      const data = await this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'savePublication'), form);
      if (data.status === 200) {
        // console.log(data);
        this.$messagePublished();
        // eslint-disable-next-line eqeqeq
      } else if (data.data == false) {
        this.$errorMessage();
      }
      this.getPublications();
      this.publication = '';
    },
    getPublications() {
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'getPublications')).then((response) => {
        this.publications = response.data;
      });
    },
    // eslint-disable-next-line camelcase
    doPublicationLike(publication_id) {
      console.log(publication_id);
      const form = new FormData();
      form.append('social_publication_id', publication_id);
      form.append('myuser_id', this.user.id);
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'doLike'), form).then((response) => {
        // console.log(response.data);
      });
    },
    getOnlineUsers() {
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'getOnlineUsers')).then((response) => {
        console.log(response);
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
