<template>
  <div>
    <el-dialog :visible.sync="modal" :title="lang['edit-link']" center width="40%" top="5vh">
      <form id="form-link" @submit.prevent="editLink()">
        <div class="form-group">
          <label>{{lang["name"]}}</label>
          <el-input name="title" v-model="title"></el-input>
          <input type="text" name="linkId" v-model="linkId" class="hide" />
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
          <el-button native-type="submit" class="sbr-primary">{{lang["save-button"]}}</el-button>
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
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { mapState } from "vuex";
import { eventBus } from "@/components/site/App";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      linkId: "",
      title: "",
      url: "",
      target: "",
      modal: false,
      loading: false
    };
  },
  mounted() {
    eventBus.$on(
      "edit-link",
      function(data) {
        this.linkId = data["id"];
        this.title = data["title"];
        this.url = data["url"];
        this.target = data["target"];

        this.modal = true;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    editLink: function() {
      var form = document.getElementById("form-link");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest("link", "edit");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.actionsToBePerformedAfterEdit();
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    actionsToBePerformedAfterEdit() {
      eventBus.$emit("link-list-update");
      this.modal = false;
    }
  }
};
</script>

