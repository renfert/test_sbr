<template>
  <div>
    <div>
      <el-submenu index="0">
        <template slot="title">
          <i class="el-icon-menu"></i>
          <span>General</span>
        </template>
        <form id="form-general">
          <el-menu-item-group class="mb-5" :title="lang['color']">
            <el-menu-item>
              <input type="text" v-model="color" name="color" class="hide" />
              <el-color-picker @change="changeHeaderColor()" v-model="color"></el-color-picker>
            </el-menu-item>
          </el-menu-item-group>
        </form>
      </el-submenu>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

import { mapState } from "vuex";

export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      color: ""
    };
  },
  mounted() {
    this.getColor();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    changeHeaderColor: function() {
      setTimeout(
        function() {
          this.editColor();
        }.bind(this),
        100
      );
    },
    getColor: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.color = response.data["color"];
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    editColor: function() {
      var form = document.getElementById("form-general");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "editPrimaryColor"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {},
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
[class*=" el-icon-"],
[class^="el-icon-"] {
  line-height: 0 !important;
}

.el-menu-item {
  height: auto !important;
}

.el-submenu {
  list-style: none;
  margin: 0;
  padding-left: 0;
  border-bottom: 1px solid #ccc !important;
}

.el-submenu span {
  font-size: 1.2em !important;
  font-family: "Montserrat", sans-serif;
  color: #53536e !important;
}
</style>
