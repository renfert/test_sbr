<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['edit-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-downloadable-edit" @submit.prevent="edit()">
        <div class="form-row">
          <input
            type="number"
            class="hide"
            name="lessonId"
            :value="downloadable.id"
          />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input
              required
              v-model="downloadable.name"
              name="title"
            ></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Downloadable file upload -->
            <label class="col-form-label">Downloadable file *</label>
            <upload
              v-if="this.downloadable.fileRealName != ''"
              :src-name="this.downloadable.fileName"
              :src-real-name="this.downloadable.fileRealName"
              do-upload="true"
              box-height="200"
              return-name="path"
              input-name="file"
              bucket-key="uploads/content"
              acceptable=".jpg,.png,.docx,.xlsx,.doc,.pptx,.pdf,.zip,.mp4,.mp3,.mov"
            ></upload>
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
</template>

<script>
import Upload from '@/components/helper/HelperUpload';
import { mapState } from 'vuex';
import { eventBus } from '@/components/newcourse/App';

export default {
  components: {
    Upload
  },
  data: () => {
    return {
      downloadable: {
        id: '',
        name: '',
        fileName: '',
        fileRealName: ''
      },
      modal: false,
      loading: false
    };
  },
  mounted() {
    eventBus.$on('edit-lesson-4', (response) => {
      this.modal = true;
      this.downloadable.id = response[0].id;
      this.downloadable.name = response[0].title;
      this.downloadable.fileRealName = response[0].real_name;
      this.downloadable.fileName = response[0].path;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    edit() {
      this.loading = true;
      const form = document.getElementById('form-lesson-downloadable-edit');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.modal = false;
          eventBus.$emit('new-lesson');
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
