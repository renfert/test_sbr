<template>
  <div>
    <el-menu-item
      :index="'lesson' + moduleIndex + index"
      :id="'lesson' + moduleIndex + index"
      v-for="(element, index) in lessons"
      :key="index"
      @click="
        sendEventToLoadLesson(
          element.id,
          element.type_mylesson_id,
          element.lessonStatus
        )
      "
    >
      <el-divider
        style="color: red !important"
        direction="vertical"
      ></el-divider>
      <!-- Video icon -->
      <i
        v-if="
          element.type_mylesson_id == 1 && element.lessonStatus != 'finished'
        "
        class="mdi mdi-play-speed lesson-icon"
      ></i>
      <!-- Audio icon -->
      <i
        v-if="
          element.type_mylesson_id == 2 && element.lessonStatus != 'finished'
        "
        class="mdi mdi-volume-high lesson-icon"
      ></i>
      <!-- Pdf icon -->
      <i
        v-if="
          element.type_mylesson_id == 3 && element.lessonStatus != 'finished'
        "
        class="mdi mdi-file-pdf lesson-icon"
      ></i>
      <!-- Downloadable icon -->
      <i
        v-if="
          element.type_mylesson_id == 4 && element.lessonStatus != 'finished'
        "
        class="mdi mdi-cloud-download-outline lesson-icon"
      ></i>
      <!-- Video conf icon -->
      <i
        v-if="
          element.type_mylesson_id == 5 && element.lessonStatus != 'finished'
        "
        class="mdi mdi-microphone lesson-icon"
      ></i>
      <!-- Webinar icon -->
      <i
        v-if="
          element.type_mylesson_id == 6 && element.lessonStatus != 'finished'
        "
        class="mdi mdi-message-video lesson-icon"
      ></i>
      <!-- Html icon -->
      <i
        v-if="
          element.type_mylesson_id == 7 && element.lessonStatus != 'finished'
        "
        class="mdi mdi-code-tags lesson-icon"
      ></i>
      <!-- Exam icon -->
      <i
        v-if="
          element.type_mylesson_id == 8 && element.lessonStatus != 'finished'
        "
        class="mdi mdi-comment-question lesson-icon"
      ></i>

      <!-- Finished icon -->
      <i
        v-if="element.lessonStatus == 'finished'"
        class="mdi mdi-checkbox-marked-circle-outline lesson-icon lesson-finished"
      ></i>

      <span
        :class="element.lessonStatus == 'finished' ? 'lesson-finished' : ''"
        >{{ element.title }}</span
      >
    </el-menu-item>
  </div>
</template>

<script>
import { eventBus } from '@/components/viewcourse/App';
import { mapState } from 'vuex';

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
    sendEventToLoadLesson(lessonId, lessonType, lessonStatus) {
      const data = {
        lessonId: lessonId,
        lessonType: lessonType,
        lessonStatus: lessonStatus
      };
      eventBus.$emit('load-lesson', data);
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
.lesson-finished {
  color: rgb(0, 195, 255) !important;
}

.lesson-icon {
  font-size: 1.3em !important;
  padding-right: 10px;
}

.el-menu-item {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.1em;
  font-weight: 100 !important;
}

.el-divider--vertical {
  height: 100% !important;
}

.is-active {
  color: white !important;
  background-color: rgb(67, 74, 80) !important;
}
</style>
