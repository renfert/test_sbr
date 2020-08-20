<template>
  <div>
    <div v-for="element in banner" :key="element.id">
      <el-dialog :visible.sync="modal" title="Banner" center width="40%" top="5vh">
        <form id="form-banner" @submit.prevent="editBanner()">
          <!-- Banner id -->
          <input type="number" name="bannerId" class="hide" :value="element.id" />
          <!-- Cta id -->
          <input type="number" name="buttonId" class="hide" :value="element.button_id" />
          <el-tabs type="border-card">
            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-picture-outline"></i>
                {{lang["image"]}}
              </span>
              <div class="form-row">
                <div class="form-group col-xl-12 col-md-12">
                  <!-- Banner image  -->
                  <label class="col-form-label">{{lang["image"]}} *</label>
                  <upload
                    :src-name="element.image"
                    :src-img="getUrlToContents() + 'builder/body/'+element.image+''"
                    do-upload="true"
                    box-height="200"
                    return-name="bannerName"
                    input-name="file"
                    bucket-key="uploads/builder/body"
                    acceptable=".png,.jpg"
                  ></upload>
                </div>
              </div>
            </el-tab-pane>

            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-document"></i>
                {{lang["header"]}}
              </span>
              <div class="form-row" :class="activeHeader == false ? 'disabled' : ''">
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Header -->
                  <label class="col-form-label">{{lang["header"]}} *</label>
                  <el-input
                    :disabled="activeHeader == false ? true : false "
                    name="header"
                    v-model="header"
                  ></el-input>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Header color -->
                  <label class="col-form-label">{{lang["header-color"]}} *</label>
                  <div class="block">
                    <input name="headerColor" v-model="headerColor" type="text" class="hide" />
                    <el-color-picker name="headerColor" v-model="headerColor"></el-color-picker>
                  </div>
                </div>
              </div>
              <hr />
              <el-alert :title="lang['disable-section-message']" type="info" show-icon></el-alert>
              <br />
              <el-switch @change="showHeader()" v-model="activeHeader"></el-switch>
            </el-tab-pane>

            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-document-copy"></i>
                {{lang["sub-header"]}}
              </span>
              <div class="form-row" :class="activeSubHeader == false ? 'disabled' : ''">
                <div class="form-group col-xl-6 col-md-6">
                  <!-- SubHeader -->
                  <label class="col-form-label">{{lang["sub-header"]}} *</label>
                  <el-input
                    :disabled="activeSubHeader == false ? true : false "
                    name="subHeader"
                    v-model="subHeader"
                  ></el-input>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- SubHeader color -->
                  <label class="col-form-label">{{lang["sub-header-color"]}} *</label>
                  <div class="block">
                    <input name="subHeaderColor" v-model="subHeaderColor" type="text" class="hide" />
                    <el-color-picker name="subHeaderColor" v-model="subHeaderColor"></el-color-picker>
                  </div>
                </div>
              </div>
              <hr />
              <el-alert :title="lang['disable-section-message']" type="info" show-icon></el-alert>
              <br />
              <el-switch @change="showSubHeader()" v-model="activeSubHeader"></el-switch>
            </el-tab-pane>
            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-s-opportunity"></i>
                {{lang["button"]}}
              </span>
              <div class="form-row" :class="activeButton == false ? 'disabled' : ''">
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta title -->
                  <label class="col-form-label">{{lang["button-title"]}} *</label>
                  <el-input
                    :disabled="activeButton == false ? true : false "
                    name="buttonTitle"
                    v-model="buttonTitle"
                  ></el-input>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta url -->
                  <label class="col-form-label">{{lang["button-url"]}} *</label>
                  <el-input name="buttonUrl" v-model="buttonUrl"></el-input>
                </div>
              </div>
              <div class="form-row" :class="activeButton == false ? 'disabled' : ''">
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta target -->
                  <label class="col-form-label">{{lang["button-target"]}} *</label>
                  <el-select name="buttonTarget" v-model="buttonTarget">
                    <el-option value="_self" label="Same window"></el-option>
                    <el-option value="_blank" label="New window"></el-option>
                  </el-select>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta style -->
                  <label class="col-form-label">{{lang["button-style"]}} *</label>
                  <el-select name="buttonStyle" v-model="buttonStyle">
                    <el-option value="plain" label="Plain"></el-option>
                    <el-option value="rounded" label="Rounded"></el-option>
                  </el-select>
                </div>
              </div>
              <hr />
              <div class="form-row" :class="activeButton == false ? 'disabled' : ''">
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta bg color -->
                  <label class="col-form-label">{{lang["button-bg-color"]}} *</label>
                  <div class="block">
                    <input name="buttonColor" type="text" class="hide" v-model="buttonColor" />
                    <el-color-picker v-model="buttonColor"></el-color-picker>
                  </div>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta hover color -->
                  <label class="col-form-label">{{lang["button-hover-color"]}} *</label>
                  <div class="block">
                    <input
                      name="buttonHoverColor"
                      type="text"
                      class="hide"
                      v-model="buttonColorHover"
                    />
                    <el-color-picker v-model="buttonColorHover"></el-color-picker>
                  </div>
                </div>
              </div>
              <hr />
              <el-alert :title="lang['disable-section-message']" type="info" show-icon></el-alert>
              <br />
              <el-switch @change="showButton()" v-model="activeButton"></el-switch>
            </el-tab-pane>
          </el-tabs>
          <br />
          <div class="form-row">
            <div class="form-group col-xl-12 col-md-12">
              <el-button
                class="sbr-primary"
                native-type="submit"
                v-loading="loadingButton"
              >{{lang["save-button"]}}</el-button>
            </div>
          </div>
        </form>
      </el-dialog>
    </div>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import Upload from "@/components/helper/HelperUpload";
