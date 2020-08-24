<template>
  <div class="card-box">
    <h4 class="fw-700 mb-5">{{lang["your-settings"]}}</h4>
    <br />
    <form id="form-settings" @submit.prevent="editSettings">
      <div class="row">
        <template>
          <el-tabs tab-position="left">
            <el-tab-pane :label="lang['school-information']">
              <div class="row" style="padding-left:15px;">
                <div class="col-6">
                  <div class="form-group">
                    <!-- School name -->
                    <label>{{lang['school-name']}}</label>
                    <el-input
                      required
                      name="name"
                      :placeholder="lang['school-name']"
                      v-model="name"
                    ></el-input>
                  </div>
                  <label>{{lang['logo']}}</label>
                  <upload
                    v-if="this.logoName != ''"
                    :src-img="this.getUrlToContents() + 'settings/'+this.logoName+''"
                    :src-name="this.logoName"
                    do-upload="true"
                    box-height="200"
                    return-name="logo"
                    input-name="file"
                    bucket-key="uploads/settings"
                    acceptable=".png,.jpg,.jpeg"
                  ></upload>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>{{lang['description']}}</label>
                    <el-input
                      name="description"
                      :placeholder="lang['description']"
                      v-model="description"
                    ></el-input>
                  </div>
                  <label>{{lang['favicon']}}</label>
                  <upload
                    v-if="this.faviconName != ''"
                    :src-img="this.getUrlToContents() + 'settings/'+this.faviconName+''"
                    :src-name="this.faviconName"
                    do-upload="true"
                    box-height="200"
                    return-name="favicon"
                    input-name="file"
                    bucket-key="uploads/settings"
                    acceptable=".png,.jpg,.jpeg"
                  ></upload>
                </div>
              </div>
            </el-tab-pane>

            <el-tab-pane :label="lang['contact-information']">
              <div class="col-12">
                <div class="form-group">
                  <!-- Email -->
                  <label>{{lang['email']}}</label>
                  <el-input name="email" :placeholder="lang['email']" v-model="email"></el-input>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <!-- phone -->
                  <label>{{lang['phone']}}</label>
                  <el-input name="phone" :placeholder="lang['phone']" v-model="phone"></el-input>
                </div>
              </div>
            </el-tab-pane>

            <el-tab-pane :label="lang['general-settings']">
              <div class="col-12">
                <div class="form-group">
                  <!-- lang -->
                  <label>{{lang['language']}}</label>
                  <br />
                  <el-select v-model="language" name="language" placeholder="Select your language">
                    <el-option label="en" value="en">
                      <span style="float: left">en</span>
                      <span style="float: right; color: #8492a6; font-size: 13px">
                        <img src="@/assets/img/general/flags/en.png" alt="en" />
                      </span>
                    </el-option>

                    <el-option label="es" value="es">
                      <span style="float: left">es</span>
                      <span style="float: right; color: #8492a6; font-size: 13px">
                        <img src="@/assets/img/general/flags/es.png" alt="es" />
                      </span>
                    </el-option>

                    <el-option label="pt-br" value="pt-br">
                      <span style="float: left">pt-br</span>
                      <span style="float: right; color: #8492a6; font-size: 13px">
                        <img src="@/assets/img/general/flags/pt-br.png" alt="pt-br" />
                      </span>
                    </el-option>
                  </el-select>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <!-- Time/zone -->
                  <label>Time/zone</label>
                  <br />
                  <el-select
                    filterable
                    v-model="timezone"
                    name="timezone"
                    placeholder="Select your Time/Zone"
                  >
                    <el-option v-for="item in zones" :key="item" :label="item" :value="item">
                      <span style="float: left">{{item}}</span>
                    </el-option>
                  </el-select>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <!-- marketplace -->
                  <label>{{lang['marketplace']}}</label>
                  <br />
                  <el-switch name="marketplace" v-model="marketplace"></el-switch>
                </div>
              </div>
            </el-tab-pane>
          </el-tabs>
        </template>
      </div>
      <el-button class="sbr-primary" native-type="submit" type="primary">{{lang["save-button"]}}</el-button>
    </form>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import Upload from "@/components/helper/HelperUpload";
import HelperProgress from "@/components/helper/HelperProgress.vue";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { mapState } from "vuex";

Vue.use(ElementUI);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      name: "",
      email: "",
      description: "",
      phone: "",
      logoName: "",
      faviconName: "",
      language: "",
      marketplace: false,
      timezone: "",
      zones: []
    };
  },
  components: {
    Upload,
    HelperProgress
  },
  created() {
    this.getSettings();
    this.getTimeZone();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getSettings: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.faviconName = response.data["favicon"];
          this.name = response.data["name"];
          this.description = response.data["description"];
          this.email = response.data["email"];
          this.phone = response.data["phone"];
          this.timezone = response.data["zone"];
          this.language = response.data["lang"];
          response.data["marketplace"] == "on"
            ? (this.marketplace = true)
            : (this.marketplace = false);
          this.logoName = response.data["logo"];
          this.faviconName = response.data["favicon"];
        }.bind(this)
      );
    },
    getTimeZone: function() {
      axios.get("https://worldtimeapi.org/api/timezone").then(
        function(response) {
          this.zones = response.data;
        }.bind(this)
      );
    },
    editSettings: function() {
      var form = document.getElementById("form-settings");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "edit"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  }
};
</script>

