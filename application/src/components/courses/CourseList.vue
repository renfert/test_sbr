<template>
  <div class="col-12">
    <div class="card-box table-responsive mt-5" v-if="courseList != null">
      <div class="dropdown pull-right">
        <a
          @click="changeCourseVisualization()"
          href="javascript:void(0)"
          class="dropdown-toggle arrow-none card-drop"
          data-toggle="dropdown"
          aria-expanded="false"
        >
          <i v-if="courseVisualization == 'list'" class="mdi mdi-view-list mdi-36px"></i>
          <i v-else class="mdi mdi-table mdi-36px"></i>
        </a>
      </div>
      <course-list-view v-if="courseVisualization == 'list'"></course-list-view>
      <course-table-view v-else></course-table-view>
    </div>

    <div class="row mb-5 mt-5" v-else>
      <div class="col-12 text-center">
        <img class="no-results-img" src="@/assets/img/general/ux/no_courses.png" alt="No persons" />
        <h4 class="no-results-text">{{lang["no-courses-found"]}}</h4>
      </div>
    </div>
  </div>
  <!-- End col-12 -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import CourseListView from "@/components/courses/views/CourseListView";
import CourseTableView from "@/components/courses/views/CourseTableView";

import { eventBus } from "@/components/courses/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  components: {
    CourseListView,
    CourseTableView
  },
  computed: {
    ...mapState(["lang"])
  },
  data: function() {
    return {
      titles: [{ prop: "title", label: "Title" }],
      courseList: [],
      courseVisualization: "list"
    };
  },
  created() {
    this.updateCourseListArray();
  },
  mounted() {
    eventBus.$on(
      "course-deleted",
      function() {
        this.updateCourseListArray();
      }.bind(this)
    );
  },
  methods: {
    changeCourseVisualization: function() {
      this.courseVisualization == "list"
        ? (this.courseVisualization = "table")
        : (this.courseVisualization = "list");
    },
    editCourse: function(id) {
      window.location.href = "editcourse/" + id + "";
    },
    viewCourse: function(id) {
      window.location.href = "viewcourse/" + id + "";
    },
    updateCourseListArray() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "course",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          this.courseList = response.data;
        },
        // Failure callback
        function() {
          this.errorMessage();
        }
      );
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
