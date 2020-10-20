<template>
  <div class="m-t-40 m-b-40 center">
    <img src="@/assets/img/social/world.png" style="width: 50px" />
    <h3>{{ lang['social-public-title'] }}</h3>
    <h4>
      {{ lang['social-public-subtitle'] }}
    </h4>
    <el-switch
      @change="updatePublicNetworkStatus()"
      v-model="socialPublic"
      active-color="#009CD8"
      inactive-color="#9E9C9C"
    >
    </el-switch>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      socialPublic: false
    };
  },
  created() {
    this.getPublicNetworkStatus();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getPublicNetworkStatus() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'socialNetwork',
        'getPublicNetworkStatus'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.socialPublic = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    updatePublicNetworkStatus() {
      const formData = new FormData();
      formData.set('status', this.socialPublic);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'socialNetwork',
        'updatePublicNetworkStatus'
      );
      setTimeout(() => {
        this.$request.post(urlToBeUsedInTheRequest, formData);
      }, 500);
    }
  }
};
</script>
<style scoped>
.el-transfer-panel {
  margin: 5px;
  width: 255px;
}

@media only screen and (max-width: 1315px) {
  .el-transfer__buttons {
    display: flow-root;
  }

  .el-transfer-panel {
    width: 100%;
    margin: 5px;
  }
}
</style>
