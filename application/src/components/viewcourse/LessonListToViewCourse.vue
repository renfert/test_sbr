<template>
  <div>
    <li
      class="list_lesson"
      :index="'lesson' + moduleIndex + index"
      :id="'lesson' + moduleIndex + index"
      v-for="(element, index) in lessons"
      :key="index"
      @click="
        sendEventToLoadLesson(
          $event,
          element.id,
          element.type_mylesson_id,
          element.lessonStatus
        )
      "
    >
      <a href="javascript:void(0)" style="display: flex; align-items: center">
        <!-- video -->
        <i
          v-if="
            element.type_mylesson_id == 1 && element.lessonStatus != 'finished'
          "
          class="mdi mdi-play-speed lesson_icon"
        ></i>

        <!-- Audio icon -->
        <i
          v-if="
            element.type_mylesson_id == 2 && element.lessonStatus != 'finished'
          "
          class="mdi mdi-volume-high lesson_icon"
        ></i>

        <!-- Pdf icon -->
        <i
          v-if="
            element.type_mylesson_id == 3 && element.lessonStatus != 'finished'
          "
          class="mdi mdi-file-pdf lesson_icon"
        ></i>

        <!-- Downloadable icon -->
        <i
          v-if="
            element.type_mylesson_id == 4 && element.lessonStatus != 'finished'
          "
          class="mdi mdi-cloud-download-outline lesson_icon"
        ></i>

        <!-- Video conf icon -->
        <i
          v-if="
            element.type_mylesson_id == 5 && element.lessonStatus != 'finished'
          "
          class="mdi mdi-microphone lesson_icon"
        ></i>
        <!-- Webinar icon -->
        <i
          v-if="
            element.type_mylesson_id == 6 && element.lessonStatus != 'finished'
          "
          class="mdi mdi-message-video lesson_icon"
        ></i>
        <!-- Html icon -->
        <i
          v-if="
            element.type_mylesson_id == 7 && element.lessonStatus != 'finished'
          "
          class="mdi mdi-code-tags lesson_icon"
        ></i>
        <!-- Exam icon -->
        <i
          v-if="
            element.type_mylesson_id == 8 && element.lessonStatus != 'finished'
          "
          class="mdi mdi-comment-question lesson_icon"
        ></i>

        <!-- Finished icon -->
        <i
          v-if="element.lessonStatus == 'finished'"
          class="mdi mdi-checkbox-marked-circle-outline lesson_icon lesson_finished"
        ></i>
        {{ element.title }}</a
      >
    </li>
  </div>
</template>

<script>
import { eventBus } from '@/components/viewcourse/App';
import { mapState } from 'vuex';
import $ from 'jquery';

export default {
  data: () => {
    return {
      lessons: null,
      currentLesson: ''
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  mounted() {
    this.getLessons(true);

    eventBus.$on('update-progress-bar', () => {
      this.getLessons(false);
    });
  },
  props: ['module-id', 'module-index'],
  methods: {
    sendEventToLoadLesson(event, lessonId, lessonType, lessonStatus) {
      const el = event.currentTarget.id;
      const data = {
        lessonId: lessonId,
        lessonType: lessonType,
        lessonStatus: lessonStatus
      };
      eventBus.$emit('load-lesson', data);

      this.changeLiClass(el);
    },
    changeLiClass(el) {
      $('.list_lesson').removeClass('lesson_active');
      $('#' + el).addClass('lesson_active');
    },
    openFirstLesson() {
      document.getElementById('lesson00').click();
    },
    getLessons(firstLesson) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'listing'
      );
      formData.set('moduleId', this.moduleId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.lessons = response.data;
          if (firstLesson === true) {
            setTimeout(() => {
              this.openFirstLesson();
            }, 500);
          }
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
/*-----------------------sidebar-search------------------------*/

.sidebar-wrapper .sidebar-search > div {
  padding: 10px 20px;
}

/*----------------------sidebar-menu-------------------------*/

.sidebar-submenu {
  margin-left: 6% !important;
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
  color: white;
}

.lesson_finished {
  color: #16c7ff;
  text-shadow: 0px 0px 10px rgba(22, 199, 255, 0.5);
}

.lesson_active {
  border-left: 3px solid #16c7ff;
  padding-left: 35px !important;
}

.lesson_active a {
  color: #fff !important;
}

.lesson_icon {
  font-size: 1.3rem !important;
}

.list_lesson {
  border-bottom: 2px solid #31353d;
}

.list_lesson:last-child {
  border-bottom: none;
}
</style>
