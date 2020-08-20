<template>
  <div>
    <div class="card-box mt-5" v-if="programList != null">
      <div class="dropdown pull-right">
        <a
          @click="changeProgramVisualization()"
          href="javascript:void(0)"
          class="dropdown-toggle arrow-none card-drop"
          data-toggle="dropdown"
          aria-expanded="false"
        >
          <i v-if="programVisualization == 'list'" class="mdi mdi-view-list mdi-36px"></i>
          <i v-else class="mdi mdi-table mdi-36px"></i>
        </a>
      </div>

      <program-list-view :program-list="programList" v-if="programVisualization == 'list'"></program-list-view>
      <program-table-view v-else></program-table-view>
    </div>

    <div class="row mb-5 mt-5" v-else>
      <div class="col-12 text-center">
        <img class="no-results-img" src="@/assets/img/general/ux/no_programs.png" alt="No programs" />
        <h4 class="no-results-text">{{lang["no-programs-found"]}}</h4>
      </div>
    </div>
  </div>
  <!-- End col-12 -->
</template>

<script>
import ProgramListView from "@/components/programs/views/ProgramListView";
import ProgramTableView from "@/components/programs/views/ProgramTableView";

import { mapState } from "vuex";

export default {
  components: {
    ProgramListView,
    ProgramTableView
  },
  props: ["program-list"],
  data: function() {
    return {
      programVisualization: "list"
    };
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    changeProgramVisualization: function() {
      this.programVisualization == "list"
        ? (this.programVisualization = "table")
        : (this.programVisualization = "list");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.image-no-results {
  width: 15%;
}
.box-no-results {
  background-color: #fcfcfc;
}
.text-no-results {
  margin-top: 25%;
}
</style>
