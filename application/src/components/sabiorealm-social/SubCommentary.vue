<template>
  <div>
    <hr>
    <div v-for="(comment,index) in comments" :key="index"
         style="margin-bottom: 4px;background-color: rgba(92,99,216,0.04);border-radius: 10px;padding: 10px">

      <div style="font-size: 12px;color:#009cd8;">


          <el-row :gutter="2">
            <el-col :md="2" >

              <el-avatar size="small"
                         :src="$getUrlToContents() + 'avatar/' + comment.avatar+''"
              />
            </el-col>
            <el-col :md="12" style="margin-top: 8px">

              <a href="#">

                {{ comment.username }}</a>
            </el-col>
          </el-row>

      </div>
      <el-row justify="start">
        <el-col :md="24">
          <div v-html="comment.comment" style="overflow-wrap: anywhere" >
          </div>
        </el-col>
      </el-row>
      <br>
      <div style="color:#909399; font-size:10px">
        {{ new Date(comment.created).toLocaleString(new Date().getTimezoneOffset(), {dateStyle: "full"}) }} -
        {{new Date(comment.created).toLocaleTimeString()}}
      </div>
    </div>
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
  props: ['publication_id'],
  data: () => {
    return {
      comments: []
    };
  },
  components: {},
  created() {
    this.$verifyAdministratorPrivileges();
    setInterval(() => {

      this.loadCommentaries();
    }, 1200);
  },
  computed: {
    ...mapState(['lang', 'user'])
    // eslint-disable-next-line vue/no-async-in-computed-properties

  },
  methods: {
    async loadCommentaries() {
      const form = new FormData();
      form.append('social_publication_id', this.publication_id);
      this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'getCommentsByPub'),
        form)
        .then((response) => {
            this.comments = response.data;
          }
        );
    }
  }
};
</script>
