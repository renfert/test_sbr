<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['edit-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-audio-edit" @submit.prevent="edit()">
        <div class="form-row">
          <!-- Lesson id -->
          <input type="number" class="hide" name="lessonId" :value="audio.id" />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input required v-model="audio.name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Audio upload -->
            <label class="col-form-label">Audio *</label>
            <upload
              v-if="this.audio.fileRealName != ''"
              :src-name="this.audio.fileName"
              :src-real-name="this.audio.fileRealName"
              do-upload="true"
              box-height="200"
              return-name="path"
              input-name="file"
              bucket-key="uploads/content"
              acceptable=".mp3,.wav"
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
      audio: {
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
    eventBus.$on('edit-lesson-2', (response) => {
      this.modal = true;
      this.audio.id = response[0].id;
      this.audio.name = response[0].title;
      this.audio.fileRealName = response[0].real_name;
      this.audio.fileName = response[0].path;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    edit() {
      this.loading = true;
      const form = document.getElementById('form-lesson-audio-edit');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          eventBus.$emit('new-lesson');
          this.modalEditAudio = false;
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
