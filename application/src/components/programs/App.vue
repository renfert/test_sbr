<template >
  <div class="content-page">
    <div v-if="userRole != 3">
      <program-create :program-list="programList" :total-programs="numberTotalOfProgramsCreated"></program-create>
    </div>

    <div>
      <program-list :program-list="programList"></program-list>
    </div>
  </div>
</template>

<script>
import ProgramCreate from "@/components/programs/ProgramCreate.vue";
import ProgramList from "@/components/programs/ProgramList.vue";
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VueHead from "vue-head";
export const eventBus = new Vue();

import { mapState } from "vuex";

Vue.use(VueHead);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      programList: null,
      numberTotalOfProgramsCreated: ""
    };
  },
  computed: {
    ...mapState(["userRole"])
  },
  mounted() {
    this.getPrograms();
    eventBus.$on(
      "program-deleted",
      function() {
        this.getPrograms();
      }.bind(this)
    );
  },
  methods: {
    getPrograms: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "program",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          this.programList = response.data;
          this.numberTotalOfProgramsCreated = response.data.length;
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  },
  head: {
    title: {
      inner: "Programs"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  },
  components: {
    ProgramCreate,
    ProgramList
  }
};
</script>

<style scoped>
</style>
