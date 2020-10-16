<template>
  <el-col :sm="12" :xs="24">
    <img
      style="width: 150px"
      class="m-b-10"
      src="@/assets/img/apps/fbpixel.png"
    />
    <form @submit.prevent="saveFbPixel()" id="form-facebook-pixel">
      <el-input
        clearable
        v-model="id"
        name="id"
        class="m-b-10"
        :placeholder="lang['tracking-id']"
      ></el-input>
      <el-button
        class="sbr-btn sbr-primary"
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
<style scoped>

@media only screen and (max-width: 450px) {
  .sbr-primary{
    width: 100% !important;
  }

}
</style>