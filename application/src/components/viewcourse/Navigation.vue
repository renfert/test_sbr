<template>
  <div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="javascript:void(0)">
      <i class="fas fa-bars"></i>
    </a>
    <nav
      :class="mobile"
      id="sidebar"
      class="sidebar-wrapper leftside-viewcourse"
    >
      <div class="sidebar-content">
        <!-- sidebar-search  -->
        <div class="sidebar-menu">
          <ul>
            <div v-for="(element, index) in modules" :key="index">
              <!-- Module available -->
              <li v-if="element.daysDiff <= 0" class="sidebar-dropdown">
                <a
                  href="javascript:void(0)"
                  :class="
                    element.disable == true && user.role == 3
                      ? 'module_block'
                      : ''
                  "
                >
                  <i
                    style="font-size: 1rem"
                    v-if="element.disable == false"
                    class="el-icon-menu"
                  ></i>
                  <i
                    style="font-size: 1rem"
                    v-if="element.disable"
                    class="el-icon-lock"
                  ></i>
                  <span class="module_title">{{ element.title }}</span>
                </a>
                <div class="sidebar-submenu">
                  <ul>
                    <lesson-list-to-view-course
                      :module-id="element.id"
                      :module-index="index"
                    ></lesson-list-to-view-course>
                  </ul>
                </div>
              </li>

              <!-- Module unavailable by date -->
              <el-tooltip
                v-else
                class="item"
                effect="dark"
                :content="lang['module-available-in'] + element.release_date"
                placement="right"
              >
                <li class="sidebar-dropdown">
                  <a href="javascript:void(0)" class="module_block">
                    <i style="font-size: 1rem" class="el-icon-date"></i>
                    <span class="module_title">{{ element.title }}</span>
                  </a>
                  <div class="sidebar-submenu">
                    <ul>
                      <lesson-list-to-view-course
                        :module-id="element.id"
                        :module-index="index"
                      ></lesson-list-to-view-course>
                    </ul>
                  </div>
                </li>
              </el-tooltip>
            </div>
          </ul>
        </div>
        <!-- sidebar-menu  -->
      </div>
      <!-- sidebar-content  -->
    </nav>
    <!-- sidebar-wrapper  -->
    <main class="wrapper-content">
      <div class="row">
        <div class="form-group col-md-8">
          <load-content></load-content>
        </div>
      </div>
    </main>
    <!-- page-content" -->
  </div>
</template>

<script>
import LessonListToViewCourse from '@/components/viewcourse/LessonListToViewCourse';

import Vue from 'vue';
import LoadScript from 'vue-plugin-load-script';
import LoadContent from '@/components/viewcourse/LoadContent';
import { eventBus } from '@/components/viewcourse/App';
import { mapState } from 'vuex';
import $ from 'jquery';

/* eslint-disable */
$(document).on('click', '.sidebar-dropdown > a', function () {
  $('.sidebar-submenu').slideUp(200);
  if ($(this).parent().hasClass('active')) {
    $('.sidebar-dropdown').removeClass('active');
    $(this).parent().removeClass('active');
  } else {
    $('.sidebar-dropdown').removeClass('active');
    $(this).next('.sidebar-submenu').slideDown(200);
    $(this).parent().addClass('active');
  }
});

Vue.use(LoadScript);

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
    LessonListToViewCourse,
    LoadContent
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
@keyframes swing {
  0% {
    transform: rotate(0deg);
  }
  10% {
    transform: rotate(10deg);
  }
  30% {
    transform: rotate(0deg);
  }
  40% {
    transform: rotate(-10deg);
  }
  50% {
    transform: rotate(0deg);
  }
  60% {
    transform: rotate(5deg);
  }
  70% {
    transform: rotate(0deg);
  }
  80% {
    transform: rotate(-5deg);
  }
  100% {
    transform: rotate(0deg);
  }
}

