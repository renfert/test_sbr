<template>
  <div>
    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>
    <div v-else>
      <div v-if="publications != null">
        <div
          class="box-card publication-card m-b-40"
          v-for="(publication, index) in visiblePublications"
          :key="index"
          @load="hide($event)"
        >
          <!-- Publication header -->
          <div>
            <el-row
              :gutter="60"
              class="m-b-40"
              style="display: flex; align-items: center"
            >
              <el-col :md="2" :sm="4" :xs="4">
                <img
                  :src="
                    $getUrlToContents() + 'avatar/' + publication.avatar + ''
                  "
                  class="avatar-md"
                />
              </el-col>
              <el-col :md="18" :sm="14" :xs="14">
                <a class="link" href="javascript:void(0)">
                  <span>{{ publication.username }} </span>
                  <i class="fas fa-caret-right" style="font-size: 15px"></i>
                </a>
                <b>
                  <a v-if="parseInt(publication.mygroup_id) > 1">
                    {{ publication.group_name }}
                  </a>
                  <a v-else-if="parseInt(publication.mycourse_id) > 1">
                    {{ publication.course_name }}
                  </a>
                  <a v-else>
                    {{ lang['group-default'] }}
                  </a>
                </b>
                <h5 class="no-margin">
                  {{ processDateTime(publication.created) }}
                </h5>
              </el-col>
              <el-col
                v-if="user.id === publication.myuser_id"
                :md="2"
                :sm="3"
                :xs="3"
              >
                <div style="display: flex; align-items: center">
                  <!-- Edit button -->
                  <div>
                    <div
                      @click="
                        editPost(
                          publication.id,
                          publication.description,
                          publication.media_path,
                          publication.media_realname,
                          publication.media_type
                        )
                      "
                      class="icon-border"
                    >
                      <i
                        class="el-icon-edit-outline table-icon table-icon-primary m-t-10"
                      ></i>
                    </div>
                  </div>
                  <!-- Delete button -->
                  <div>
                    <el-popconfirm
                      confirmButtonText="Ok"
                      cancelButtonText="No, Thanks"
                      placement="right"
                      :title="lang['delete'] + ' ?'"
                      @onConfirm="deletePost(publication.id)"
                    >
                      <div slot="reference" class="icon-border">
                        <i
                          class="el-icon-delete table-icon table-icon-danger m-t-10"
                        ></i>
                      </div>
                    </el-popconfirm>
                  </div>
                </div>
              </el-col>
              <el-col
                v-if="user.role === 1 || user.id === publication.myuser_id"
                :md="1"
                :sm="2"
                :xs="2"
              >
              </el-col>
            </el-row>
          </div>
          <!-- End publication header -->

          <el-row>
            <div
              v-html="publication.description"
              style="
                font-size: 1.2em;
                word-break: break-word;
                text-overflow: ellipsis;
                -webkit-line-break: after-white-space;
                -webkit-box-orient: vertical;
              "
            ></div>
          </el-row>
          <br />
          <el-row v-if="publication.media_path">
            <!-- Publication image -->
            <center v-if="verifyMediaType(publication.media_type) == 'image'">
              <img
                class="preview_img"
                :src="$getUrlToContents() + 'social/' + publication.media_path"
              />
            </center>
            <!-- Publication content button  -->
            <el-button v-else class="sbr-secondary" type="primary">
              <a
                class="sbr-text-white"
                :download="publication.media_realname"
                :href="$getUrlToContents() + 'social/' + publication.media_path"
              >
                <i class="el-icon-download"></i>
                <span id="contentName"> {{ publication.media_realname }} </span>
              </a>
            </el-button>
          </el-row>
          <br />
          <el-row>
            <el-button
              :class="publication.i_like_it ? 'm-r-10 sbr-primary' : 'm-r-10'"
              :type="publication.i_like_it ? 'primary' : ''"
              @click="doPublicationLike(publication.id, $event)"
              circle
              ><i
                class="fas fa-thumbs-up"
                :style="publication.i_like_it ? 'color:white' : 'color:#4a5568'"
              ></i>
            </el-button>
            {{ publication.likes > 0 ? publication.likes + ' likes' : '' }}
          </el-row>
          <hr />
          <el-row class="m-b-30">
            <el-col :md="24">
              <el-input
                @keyup.enter.native="saveComment(publication.id, index)"
                :placeholder="lang['publication-comment']"
                v-model="comment[index]"
              >
                <span slot="suffix" v-if="comment[index]">
                  <i
                    @click="saveComment(publication.id, index)"
                    class="fas fa-paper-plane over"
                    style="margin-top: 10px; font-size: large"
                    :title="lang['publish']"
                  ></i>
                </span>
                <span slot="suffix" v-if="loading">
                  <i
                    class="el-icon-loading center"
                    style="
                      font-size: 25px;
                      margin-top: 10px;
                      font-size: large;
                      color: #009cd8;
                    "
                  ></i>
                </span>
              </el-input>
            </el-col>
          </el-row>
          <SubCommentary :publication_id="publication.id" />
        </div>

        <!-- Load more -->
        <div class="center">
          <a
            class="sbr-text-primary"
            v-if="loadingMorePublications == false"
            href="javascript:void(0)"
            @click.prevent="loadMore()"
            >Load more</a
          >
        </div>

        <!-- Loader -->
        <img
          v-if="loadingMorePublications"
          class="loader"
          src="https://sbrfiles.s3.amazonaws.com/gifs/loader.gif"
        />
      </div>
      <div class="center" style="margin-top: 15%; padding: 0px 10%" v-else>
        <img
          class="not-found-image"
          src="@/assets/img/social/no_publications.svg"
          alt=""
        />
        <h4 class="sbr-text-grey m-t-30 fw-700">
          Nao ha publicacoes disponiveis
        </h4>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

