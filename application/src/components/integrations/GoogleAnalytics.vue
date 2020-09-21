<template>
  <el-col :sm="12" :xs="24">
    <img
      style="width: 150px"
      class="m-b-10"
      src="@/assets/img/apps/analytics.png"
    />
    <form @submit.prevent="saveAnalytics()" id="form-google-analytics">
      <el-input
        clearable
        v-model="id"
        name="id"
        class="m-b-10"
        :placeholder="lang['tracking-id']"
      ></el-input>
      <el-button
        class="sbr-btn sbr-primary mt-3"
        native-type="submit"
        type="primary"
        >{{ lang['save-button'] }}</el-button
      >
    </form>
  </el-col>
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
