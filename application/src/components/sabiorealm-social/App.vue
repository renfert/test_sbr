<template>
  <div ref="content" class="content-page" @touchmove="detectBottom($event)" @scroll="detectBottom($event)">
    <el-row :gutter="8">
      <el-col :md="6" :sm="24" :xs="24">
        <UserStatus/>
        <br>
      </el-col>
      <el-col :md="18" :sm="24" :xs="24">
        <el-card class="box-card" style="max-width: 800px">
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
          <el-row justify="between">
            <el-col :md="6" :xs="10" :sm="8">
              <el-button @click="publish()" type="primary" round>
                <i class="el-icon-loading"
                   style="color: white;" v-if="loading"></i>
                <i class="far fa-paper-plane" v-else></i> {{
                  lang['publish']
                }}
              </el-button>
            </el-col>
            <el-col :md="9" :xs="11" :sm="8">
              <el-button
                @click="uploadImage()"
                type="warning"
                round><i class="far fa-images" type="file"></i> {{ lang['attach-image'] }}
              </el-button>
              <input
                class="upload"
                ref="inputImage"
                @change.prevent="uploadToServer($event)"
                accept='image/*'
                type='file'
                hidden
              />
            </el-col>
            <el-col style="margin-top:9px" :md="8" :xs="12" :sm="5" class="link">
              &nbsp; <a @click="showSections()">{{ lang['publish-in'] }} <i class="fas fa-angle-right"
                                                                            style="font-size: 12px"></i> {{
                section_name
              }}</a>
            </el-col>
          </el-row>
          <br>
          <el-row v-if="newFileName.length>0" justify="center" align="start" :gutter="50">
            <center>
              <img :src="$getUrlToContents() + 'social/'+newFileName" style="border-radius: 7px" height="250vh">
            </center>
          </el-row>
        </el-card>
        <el-dialog
          :title="lang['select-an-element']"
          :visible.sync="dialogVisible"
          width="30%">
          <b>{{ lang['groups'] }}</b>
          <el-row :md="24" justify="center">
            <el-button @click="selectSection(group.id,group.name,'group')" round size="small"
                       v-for="(group,index) in groups"
                       :key="index">{{ group.name == 'default' ? lang['group-default'] : group.name }}
            </el-button>
          </el-row>
          <b>{{ lang['courses'] }}</b>
          <el-row :md="24" justify="center">
            <el-button @click="selectSection(course.id,course.title,'course')" round size="small"
                       v-for="(course,index) in courses"
                       :key="index">{{ course.title == 'default' ? lang['group-default'] : course.title }}
            </el-button>
          </el-row>
        </el-dialog>
        <br>
        <PostList :publications="publications"/>
      </el-col>
    </el-row>
    <Progress/>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import {mapState} from 'vuex';
import PostList from '@/components/sabiorealm-social/PostList';
import UserStatus from '@/components/sabiorealm-social/UserStatus';
import Progress from '@/components/helper/HelperProgress';
import UploadFile from '@/mixins/upload';

Vue.use(VueHead);

export const eventBus = new Vue();
export default {
  data: () => {
    return {
      publication: '',
      comment: [],
      publications: [],
      dialogVisible: false,
      groups: [],
      courses: [],
      section_id: 1,
      section_name: 'default',
      section_type: '',
      subDomainName: '',
      uploadFile: new UploadFile(),
      realFileName: '',
      newFileName: '',
      loading: false
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
  watch: {
    // detectBottom() {
    //   window.addEventListener('scroll', () => {
    //     if (document.height === window.pageYOffset + window.innerHeight) {
    //       // hit bottom
    //       console.log('estas abajoooo');
    //     } else {
    //       console.log('sigue bajando');
    //     }
    //   });
    // }
  },
  components: {UserStatus, PostList, Progress},
  created() {
    window.addEventListener('scroll', () => {
      if (window.pageYOffset + window.innerHeight >= this.$el.clientHeight) {
        console.log('Actualizar!');
      } else {
        console.log('sigue bajando');
      }
    });

    this.getSubDomainName();
    this.getPublications();
  },
  mounted() {
    eventBus.$on('social-update-post', () => {
      this.getPublications();
    });
    this.section_name = this.lang['group-default'];
  },
  methods: {
    async publish() {

      this.loading = true;
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      if (this.section_type === 'group') {
        form.append('group_id', this.section_id);
        form.append('course_id', 1);
      } else if (this.section_type === 'course') {
        form.append('group_id', 1);
        form.append('course_id', this.section_id);
      } else {
        form.append('group_id', 1);
        form.append('course_id', 1);
      }

      if (this.newFileName.length > 0) {
        form.append('media_path', this.newFileName);
        form.append('media_realname', this.realFileName);
        form.append('media_type', this.newFileName.split('.').pop());
      }
      form.append('description', this.urlify(this.publication));
      const data = await this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'savePublication'), form);
      if (data.status === 200 && this.publication.length > 0) {
        this.$messagePublished();
        // eslint-disable-next-line eqeqeq
      } else if (data.data == false) {
        this.$errorMessage();
      }
      eventBus.$emit('social-update-post');
      await setTimeout(() => {
        eventBus.$emit('social-load-commentaries');
      }, 500);
      this.publication = '';
      this.loading = false;
      this.newFileName = '';
      this.realFileName = '';
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

    showSections() {
      this.$request.get(this.$getUrlToMakeRequest('SocialNetwork', 'getAllGroups')).then((response) => {
        this.groups = response.data;
      });
      this.$request.get(this.$getUrlToMakeRequest('SocialNetwork', 'getAllCourses')).then((response) => {
        this.courses = response.data;
      });
      this.dialogVisible = true;
    },
    selectSection(id, name, type) {
      this.section_type = type;
      this.section_id = id;
      this.section_name = name === 'default' ? this.lang['group-default'] : name;
      this.dialogVisible = false;
    },
    getSubDomainName() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'getSubDomainName'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.subDomainName = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    uploadImage() {
      this.$refs.inputImage.click();
    },
    uploadToServer(event) {
      this.uploadFile.upload(event, this.subDomainName, 'social').then((response) => {
        this.newFileName = response.newFileName;
        this.realFileName = response.fileName;
      });
    },
    detectBottom(event) {
      console.log(event.touches[0]);
      if (window.pageYOffset + window.innerHeight >= this.$el.clientHeight) {
        console.log('Actualizar!');
      } else {
        console.log();
        console.log('sigue bajando');
      }
    },
    urlify(text) {
      const urlRegex = /(https?:\/\/[^\s]+)/g;
      return text.replace(urlRegex, (url) => {
        return '<a target="_blank" href="' + url + '">' + url + '</a>';
      });
      // or alternatively
      // return text.replace(urlRegex, '<a href="$1">$1</a>')
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
