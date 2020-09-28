<template>
  <div>
    <hr>
    <a @click.prevent="viewComments=!viewComments">
      <b v-if="n_comments>0">
        {{ lang['see'] }} {{ n_comments }} {{ lang['comments'] }} <i class="fas fa-angle-down"></i>
      </b>
    </a>
    <div v-if="viewComments">
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
      comments: [],
      n_comments: 0,
      viewComments: false,
      prueba: 0
    };
  },
  components: {},
  async mounted() {
    // while (true) {
    //   this.loadCommentaries();
    //
    //   await this.sleep(5000);
    // }
    await setInterval(async() => {
      await this.loadCommentaries();
    }, 5000);
    // eslint-disable-next-line no-unreachable
    eventBus.$on('social-load-commentaries', () => {
      this.loadCommentaries();
    });
  },
  created() {
    this.loadCommentaries();
  },
  computed: {
    ...mapState(['lang', 'user'])

  },
  methods: {
    sleep(ms) {
      return new Promise(resolve => setTimeout(resolve, ms));
    },
    async loadCommentaries() {
      const form = new FormData();
      form.append('social_publication_id', this.publication_id);
      const {data} = await this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'getCommentsByPub'),
        form);
      this.comments = data;
      this.n_comments = this.comments.length;
    }
  }
}
</script>
