<template>
  <!--  Modal edit social media -->
  <div>
    <el-dialog :visible.sync="modal" :title="lang['edit']" center width="40%" top="5vh">
      <form id="form-social" @submit.prevent="editSocialMedia()">
        <input class="hide" type="number" name="socialMediaId" v-model="socialMediaId" />
        <div class="form-group">
          <label>{{lang["social-media"]}}</label>
          <div class="block">
            <select class="form-select" name="socialMedia" v-model="name">
              <option value="facebook">Facebook</option>
              <option value="instagram">Instagram</option>
              <option value="linkedin">Linkedin</option>
              <option value="twitter">Twitter</option>
              <option value="pinterest">Pinterest</option>
              <option value="youtube">Youtube</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>{{lang["url"]}}</label>
          <el-input name="url" v-model="url"></el-input>
        </div>
        <div class="form-group">
          <el-button native-type="submit" class="sbr-btn sbr-primary">{{lang["save-button"]}}</el-button>
        </div>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueTheMask from "vue-the-mask";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import { eventLang } from "@/components/helper/HelperLang";
import { eventBus } from "@/components/site/App";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

locale.use(lang);
Vue.use(VueTheMask);
Vue.use(VueTheMask);
Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      lang: {},
      socialMediaId: "",
      name: "",
      url: "",
      modal: false,
      loading: false
    };
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );

    eventBus.$on(
      "edit-social-media",
      function(data) {
        this.socialMediaId = data["id"];
        this.name = data["name"];
        this.url = data["url"];

        this.modal = true;
      }.bind(this)
    );
  },
  methods: {
    editSocialMedia: function() {
      var form = document.getElementById("form-social");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("social", "edit");
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
      eventBus.$emit("new-change-footer");
      this.modal = false;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.action-icons {
  float: right;
  margin-left: 0%;
}

.links {
  cursor: pointer;
}

.custom-control-label {
  padding-top: 4px !important;
}

#accordion > .card {
  margin-bottom: 2%;
}

.btn-link {
  padding: 0px !important;
  font-size: 13px;
  font-family: "Poppins", sans-serif;
  font-weight: 600;
}

.btn.link:hover {
  text-decoration: none !important;
}

.card-header {
  padding: 10px !important;
}

.btn-eadtools-rounded {
  border-radius: 50%;
  cursor: pointer;
  display: inline-block;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
  position: relative;
  height: 40px;
  width: 40px;
  background-color: #d696ef;
  z-index: 2;
  border: none;
  color: white;
  margin: 0 0.2rem;
}

.sortable-drag {
  opacity: 0;
}

.flip-list-move {
  transition: transform 0.5s;
}

.ghost {
  border-left: 6px solid rgb(0, 183, 255);
  border-radius: 5px;
  opacity: 0.5;
}

.card {
  margin-bottom: 15px;
}

.handle {
  cursor: move;
}

li {
  list-style-type: none;
}
</style>
