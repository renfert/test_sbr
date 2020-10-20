<template>
  <div>
    <aside>
      <div class="card-box new_publication_container">
        <div>
          <h3 class="center">
            <i class="el-icon-edit sbr-text-primary"></i>
            {{ lang['create-new-publication'] }}
          </h3>
          <hr />
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

              <el-button
                style="padding: 0px; font-size: 0.8rem"
                class="sbr-text-primary channel_name"
                type="text"
              >
                &nbsp;
                <a @click="showSections()"
                  >{{ lang['publish-in'] }}
                  <i class="fas fa-angle-right" style="font-size: 12px"></i>
                  {{ section_name }}</a
                >
              </el-button>
            </el-col>
          </el-row>
        </div>

        <br />
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
            <center
              v-if="newFileName.length > 0 && showContentToDownload == true"
            >
              <el-button class="sbr-secondary m-t-20" type="primary">
                <i class="el-icon-download"></i>
                <span id="contentName">{{ lang['file'] }} </span>
                <img
                  style="width: 30px; margin-right: 0px"
                  @click.prevent="newFileName = ''"
                  src="@/assets/img/social/close.png"
                />
              </el-button>
            </center>
            <!-- Publication image -->
            <el-row
              v-if="newFileName.length > 0 && showImg == true"
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
                    @click.prevent="newFileName = ''"
                    class="close_icon"
                    src="@/assets/img/social/close.png"
                  />
                </div>
              </center>
            </el-row>
          </fieldset>
        </div>
        <el-button @click="publish()" type="primary" class="sbr-primary">
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
  </div>
</template>

<script>
import { mapState } from 'vuex';
import { eventBus } from '@/components/sabiorealm-social/App';
import UploadFile from '@/mixins/upload';
import Progress from '@/components/helper/HelperProgress';

export default {
  props: ['public-network'],
  components: { Progress },
  created() {
    // Connect to public channel
    eventBus.$on('connect-to-public-channel', () => {
      this.channel.type = 'public';
      this.section_name = this.lang.public;
    });

    // Connect to group channel
    eventBus.$on('connect-to-group-channel', (response) => {
      this.channel.type = response.type;
      this.channel.id = response.id;
      this.section_name = response.name;
    });

    // Connect to course channel
    eventBus.$on('connect-to-course-channel', (response) => {
      this.channel.type = response.type;
      this.channel.id = response.id;
      this.section_name = response.name;
    });

    this.section_name = this.lang.public;
    this.getSubDomainName();
  },
  data: () => {
    return {
      publication: '',
      publications: [],
      dialogVisible: false,
      groups: [],
      courses: [],
      select: '',
      section_type: '',
      section_name: '',
      subDomainName: '',
      uploadFile: new UploadFile(),
      realFileName: '',
      newFileName: '',
      showImg: false,
      showContentToDownload: false,
      loading: false,
      channel: {
        id: 1,
        type: 'public'
      }
    };
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  methods: {
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
    showSections() {
      this.$request
        .get(this.$getUrlToMakeRequest('group', 'listing'))
        .then((response) => {
          this.groups = response.data;
        });
      this.$request
        .get(this.$getUrlToMakeRequest('SocialNetwork', 'getAllCourses'))
        .then((response) => {
          this.courses = response.data;
        });
      this.dialogVisible = true;
    },
    async publish() {
      this.loading = true;
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      if (this.channel.type === 'group') {
        form.append('mygroup_id', this.channel.id);
        form.append('mycourse_id', 1);
      } else if (this.channel.type === 'course') {
        form.append('mygroup_id', 1);
        form.append('mycourse_id', this.channel.id);
      } else {
        form.append('mygroup_id', 1);
        form.append('mycourse_id', 1);
      }
      if (this.newFileName.length > 0) {
        form.append('media_path', this.newFileName);
        form.append('media_realname', this.realFileName);
        form.append('media_type', this.newFileName.split('.').pop());
      }
      form.append('description', this.publication);
      const data = await this.$request.post(
        this.$getUrlToMakeRequest('SocialNetwork', 'savePublication'),
        form
      );
      if (data.status === 200 && this.publication.length > 0) {
        this.$messagePublished();
        eventBus.$emit('new-publication');
      } else if (data.data === false) {
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
    uploadContent() {
      this.$refs.inputFile.click();
    },
    uploadToServer(event) {
      this.uploadFile
        .upload(event, this.subDomainName, 'social')
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

<style scoped>
.channel_name {
  padding: 0px;
  font-size: 0.8rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
}

.box-card {
  border-radius: 30px;
  padding: 4%;
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

.new_publication_container {
  position: fixed;
  max-width: 30%;
  box-shadow: 10px 0px 13px -15px #aca9a9;
}

@media only screen and (max-width: 600px) {
  .new_publication_container {
    position: relative;
    max-width: 100%;
    box-shadow: 0px 0px 3px 0px #aca9a9;
  }
}
</style>
