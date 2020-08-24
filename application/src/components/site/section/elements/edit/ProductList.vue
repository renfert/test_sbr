<template>
  <div>
    <div>
      <el-dialog :visible.sync="modal" title="Edit product list" center width="40%" top="5vh">
        <form @submit.prevent="editProductList()">
          <input type="number" class="hide" v-model="productListId" />
          <el-tabs type="border-card">
            <!-- Header -->
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

            <!-- Subheader -->
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

            <!-- Number of courses -->
            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-s-management"></i>
                {{lang["courses"]}}
              </span>
              <div class="form-row">
                <div class="form-group col-xl-12 col-md-12">
                  <label class="col-form-label">{{lang["number-of-courses-to-be-listed"]}}</label>
                  <br />
                  <el-input-number name="limitListOfCourses" v-model="limitListOfCourses"></el-input-number>
                </div>
              </div>
            </el-tab-pane>
          </el-tabs>
          <br />
          <div class="form-row">
            <div class="form-group col-xl-6 col-md-6">
              <el-button
                class="sbr-primary"
                v-loading="loadingButton"
                native-type="submit"
              >{{lang["save-button"]}}</el-button>
            </div>
          </div>
        </form>
      </el-dialog>
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

import { eventBus } from "@/components/site/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      modal: false,
      loadingButton: false,
      header: "",
      subHeader: "",
      productListId: "",
      limitListOfCourses: "",
      activeHeader: true,
      activeSubHeader: true
    };
  },
  mounted() {
    eventBus.$on(
      "edit-product-list",
      function(sectionId) {
        this.getProductList(sectionId);
        this.modal = true;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    editProductList: function() {
      this.loadingButton = true;
      var formData = new FormData();
      formData.set("productListId", this.productListId);
      formData.set("header", this.header);
      formData.set("subHeader", this.subHeader);
      formData.set("limitListOfCourses", this.limitListOfCourses);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "site-elements/productList",
        "edit"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          eventBus.$emit("new-product-list-change");
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

    getProductList: function(sectionId) {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "site-elements/productList",
        "get"
      );
      var formData = new FormData();
      formData.set("sectionId", sectionId);
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.productListId = response.data["productList"][0]["id"];
          this.header = response.data["productList"][0]["header"];
          this.subHeader = response.data["productList"][0]["subheader"];
          this.limitListOfCourses =
            response.data["productList"][0]["number_of_products"];

          if (response.data["productList"][0]["header"] == null) {
            this.activeHeader = false;
          }

          if (response.data["productList"][0]["subheader"] == null) {
            this.activeSubHeader = false;
          }
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

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.disabled {
  opacity: 0.2;
}
</style>
