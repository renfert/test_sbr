<template>
  <el-aside
    class="leftside-viewcourse"
    :class="mobile"
    style="background-color: #545c64; width: 350px"
  >
    <el-menu
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
          class="submenu-course"
        >
          <template slot="title">
            <i class="el-icon-menu"></i>
            <span :title="element.title">{{ element.title }}</span>
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
              <table>
                <i class="el-icon-date"></i>
                <span :title="element.title">{{ element.title }}</span>
              </table>
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
      loading: false,
      eventBusTemplate: eventBus
    };
  },
  components: {
    LessonListToViewCourse
  },
  created() {
    this.courseId = this.$route.params.id;
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
<style lang="css" scoped>
.el-submenu {
  border-bottom: 1px solid rgb(67, 74, 80);
  word-break: break-word;
  text-overflow: ellipsis;
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
  list-style: none;
  margin: 0;
  padding: 5px;
  text-decoration: none;
  overflow-scrolling: touch;
  z-index: 1111 !important;
}

.progress {
  margin-bottom: 0px !important;
}

.col-2 {
  padding: 0px !important;
}

.leftside-viewcourse {
  height: 100%;
  overflow: -moz-scrollbars-vertical;
  overflow-y: auto;
  z-index: 2;
  position: static;
}
@media only screen and (max-width: 768px) {
  .leftside-viewcourse.opened {
    -webkit-animation: slide 2s forwards;
    -webkit-animation-delay: 2s;
    animation-delay: 2s;
    animation: hideLeftBar 2s;
    z-index: 1000 !important;
    position: absolute;
  }
  .leftside-viewcourse.retracted {
    -webkit-animation: slide 2s forwards;
    -webkit-animation-delay: 2s;
    animation-delay: 2s;
    animation: hideLeftBar 2s;
    z-index: 1000 !important;
  }
}

@keyframes hideLeftBar {
  0% {
    transform: translateX(-100px);
  }
  100% {
    transform: translateX(0px);
  }
}

.el-submenu__title {
  white-space: initial;
  /*  height: 56px;*/
  /*  line-height: 56px;*/
  /*  position: relative;*/
  /*  -webkit-box-sizing: border-box;*/
  /*  !* white-space: nowrap; *!*/
  /*  list-style: none;*/
  /*  overflow-wrap: break-word;*/
  /*  !* list-style: none; *!*/
  /*  display: inline-table;*/
  /*  !* overflow: hidden; *!*/
  /*  height: 56px;*/
  /*  line-height: 56px;*/
  /*  position: relative;*/
  /*  -webkit-box-sizing: border-box;*/
  /*  !* text-overflow: clip; *!*/
  /*  line-height: 1.2;*/
  /*  width: 100%;*/
  /*  -webkit-line-clamp: 2;*/
  /*  -webkit-box-orient: vertical;*/
  /*  overflow: hidden;*/
  /*  margin-left: auto;*/
  /*  margin-right: auto;*/
  /*  padding: 15px 0px 15px 5px;*/
}
</style>
