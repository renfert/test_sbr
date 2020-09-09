<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['create-new-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-audio" @submit.prevent="create()">
        <div class="form-row">
          <!-- Module id -->
          <input type="number" class="hide" name="moduleId" :value="moduleId" />
          <input type="text" class="hide" name="type_mylesson_id" value="2" />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Audio upload -->
            <label class="col-form-label">Audio *</label>
            <upload
              :key="key"
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
      modal: false,
      loading: false,
      key: 0
    };
  },
  mounted() {
    eventBus.$on('new-audio', () => {
      this.modal = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    forceUpdate() {
      this.key++;
    },
    create() {
      this.loading = true;
      const form = document.getElementById('form-lesson-audio');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'create'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          form.reset();
          eventBus.$emit('new-lesson');
          this.forceUpdate();
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
