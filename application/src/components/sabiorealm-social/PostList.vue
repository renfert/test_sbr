<template>
  <div>
    <el-card class="box-card" style="max-width: 800px;margin-bottom: 10px" v-for="(publication,index) in publications"
             :key="index" @load="hide($event)">
      <div slot="header" class="clearfix">
        <el-row>
          <el-col :md="2" :sm="4" :xs="4">
            <el-avatar
              :src="$getUrlToContents() + 'avatar/' + user.avatar + ''"
            />
          </el-col>
          <el-col :md="18" :sm="14" :xs="14" class="p-t-10">
            <router-link :to="'/user/'+publication.myuser_id">
              <b><span class="link">{{ publication.username }} </span>
                <i class="fas fa-caret-right" style="font-size: 15px"></i>
              </b>
            </router-link>
            <b>
              <a v-if="publication.group_id >1">
                {{ publication.group_name }}
              </a>
              <a v-else-if="publication.course_id>1">
                {{ publication.course_name }}
              </a>
              <a v-else>
                {{ lang['group-default'] }}
              </a>
            </b>
          </el-col>
          <div v-if="user.id===publication.myuser_id ">

            <el-col :md="2" :sm="3" :xs="3">
              <el-button @click="editPost(publication.id,publication.description)" type="primary" icon="el-icon-edit"
                         circle
                         size="small"></el-button>
            </el-col>
          </div>
          <div v-if="user.role===1 || user.id===publication.myuser_id ">
            <el-col :md="1" :sm="2" :xs="2">
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                placement="right"
                :title="lang['delete']+' ?'"
                @onConfirm="deletePost(publication.id)"
              >
                <el-button
                  size="small"
                  class="sbr-danger ml-1"
                  slot="reference"
                  icon="el-icon-delete"
                  circle
                ></el-button>
              </el-popconfirm>
            </el-col>
          </div>
        </el-row>
      </div>
      <!--      <div v-if="publication.description.length>=280 ">-->

      <!--<div v-html="publication.description" style="-->
      <!--  overflow: hidden;-->
      <!--text-overflow: ellipsis;-->
      <!--display: -webkit-box;-->
      <!-- -webkit-line-clamp: 3;-->
      <!-- -webkit-box-orient: vertical;">-->
      <!--        </div>-->
      <!--        <b><a class="linknav" @click.prevent="viewMore(index)">{{ lang["view-more"] }}</a></b>-->
      <!--      </div>-->
      <!--      <div v-else>-->
      <!--        <div v-html="publication.description">-->
      <!--        </div>-->
      <!--      </div>-->
      <el-row >
        <div v-html="publication.description" style="word-break: break-word;text-overflow: ellipsis;-webkit-line-break: after-white-space;-webkit-box-orient: vertical; ">
        </div>
      </el-row>
      <br>
      <el-row v-if="publication.media_path" justify="center" align="start" :gutter="50">
        <center>
          <img :src="$getUrlToContents() + 'social/'+publication.media_path" style="border-radius: 7px" height="250vh"
               onerror="this.onerror=null">
        </center>
      </el-row>
      <br>
      <el-row>
        <p style="color: rgba(43,33,40,0.66)">
          <el-button
            size="mini"
            :type="publication.i_like_it?'primary':''"
                     @click="doPublicationLike(publication.id,$event)"
                     circle><i class="fas fa-thumbs-up"
                               :style="publication.i_like_it?'color:white':'color:#4a5568'"></i>
          </el-button>
          {{ publication.likes > 0 ? publication.likes + ' likes,' : '' }}
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
          <i class="el-icon-loading center"
             style="font-size: 25px;margin-top: 10px;font-size:large;color: #009cd8;"></i>
          </span>
          </el-input>
        </el-col>
      </el-row>
      <br>
      <SubCommentary :publication_id="publication.id"/>
    </el-card>
    <el-dialog
      :title="lang['edit']"
      :visible.sync="editDialog"
      width="50%"
    >
      <el-row :md="24" justify="center">
        <el-input
          type="textarea"
          :rows="3"
          :placeholder="lang['enter-text']"
          v-model="editText">
        </el-input>
        <br>
        <br>
        <el-button @click="publish()" type="primary" round>
          <i class="el-icon-loading"
             style="color: white;" v-if="loading"></i>
          <i class="far fa-paper-plane" v-else></i> {{
            lang['publish']
          }}
        </el-button>
      </el-row>
    </el-dialog>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';

