<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['add-new-social']"
      center
      width="40%"
      top="5vh"
    >
      <form id="form-social" @submit.prevent="createSocialMedia()">
        <div class="form-group">
          <label>{{ lang['social-media'] }}</label>
          <div class="block">
            <select
              class="form-select"
              name="socialMedia"
              v-model="socialMedia"
            >
              <option value="facebook">Facebook</option>
              <option value="instagram">Instagram</option>
              <option value="linkedin">Linkedin</option>
              <option value="twitter">Twitter</option>
              <option value="pinterest">Pinterest</option>
              <option value="youtube">Youtube</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>{{ lang['url'] }}</label>
          <el-input name="url" v-model="url"></el-input>
        </div>
        <div class="form-group">
          <el-button class="sbr-btn sbr-primary" native-type="submit">{{
            lang['save-button']
          }}</el-button>
        </div>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import { eventBus } from '@/components/site/App';
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      socialMedia: '',
      url: '',
      modal: false
    };
  },
  mounted() {
    eventBus.$on('open-social-modal', () => {
      this.modal = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    createSocialMedia() {
      const form = document.getElementById('form-social');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        'social',
        'create'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.actionsToBePerformedAfterRegistration();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    actionsToBePerformedAfterRegistration() {
      this.socialMedia = '';
      this.url = '';
      this.modal = false;
      eventBus.$emit('social-media-list-update');
      eventBus.$emit('new-change-footer');
    }
  }
};
</script>
