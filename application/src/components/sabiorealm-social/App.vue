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
          <el-row justify="between">
            <el-col :md="6" :xs="10" :sm="8">
              <el-button @click="publish()" type="primary" round><i class="far fa-paper-plane"></i> {{
                  lang['publish']
                }}
              </el-button>
            </el-col>
            <el-col :md="9" :xs="11" :sm="8">
              <el-button type="warning" round><i class="far fa-images"></i> Adjuntar imagen</el-button>
              <input
                class="upload"
                @change.prevent="uploadFile($event)"
                type="file"
                accept="image/*"
              />
            </el-col>
            <el-col style="margin-top:9px" :md="8" :xs="12" :sm="5" class="link">
              &nbsp; <a @click="showGroups()">{{ lang['publish-in'] }} <i class="fas fa-angle-right"
                                                                          style="font-size: 12px"></i> {{
                mygroup_name
              }}</a>
            </el-col>
          </el-row>
        </el-card>
        <el-dialog
          title="Select group"
          :visible.sync="dialogVisible"
          width="30%">
          <el-row :md="24" justify="center" :gutter="24">
            <el-button @click="selectGroup(group.id,group.name)" type="warning" round size="small"
                       v-for="(group,index) in groups"
                       :key="index">{{ group.name == 'default' ? lang['group-default'] : group.name }}
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
import { mapState } from 'vuex';
import PostList from '@/components/sabiorealm-social/PostList';
import UserStatus from '@/components/sabiorealm-social/UserStatus';
import { eventProgress } from '@/components/helper/HelperProgress';
import Progress from '@/components/helper/HelperProgress';
import AWS from 'aws-sdk/global';
import S3 from 'aws-sdk/clients/s3';
import { eventUpload } from '@/components/helper/HelperUpload';

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
      mygroup_id: 1,
      mygroup_name: 'default',
      subDomainName: ''
    };
  },
  head: {
    title: {
      inner: 'Courses'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  components: { UserStatus, PostList, Progress},
  created() {
    this.getPublications();
  },
  mounted() {
    eventBus.$on('social-update-post', () => {
      this.getPublications();
    });
    this.mygroup_name = this.lang['group-default'];
  },
  methods: {
    async publish() {
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      form.append('group_id', this.mygroup_id);
      form.append('description', this.publication);
      const data = await this.$request.post(this.$getUrlToMakeRequest('SocialNetwork', 'savePublication'), form);
      if (data.status === 200 && this.publication.length > 0) {
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

    showGroups() {
      this.$request.get(this.$getUrlToMakeRequest('SocialNetwork', 'getAllGroups')).then((response) => {
        this.groups = response.data;
      });
      this.dialogVisible = true;
    },
    selectGroup(group_id, group_name) {
      this.mygroup_id = group_id;
      this.mygroup_name = group_name == 'default' ? this.lang['group-default'] : group_name;
      this.dialogVisible = false;
    },
    formatExtension(ext) {
      if (
        ext === 'mp4' ||
        ext === 'avi' ||
        ext === 'mov' ||
        ext === 'flv' ||
        ext === 'wmv' ||
        ext === 'MP4' ||
        ext === 'AVI' ||
        ext === 'MOV' ||
        ext === 'FLV' ||
        ext === 'WMV'
      ) {
        return 'mp4';
      } else {
        return ext;
      }
    },
    generateFileName(length) {
      const today = new Date();
      const time = today.getHours() + today.getMinutes() + today.getSeconds();

      let result = '';
      const characters =
        'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      const charactersLength = characters.length;
      for (let i = 0; i < length; i++) {
        result += characters.charAt(
          Math.floor(Math.random() * charactersLength)
        );
      }
      return result + time;
    },
    uploadFile(event) {
      const file = event.target.files[0];
      const fileName = file.name;
      const fileExt = this.formatExtension(fileName.split('.').pop());

      const newFileName = this.generateFileName(40) + '.' + fileExt;
      eventProgress.$emit('new-progress');

      AWS.config.update({
        accessKeyId: 'AKIA5AQZS5JMAWUELDG7',
        secretAccessKey: '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',
        region: 'us-east-1'
      });

      console.log(newFileName);
      const bucket = new S3({ params: { Bucket: 'sabiorealm' } });
      const params = {
        Key:
          '' +
          this.subDomainName +
          '/' +
          'uploads/flags' +
          '/' +
          newFileName +
          '',
        ContentType: file.type,
        Body: file
      };

      bucket
        .upload(params)
        .on('httpUploadProgress', (evt) => {
          const percentCompleted = Math.round(
            parseInt((evt.loaded * 100) / evt.total)
          );
          eventProgress.$emit('new-percent', percentCompleted);
        })
        .send(() => {
          event.target.value = null;
          const el = event.target.parentElement.children[0];
          el.value = newFileName;
          eventProgress.$emit('finish-progress');
          eventUpload.$emit('finish-upload');
        });
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
