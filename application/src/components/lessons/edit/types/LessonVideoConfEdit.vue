<template>
  <!--  Modal new lesson -->
  <div>
    <el-dialog :visible.sync="modalEditVideoConf" :title="lang['edit-lesson']" center top="5vh">
      <form id="form-lesson-videoconf-edit" @submit.prevent="edit()">
        <div class="form-row">
          <!-- Lesson id -->
          <input type="number" class="hide" name="lessonId" :value="lessonId" />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{lang["name"]}} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson description -->
            <label class="col-form-label">{{lang["description"]}} *</label>
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
              v-loading="loading"
              native-type="submit"
              class="sbr-primary"
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
  data: () => {
    return {
      name: "",
      modalEditVideoConf: false,
      loading: false,
      url: "",
      date: "",
      description: "",
      schedule: "",
      lessonId: ""
    };
  },
  mounted() {
    eventBus.$on(
      "edit-lesson-5",
      function(response) {
        this.modalEditVideoConf = true;
        this.lessonId = response[0]["id"];
        this.name = response[0]["title"];
        this.url = response[0]["url"];
        this.date = response[0]["date"];
        this.description = response[0]["description"];
        this.schedule = response[0]["time"];
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    /* Edit a lesson */
    edit: function() {
      this.loading = true;
      var form = document.getElementById("form-lesson-videoconf-edit");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "edit");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
          this.successMessage();
          this.actionsToBePerformedAfterEdit();
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    actionsToBePerformedAfterEdit() {
      this.name = "";
      this.url = "";
      this.description = "";
      this.date = "";
      this.schedule = "";
      this.modalEditVideoConf = false;
      eventBus.$emit("new-lesson");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
