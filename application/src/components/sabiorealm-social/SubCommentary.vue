<template>
  <div>
    <hr />
    <a @click.prevent="viewComments = !viewComments">
      <b v-if="n_comments > 0">
        {{ lang['see'] }} {{ n_comments }} {{ lang['comments'] }}
        <i class="fas fa-angle-down"></i>
      </b>
    </a>
    <div v-if="viewComments">
      <div
        v-for="(comment, index) in comments"
        :key="index"
        style="
          margin-bottom: 4px;
          background-color: rgba(92, 99, 216, 0.1);
          border-radius: 10px;
          padding: 10px;
        "
      >
        <div style="font-size: 12px; color: #009cd8">
          <el-row :gutter="2">
            <el-col :md="2" :sm="3" :xs="3">
              <el-avatar
                size="small"
                :src="$getUrlToContents() + 'avatar/' + comment.avatar + ''"
              />
            </el-col>
            <el-col :md="12" :sm="10" :xs="10" style="margin-top: 8px">
              <router-link :to="'user/' + user.id">
                {{ comment.username }}
              </router-link>
              <div
                style="
                  color: #909399;
                  font-size: 10px;
                  display: inline-block;
                  white-space: nowrap;
                "
              >
                {{
                  new Date(comment.created).toLocaleString(
                    new Date().getTimezoneOffset(),
                    {
                      dateStyle: 'full'
                    }
                  )
                }}
                -
                {{ new Date(comment.created).toLocaleTimeString() }}
              </div>
            </el-col>
          </el-row>
        </div>
        <el-row justify="start">
          <el-col :md="20" :sm="10">
            <div v-html="comment.comment" style="overflow-wrap: anywhere"></div>
          </el-col>
          <div v-if="user.id === comment.myuser_id">
            <el-col :md="2" :sm="1" :xs="3">
              <el-button
                type="primary"
                icon="el-icon-edit"
                circle
                @click="editComment(comment.id, comment.comment)"
                size="small"
              ></el-button>
            </el-col>
          </div>

          <div v-if="user.role === 1 || user.id === comment.myuser_id">
            <el-col :md="1" :sm="1" :xs="2">
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                placement="right"
                :title="lang['delete'] + ' ?'"
                @onConfirm="deleteComment(comment.id)"
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
        <br />
        <el-row justify="center">
          <el-col :md="4" :sm="4" :xs="4">
            <el-button
              :type="comment.i_like_it ? 'primary' : ''"
              @click="doCommentaryLike(comment.id)"
              circle
              ><i
                class="fas fa-thumbs-up"
                :style="comment.i_like_it ? 'color:white' : 'color:#4a5568'"
              ></i>
            </el-button>

            {{ comment.likes > 0 ? comment.likes + ' likes' : '' }}
          </el-col>
        </el-row>
      </div>
    </div>

    <el-dialog :title="lang['edit']" :visible.sync="editDialog" width="50%">
      <el-row :md="24" justify="center">
        <el-input
          type="textarea"
          :rows="3"
          :placeholder="lang['enter-text']"
          v-model="editText"
        >
        </el-input>
        <br />
        <br />
        <el-button @click="saveComment()" type="primary" round>
          <i class="el-icon-loading" style="color: white" v-if="loading"></i>
          <i class="far fa-paper-plane" v-else></i> {{ lang['publish'] }}
        </el-button>
      </el-row>
    </el-dialog>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';

import wysiwyg from 'vue-wysiwyg';
import { mapState } from 'vuex';
import { eventBus } from '@/components/sabiorealm-social/App';

Vue.use(VueHead);

Vue.use(wysiwyg, {});
export default {
  props: ['publication_id'],
  data: () => {
    return {
      editText: '',
      comment_id: '',
      editDialog: false,
      comments: [],
      n_comments: 0,
      viewComments: false,
      prueba: 0,
      loading: false,
      commentUpdateHandle: null
    };
  },
  components: {},
  async mounted() {
    // while (true) {
    //   this.loadCommentaries();
    //
    //   await this.sleep(5000);
    // }
    /* eslint-disable */
    this.commentUpdateHandle = await setInterval(async () => {
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
      return new Promise((resolve) => setTimeout(resolve, ms));
    },
    async loadCommentaries() {
      const form = new FormData();
      form.append('social_publication_id', this.publication_id);
      form.append('myuser_id', this.user.id);
      const { data } = await this.$request.post(
        this.$getUrlToMakeRequest('SocialNetwork', 'getCommentsByPub'),
        form
      );
      this.comments = data;
      this.n_comments = this.comments.length;
    },
    // eslint-disable-next-line camelcase
    doCommentaryLike(comment_id) {
      const form = new FormData();
      form.append('social_comment_id', comment_id);
      form.append('myuser_id', this.user.id);
      this.$request
        .post(
          this.$getUrlToMakeRequest('SocialNetwork', 'doCommentaryLike'),
          form
        )
        .then((response) => {
          eventBus.$emit('social-update-post');
          eventBus.$emit('social-load-commentaries');
        });
    },
    // eslint-disable-next-line camelcase
    deleteComment(comment_id) {
      const form = new FormData();
      form.append('social_comment_id', comment_id);
      this.$request
        .post(this.$getUrlToMakeRequest('SocialNetwork', 'deleteComment'), form)
        .then((response) => {
          eventBus.$emit('social-update-post');
          eventBus.$emit('social-load-commentaries');
        });
    },
    editComment(id, description) {
      this.editDialog = true;
      this.editText = description;
      this.comment_id = id;
    },
    // eslint-disable-next-line camelcase
    async saveComment() {
      this.loading = true;
      const form = new FormData();
      form.append('id', this.comment_id);
      form.append('comment', this.editText);
      const { data } = await this.$request.post(
        this.$getUrlToMakeRequest('SocialNetwork', 'saveComment'),
        form
      );
      this.loading = false;
      this.editDialog = false;
      eventBus.$emit('social-load-commentaries');
      eventBus.$emit('social-update-post');
    }
  },
  beforeDestroy() {
    clearInterval(this.commentUpdateHandle);
  }
};
</script>
