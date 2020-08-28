<template>
  <div class="card-box">
    <h4>{{lang["create-group"]}}</h4>
    <el-form id="form-group" :inline="true">
      <el-form-item>
        <el-input required name="name" :placeholder="lang['name']" v-model="groupName"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button
          @click.prevent="createGroup()"
          v-loading="loadingButton"
          class="sbr-primary"
          native-type="submit"
        >{{lang["save-button"]}}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/groups/App";
import { mapState } from "vuex";

Vue.use(ElementUI);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      groupName: "",
      loadingButton: false
    };
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    createGroup: function() {
      this.loadingButton = true;
      var form = document.getElementById("form-group");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "group",
        "create"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          /* Success callback */
          if (response.data == false) {
            this.groupAlreadyExistsMessage();
          } else {
            this.successMessage();
            this.actionsToBePerformedAfterRegistration();
          }
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    groupAlreadyExistsMessage() {
      this.$notify({
        title: this.lang["error"],
        message: this.lang["group-already-exists"],
        type: "warning",
        duration: 3500
      });
    },
    actionsToBePerformedAfterRegistration() {
      this.loadingButton = false;
      this.groupName = "";
      eventBus.$emit("new-group");
    }
  }
};
</script>
