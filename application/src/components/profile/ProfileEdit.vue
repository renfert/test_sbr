<template>
  <div class="card-box text-center">
    <!-- Profile edit -->
    <form id="form-profile" @submit.prevent="editProfile()">
      <!-- Person id -->
      <input type="number" v-model="userId" name="userId" class="hide" />
      <div class="form-group">
        <div class="image-upload" style="text-align: center">
          <label for="file-input">
            <el-avatar style="cursor: pointer" :size="100" fit="none">
              <img :src="$getUrlToContents() + 'avatar/' + avatar + ''" />
            </el-avatar>
          </label>
          <input class="hide" :value="avatar" name="avatar" type="text" />
          <input
            class="hide"
            id="file-input"
            type="file"
            @change.prevent="uploadAvatar($event)"
          />
        </div>
      </div>
      <div class="form-group">
        <label>{{ lang['name'] }}</label>
        <el-input name="name" v-model="name"></el-input>
      </div>

      <!-- Description -->
      <div class="form-group">
        <label>{{ lang['description'] }}</label>
        <el-input
          type="textarea"
          name="description"
          v-model="description"
        ></el-input>
      </div>

      <div class="form-group">
        <label>{{ lang['change-password'] }}</label>
        <br />
        <el-switch v-model="changePassword"></el-switch>
      </div>

      <div class="m-b-30" v-if="changePassword">
        <!-- Password -->
        <div class="form-group">
          <label>{{ lang['new-password'] }}</label>
          <el-input
            @focus="showConfirmPassword = true"
            type="password"
            name="password"
            v-model="password"
          ></el-input>
        </div>

        <!-- Confirm password -->
        <div v-if="showConfirmPassword" class="form-group">
          <label>{{ lang['confirm-password'] }}</label>
          <el-input type="password" v-model="confirmPassword"></el-input>
        </div>
      </div>

      <div class="form-group m-t-40">
        <el-button native-type="submit" class="sbr-primary">{{
          lang['save-button']
        }}</el-button>
      </div>
    </form>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import HelperProgress from '@/components/helper/HelperProgress.vue';
import AWS from 'aws-sdk/global';
import S3 from 'aws-sdk/clients/s3';

import { eventBus } from '@/components/profile/App';
import { eventProgress } from '@/components/helper/HelperProgress';
import { mapState } from 'vuex';

export default {
  components: {
    HelperProgress
  },
  props: ['testimonial-id'],
  data: () => {
    return {
      name: '',
      userId: '',
      avatar: '',
      description: '',
      password: '',
      confirmPassword: '',
      confirmPasswordShow: '',
      showConfirmPassword: false,
      changePassword: false,
      subDomainName: ''
    };
  },
  mounted() {
    this.getSubDomainName();
    this.getProfile();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    uploadAvatar(event) {
      this.upload(event);
      const input = event.target;
      if (input.files && input.files[0]) {
        this.render(input);
      }
    },
    render(input) {
      const reader = new FileReader();
      reader.onload = (e) => {
        const div = input.parentElement;
        const img = div.getElementsByTagName('img')[0];
        img.src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    },
    upload(event) {
      const file = event.target.files[0];
      const fileName = file.name;
      const fileExt = fileName.split('.').pop();
      const newFileName = this.generateFileName(40) + '.' + fileExt;
      eventProgress.$emit('new-progress');

      AWS.config.update({
        accessKeyId: 'AKIA5AQZS5JMAWUELDG7',
        secretAccessKey: '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',
        region: 'us-east-1'
      });

      const bucket = new S3({ params: { Bucket: 'sabiorealm' } });
      const params = {
        Key: '' + this.subDomainName + '/uploads/avatar/' + newFileName + '',
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
          this.avatar = newFileName;
          eventProgress.$emit('finish-progress');
        });
    },
    editProfile() {
      if (this.password !== this.confirmPassword) {
        this.$message({
          message: 'The passwords are different',
          type: 'warning'
        });
      } else {
        const form = document.getElementById('form-profile');
        const formData = new FormData(form);
        const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
          'user',
          'editProfile'
        );
        this.$request.post(urlToBeUsedInTheRequest, formData).then(
          () => {
            this.$successMessage();
            eventBus.$emit('profile-edited');
          },
          () => {
            this.$errorMessage();
          }
        );
      }
    },
    getProfile() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getUserProfile'
      );
      formData.set('testimonialId', this.testimonialId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.userId = response.data.id;
          this.avatar = response.data.avatar;
          this.name = response.data.name;
          this.description = response.data.description;
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
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
