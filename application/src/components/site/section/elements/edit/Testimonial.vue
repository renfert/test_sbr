<template>
  <div>
    <div v-for="element in testimonialArray" :key="element.id">
      <el-dialog :visible.sync="modal" :title="lang['testimonial']" center width="40%" top="5vh">
        <form>
          <input type="number" class="hide" v-model="testimonialId" />
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
                  <label class="col-form-label">{{lang["header"]}} *</label>
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
                  <label class="col-form-label">{{lang["sub-header"]}} *</label>
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

            <!-- Persons -->
            <el-tab-pane>
              <span slot="label">
                <i class="el-icon-user"></i>
                {{lang["persons"]}}
              </span>
              <div class="form-row">
                <div class="form-group col-xl-12 col-md-12">
                  <persons-list-to-edit :testimonial-id="element.id"></persons-list-to-edit>
                </div>
              </div>
            </el-tab-pane>
          </el-tabs>
          <br />
          <div class="form-row">
            <div class="form-group col-xl-12 col-md-12">
              <el-button
                v-loading="loadingButton"
                @click.prevent="editTestimonial()"
                native-type="submit"
                class="sbr-primary"
              >{{lang["save-button"]}}</el-button>
              <el-button
                class="sbr-purple"
                v-loading="loadingButton"
                @click.prevent="addNewPerson(element.id)"
                native-type="submit"
              >{{lang["add-new-testimonial"]}}</el-button>
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
import PersonsListToEdit from "@/components/persons/PersonsListToEdit";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/site/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  components: {
    PersonsListToEdit
  },
  mixins: [domains, alerts],
  data: () => {
    return {
      loadingButton: false,
      banner: [],
      header: "",
      subHeader: "",
      testimonialArray: [],
      testimonialId: "",
      modal: false,
      activeHeader: true,
      activeSubHeader: true
    };
  },
  mounted() {
    eventBus.$on(
      "edit-testimonial",
      function(sectionId) {
        this.getTestimonial(sectionId);
        this.modal = true;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    editTestimonial: function() {
      this.loadingButton = true;
      var formData = new FormData();
      formData.set("header", this.header);
      formData.set("subHeader", this.subHeader);
      formData.set("testimonialId", this.testimonialId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "site-elements/testimonial",
        "edit"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          eventBus.$emit("new-testimonial-change");
          this.modal = false;
          this.loadingButton = false;
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    addNewPerson(id) {
      this.loadingButton = true;
      var formData = new FormData();
      formData.set("testimonialId", id);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "persons",
        "create"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          eventBus.$emit("edit-person");
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

    getTestimonial: function(sectionId) {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "site-elements/testimonial",
        "get"
      );
      var formData = new FormData();
      formData.set("sectionId", sectionId);
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.testimonialArray = response.data;
          this.header = response.data[0]["header"];
          this.subHeader = response.data[0]["subheader"];
          this.testimonialId = response.data[0]["id"];

          if (response.data[0]["header"] == null) {
            this.activeHeader = false;
          }

          if (response.data[0]["subheader"] == null) {
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
