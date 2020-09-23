<template>
  <div>
    <hr>
    <div v-for="(comment,index) in comments" :key="index"
         style="margin-bottom: 4px;background-color: rgba(92,99,216,0.1);border-radius: 10px;padding: 10px">

      <div style="font-size: 12px;color:#009cd8;">

        <el-row :gutter="2">
          <el-col :md="2" :sm="3" :xs="3">

            <el-avatar size="small"
                       :src="$getUrlToContents() + 'avatar/' + comment.avatar+''"
            />
          </el-col>
          <el-col :md="12" :sm="10" :xs="10" style="margin-top: 8px">

            <router-link :to="'user/'+user.id">
              {{ comment.username }}
            </router-link>
          </el-col>
        </el-row>

      </div>
      <el-row justify="start">

        <el-col :md="22">
          <div v-html="comment.comment" style="overflow-wrap: anywhere">
          </div>
        </el-col>

      </el-row>
      <br>
      <el-row justify="center">

        <el-col :md="2" :sm="4" :xs="4">
          <el-button
            circle><i class="fas fa-thumbs-up"
                      style="color:#4a5568"></i>
          </el-button>

        </el-col>
        <el-col :md="10" :sm="15" :xs="15" style="margin-top:10px">

          <div style="color:#909399; font-size:10px">
            {{ new Date(comment.created).toLocaleString(new Date().getTimezoneOffset(), {dateStyle: "full"}) }} -
            {{ new Date(comment.created).toLocaleTimeString() }}
          </div>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';

import wysiwyg from 'vue-wysiwyg';
import {mapState} from 'vuex';
import {eventBus} from '@/components/sabiorealm-social/App';

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
  mounted() {
    setInterval(() => {
      this.loadCommentaries();
    }, 2900);
    eventBus.$on('social-load-commentaries', () => {
      console.log('cargando comentarios');
      this.loadCommentaries();
    });
  },
  created() {
    this.loadCommentaries();
  },
  computed: {
    ...mapState(['lang', 'user'])
    // eslint-disable-next-line vue/no-async-in-computed-properties

  },
  methods: {
    loadCommentaries() {
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
