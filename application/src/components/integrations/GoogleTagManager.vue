<template>
  <div class="col-md-6 col-12">
    <img class="integration-image" src="@/assets/img/apps/tagmanager.jpg" />
    <form @submit.prevent="saveTagManager()" id="form-tag-manager">
      <el-input
        v-model="id"
        name="id"
        :placeholder="lang['tracking-id']"
      ></el-input>
      <el-button
        class="sbr-btn sbr-primary mt-3"
        native-type="submit"
        type="primary"
        >{{ lang['save-button'] }}</el-button
      >
    </form>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      id: ''
    };
  },
  mounted() {
    this.getTagManager();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getTagManager() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'getIntegrations'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          response.data.gtm_id === 'default'
            ? (this.id = '')
            : (this.id = response.data.gtm_id);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    saveTagManager() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'saveTagManager'
      );
      formData.set('id', this.id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getTagManager();
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
