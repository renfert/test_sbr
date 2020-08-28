<template>
  <div>
    <el-dialog :visible.sync="modal" :title="lang['new-link']" center width="40%" top="5vh">
      <form id="form-link" @submit.prevent="createLink()">
        <div class="form-group">
          <label>{{lang["name"]}}</label>
          <el-input name="title" v-model="title"></el-input>
        </div>
        <div class="form-group">
          <label>{{lang["url"]}}</label>
          <el-input name="url" v-model="url"></el-input>
        </div>
        <div class="form-group">
          <label>{{lang["target"]}}</label>
          <div class="block">
            <select class="form-select" name="target" v-model="target">
              <option value="_new">{{lang["new-window"]}}</option>
              <option value="_blank">{{lang["same-window"]}}</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <el-button class="sbr-primary" native-type="submit">{{lang["save-button"]}}</el-button>
        </div>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import { eventBus } from "@/components/site/App";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

Vue.use(ElementUI);
Vue.use(VueAxios, axios);

import { mapState } from "vuex";

export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      title: "",
      url: "",
      target: "",
      modal: false
    };
  },
  mounted() {
    eventBus.$on(
      "open-link-modal",
      function() {
        this.modal = true;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    createLink: function() {
      var form = document.getElementById("form-link");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest("link", "create");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
          this.successMessage();
          this.clearFields();
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    clearFields() {
      this.title = "";
      this.url = "";
      this.target = "";
      this.modal = false;
      eventBus.$emit("link-list-update"); // Emit a event to list component update the table of categories.
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
