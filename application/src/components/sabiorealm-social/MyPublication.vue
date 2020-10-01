<template>
  <div>
    <aside>
      <div class="card-box" style="position: fixed; max-width: 30%">
        <div>
          <h3 class="center">
            <i class="el-icon-edit sbr-text-primary"></i> Criar nova publicacao
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
                class="sbr-text-primary"
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

        <el-row>
          <el-col v-if="!to" :md="8" :xs="12" :sm="5" class="link"> </el-col>
        </el-row>
        <br />
        <div class="publication_area m-b-30">
          <div style="width: 100%; text-align: right; padding-top: 3%">
            <img
              class="widget_publication m-r-10"
              style="width: 25px"
              src="@/assets/img/social/photo.png"
              @click="uploadImage()"
            />
          </div>
          <fieldset>
            <textarea
              placeholder="Escreva alguma coisa..."
              v-model="publication"
              rows="2"
            ></textarea>
            <el-row
              v-if="newFileName.length > 0"
              justify="center"
              align="start"
              :gutter="50"
            >
              <center>
                <div class="img_wrp">
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
      </div>
    </aside>

    <el-dialog
      top="5vh"
      :title="lang['select-an-element']"
      :visible.sync="dialogVisible"
      width="30%"
    >
      <h4>Onde voce gostaria de realizar a publicacao?</h4>
      <!-- Public -->
      <el-row @click="selectPublic()" class="publish-location">
        <el-col :sm="4">
          <img style="width: 50px" src="@/assets/img/social/world.png" alt="" />
        </el-col>
        <el-col :sm="20">
          <h3 style="margin: 0px">Publico</h3>
          <h4 style="margin: 0px">Qualquer pessoa pode ver</h4>
        </el-col>
      </el-row>

      <!-- Specific group -->
      <el-row class="publish-location">
        <el-col :sm="4">
          <img
            style="width: 50px"
            src="@/assets/img/general/ux/join_persons.png"
            alt=""
          />
        </el-col>
        <el-col :sm="14">
          <h3 class="m-b-20" style="margin: 0px">Grupo especifico</h3>
          <el-select
            @change="selectSection('group')"
            v-model="select"
            class="m-b-20"
            filterable
            placeholder="Select"
          >
            <el-option
              v-for="(group, index) in groups"
              :key="index"
              :label="group.name"
              :value="{ id: group.id, name: group.name }"
            >
            </el-option>
          </el-select>
        </el-col>
      </el-row>

      <!-- Specific course -->
      <el-row class="publish-location">
        <el-col :sm="4">
          <img
            style="width: 50px"
            src="@/assets/img/general/ux/view_course.png"
            alt=""
          />
        </el-col>
        <el-col :sm="14">
          <h3 class="m-b-20" style="margin: 0px">Curso especifico</h3>
          <el-select
            @change="selectSection('course')"
            v-model="select"
            class="m-b-20"
            filterable
            placeholder="Select"
          >
            <el-option
              v-for="(course, index) in courses"
              :key="index"
              :label="course.title"
              :value="{ id: course.id, name: course.title }"
            >
            </el-option>
          </el-select>
        </el-col>
      </el-row>
    </el-dialog>

    <Progress />
  </div>
</template>

<script>
import { mapState } from 'vuex';
import { eventBus } from '@/components/sabiorealm-social/App';
import UploadFile from '@/mixins/upload';
import Progress from '@/components/helper/HelperProgress';

export default {
  components: { Progress },
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
      select: '',
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
    selectSection(type) {
      this.section_type = type;
      this.section_id = this.select.id;
      this.section_name = this.select.name;
      this.dialogVisible = false;
    },
    async publish() {
      this.loading = true;
      const form = new FormData();
      form.append('myuser_id', this.user.id);
      if (this.section_type === 'group') {
        form.append('mygroup_id', this.section_id);
        form.append('mycourse_id', 1);
      } else if (this.section_type === 'course') {
        form.append('mygroup_id', 1);
        form.append('mycourse_id', this.section_id);
      } else {
        form.append('mygroup_id', 1);
        form.append('mycourse_id', 1);
      }
      if (this.newFileName.length > 0) {
        form.append('media_path', this.newFileName);
        form.append('media_realname', this.realFileName);
        form.append('media_type', this.newFileName.split('.').pop());
      }
      form.append('description', this.urlify(this.publication));
      const data = await this.$request.post(
        this.$getUrlToMakeRequest('SocialNetwork', 'savePublication'),
        form
      );
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
      this.uploadFile
        .upload(event, this.subDomainName, 'social')
        .then((response) => {
          this.newFileName = response.newFileName;
          this.realFileName = response.fileName;
        });
    }
  }
};
</script>

<style scoped>
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
</style>
