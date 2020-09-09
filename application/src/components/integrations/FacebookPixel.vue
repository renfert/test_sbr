<template>
  <div class="col-md-6 col-12">
    <img class="integration-image mb-3" src="@/assets/img/apps/fbpixel.png" />
    <form @submit.prevent="saveFbPixel()" id="form-facebook-pixel">
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
    this.getFbPixel();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getFbPixel() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'getIntegrations'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          response.data.fb_id === 'default'
            ? (this.id = '')
            : (this.id = response.data.fb_id);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    saveFbPixel() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'saveFbPixel'
      );
      formData.set('id', this.id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getFbPixel();
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
