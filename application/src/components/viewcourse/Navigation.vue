<template>
  <el-aside
    class="leftside-viewcourse"
    :class="mobile"
    width="350x"
    style="background-color: #545c64"
  >
    <el-menu
      style="width: 351px"
      background-color="#545c64"
      text-color="#fff"
      active-text-color="#09dfff"
      default-active="lesson00"
      ref="menu"
    >
      <div v-for="(element, index) in modules" :key="index">
        <el-submenu
          :disabled="element.disable"
          v-if="element.daysDiff <= 0"
          :id="'module' + index"
          :index="'module' + index"
        >
          <template slot="title">
            <i class="el-icon-menu"></i>
            <span>{{ element.title }}</span>
          </template>

          <lesson-list-to-view-course
            :module-id="element.id"
            :module-index="index"
          ></lesson-list-to-view-course>
        </el-submenu>

        <el-tooltip
          v-else
          class="item"
          effect="dark"
          :content="lang['module-available-in'] + element.release_date"
          placement="top"
        >
          <el-submenu
            :disabled="true"
            :id="'module' + index"
            :index="'module' + index"
          >
            <template slot="title">
              <i class="el-icon-date"></i>
              <span>{{ element.title }}</span>
            </template>
          </el-submenu>
        </el-tooltip>
      </div>
    </el-menu>
  </el-aside>
</template>

<script>
import LessonListToViewCourse from '@/components/viewcourse/LessonListToViewCourse';

import { eventBus } from '@/components/viewcourse/App';
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      logo: '',
      title: '',
      modules: [],
      courseId: '',
      currentDate: '',
      mobile: 'retracted',
      loading: false
    };
  },
  components: {
    LessonListToViewCourse
  },
  created() {
    this.courseId = this.$route.params.id;
    this.getCompanyLogo();
    this.getCourse(this.courseId);
    this.getModules(this.courseId);
  },
  computed: {
    ...mapState(['lang'])
  },
  mounted() {
    eventBus.$on('open-menu', (response) => {
      this.openmenu(response);
    });

    eventBus.$on('update-modules', () => {
      this.getModules(this.courseId);
    });

    eventBus.$on('change-leftbar-class', () => {
      this.mobile === 'retracted'
        ? (this.mobile = 'opened')
        : (this.mobile = 'retracted');
    });
  },
  methods: {
    getCompanyLogo() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.logo = response.data.logo;
      });
    },
    openmenu(index) {
      this.$refs.menu.open(index);
    },

    getCourse(courseId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'get'
      );
      formData.set('courseId', courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then((response) => {
        this.title = response.data.title;
      });
    },
    getModules(courseId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'module',
        'listing'
      );
      formData.set('courseId', courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then((response) => {
        this.modules = response.data;
      });
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.el-submenu {
  border-bottom: 1px solid rgb(67, 74, 80);
}

.course-title {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.1em;
}

.el-submenu__title * {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.1em;
  border: 0;
  font-weight: normal;
  line-height: 1;
  list-style: none;
  margin: 0;
  padding: 0;
  position: relative;
  text-decoration: none;
}

.progress {
  margin-bottom: 0px !important;
}

.col-2 {
  padding: 0px !important;
}
</style>
