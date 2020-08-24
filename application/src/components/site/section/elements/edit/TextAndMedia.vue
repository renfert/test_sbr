<template>
  <div>
    <div>
      <el-dialog :visible.sync="modal" title="Text and media" center width="40%" top="5vh">
        <form id="form-text-and-media" @submit.prevent="editTextAndMedia()">
          <!-- Text and media id -->
          <input type="number" name="textAndMediaId" class="hide" :value="textAndMediaId" />
          <!-- Cta id -->
          <input type="number" name="buttonId" class="hide" :value="buttonId" />
          <el-tabs type="border-card">
            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-picture-outline"></i>
                {{lang["media"]}}
              </span>
              <div class="form-row">
                <div class="form-group col-xl-12 col-md-12">
                  <!-- Media  -->
                  <label class="col-form-label">{{lang["media"]}} *</label>
                  <upload
                    :key="componentKey"
                    v-if="media != ''"
                    :src-name="mediaName"
                    :src-img="media"
                    do-upload="true"
                    box-height="200"
                    return-name="mediaName"
                    input-name="file"
                    bucket-key="uploads/builder/body"
                    acceptable=".png,.jpg,.jpeg,.mov,.mp4,.avi"
                  ></upload>
                </div>
                <div class="form-group col-xl-12 col-md-12">
                  <!-- Media align -->
                  <label class="col-form-label">{{lang["media-align"]}}</label>
                  <el-select v-model="mediaAlign" name="mediaAlign">
                    <el-option label="left" value="left"></el-option>
                    <el-option label="right" value="right"></el-option>
                    <el-option label="top" value="top"></el-option>
                    <el-option label="bottom" value="bottom"></el-option>
                  </el-select>
                </div>
              </div>
            </el-tab-pane>

            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-document"></i>
                {{lang["header"]}}
              </span>
              <div class="form-row" :class="activeHeader == false ? 'disabled' : ''">
                <div class="form-group col-xl-12 col-md-12">
                  <!-- Header -->
                  <label class="col-form-label">{{lang["header"]}}</label>
                  <el-input
                    :disabled="activeHeader == false ? true : false "
                    name="header"
                    v-model="header"
                  ></el-input>
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
                <div class="form-group col-xl-12 col-md-12">
                  <!-- SubHeader -->
                  <label class="col-form-label">{{lang["sub-header"]}}</label>
                  <el-input
                    :disabled="activeSubHeader == false ? true : false "
                    name="subHeader"
                    v-model="subHeader"
                  ></el-input>
                </div>
              </div>
              <hr />
              <el-alert :title="lang['disable-section-message']" type="info" show-icon></el-alert>
              <br />
              <el-switch @change="showSubHeader()" v-model="activeSubHeader"></el-switch>
            </el-tab-pane>

            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-document"></i>
                {{lang["content"]}}
              </span>
              <div class="form-row" :class="activeContent == false ? 'disabled' : ''">
                <div class="form-group col-xl-12 col-md-12">
                  <!-- Content -->
                  <label class="col-form-label">{{lang["content"]}}</label>
                  <el-input
                    type="textarea"
                    :disabled="activeContent == false ? true : false "
                    name="content"
                    v-model="content"
                  ></el-input>
                </div>
              </div>
              <hr />
              <el-alert :title="lang['disable-section-message']" type="info" show-icon></el-alert>
              <br />
              <el-switch @change="showContent()" v-model="activeContent"></el-switch>
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
                  <el-select v-model="buttonTarget" name="buttonTarget">
                    <el-option value="_self" label="Same window"></el-option>
                    <el-option value="_blank" label="New window"></el-option>
                  </el-select>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta style -->
                  <label class="col-form-label">{{lang["button-style"]}} *</label>
                  <el-select v-model="buttonStyle" name="buttonStyle">
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
                type="primary"
              >{{lang["save-button"]}}</el-button>
            </div>
          </div>
        </form>
        <helper-progress></helper-progress>
      </el-dialog>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import Upload from "@/components/helper/HelperUpload";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import HelperProgress from "@/components/helper/HelperProgress.vue";

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
      textAndMediaId: "",
      header: "",
      content: "",
      media: "",
      mediaName: "",
      mediaAlign: "",
      buttonId: "",
      buttonAlign: "",
      subHeader: "",
      textAlign: "",
      title: "",
      buttonTitle: "",
      buttonUrl: "",
      buttonTarget: "",
      buttonColor: "",
      buttonColorHover: "",
      buttonStyle: "",
      loading: false,
      loadingButton: false,
      modal: false,
      activeHeader: true,
      activeSubHeader: true,
      activeButton: true,
      activeContent: true,
      sectionId: "",
      componentKey: 0
    };
  },
  mounted() {
    eventBus.$on(
      "edit-text-and-media",
      function(sectionId) {
        this.getTextAndMedia(sectionId);
        this.modal = true;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    forceRerender: function() {
      this.componentKey += 1;
    },
    editTextAndMedia: function() {
      this.loadingButton = true;
      var form = document.getElementById("form-text-and-media");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "site-elements/TextAndMedia",
        "edit"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          eventBus.$emit("new-text-and-media-change");
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
    showContent: function() {
      if (this.activeContent == false) {
        this.content = "";
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

    getTextAndMedia: function(sectionId) {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "site-elements/TextAndMedia",
        "get"
      );
      var formData = new FormData();
      formData.set("sectionId", sectionId);
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.textAndMediaId = response.data[0]["id"];
          this.header = response.data[0]["header"];
          this.content = response.data[0]["content"];
          this.mediaName = response.data[0]["media"];
          this.media =
            this.getUrlToContents() + "builder/body/" + this.mediaName + "";
          this.mediaAlign = response.data[0]["media_align"];
          this.buttonId = response.data[0]["button_id"];
          this.buttonAlign = response.data[0]["button_align"];
          this.subHeader = response.data[0]["subheader"];
          this.textAlign = response.data[0]["text_align"];
          this.buttonTitle = response.data[0]["title"];
          this.buttonUrl = response.data[0]["url"];
          this.buttonTarget = response.data[0]["target"];
          this.buttonColor = response.data[0]["color"];
          this.buttonColorHover = response.data[0]["color_hover"];
          this.buttonstyle = response.data[0]["style"];

          if (response.data[0]["header"] == null) {
            this.activeHeader = false;
          }

          if (response.data[0]["subheader"] == null) {
            this.activeSubHeader = false;
          }

          if (response.data[0]["title"] == null) {
            this.activeButton = false;
          }

          if (response.data[0]["content"] == null) {
            this.activeContent = false;
          }

          this.forceRerender();
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
