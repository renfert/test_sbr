<template>
  <div>
    <div>
      <el-dialog
        :visible.sync="modal"
        title="Banner"
        center
        width="40%"
        top="5vh"
      >
        <form id="form-banner" @submit.prevent="editBanner()">
          <!-- Banner id -->
          <input
            class="hide"
            type="number"
            name="bannerId"
            v-model="bannerId"
          />
          <!-- Cta id -->
          <input
            type="number"
            name="buttonId"
            class="hide"
            v-model="buttonId"
          />
          <el-tabs type="border-card">
            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-picture-outline"></i>
                {{ lang['image'] }}
              </span>
              <div class="form-row">
                <div class="form-group col-xl-12 col-md-12">
                  <!-- Banner image  -->
                  <label class="col-form-label">{{ lang['image'] }} *</label>
                  <upload
                    :key="componentKey"
                    v-if="bannerImage != ''"
                    :src-name="bannerImageName"
                    :src-img="bannerImage"
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
                {{ lang['header'] }}
              </span>
              <div
                class="form-row"
                :class="activeHeader == false ? 'disabled' : ''"
              >
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Header -->
                  <label class="col-form-label">{{ lang['header'] }} *</label>
                  <el-input
                    :disabled="activeHeader == false ? true : false"
                    name="header"
                    v-model="header"
                  ></el-input>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Header color -->
                  <label class="col-form-label"
                    >{{ lang['header-color'] }} *</label
                  >
                  <div class="block">
                    <input
                      name="headerColor"
                      v-model="headerColor"
                      type="text"
                      class="hide"
                    />
                    <el-color-picker
                      name="headerColor"
                      v-model="headerColor"
                    ></el-color-picker>
                  </div>
                </div>
              </div>
              <hr />
              <el-alert
                :title="lang['disable-section-message']"
                type="info"
                show-icon
              ></el-alert>
              <br />
              <el-switch
                @change="showHeader()"
                v-model="activeHeader"
              ></el-switch>
            </el-tab-pane>

            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-document-copy"></i>
                {{ lang['sub-header'] }}
              </span>
              <div
                class="form-row"
                :class="activeSubHeader == false ? 'disabled' : ''"
              >
                <div class="form-group col-xl-6 col-md-6">
                  <!-- SubHeader -->
                  <label class="col-form-label"
                    >{{ lang['sub-header'] }} *</label
                  >
                  <el-input
                    :disabled="activeSubHeader == false ? true : false"
                    name="subHeader"
                    v-model="subHeader"
                  ></el-input>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- SubHeader color -->
                  <label class="col-form-label"
                    >{{ lang['sub-header-color'] }} *</label
                  >
                  <div class="block">
                    <input
                      name="subHeaderColor"
                      v-model="subHeaderColor"
                      type="text"
                      class="hide"
                    />
                    <el-color-picker
                      name="subHeaderColor"
                      v-model="subHeaderColor"
                    ></el-color-picker>
                  </div>
                </div>
              </div>
              <hr />
              <el-alert
                :title="lang['disable-section-message']"
                type="info"
                show-icon
              ></el-alert>
              <br />
              <el-switch
                @change="showSubHeader()"
                v-model="activeSubHeader"
              ></el-switch>
            </el-tab-pane>
            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-s-opportunity"></i>
                {{ lang['button'] }}
              </span>
              <div
                class="form-row"
                :class="activeButton == false ? 'disabled' : ''"
              >
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta title -->
                  <label class="col-form-label"
                    >{{ lang['button-title'] }} *</label
                  >
                  <el-input
                    :disabled="activeButton == false ? true : false"
                    name="buttonTitle"
                    v-model="buttonTitle"
                  ></el-input>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta url -->
                  <label class="col-form-label"
                    >{{ lang['button-url'] }} *</label
                  >
                  <el-input name="buttonUrl" v-model="buttonUrl"></el-input>
                </div>
              </div>
              <div
                class="form-row"
                :class="activeButton == false ? 'disabled' : ''"
              >
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta target -->
                  <label class="col-form-label"
                    >{{ lang['button-target'] }} *</label
                  >
                  <el-select name="buttonTarget" v-model="buttonTarget">
                    <el-option value="_self" label="Same window"></el-option>
                    <el-option value="_blank" label="New window"></el-option>
                  </el-select>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta style -->
                  <label class="col-form-label"
                    >{{ lang['button-style'] }} *</label
                  >
                  <el-select name="buttonStyle" v-model="buttonStyle">
                    <el-option value="plain" label="Plain"></el-option>
                    <el-option value="rounded" label="Rounded"></el-option>
                  </el-select>
                </div>
              </div>
              <hr />
              <div
                class="form-row"
                :class="activeButton == false ? 'disabled' : ''"
              >
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta bg color -->
                  <label class="col-form-label"
                    >{{ lang['button-bg-color'] }} *</label
                  >
                  <div class="block">
                    <input
                      name="buttonColor"
                      type="text"
                      class="hide"
                      v-model="buttonColor"
                    />
                    <el-color-picker v-model="buttonColor"></el-color-picker>
                  </div>
                </div>
                <div class="form-group col-xl-6 col-md-6">
                  <!-- Cta hover color -->
                  <label class="col-form-label"
                    >{{ lang['button-hover-color'] }} *</label
                  >
                  <div class="block">
                    <input
                      name="buttonHoverColor"
                      type="text"
                      class="hide"
                      v-model="buttonColorHover"
                    />
                    <el-color-picker
                      v-model="buttonColorHover"
                    ></el-color-picker>
                  </div>
                </div>
              </div>
              <hr />
              <el-alert
                :title="lang['disable-section-message']"
                type="info"
                show-icon
              ></el-alert>
              <br />
              <el-switch
                @change="showButton()"
                v-model="activeButton"
              ></el-switch>
            </el-tab-pane>
          </el-tabs>
          <br />
          <div class="form-row">
            <div class="form-group col-xl-12 col-md-12">
              <el-button
                class="sbr-primary"
                native-type="submit"
                v-loading="loadingButton"
                >{{ lang['save-button'] }}</el-button
              >
            </div>
          </div>
        </form>
      </el-dialog>
    </div>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import Upload from '@/components/helper/HelperUpload';
