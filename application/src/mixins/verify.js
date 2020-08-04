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
    }
  }
};

export default verify;
