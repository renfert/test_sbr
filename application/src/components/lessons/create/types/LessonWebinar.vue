<template>
  <!--  Modal new lesson -->
  <div>
    <el-dialog
      :visible.sync="modalCreateWebinar"
      :title="lang['create-new-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-webinar" @submit.prevent="create()">
        <div class="form-row">
          <!-- Module id -->
          <input type="number" class="hide" name="moduleId" :value="moduleId" />
          <!-- Type lesson -->
          <input type="text" class="hide" name="type_mylesson_id" value="6" />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{lang["name"]}} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson url -->
            <label class="col-form-label">{{lang["url"]}} *</label>
            <el-input required v-model="url" name="url"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson description -->
            <label class="col-form-label">{{lang["description"]}}</label>
            <el-input type="textarea" name="description" rows="3" v-model="description"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson date -->
            <label class="col-form-label">{{lang["date"]}} *</label>
            <div class="block">
              <el-date-picker
                required
                v-model="date"
                type="date"
                name="date"
                format="yyyy/MM/dd"
                value-format="yyyy-MM-dd"
                placeholder="Pick a day"
              ></el-date-picker>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson Schedule -->
            <label class="col-form-label">{{lang["schedule"]}} *</label>
            <div class="block">
              <el-time-select
                required
                v-model="schedule"
                name="time"
                :picker-options="{
                                start: '00:00',
                                end: '23:30'
                            }"
                placeholder="Select time"
              ></el-time-select>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              class="sbr-primary"
              v-loading="loading"
              native-type="submit"
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
  props: ["module-id"],
  data: () => {
    return {
      name: "",
      modalCreateWebinar: false,
      loading: false,
      url: "",
      date: "",
      description: "",
      schedule: ""
    };
  },
  mounted() {
    /* Get new video click event */
    eventBus.$on(
      "new-webinar",
      function() {
        this.modalCreateWebinar = true;
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    /* Create a new lesson */
    create: function() {
      this.loading = true;
      var form = document.getElementById("form-lesson-webinar");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "lesson",
        "create"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
          this.successMessage();
          this.actionsToBePerformedAfterRegistration();
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    actionsToBePerformedAfterRegistration() {
      this.name = "";
      this.url = "";
      this.description = "";
      this.date = "";
      this.schedule = "";
      this.modalCreateWebinar = false;
      eventBus.$emit("new-lesson");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.modal {
  z-index: 100 !important;
}
</style>
