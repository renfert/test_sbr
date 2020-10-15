<template>
  <el-dialog :visible.sync="modal">
    <div slot="title" class="center">
      <h3>
        <i class="el-icon-edit sbr-text-primary"></i> {{ lang['edit-post'] }}
      </h3>
    </div>
    <aside class="publication_content">
      <div>
        <div class="m-b-20">
          <el-row :gutter="60" style="display: flex; align-items: center">
            <el-col :md="2" :sm="4" :xs="4">
              <img
                :src="$getUrlToContents() + 'avatar/' + user.avatar + ''"
                class="avatar-md"
              />
            </el-col>
            <el-col :md="20" :sm="20" :xs="20">
              <router-link :to="'/user/' + user.id">
                <h3 style="margin: 0px !important">
                  {{ user.name }}
                </h3>
              </router-link>
            </el-col>
          </el-row>
        </div>

        <div class="publication_area m-b-30">
          <div style="width: 100%; text-align: right; padding-top: 3%">
            <img
              class="widget_publication m-r-10"
              style="width: 25px"
              src="@/assets/img/social/photo.png"
              @click="uploadImage()"
            />
            <img
              class="widget_publication m-r-10"
              style="width: 23px"
              src="@/assets/img/social/content.png"
              @click="uploadContent()"
            />
          </div>
          <fieldset class="m-t-20">
            <!-- Publication textarea -->
            <textarea
              ref="publication"
              :keyup="doResize()"
              :placeholder="lang['write-something']"
              v-model="publication"
              rows="1"
            ></textarea>
            <!-- Publication content button  -->
            <center v-if="newFileName != null && showContentToDownload == true">
              <el-button class="sbr-secondary m-t-20" type="primary">
                <i class="el-icon-download"></i>
                <span id="contentName">{{ realFileName }} </span>
                <img
                  style="width: 20%; margin-right: 0px"
                  @click.prevent="newFileName = null"
                  src="@/assets/img/social/close.png"
                />
              </el-button>
            </center>
            <!-- Publication image -->
            <el-row
              v-if="newFileName != null && showImg == true"
              justify="center"
              align="start"
              :gutter="50"
            >
              <center>
                <div class="img_wrp m-t-20">
                  <img
                    class="preview_img"
                    :src="$getUrlToContents() + 'social/' + newFileName"
                  />
                  <img
                    @click.prevent="newFileName = null"
                    class="close_icon"
                    src="@/assets/img/social/close.png"
                  />
                </div>
              </center>
            </el-row>
          </fieldset>
        </div>
        <el-button
          @click="editPublication()"
          type="primary"
          class="sbr-primary"
        >
          <i class="el-icon-loading" style="color: white" v-if="loading"></i>
          <i class="far fa-paper-plane" v-else></i> {{ lang['publish'] }}
        </el-button>
        <input
          class="upload"
          ref="inputImage"
          @change.prevent="uploadToServer($event)"
          accept="image/*"
          type="file"
          hidden
        />
        <input
          class="upload"
          ref="inputFile"
          @change.prevent="uploadToServer($event)"
          accept="*"
          type="file"
          hidden
        />
      </div>
    </aside>

    <Progress />
  </el-dialog>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';

import wysiwyg from 'vue-wysiwyg';
import Progress from '@/components/helper/HelperProgress';
import UploadFile from '@/mixins/upload';
import { mapState } from 'vuex';
import { eventBus } from '@/components/sabiorealm-social/App';

