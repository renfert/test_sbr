<template>
  <!--  Modal new lesson -->
  <div>
    <el-dialog
      :visible.sync="modalCreateHtml"
      :title="lang['create-new-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-html" @submit.prevent="create()">
        <div class="form-row">
          <!-- Module id -->
          <input type="number" class="hide" name="moduleId" :value="moduleId" />
          <input type="text" class="hide" name="type_mylesson_id" value="7" />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Video upload -->
            <label class="col-form-label">Zip file *</label>
            <upload
              do-upload="true"
              box-height="200"
              return-name="path"
              input-name="file"
              bucket-key="uploads/html"
              acceptable=".zip"
            ></upload>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              class="sbr-primary"
              v-loading="loading"
              native-type="submit"
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
import Upload from '@/components/helper/HelperUpload';
import { eventBus } from '@/components/newcourse/App';
import { mapState } from 'vuex';

export default {
  props: ['module-id'],
  components: {
    Upload
  },
  data: () => {
    return {
      name: '',
      previewImg: '',
      realName: '',
      modalCreateHtml: false,
      loading: false
    };
  },
  mounted() {
    eventBus.$on('new-html', () => {
      this.modalCreateHtml = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    create() {
      this.loading = true;
      const form = document.getElementById('form-lesson-html');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'create'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.actionsToBePerformedAfterRegistration();
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    actionsToBePerformedAfterRegistration() {
      this.name = '';
      this.modalCreateHtml = false;
      eventBus.$emit('new-lesson');
    }
  }
};
</script>
