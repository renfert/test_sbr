<template>
  <div>
    <el-card class="box-card" style="max-width: 800px">
      <div slot="header" class="clearfix">
        <el-row>
          <el-col :md="2" :sm="4" :xs="4">
            <el-avatar
              size="large"
              :src="$getUrlToContents() + 'avatar/' + user.avatar+''"
            />
          </el-col>
          <el-col :md="17" :sm="20" :xs="20" class="p-t-10">
            <router-link :to="'/user/'+user.id">
              <b><span class="link">{{ user.name }}</span></b> <i class="fas fa-check-circle"></i><br>
              <div style="font-size:12px">
                <div v-if="user.role===1">
                  {{ lang['admin-view-topbar'] }}
                </div>
                <div v-else-if="user.role===2">
                  {{ lang['instructor'] }}
                </div>
                <div v-else-if="user.role===3">
                  {{ lang['student'] }}
                </div>
              </div>
            </router-link>

          </el-col>
        </el-row>

      </div>

      <el-row>

        <el-col v-if="!to" style="margin-top:9px" :md="8" :xs="12" :sm="5" class="link">
          <el-button type="text">
            &nbsp; <a @click="showSections()">{{ lang['publish-in'] }} <i class="fas fa-angle-right"
                                                                          style="font-size: 12px"></i> {{
              section_name
            }}</a>
          </el-button>
        </el-col>

      </el-row>
      <br>
      <el-input
        type="textarea"
        :rows="2"
        :placeholder="lang['enter-text']"
        v-model="publication">
      </el-input>
      <br>
      <br>
      <el-button size="small"
                 @click="publish()"
                 type="primary" round>
        <i class="el-icon-loading"
           style="color: white;" v-if="loading"></i>
        <i class="far fa-paper-plane" v-else></i> {{
          lang['publish']
        }}
      </el-button>
      <el-button
        size="small"
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

    <Progress/>
  </div>

</template>

<script>
import {mapState} from 'vuex';
import {eventBus} from '@/components/sabiorealm-social/App';
import UploadFile from '@/mixins/upload';
import Progress from '@/components/helper/HelperProgress';

export default {
  components: {Progress},
  props: ['to', 'myid'],
  created() {
    switch (this.to) {
      case 'group': {
        this.selectSection(this.myid, '', this.to);
        break;
      }
      case 'course': {
        this.selectSection(this.myid, '', this.to);
        break;
      }
    }
    this.section_name = this.lang['group-default'];
    this.getSubDomainName();
  },
  data: () => {
    return {
      publication: '',
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
  computed: {
    ...mapState(['lang', 'user'])
  },
  methods: {
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
    urlify(text) {
      const urlRegex = /(https?:\/\/[^\s]+)/g;
      return text.replace(urlRegex, (url) => {
        return '<a target="_blank" href="' + url + '">' + url + '</a>';
      });
      // or alternatively
      // return text.replace(urlRegex, '<a href="$1">$1</a>')
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

  }

};

</script>

<style scoped>

</style>