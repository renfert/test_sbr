<template>
  <div class="content-page">
    <el-row :gutter="8">
      <el-col :md="6" :sm="24" :xs="24">
        <UserStatus/>
        <br>
      </el-col>
      <el-col :md="18" :sm="24" :xs="24">
        <el-card class="box-card" style="max-width: 570px">
          <div slot="header" class="clearfix">
            <el-row>
              <el-col :md="3" :sm="4" :xs="4">

                <el-avatar
                  :src="$getUrlToContents() + 'avatar/' + user.avatar+''"
                />
              </el-col>
              <el-col :md="17" :sm="20" :xs="20" class="p-t-10">
                <router-link :to="'user/'+user.id">
                  <b><span class="link">{{ user.name }}</span></b><br>
                </router-link>
              </el-col>

            </el-row>

          </div>
          <el-input
            type="textarea"
            :rows="2"
            :placeholder="lang['enter-text']"
            v-model="publication">
          </el-input>
          <br>
          <br>
          <el-button @click="publish()" type="primary" round>{{ lang['publish'] }}</el-button>
          &nbsp;
          <i
            style="color: rgba(43,33,40,0.66)">{{
              new Date().toLocaleString(new Date().getTimezoneOffset(), {dateStyle: "full"})
            }}</i>
        </el-card>
        <br>
        <PostList :publications="publications"/>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import {mapState} from 'vuex';
import PostList from '@/components/sabiorealm-social/PostList';
import UserStatus from '@/components/sabiorealm-social/UserStatus';

Vue.use(VueHead);
export const eventBus = new Vue();
export default {
  data: () => {
    return {
      publication: '',
      comment: [],
      publications: []
    };
  },
  head: {
    title: {
      inner: 'Courses'
    },
    meta: [
      {name: 'charset', content: 'utf-8'},
      {name: 'viewport', content: 'width=device-width, initial-scale=1.0'},
      {name: 'author', content: 'Sabiorealm'}
    ]
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  components: {UserStatus, PostList},
  created() {
    this.getPublications();
  },
  mounted() {
    eventBus.$on('social-update-post', () => {
      this.getPublications();
    });
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
      eventBus.$emit('social-update-post');
      eventBus.$emit('social-load-commentaries');
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
