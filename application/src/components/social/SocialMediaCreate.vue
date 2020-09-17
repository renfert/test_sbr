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
        <label>{{ lang['social-media'] }}</label>
        <div class="form-group">
          <el-select
            name="socialMedia"
            v-model="socialMedia"
            placeholder="Select"
          >
            <el-option label="Facebook" value="facebook"> </el-option>
            <el-option label="Instagram" value="instagram"> </el-option>
            <el-option label="Linkedin" value="linkedin"> </el-option>
            <el-option label="Twitter" value="twitter"> </el-option>
            <el-option label="Pinterest" value="pinterest"> </el-option>
            <el-option label="Youtube" value="youtube"> </el-option>
          </el-select>
        </div>

        <div class="form-group">
          <label>{{ lang['url'] }}</label>
          <el-input name="url" v-model="url"></el-input>
        </div>
        <div>
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
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
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
