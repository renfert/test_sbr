<template>
  <div>
    <div :style="style" class="drop-area">
      <input v-if="returnName" :value="name" :name="returnName" type="text"/>
      <input
        :name="inputName"
        class="upload"
        @change.prevent="preview($event)"
        :accept="acceptable"
        type="file"
      />
      <div class="drop-message" :class="messageClass">
        <img v-if="icon != ''" style="width: 40px" :src="icon"/>
        <p>{{ message }}</p>
      </div>
      <div class="drop-preview on" style="text-align: center">
        <div :style="style" class="drop-img">
          <img class="preview" :src="previewImg" alt/>
        </div>
      </div>
    </div>
    <input class="hide" type="text" name="real_name" :value="realName"/>
  </div>
</template>

<script>
import Vue from 'vue';
import toastr from 'toastr';
import AWS from 'aws-sdk/global';
import S3 from 'aws-sdk/clients/s3';

import {eventProgress} from '@/components/helper/HelperProgress';
import {eventPlan} from '@/components/plans/UpgradePlan.vue';
import {mapState} from 'vuex';

Vue.use(toastr);

export const eventUpload = new Vue();

export default {
  data: () => {
    return {
      icon: require('@/assets/img/icons/upload.png'),
      message: '',
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
    'src-real-name',
    'random-folder'
  ],
  async created() {
    this.message = this.lang['upload-a-file'];
    this.checkStorageAvailability();
    await this.getSubDomainName();
  },
  mounted() {
    if (
      this.srcName !== undefined &&
      this.srcName !== null &&
      this.srcName !== ''
    ) {
      this.name = this.srcName;
      this.message = this.srcRealName;
      this.realName = this.srcRealName;
    }

    if (
      this.srcImg !== undefined &&
      this.srcImg != null &&
      this.srcImg !== ''
    ) {
      this.loadPreview();
    }
  },
  methods: {
    preview(event) {
      /* --------------------------
        File information
      -------------------------- */
      const input = event.target;
      const fullName = input.value;
      const fileName = fullName.split(/(\\|\/)/g).pop();
      const fileExtension = fullName.split('.').pop();

      /* --------------------------
        Check storage availability
      -------------------------- */
      if (this.storageAvailability) {
        const ins = this;

        /* --------------------------
        Check if file upload is enabled
        -------------------------- */
        if (this.doUpload !== undefined) {
          /* --------------------------
          Check if extension is valid
          -------------------------- */
          if (input.files && input.files[0]) {
            const acceptable = ins.acceptable;
            if (
              acceptable.indexOf(fileExtension) === -1 &&
              acceptable !== '.*'
            ) {
              ins.message = 'Invalid extension: ' + fileExtension + '';
              ins.icon = require('@/assets/img/icons/invalid.png');
              input.value = '';
            } else {
              this.upload(event);
              this.message = fileName;
              this.realName = fileName;

              if (
                fileExtension === 'png' ||
                fileExtension === 'jpg' ||
                fileExtension === 'jpeg'
              ) {
                this.renderImage(input);
              } else {
                this.loadIcon();
              }
            }
          }
        } else {
          this.message = fileName;
          this.realName = fileName;
        }
      } else {
        eventPlan.$emit('upgrade-plan', 'storage');
        this.icon = require('@/assets/img/icons/invalid.png');
        this.message = 'Full storage';
        this.previewImg = '';
        this.realName = '';
        this.src = '';
      }
    },
    loadPreview() {
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
          this.loadIcon();
        }
      }
    },
    renderImage(input) {
      this.message = '';
      this.icon = '';
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
    async upload(event) {
      if (this.randomFolder) {
        // eslint-disable-next-line no-var
        var newFolder = await this.createFolder();
        this.bucketKey = this.bucketKey + '/' + newFolder;
      }
      const file = event.target.files[0];
      const fileName = file.name;
      const fileExt = this.formatExtension(fileName.split('.').pop());

      const newFileName = this.generateFileName(30) + '.' + fileExt;
      eventProgress.$emit('new-progress');

      AWS.config.update({
        accessKeyId: 'AKIA5AQZS5JMAWUELDG7',
        secretAccessKey: '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',
        region: 'us-east-1'
      });

      const fileRoute = this.subDomainName + '/' + this.bucketKey + '/';
      const valueKey = fileRoute + newFileName;
      const bucket = new S3({params: {Bucket: 'sabiorealm'}});
      const params = {
        Key: valueKey,
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
          if (this.randomFolder) {
            el.value = newFolder;
          } else {
            el.value = newFileName;
          }
          eventProgress.$emit('finish-progress');
          eventUpload.$emit('finish-upload');
        });
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
    createFolder(folderName = '') {
      /* Create new folder into bucket */
      return new Promise((resolve, reject) => {
        AWS.config.update({
          accessKeyId: 'AKIA5AQZS5JMAWUELDG7',
          secretAccessKey: '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',
          region: 'us-east-1'
        });
        if (folderName.length === 0) {
          folderName = this.generateFileName(20);
        }
        const keyName = this.subDomainName + '/uploads/html/' + folderName + '/';

        const bucket = new S3({
          params: {
            Bucket: 'sabiorealm'
          }
        });

        const contentToPost = {
          Key: keyName
        };

        bucket.putObject(contentToPost, (error, data) => {
          if (error) {
            // eslint-disable-next-line prefer-promise-reject-errors
            reject(false);
          } else {
            resolve(folderName);
          }
        });

      });
    },
    getSubDomainName() {
      return new Promise((resolve) => {
        const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
          'verify',
          'getSubDomainName'
        );
        this.$request.get(urlToBeUsedInTheRequest).then(
          (response) => {
            resolve(this.subDomainName = response.data);
          },
          () => {
            this.$errorMessage();
          }
        );
      });
    },
    loadIcon() {
      this.icon = require('@/assets/img/icons/success.png');
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
  border-radius: 30px;
  border: 2px dashed #ccc;
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
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  padding: 2px;
  position: relative;
}

.drop-preview img {
  max-width: 100%;
  width: 40%;
  border-style: none;
  border-radius: 10px;
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