@keyframes sonar {
  0% {
    transform: scale(0.9);
    opacity: 1;
  }
  100% {
    transform: scale(2);
    opacity: 0;
  }
}
body {
  font-size: 0.9rem;
}
.page-wrapper .sidebar-wrapper,
.sidebar-wrapper .sidebar-brand > a,
.sidebar-wrapper .sidebar-dropdown > a:after,
.sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a:before,
.sidebar-wrapper ul li a i,
.page-wrapper .page-content,
.sidebar-wrapper .sidebar-search input.search-menu,
.sidebar-wrapper .sidebar-search .input-group-text,
.sidebar-wrapper .sidebar-menu ul li a,
#show-sidebar,
#close-sidebar {
  -webkit-transition: all 0.3s ease;
  -moz-transition: all 0.3s ease;
  -ms-transition: all 0.3s ease;
  -o-transition: all 0.3s ease;
  transition: all 0.3s ease;
}

/*----------------page-wrapper----------------*/

.module_title {
  font-size: 1rem;
}

.page-wrapper {
  height: 100vh;
}

.page-wrapper .theme {
  width: 40px;
  height: 40px;
  display: inline-block;
  border-radius: 4px;
  margin: 2px;
}

.page-wrapper .theme.chiller-theme {
  background: #1e2229;
}

/*----------------toggeled sidebar----------------*/

.page-wrapper.toggled .sidebar-wrapper {
  left: 0px;
}

@media screen and (min-width: 768px) {
  .page-wrapper.toggled .page-content {
    padding-left: 300px;
  }
}
/*----------------show sidebar button----------------*/
#show-sidebar {
  position: fixed;
  left: 0;
  top: 10px;
  border-radius: 0 4px 4px 0px;
  width: 35px;
  transition-delay: 0.3s;
}
.page-wrapper.toggled #show-sidebar {
  left: -40px;
}
/*----------------sidebar-wrapper----------------*/

.sidebar-wrapper {
  width: 320px;
  height: 100%;
  max-height: 100%;
  position: fixed;
  top: 0;
  left: -300px;
  z-index: 999;
}

.sidebar-wrapper ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.sidebar-wrapper a {
  text-decoration: none;
}

/*----------------sidebar-content----------------*/

.sidebar-content {
  max-height: calc(100% - 30px);
  height: calc(100% - 30px);
  overflow-y: auto;
  position: relative;
}

.sidebar-content.desktop {
  overflow-y: hidden;
}

/*----------------------sidebar-menu-------------------------*/

.sidebar-menu {
  margin-top: 30%;
}

.sidebar-wrapper .sidebar-menu {
  padding-bottom: 10px;
}

.sidebar-wrapper .sidebar-menu .header-menu span {
  font-weight: bold;
  font-size: 14px;
  padding: 15px 20px 5px 20px;
  display: inline-block;
}

.sidebar-wrapper .sidebar-menu ul li a {
  display: inline-block;
  width: 100%;
  text-decoration: none;
  position: relative;
  padding: 8px 30px 8px 20px;
}

.sidebar-wrapper .sidebar-menu ul li a i {
  margin-right: 10px;
  font-size: 12px;
  width: 30px;
  height: 30px;
  line-height: 30px;
  text-align: center;
  border-radius: 4px;
}

.sidebar-wrapper .sidebar-menu ul li a:hover > i::before {
  display: inline-block;
  animation: swing ease-in-out 0.5s 1 alternate;
}

.sidebar-wrapper .sidebar-menu .sidebar-dropdown > a:after {
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  content: '\f105';
  font-style: normal;
  display: inline-block;
  font-style: normal;
  font-variant: normal;
  text-rendering: auto;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  background: 0 0;
  position: absolute;
  right: 15px;
  top: 14px;
}

.sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu ul {
  padding: 5px 0;
}

.sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li {
  padding-left: 25px;
  font-size: 13px;
}

.sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a:before {
  content: '\f111';
  font-family: 'Font Awesome 5 Free';
  font-weight: 400;
  font-style: normal;
  display: inline-block;
  text-align: center;
  text-decoration: none;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin-right: 10px;
  font-size: 8px;
}

