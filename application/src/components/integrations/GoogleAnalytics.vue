<template>
  <div class="col-md-6 col-12">
    <img class="integration-image" src="@/assets/img/apps/analytics.png" />
    <form @submit.prevent="saveAnalytics()" id="form-google-analytics">
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
    this.getAnalytics();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getAnalytics() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'getIntegrations'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          response.data.ga_id === 'default'
            ? (this.id = '')
            : (this.id = response.data.ga_id);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    saveAnalytics() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'saveAnalytics'
      );
      formData.set('id', this.id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getAnalytics();
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
