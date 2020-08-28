const verify = {
  methods: {
    $verifySession() {
      let urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "mysessions",
        "activeSession"
      );
      this.$request.get(urlToBeUsedInTheRequest).then(response => {
        let session = response.data;
        if (session == false) {
          window.location.href = "/invalidsession";
        }
      });
    },
    $verifyAdministratorPrivileges() {
      let urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      this.$request.get(urlToBeUsedInTheRequest).then(response => {
        let roleId = response.data["myrole_id"];
        if (roleId != 1) {
          window.location.href = "/404";
        }
      });
    },
    $verifyInstructorPrivileges() {
      let urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      this.$request.get(urlToBeUsedInTheRequest).then(response => {
        let roleId = response.data["myrole_id"];
        if (roleId != 2) {
          window.location.href = "/404";
        }
      });
    },
    $blockStudentAccess() {
      let urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      this.$request.get(urlToBeUsedInTheRequest).then(response => {
        let roleId = response.data["myrole_id"];
        if (roleId == 3) {
          window.location.href = "/404";
        }
      });
    },
    $verifyCourseReleased(courseId) {
      let formData = new FormData();
      let urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "verify",
        "courseReleased"
      );
      formData.set("courseId", courseId);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(response => {
        if (response.data > 0) {
          window.history.back();
        }
      });
    },
    $verifyCourseExpiration(courseId) {
      let formData = new FormData();
      let urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "verify",
        "courseExpiration"
      );
      formData.set("courseId", courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(response => {
        if (response.data < 0) {
          window.history.back();
        }
      });
    }
  }
};

export default verify;