.sidebar-wrapper .sidebar-menu ul li a span.label,
.sidebar-wrapper .sidebar-menu ul li a span.badge {
  float: right;
  margin-top: 8px;
  margin-left: 5px;
}

.sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .badge,
.sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .label {
  float: right;
  margin-top: 0px;
}

.sidebar-wrapper .sidebar-menu .sidebar-submenu {
  display: none;
}

.sidebar-wrapper .sidebar-menu .sidebar-dropdown.active > a:after {
  transform: rotate(90deg);
  right: 17px;
}

/*--------------------------page-content-----------------------------*/

.wrapper-content {
  margin-left: 320px;
}

.wrapper-content .row {
  display: flex !important;
  justify-content: center !important;
  margin-top: 3%;
}

.page-wrapper .page-content {
  display: inline-block;
  width: 100%;
  padding-left: 0px;
  padding-top: 20px;
}

.page-wrapper .page-content > div {
  padding: 20px 40px;
}

.page-wrapper .page-content {
  overflow-x: hidden;
}

/*------scroll bar---------------------*/

::-webkit-scrollbar {
  width: 5px;
  height: 7px;
}
::-webkit-scrollbar-button {
  width: 0px;
  height: 0px;
}

::-webkit-scrollbar-thumb:hover {
  background: #525965;
}
::-webkit-scrollbar-thumb:active {
  background: #525965;
}
::-webkit-scrollbar-track {
  background: transparent;
  border: 0px none #ffffff;
  border-radius: 50px;
}
::-webkit-scrollbar-track:hover {
  background: transparent;
}
::-webkit-scrollbar-track:active {
  background: transparent;
}
::-webkit-scrollbar-corner {
  background: transparent;
}

/*-----------------------------chiller-theme-------------------------------------------------*/

.chiller-theme .sidebar-wrapper {
  background: #31353d;
}

.chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
.chiller-theme .sidebar-wrapper .sidebar-search .input-group-text {
  border-color: transparent;
  box-shadow: none;
}

.chiller-theme .sidebar-wrapper .sidebar-header .user-info .user-role,
.chiller-theme .sidebar-wrapper .sidebar-header .user-info .user-status,
.chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
.chiller-theme .sidebar-wrapper .sidebar-search .input-group-text,
.chiller-theme .sidebar-wrapper .sidebar-brand > a,
.chiller-theme .sidebar-wrapper .sidebar-menu ul li a,
.chiller-theme .sidebar-footer > a {
  color: #818896;
}

.chiller-theme .sidebar-wrapper .sidebar-menu ul li:hover > a,
.chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active > a,
.chiller-theme .sidebar-wrapper .sidebar-header .user-info,
.chiller-theme .sidebar-wrapper .sidebar-brand > a:hover,
.chiller-theme .sidebar-footer > a:hover i {
  color: #b8bfce;
}

.page-wrapper.chiller-theme.toggled #close-sidebar {
  color: #bdbdbd;
}

.page-wrapper.chiller-theme.toggled #close-sidebar:hover {
  color: #ffffff;
}

.chiller-theme .sidebar-wrapper ul li:hover a i,
.chiller-theme
  .sidebar-wrapper
  .sidebar-dropdown
  .sidebar-submenu
  li
  a:hover:before,
.chiller-theme .sidebar-wrapper .sidebar-search input.search-menu:focus + span,
.chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active a i {
  color: #16c7ff;
  text-shadow: 0px 0px 10px rgba(22, 199, 255, 0.5);
}

.chiller-theme .sidebar-wrapper .sidebar-menu ul li a i,
.chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown div,
.chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
.chiller-theme .sidebar-wrapper .sidebar-search .input-group-text {
  background: #3a3f48;
}

.chiller-theme .sidebar-wrapper .sidebar-menu .header-menu span {
  color: #6c7b88;
}

.sidebar-submenu {
  margin-left: 6%;
}

.module_block {
  cursor: not-allowed;
  pointer-events: none;
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
  .wrapper-content {
    margin-left: 0px;
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
</style>
