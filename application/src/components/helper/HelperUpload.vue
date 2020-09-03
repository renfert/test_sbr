<template>
  <div>
    <div :style="style" class="drop-area">
      <input :value="name" :name="returnName" type="text" />
      <input
        :name="inputName"
        class="upload"
        @change.prevent="preview($event, doUpload)"
        :accept="acceptable"
        type="file"
      />
      <div class="drop-message" :class="messageClass">
        <span class="file-icon" :class="icon"></span>
        <p>{{ message }}</p>
      </div>
      <div class="drop-preview on" style="text-align: center">
        <div class="drop-img">
          <img class="preview" :src="previewImg" alt />
        </div>
      </div>
    </div>
    <input class="hide" type="text" name="real_name" :value="realName" />
  </div>
</template>

<script>
import Vue from 'vue';
import toastr from 'toastr';
import AWS from 'aws-sdk/global';
import S3 from 'aws-sdk/clients/s3';

import { eventProgress } from '@/components/helper/HelperProgress';
import { eventPlan } from '@/components/plans/UpgradePlan.vue';
import { mapState } from 'vuex';

Vue.use(toastr);

export const eventUpload = new Vue();

export default {
  data: () => {
    return {
      icon: 'fas fa-cloud-upload-alt',
      message: 'Upload a file',
      src: '',
      messageClass: '',
      realName: '',
      name: '',
      previewImg: '',
      subDomainName: '',
      storageAvailability: true
    };
  },
  props: [
    'acceptable',
    'input-name',
    'do-upload',
    'return-name',
    'bucket-key',
    'box-height',
    'src-name',
    'src-img',
    'src-real-name'
  ],
  created() {
    this.checkStorageAvailability();
    this.getSubDomainName();
  },
  mounted() {
    if (
      this.srcName !== undefined &&
      this.srcName !== null &&
      this.srcName !== ''
    ) {
      this.loadDefaultName();
      this.message = this.srcRealName;
      this.realName = this.srcRealName;
    }

    if (
      this.srcImg !== undefined &&
      this.srcImg != null &&
      this.srcImg !== ''
    ) {
      this.loadDefaultImg();
    }
  },
  methods: {
    preview(event, upload) {
      if (this.storageAvailability) {
        const ins = this;
        if (upload !== undefined) {
          ins.upload(event);
        }
        const input = event.target;
        const fullName = input.value;
        const fileName = fullName.split(/(\\|\/)/g).pop();
        const fileExtension = fullName.split('.').pop();

        this.realName = fileName;

        if (input.files && input.files[0]) {
          const acceptable = ins.acceptable;
          if (acceptable.indexOf(fileExtension) === -1 && acceptable !== '.*') {
            ins.message = 'Invalid extension: ' + fileExtension + '';
            ins.icon = 'fas fa-exclamation-triangle sbr-text-danger';
            input.value = '';
          } else {
            /*  Chance image or icon preview */
            switch (fileExtension) {
              case 'png':
                ins.messageClass = 'hide';
                ins.render(input);
                break;
              case 'jpg':
                ins.render(input);
                ins.messageClass = 'hide';
                break;
              case 'jpeg':
                ins.render(input);
                ins.messageClass = 'hide';
                break;
              case 'xlsx':
                ins.icon = 'fas fa-file-pdf text-default';
                ins.message = fileName;
                break;
              case 'pdf':
                ins.icon = 'fas fa-file-excel text-default';
                ins.message = fileName;
                break;
              case 'docx':
                ins.icon = 'fas fa-file-word text-default';
                ins.message = fileName;
                break;
              case 'mp4':
                ins.icon = 'fas fa-file-video text-default';
                ins.message = fileName;
                break;
              case 'mov':
                ins.icon = 'fas fa-file-video text-default';
                ins.message = fileName;
                break;
              case 'mp3':
                ins.icon = 'fas fa-file-audio text-default';
                ins.message = fileName;
                break;
              case 'pptx':
                ins.icon = 'fas fa-file-powerpoint text-default';
                ins.message = fileName;
                break;
              case 'zip':
                ins.icon = 'fas fa-file-archive text-default';
                ins.message = fileName;
                break;
              default:
                ins.icon = 'fas fa-file text-default';
                ins.message = fileName;
            }
          }
        }
      } else {
        eventPlan.$emit('upgrade-plan', 'storage');
        this.icon = 'fas fa-lock sbr-text-danger';
        this.message = 'Full storage';
        this.previewImg = '';
        this.realName = '';
        this.src = '';
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
    checkStorageAvailability() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'checkStorageAvailability'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.storageAvailability = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
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
        Key:
          '' +
          this.subDomainName +
          '/' +
          this.bucketKey +
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
    createFolder() {
      /* Create new folder into bucket */
      AWS.config.update({
        accessKeyId: 'AKIA5AQZS5JMAWUELDG7',
        secretAccessKey: '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',
        region: 'us-east-1'
      });

      const folderName = this.generateFileName(30);
      const keyName = this.subDomainName + '/uploads/html/' + folderName + '/';

      const bucket = new S3({
        params: {
          Bucket: 'sabiorealm'
        }
      });

      const contentToPost = {
        Key: keyName
      };

      bucket.putObject(contentToPost, (error) => {
        if (error) {
          return false;
        } else {
          return folderName;
        }
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
    },
    loadDefaultName() {
      this.name = this.srcName;
    },
    loadDefaultImg() {
      if (this.srcName != null) {
        const array = this.srcName.split('.', 2);
        const extension = array[1];

        if (
          extension === 'png' ||
          extension === 'jpg' ||
          extension === 'jpeg'
        ) {
          this.previewImg = this.srcImg;
          this.messageClass = 'hide';
          this.icon = '';
        } else {
          this.loadIcon(extension);
        }
      }
    },
    loadIcon(extension) {
      switch (extension) {
        case 'mp4':
          this.icon = 'fas fa-file-video sbr-text-primary';
          break;
        case 'pdf':
          this.icon = 'fas fa-file-pdf sbr-text-primary';
          break;
        case 'zip':
          this.icon = 'fas fa-file-archive sbr-text-primary';
          break;
        case 'mp3':
          this.icon = 'fas fa-file-audio sbr-text-primary';
          break;
        default:
          this.icon = 'fas fa-cloud-upload-alt sbr-text-primary';
          break;
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
    }
  },
  computed: {
    ...mapState(['lang']),
    style() {
      return 'height: ' + this.boxHeight + 'px';
    }
  }
};
</script>

<style lang="scss" scoped>
.hide {
  display: none !important;
}

.drop-area {
  display: block;
  position: relative;
  cursor: pointer;
  overflow: hidden;
  width: 100%;
  max-width: 100%;
  padding: 5px 10px;
  font-size: 14px;
  line-height: 22px;
  color: #585858;
  background-color: #fff;
  background-image: none;
  text-align: center;
  border: 2px solid #ccc;
  -webkit-transition: border-color 0.15s linear;
  transition: border-color 0.15s linear;
  border-radius: 4px;
  border: 2px solid #ccc;
}

.drop-area:hover {
  background-size: 30px 30px;
  background-image: linear-gradient(
    -45deg,
    #f6f6f6 25%,
    transparent 0,
    transparent 50%,
    #f6f6f6 0,
    #f6f6f6 75%,
    transparent 0,
    transparent
  );
  -webkit-animation: stripes 2s linear infinite;
  animation: stripes 2s linear infinite;
}

.drop-preview {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
}

.drop-img {
  width: 100%;
  height: 210px;
  display: inline-block;
  overflow: hidden;
  padding: 2px;
  position: relative;
}

.drop-preview img {
  max-width: 100%;
  width: 50%;
  vertical-align: middle;
  border-style: none;
}

.drop-message {
  position: relative;
  top: 50%;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
}

.file-icon {
  font-size: 40px;
  padding-bottom: 10px;
  color: #ccc;
}

.drop-area input {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  cursor: pointer;
  z-index: 5;
}
</style>