import wysiwyg from 'vue-wysiwyg';
import {mapState} from 'vuex';
import SubCommentary from '@/components/sabiorealm-social/SubCommentary';
import {eventBus} from '@/components/sabiorealm-social/App';

Vue.use(VueHead);
Vue.use(wysiwyg, {});
export default {
  props: ['type', 'typeid'],
  data: () => {
    return {
      comment: [],
      update: [],
      loading: false,
      editDialog: false,
      editText: '',
      publication_id: null,
      publications: []
    };
  },
  components: {SubCommentary},
  created() {
    switch (this.type) {
      case 'all': {
        this.getPublications();
        break;
      }
      case 'group': {
        this.getPublicationByGroup();
        break;
      }
      case 'course': {
        this.getPublicationByCourse();
        break;
      }
    }
  },
  mounted() {
    eventBus.$on('social-update-post', () => {
      switch (this.type) {
        case 'all': {
          this.getPublications();
          break;
        }
        case 'group': {
          this.getPublicationByGroup();
          break;
        }

        case 'course': {
          this.getPublicationByCourse();
          break;
        }
      }
    });
  },
  computed: {

    ...mapState(['lang', 'user'])
    // eslint-disable-next-line vue/no-async-in-computed-properties

  },
  methods: {
    getPublicationByGroup() {
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      form.append('group_id', this.typeid);
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'getPublicationsByGroup'), form).then((response) => {
        this.publications = response.data;
      });
    },
    getPublicationByCourse() {
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      form.append('course_id', this.typeid);
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'getPublicationsByCourse'), form).then((response) => {
        this.publications = response.data;
      });
    },
    getPublications() {
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'getPublications'), form).then((response) => {
        this.publications = response.data;
      });
    },
    // eslint-disable-next-line camelcase
    async saveComment(publication_id, index) {
      this.loading = true;
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      form.append('comment', this.urlify(this.comment[index]));
      form.append('social_publication_id', publication_id);
      this.comment[index] = '';
      await this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'saveComment'), form);
      this.loading = false;
      eventBus.$emit('social-update-post');
      eventBus.$emit('social-load-commentaries');
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
      const form = new FormData();
      form.append('social_publication_id', publication_id);
      form.append('myuser_id', this.user.id);
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'doPublicationLike'), form).then((response) => {
        eventBus.$emit('social-update-post');
      });
    },
    // eslint-disable-next-line camelcase
    deletePost(publication_id) {
      const form = new FormData();
      form.append('social_publication_id', publication_id);
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'deletePost'), form).then((response) => {
        eventBus.$emit('social-update-post');
        setTimeout(() => {
          eventBus.$emit('social-load-commentaries');
        }, 500);
      });
    },
    editPost(id, description) {
      this.editDialog = true;
      this.editText = description;
      this.publication_id = id;
    },
    async publish() {
      this.loading = true;
      const form = new FormData();
      form.append('id', this.publication_id);
      form.append('description', this.editText);
      const data = await this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'savePublication'), form);
      if (data.status === 200 && this.editText.length > 0) {
        this.$messagePublished();
        // eslint-disable-next-line eqeqeq
      } else if (data.data == false) {
        this.$errorMessage();
      }
      eventBus.$emit('social-update-post');
      setTimeout(() => {
        eventBus.$emit('social-load-commentaries');
      }, 500);
      this.editText = '';
      this.loading = false;
      this.editDialog = false;
    },
    urlify(text) {
      const urlRegex = /(https?:\/\/[^\s]+)/g;
      return text.replace(urlRegex, (url) => {
        return '<a target="_blank" href="' + url + '">' + url + '</a>';
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
