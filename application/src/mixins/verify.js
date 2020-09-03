const verify = {
  methods: {
    $verifySession() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'mysessions',
        'activeSession'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        const session = response.data;
        if (session === false) {
          window.location.href = '/invalidsession';
        }
      });
    },
    $verifyAdministratorPrivileges() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getUserProfile'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        const roleId = response.data.myrole_id;
        if (parseInt(roleId) !== 1) {
          window.location.href = '/404';
        }
      });
    },
    $verifyInstructorPrivileges() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getUserProfile'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        const roleId = response.data.myrole_id;
        if (roleId !== 2) {
          window.location.href = '/404';
        }
      });
    },
    $blockStudentAccess() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getUserProfile'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        const roleId = response.data.myrole_id;
        if (roleId === 3) {
          window.location.href = '/404';
        }
      });
    },
    $verifyCourseReleased(courseId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'courseReleased'
      );
      formData.set('courseId', courseId);

      this.$request.post(urlToBeUsedInTheRequest, formData).then((response) => {
        if (response.data > 0) {
          window.history.back();
        }
      });
    },
    $verifyCourseExpiration(courseId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'courseExpiration'
      );
      formData.set('courseId', courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then((response) => {
        if (response.data < 0) {
          window.history.back();
        }
      });
    }
  }
};

export default verify;