import HelperProgress from "@/components/helper/HelperProgress.vue";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/site/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  components: {
    Upload,
    HelperProgress
  },
  data: () => {
    return {
      banner: [],
      modules: null,
      header: "",
      subHeader: "",
      headerColor: "",
      subHeaderColor: "",
      loadingButton: false,
      modal: false,
      buttonTitle: "",
      buttonUrl: "",
      buttonTarget: "",
      buttonColor: "",
      buttonColorHover: "",
      buttonStyle: "",
      activeHeader: true,
      activeSubHeader: true,
      activeButton: true,
      sectionId: "",
      bannerImage: ""
    };
  },
  mounted() {
    eventBus.$on(
      "edit-banner",
      function(sectionId) {
        this.getBanner(sectionId);
        this.modal = true;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    editBanner: function() {
      this.loadingButton = true;
      var form = document.getElementById("form-banner");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "site-elements/banner",
        "editBanner"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          eventBus.$emit("new-banner-change");
          this.successMessage();
          this.modal = false;
          this.loadingButton = false;
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },

    showHeader: function() {
      if (this.activeHeader == false) {
        this.header = "";
      }
    },
    showSubHeader: function() {
      if (this.activeSubHeader == false) {
        this.subHeader = "";
      }
    },
    showButton: function() {
      if (this.activeButton == false) {
        this.buttonTitle = "";
      }
    },

    getBanner: function(sectionId) {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "site-elements/banner",
        "getBanner"
      );
      var formData = new FormData();
      formData.set("sectionId", sectionId);
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.banner = response.data;
          this.buttonTitle = response.data[0]["title"];
          this.buttonColor = response.data[0]["color"];
          this.buttonColorHover = response.data[0]["color_hover"];
          this.headerColor = response.data[0]["header_color"];
          this.subHeaderColor = response.data[0]["subheader_color"];
          this.buttonStyle = response.data[0]["style"];
          this.buttonUrl = response.data[0]["url"];
          this.buttonTarget = response.data[0]["target"];
          this.header = response.data[0]["header"];
          this.subHeader = response.data[0]["subheader"];
          this.bannerImage = response.data[0]["image"];

          if (response.data[0]["header"] == null) {
            this.activeHeader = false;
          }

          if (response.data[0]["subheader"] == null) {
            this.activeSubHeader = false;
          }

          if (response.data[0]["title"] == null) {
            this.activeButton = false;
          }
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },

    openEditModuleModal: function(id, title, required, date) {
      this.moduleId = id;
      this.moduleTitle = title;
      this.moduleRequired = required;
      this.moduleReleaseDate = date;
      this.modal = true;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.disabled {
  opacity: 0.2;
}
</style>
