<template>
  <div>
    <el-dialog
      :visible.sync="modalEditHtml"
      :title="lang['edit-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-html-edit" @submit.prevent="edit()">
        <div class="form-row">
          <input type="number" class="hide" name="lessonId" :value="lessonId" />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <label class="col-form-label">Zip file *</label>
            <div class="drop-area">
              <input :value="htmlName" name="path" type="text" />
              <input
                class="upload"
                @change.prevent="render($event)"
                type="file"
                acceptable=".zip"
              />
              <div class="drop-message">
                <span class="file-icon" :class="icon"></span>
                <p>{{ message }}</p>
              </div>
              <div class="drop-preview on" style="text-align: center">
                <div class="drop-img">
                  <img class="preview" :src="previewImg" alt />
                </div>
              </div>
            </div>
            <input
              class="hide"
              type="text"
              name="real_name"
              :value="realName"
            />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              v-loading="loading"
              native-type="submit"
              class="sbr-primary"
              >{{ lang['save-button'] }}</el-button
            >
          </div>
        </div>
      </form>
    </el-dialog>
  </div>
  <!-- End  modal new lesson -->
</template>

<script>
import { eventProgress } from '@/components/helper/HelperProgress';
import { eventBus } from '@/components/newcourse/App';
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      name: '',
      htmlName: '',
      previewImg: '',
      realName: '',
      icon: 'fas fa-cloud-upload-alt',
      message: 'Upload a file',
      modalEditHtml: false,
      loading: false,
      lessonId: ''
    };
  },
  mounted() {
    eventBus.$on('edit-lesson-7', (response) => {
      this.modalEditHtml = true;
      this.lessonId = response[0].id;
      this.name = response[0].title;
      this.realName = response[0].real_name;
      this.htmlName = response[0].path;
      this.previewImg =
        '' +
        this.getCurrentDomainName() +
        'assets/uploads/content/' +
        response[0].path;
      this.message = response[0].real_name;
      this.icon = 'far fa-thumbs-up text-default';
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    edit() {
      this.loading = true;
      const form = document.getElementById('form-lesson-html-edit');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.actionsToBePerformedAfterEdit();
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    render(event) {
      this.upload(event);
      this.message = '';
      this.icon = '';
      const input = event.target;
      const fullName = input.value;
      const fileName = fullName.split(/(\\|\/)/g).pop();
      const fileExtension = fullName.split('.').pop();
      this.realName = fileName;
      if (
        fileExtension === 'png' ||
        fileExtension === 'jpg' ||
        fileExtension === 'jpeg'
      ) {
        const reader = new FileReader();
        reader.onload = (e) => {
          const div = input.parentElement;
          const img = div.getElementsByTagName('img')[0];
          img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      } else {
        this.message = fileName;
        this.icon = 'far fa-thumbs-up text-default';
      }
    },
    upload(event) {
      eventProgress.$emit('new-progress');
      const config = {
        onUploadProgress: (progressEvent) => {
          const percentCompleted = Math.round(
            (progressEvent.loaded * 100) / progressEvent.total
          );
          eventProgress.$emit('new-percent', percentCompleted);
        }
      };
      const formData = new FormData();
      formData.append('file', event.target.files[0]);
      formData.append('type', 'lesson-html');
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'upload',
        'upload_file'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData, config).then(
        (response) => {
          this.htmlName = response.data;
          event.target.value = null;
          eventProgress.$emit('finish-progress');
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    actionsToBePerformedAfterEdit() {
      this.name = '';
      this.htmlName = '';
      this.modalEditHtml = false;
      eventBus.$emit('new-lesson');
    }
  }
};
</script>
