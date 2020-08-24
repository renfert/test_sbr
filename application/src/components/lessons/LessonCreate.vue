<template>
  <div>
    <lesson-video :module-id="moduleId"></lesson-video>
    <lesson-audio :module-id="moduleId"></lesson-audio>
    <lesson-pdf :module-id="moduleId"></lesson-pdf>
    <lesson-downloadable :module-id="moduleId"></lesson-downloadable>
    <lesson-html :module-id="moduleId"></lesson-html>
    <lesson-webinar :module-id="moduleId"></lesson-webinar>
    <lesson-video-conf :module-id="moduleId"></lesson-video-conf>
    <lesson-exam :module-id="moduleId"></lesson-exam>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import LessonVideo from "@/components/lessons/create/types/LessonVideo";
import LessonAudio from "@/components/lessons/create/types/LessonAudio";
import LessonPdf from "@/components/lessons/create/types/LessonPdf";
import LessonDownloadable from "@/components/lessons/create/types/LessonDownloadable";
import LessonHtml from "@/components/lessons/create/types/LessonHtml";
import LessonWebinar from "@/components/lessons/create/types/LessonWebinar";
import LessonVideoConf from "@/components/lessons/create/types/LessonVideoConf";
import LessonExam from "@/components/lessons/create/types/LessonExam";
import HelperProgress from "@/components/helper/HelperProgress.vue";

import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";

export default {
  props: ["module-id"],
  components: {
    LessonVideo,
    LessonAudio,
    LessonPdf,
    LessonDownloadable,
    LessonHtml,
    LessonWebinar,
    LessonVideoConf,
    LessonExam,
    HelperProgress
  },
  mounted() {
    eventBus.$on("create-lesson", function(response) {
      eventBus.$emit(response);
    });
  },
  computed: {
    ...mapState(["lang"])
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
