<template>
  <el-col class="m-t-20" :sm="12" :xs="24">
    <img
      style="width: 100px"
      class="m-b-10"
      src="@/assets/img/apps/paypal.png"
    />
    <form @submit.prevent="savePaypalClientId()" id="form-tag-manager">
      <el-input
        clearable
        class="m-b-10"
        :type="typeInput"
        v-model="id"
        name="id"
        placeholder="Client ID"
      >
        <el-button
          @click.prevent="changeInputType()"
          slot="append"
          :icon="typeInput == 'password' ? 'mdi mdi-eye-off' : 'mdi mdi-eye'"
        ></el-button>
      </el-input>
      <el-button
        class="sbr-btn sbr-primary mt-3"
        native-type="submit"
        type="primary"
      >{{ lang['save-button'] }}
      </el-button
      >
    </form>
  </el-col>
</template>

<script>
import {mapState} from 'vuex';

export default {
  data: () => {
    return {
      id: '',
      typeInput: 'password'
    };
  },
  mounted() {
    this.getPaypalClientId();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    changeInputType() {
      if (this.typeInput === 'password') {
        this.typeInput = 'text';
      } else {
        this.typeInput = 'password';
      }
    },
    getPaypalClientId() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'getIntegrations'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.id = response.data.paypal_client_id;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    savePaypalClientId() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'savePaypal'
      );
      formData.set('id', this.id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getPaypalClientId();
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