import wysiwyg from 'vue-wysiwyg';
import SubCommentary from '@/components/sabiorealm-social/feed/SubCommentary';
import { FacebookLoader } from 'vue-content-loader';
import { mapState } from 'vuex';
import { eventBus } from '@/components/sabiorealm-social/App';
Vue.use(wysiwyg, {});

export default {
  props: ['public-network'],
  data: () => {
    return {
      comment: [],
      update: [],
      loading: false,
      loadingMorePublications: false,
      loadingContent: false,
      editDialog: false,
      editText: '',
      publication_id: null,
      visiblePublications: null,
      publications: [],
      position: {
        start: 0,
        end: 4
      },
      pageSize: 4,
      showButtons: false,
      currentDate: '',
      channel: {
        type: '',
        id: ''
      }
    };
  },
  components: { SubCommentary, FacebookLoader },
  created() {
    if (this.publicNetwork !== false) {
      this.channel.type = 'public';
    }
  },
  mounted() {
    this.getCurrentDate();
    this.getPublications();

    eventBus.$on('edited-publication', () => {
      this.getPublications();
    });

    // New publication
    eventBus.$on('new-publication', () => {
      this.getPublications();
    });

    // Connect to public channel
    eventBus.$on('connect-to-public-channel', () => {
      this.channel.type = 'public';
      this.getPublications();
    });

    // Connect to group channel
    eventBus.$on('connect-to-group-channel', (response) => {
      this.channel.type = response.type;
      this.channel.id = response.id;
      this.getPublications();
    });

    // Connect to course channel
    eventBus.$on('connect-to-course-channel', (response) => {
      this.channel.type = response.type;
      this.channel.id = response.id;
      this.getPublications();
    });
  },
  computed: {
    ...mapState(['lang', 'user'])
  },

  methods: {
    loadMore() {
      this.loadingMorePublications = true;

      const newAr = this.publications.slice(
        this.position.start,
        this.position.end
      );

      setTimeout(() => {
        newAr.forEach((element) => {
          this.visiblePublications.push(element);
        });
        this.loadingMorePublications = false;
      }, 1000);

      this.position.start = this.position.start + this.pageSize;
      this.position.end = this.position.end + this.pageSize;
    },
    processDateTime(date) {
      const dt1 = new Date(this.currentDate);
      const dt2 = new Date(date);
      const diffTime = Math.abs(dt2 - dt1);
      const diffinMinutes = diffTime / (1000 * 60);
      const diffInHours = diffTime / (1000 * 60 * 60);

      const day = dt2.getDate();
      const month = dt2.getMonth() + 1;
      const year = dt2.getFullYear();

      if (diffinMinutes > 60) {
        if (diffInHours < 24) {
          return (
            this.lang['activity-about-time-hour'] +
            Math.round(diffInHours) +
            this.lang['activity-time-hour-ago']
          );
        } else {
          return day + '/' + month + '/' + year;
        }
      } else {
        return this.lang['activity-few-minutes-ago'];
      }
    },
    getCurrentDate() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'getCurrentDate'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.currentDate = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    verifyMediaType(extension) {
      if (
        extension === 'png' ||
        extension === 'jpeg' ||
        extension === 'jpg' ||
        extension === 'gif'
      ) {
        return 'image';
      } else {
        return 'file';
      }
    },
    getPublications() {
      this.position.start = 0;
      this.position.end = 4;
      console.log(this.position.start);
      this.loadingContent = true;
      const formData = new FormData();
      formData.set('myuser_id', this.user.id);
      formData.set('channel_name', this.channel.type);
      formData.set('channel_id', this.channel.id);

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'SocialNetwork',
        'getPublications'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then((response) => {
        this.publications = response.data;

        const data = response.data;

        setTimeout(() => {
          if (response.data != null) {
            if (response.data.length > 5) {
              this.visiblePublications = data.slice(
                this.position.start,
                this.position.end
              );
            } else {
              this.visiblePublications = data;
            }
          }

          this.position.start = this.position.start + this.pageSize;
          this.position.end = this.position.end + this.pageSize;
          this.loadingContent = false;
        }, 1000);
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
      await this.$request.post(
        this.$getUrlToMakeRequest('SocialNetwork', 'saveComment'),
        form
      );
      this.loading = false;
      eventBus.$emit('social-update-post');
      eventBus.$emit('social-load-commentaries');
    },

    // eslint-disable-next-line camelcase
    doPublicationLike(publication_id) {
      const form = new FormData();
      form.append('social_publication_id', publication_id);
      form.append('myuser_id', this.user.id);
      this.$request
        .post(
          this.$getUrlToMakeRequest('SocialNetwork', 'doPublicationLike'),
          form
        )
        .then((response) => {
          eventBus.$emit('social-update-post');
        });
    },
    // eslint-disable-next-line camelcase
    deletePost(publication_id) {
      const form = new FormData();
      form.append('social_publication_id', publication_id);
      this.$request
        .post(this.$getUrlToMakeRequest('SocialNetwork', 'deletePost'), form)
        .then((response) => {
          this.getPublications();
          eventBus.$emit('social-update-post');
          setTimeout(() => {
            eventBus.$emit('social-load-commentaries');
          }, 500);
        });
    },
    editPost(id, publication, path, realname, mediaExtension) {
      const obj = {
        id: id,
        publication: publication,
        path: path,
        realname: realname,
        mediaExtension: mediaExtension
      };
      eventBus.$emit('edit-post', obj);
    },
    async publish() {
      this.loading = true;
      const form = new FormData();
      form.append('id', this.publication_id);
      form.append('description', this.editText);
      const data = await this.$request.post(
        this.$getUrlToMakeRequest('SocialNetwork', 'savePublication'),
        form
      );
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

.loader {
  width: 30px;
  margin-left: 50%;
}

.link {
  font-family: 'Poppins', sans-serif !important;
  word-break: break-word !important;
  color: #647b9c !important;
  line-height: 24px;
  font-size: 18px !important;
}

.over:hover {
  transition: 1.2s;
  color: #009cd8;
  cursor: pointer;
}

.icon-border {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  text-align: center;
}

.buttons_hide {
  display: none;
}

.publication-card {
  background-color: rgb(251, 251, 255);
  padding: 30px;
  border-radius: 20px;
}

.preview_img {
  border-style: none;
  height: auto;
  width: 100%;
  object-fit: cover;
  border-radius: 20px;
}

.el-input__suffix {
  right: 5px;
  -webkit-transition: all 0.3s;
  transition: all 0.3s;
  padding-right: 10px;
}
</style>
