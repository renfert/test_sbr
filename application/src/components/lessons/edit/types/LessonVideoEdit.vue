<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['edit-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-video-edit" @submit.prevent="edit()">
        <!-- Lesson id -->
        <input type="text" name="lessonId" class="hide" v-model="video.id" />
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input required v-model="video.name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Video upload -->
            <label class="col-form-label">Video *</label>
            <upload
              v-if="this.video.fileRealName != ''"
              :src-name="this.video.fileName"
              :src-real-name="this.video.fileRealName"
              do-upload="true"
              box-height="200"
              return-name="path"
              input-name="file"
              bucket-key="uploads/content"
              acceptable=".mp4,.mov"
            ></upload>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button native-type="submit" class="sbr-primary">{{
              lang['save-button']
            }}</el-button>
          </div>
        </div>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import Upload from '@/components/helper/HelperUpload';
import { eventBus } from '@/components/newcourse/App';
import { mapState } from 'vuex';

export default {
  components: {
    Upload
  },
  props: ['module-id'],
  data: () => {
    return {
      video: {
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
    eventBus.$on('edit-lesson-1', (response) => {
      this.modal = true;
      this.video.id = response[0].id;
      this.video.name = response[0].title;
      this.video.fileRealName = response[0].real_name;
      this.video.fileName = response[0].path;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    edit() {
      this.loading = true;
      const form = document.getElementById('form-lesson-video-edit');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          eventBus.$emit('new-lesson');
          this.modalEditLesson = false;
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