import HelperProgress from '@/components/helper/HelperProgress.vue';

import { eventBus } from '@/components/site/App';
import { mapState } from 'vuex';

export default {
  components: {
    Upload,
    HelperProgress
  },
  data: () => {
    return {
      modules: null,
      bannerId: '',
      header: '',
      subHeader: '',
      headerColor: '',
      subHeaderColor: '',
      loadingButton: false,
      modal: false,
      buttonId: '',
      buttonTitle: '',
      buttonUrl: '',
      buttonTarget: '',
      buttonColor: '',
      buttonColorHover: '',
      buttonStyle: '',
      activeHeader: true,
      activeSubHeader: true,
      activeButton: true,
      sectionId: '',
      bannerImage: '',
      bannerImageName: '',
      componentKey: 0
    };
  },
  mounted() {
    eventBus.$on('edit-banner', (sectionId) => {
      this.getBanner(sectionId);
      this.modal = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    forceRerender() {
      this.componentKey += 1;
    },
    editBanner() {
      this.loadingButton = true;
      const form = document.getElementById('form-banner');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'site-elements/banner',
        'editBanner'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          eventBus.$emit('new-banner-change');
          this.$successMessage();
          this.modal = false;
          this.loadingButton = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },

    showHeader() {
      if (this.activeHeader === false) {
        this.header = '';
      }
    },
    showSubHeader() {
      if (this.activeSubHeader === false) {
        this.subHeader = '';
      }
    },
    showButton() {
      if (this.activeButton === false) {
        this.buttonTitle = '';
      }
    },

    getBanner(sectionId) {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'site-elements/banner',
        'getBanner'
      );
      const formData = new FormData();
      formData.set('sectionId', sectionId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.bannerId = response.data[0].banner_id;
          this.buttonId = response.data[0].button_id;
          this.buttonTitle = response.data[0].title;
          this.buttonColor = response.data[0].color;
          this.buttonColorHover = response.data[0].color_hover;
          this.headerColor = response.data[0].header_color;
          this.subHeaderColor = response.data[0].subheader_color;
          this.buttonStyle = response.data[0].style;
          this.buttonUrl = response.data[0].url;
          this.buttonTarget = response.data[0].target;
          this.header = response.data[0].header;
          this.subHeader = response.data[0].subheader;
          this.bannerImageName = response.data[0].image;
          this.bannerImage =
            this.$getUrlToContents() +
            'builder/body/' +
            this.bannerImageName +
            '';

          if (response.data[0].header == null) {
            this.activeHeader = false;
          }

          if (response.data[0].subheader == null) {
            this.activeSubHeader = false;
          }

          if (response.data[0].title == null) {
            this.activeButton = false;
          }
          this.forceRerender();
        },
        () => {
          this.$errorMessage();
        }
      );
    },

    openEditModuleModal(id, title, required, date) {
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