Vue.use(VueHead);
Vue.use(wysiwyg, {});
export default {
  components: { Progress },
  props: ['type', 'typeid'],
  data: () => {
    return {
      modal: false,
      uploadFile: new UploadFile(),
      publication: '',
      publicationId: '',
      newFileName: null,
      showContentToDownload: false,
      realFileName: '',
      showImg: '',
      loading: false
    };
  },
  created() {
    eventBus.$on('edit-post', (response) => {
      this.showImg = false;
      this.showContentToDownload = false;
      this.modal = true;

      this.publication = response.publication;
      this.newFileName = response.path;
      this.realFileName = response.realname;
      this.publicationId = response.id;

      if (response.mediaExtension != null) {
        const extension = response.mediaExtension.toLowerCase();

        if (
          extension === 'jpg' ||
          extension === 'png' ||
          extension === 'gif' ||
          extension === 'jpeg'
        ) {
          this.showImg = true;
        } else {
          this.showContentToDownload = true;
        }
      }
    });
  },
  computed: {
    ...mapState(['lang', 'user', 'company'])
  },
  methods: {
    editPublication() {
      const formData = new FormData();
      formData.set('publication', this.publication);
      formData.set('media_path', this.newFileName);
      formData.set('media_name', this.realFileName);
      formData.set('id', this.publicationId);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'SocialNetwork',
        'editPublication'
      );

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          if (response.data === true) {
            eventBus.$emit('edited-publication');
            this.modal = false;
            this.$successMessage();
          }
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    doResize() {
      const textbox = this.$refs.publication;
      if (textbox !== undefined) {
        const maxrows = 5;
        const txt = textbox.value;
        const cols = textbox.cols;

        const arraytxt = txt.split('\n');
        let rows = arraytxt.length;

        for (let i = 0; i < arraytxt.length; i++) {
          rows += parseInt(arraytxt[i].length / cols);
          if (rows > maxrows) {
            textbox.rows = maxrows;
          } else {
            textbox.rows = rows;
          }
        }
      }
    },
    uploadImage() {
      this.$refs.inputImage.click();
    },
    uploadContent() {
      this.$refs.inputFile.click();
    },
    uploadToServer(event) {
      this.uploadFile
        .upload(event, this.company.subdomain, 'social')
        .then((response) => {
          this.newFileName = response.newFileName;
          this.realFileName = response.fileName;
          const fileExtension = response.fileName
            .split('.')
            .pop()
            .toLowerCase();
          if (
            fileExtension === 'png' ||
            fileExtension === 'jpeg' ||
            fileExtension === 'gif' ||
            fileExtension === 'jpg'
          ) {
            this.showImg = true;
            this.showContentToDownload = false;
          } else {
            this.showContentToDownload = true;
            this.showImg = false;
          }
        });
    }
  }
};
</script>
<style scoped type="text/scss">
.box-card {
  border-radius: 30px;
  padding: 4%;
}

.publication_content {
  padding: 0% 10%;
}

.publish-location {
  display: flex;
  align-items: center;
  margin: 0px;
  margin-bottom: 5%;
  padding: 3%;
  border-radius: 20px;
  box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.publish-location:hover {
  background-color: #f8f8ff;
}

.publication_area {
  display: inline-block;
  padding: 0% 5% 0% 5%;
  border: 1px solid #e4e4e4 !important;
  width: 100% !important;
  border-radius: 14px !important;
  overflow-y: auto;
  overflow-x: hidden;
  height: 250px !important;
  border-radius: 14px !important;
  border: 2px solid #ccc;
  -webkit-transition: border-color 0.15s linear !important;
  transition: border-color 0.15s linear !important;
}

.publication_area textarea {
  border: none;
  resize: none;
  width: 100%;
  color: #647b9c;
  font-family: 'Poppins', sans-serif !important;
  font-size: 15px !important;
  height: auto;
  box-sizing: border-box;
  display: block;
}

.widget_publication:hover {
  transform: translateY(-1px);
  cursor: pointer;
}

.preview_img {
  border-style: none;
  margin-bottom: 10%;
  height: auto;
  width: 90%;
  object-fit: cover;
  border-radius: 20px;
}

.img_wrp {
  display: inline-block;
  position: relative;
}
.close_icon {
  position: absolute;
  top: 0;
  right: 0;
  cursor: pointer;
  opacity: 0.8;
  width: 10%;
  right: 5%;
}

.close_icon:hover {
  opacity: 1;
}
</style>
