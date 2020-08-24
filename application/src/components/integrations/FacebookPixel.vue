<template>
  <div class="col-md-6 col-12">
    <img class="integration-image mb-3" src="@/assets/img/apps/fbpixel.png" />
    <form @submit.prevent="saveFbPixel()" id="form-facebook-pixel">
      <el-input v-model="id" name="id" :placeholder="lang['tracking-id']"></el-input>
      <el-button
        class="sbr-btn sbr-primary mt-3"
        native-type="submit"
        type="primary"
      >{{lang["save-button"]}}</el-button>
    </form>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { mapState } from "vuex";

Vue.use(ElementUI);
Vue.use(VueAxios, axios);
export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      id: ""
    };
  },
  mounted() {
    this.getFbPixel();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getFbPixel() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "integrations",
        "getIntegrations"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          response.data["fb_id"] == "default"
            ? (this.id = "")
            : (this.id = response.data["fb_id"]);
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    saveFbPixel: function() {
      var formData = new FormData();
      formData.set("id", this.id);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "integrations",
        "saveFbPixel"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.getFbPixel();
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  }
};
</script>
