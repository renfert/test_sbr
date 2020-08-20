<template>
  <!--  Modal new module -->
  <div>
    <el-dialog
      :visible.sync="modalCreateModule"
      :title="lang['create-new-module']"
      center
      top="5vh"
    >
      <form id="form-create-module" @submit.prevent="createModule()" v-loading="loading">
        <div class="form-row">
          <!-- Course id -->
          <input type="number" class="hide" name="courseId" v-model="courseId" />

          <div class="form-group col-xl-12 col-md-12">
            <!-- Module name -->
            <label class="col-form-label">{{lang["name"]}} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <!-- Module release date -->
            <label class="col-form-label">{{lang["start-date"]}} *</label>
            <br />
            <el-date-picker
              v-model="releaseDate"
              name="date"
              type="date"
              format="yyyy/MM/dd"
              value-format="yyyy-MM-dd"
              placeholder="Pick a day"
            ></el-date-picker>
          </div>
          <div class="form-group col-xl-6 col-md-6">
            <!-- Module requirement -->
            <label style="margin-bottom:4%;" class="col-form-label">{{lang["required-module"]}}</label>
            <br />
            <div class="input-group">
              <el-switch name="required" v-model="required" active-color="#09dfff"></el-switch>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              class="sbr-primary"
              native-type="submit"
              type="primary"
              size="medium"
            >{{lang["save-button"]}}</el-button>
          </div>
        </div>
      </form>
    </el-dialog>
  </div>
  <!-- End  modal new module -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      name: "",
      releaseDate: "",
      required: false,
      courseId: "",
      modalCreateModule: false,
      loading: false
    };
  },
  mounted() {
    /* Get course id */
    eventBus.$on(
      "new-course",
      function(response) {
        this.courseId = response;
      }.bind(this)
    );

    /* Get new module click event */
    eventBus.$on(
      "open-module-modal",
      function() {
        this.modalCreateModule = true;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    createModule: function() {
      this.loading = true;
      var form = document.getElementById("form-create-module");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "module",
        "create"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.successMessage();
          this.actionsToBePerformedAfterRegistration(response.data);
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }
      );
    },
    actionsToBePerformedAfterRegistration(moduleId) {
      this.name = "";
      this.releaseDate = "";
      this.modalCreateModule = false;
      eventBus.$emit("new-module", moduleId);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
