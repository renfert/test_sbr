<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['edit-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-pdf-edit" @submit.prevent="edit()">
        <div class="form-row">
          <!-- Lesson id -->
          <input type="number" class="hide" name="lessonId" :value="pdf.id" />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input required v-model="pdf.name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Pdf upload -->
            <label class="col-form-label">Pdf *</label>
            <upload
              :key="componentKey"
              v-if="this.pdf.fileRealName != ''"
              :src-name="this.pdf.fileName"
              :src-real-name="this.pdf.fileRealName"
              do-upload="true"
              box-height="200"
              return-name="path"
              input-name="file"
              bucket-key="uploads/content"
              acceptable=".pdf"
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
import { eventBus } from '@/components/newcourse/App';
import { mapState } from 'vuex';

export default {
  components: {
    Upload
  },
  data: () => {
    return {
      pdf: {
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
    eventBus.$on('edit-lesson-3', (response) => {
      this.modal = true;
      this.pdf.id = response[0].id;
      this.pdf.name = response[0].title;
      this.pdf.fileRealName = response[0].real_name;
      this.pdf.fileName = response[0].path;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    edit() {
      this.loading = true;
      const form = document.getElementById('form-lesson-pdf-edit');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          eventBus.$emit('new-lesson');
          this.modal = false;
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
