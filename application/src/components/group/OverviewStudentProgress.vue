<template>
  <el-progress :color="customColor" :percentage="progress"></el-progress>
</template>

<script>
export default {
  props: ['user-id', 'course-id'],
  data: () => {
    return {
      progress: 0,
      customColor: ''
    };
  },
  created() {
    this.getUserCourseProgress();
  },
  methods: {
    getUserCourseProgress() {
      this.content = false;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getUserCourseProgress'
      );
      formData.set('userId', this.userId);
      formData.set('courseId', this.courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.progress = response.data;

          if (this.progress === 100 || this.progress > 99) {
            this.customColor = '#009cd8';
          }

          if (this.progress > 0 && this.progress < 100) {
            this.customColor = '#ffba00';
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
