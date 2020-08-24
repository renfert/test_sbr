import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
Vue.use(VueAxios, axios);
const verify = {
  methods: {
    verifySession() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "mysessions",
        "activeSession"
      );
      axios.get(urlToBeUsedInTheRequest).then(response => {
        let session = response.data;
        if (session == false) {
          window.location.href = "/invalidsession";
        }
      });
    },
    verifyAdministratorPrivileges() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(response => {
        let roleId = response.data["myrole_id"];
        if (roleId != 1) {
          window.location.href = "/404";
        }
      });
    },
    verifyInstructorPrivileges() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(response => {
        let roleId = response.data["myrole_id"];
        if (roleId != 2) {
          window.location.href = "/404";
        }
      });
    },
    blockStudentAccess() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(response => {
        let roleId = response.data["myrole_id"];
        if (roleId == 3) {
          window.location.href = "/404";
        }
      });
    },
    verifyCourseReleased(courseId) {
      var formData = new FormData();
      formData.set("courseId", courseId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "verify",
        "courseReleased"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(response => {
        if (response.data > 0) {
          window.history.back();
        }
      });
    },
    verifyCourseExpiration(courseId) {
      var formData = new FormData();
      formData.set("courseId", courseId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "verify",
        "courseExpiration"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(response => {
        if (response.data < 0) {
          window.history.back();
        }
      });
    }
  }
};

export default verify;
