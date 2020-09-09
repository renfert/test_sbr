<template>
  <div
    class="card-box table-responsive mt-5 pr-0 pl-0"
    v-if="courseList != null"
  >
    <div class="dropdown pull-right">
      <a
        @click="changeCourseVisualization()"
        href="javascript:void(0)"
        class="dropdown-toggle arrow-none card-drop"
        data-toggle="dropdown"
        aria-expanded="false"
      >
        <i
          v-if="courseVisualization == 'list'"
          class="mdi mdi-view-list mdi-36px pr-4"
        ></i>
        <i v-else class="mdi mdi-table mdi-36px pr-4"></i>
      </a>
    </div>
    <course-list-view v-if="courseVisualization == 'list'"></course-list-view>
    <course-table-view v-else></course-table-view>
  </div>

  <div class="row mb-5 mt-5" v-else>
    <div class="col-12 text-center">
      <img
        class="no-results-img"
        src="@/assets/img/general/ux/no_courses.png"
        alt="No persons"
      />
      <h4 class="no-results-text">{{ lang['no-courses-found'] }}</h4>
    </div>
  </div>
</template>

<script>
import CourseListView from '@/components/courses/views/CourseListView';
import CourseTableView from '@/components/courses/views/CourseTableView';

import { eventBus } from '@/components/courses/App';
import { mapState } from 'vuex';

export default {
  components: {
    CourseListView,
    CourseTableView
  },
  computed: {
    ...mapState(['lang'])
  },
  data: () => {
    return {
      courseList: [],
      courseVisualization: 'list'
    };
  },
  created() {
    this.getCourses();
  },
  mounted() {
    eventBus.$on('course-deleted', () => {
      this.getCourses();
    });
  },
  methods: {
    changeCourseVisualization() {
      this.courseVisualization === 'list'
        ? (this.courseVisualization = 'table')
        : (this.courseVisualization = 'list');
    },
    getCourses() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.courseList = response.data;
        },
        () => {
          this.$errorMessage();
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
