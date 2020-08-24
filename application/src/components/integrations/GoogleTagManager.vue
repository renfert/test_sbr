<template>
  <div class="col-md-6 col-12">
    <img class="integration-image" src="@/assets/img/apps/tagmanager.jpg" />
    <form @submit.prevent="saveTagManager()" id="form-tag-manager">
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
    this.getTagManager();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getTagManager() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "integrations",
        "getIntegrations"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          response.data["gtm_id"] == "default"
            ? (this.id = "")
            : (this.id = response.data["gtm_id"]);
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    saveTagManager: function() {
      var formData = new FormData();
      formData.set("id", this.id);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "integrations",
        "saveTagManager"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.getTagManager();
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
