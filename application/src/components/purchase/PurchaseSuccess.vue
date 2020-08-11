<template>
  <div class="col-12">
    <div class="card-sabiorealm text-center">
      <img :src="courseImage" style="width: 200px" />

      <h5 class="mb-4">{{lang["approved-purchase"]}}</h5>

      <h2 class="mb-4">{{courseTitle}}</h2>

      <router-link
        class="sbr-btn sbr-primary mb-4"
        :to="'/viewcourse/'+courseId"
      >{{lang["view-course"]}}</router-link>

      <p>
        {{lang["doubts"]}}
        <b>{{email}}</b>
      </p>
    </div>

    <div class="app-background-accent"></div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueTheMask from "vue-the-mask";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import { eventLang } from "@/components/helper/HelperLang";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

Vue.use(ElementUI);
Vue.use(VueTheMask);
Vue.use(VueAxios, axios);
export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      lang: {},
      courseId: "",
      courseTitle: "",
      courseImage: "",
      email: ""
    };
  },
  created() {
    this.courseId = this.$route.params.id;
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );

    this.getCourse();

    this.getCompanyInformation();
  },
  methods: {
    getCourse: function() {
      var formData = new FormData();
      formData.set("courseId", this.courseId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "get");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          /* Success callback */
          this.courseTitle = response.data["title"];
          this.courseImage =
            this.getUrlToContents() + "course/" + response.data["photo"] + "";
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }
      );
    },

    getCompanyInformation: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "company",
        "getCompanyInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          /* Success callback */
          this.email = response.data["email"];
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
h1,
h2,
h3,
h4,
h5,
h6 {
  color: #2d3954;
  font-family: "Poppins", sans-serif;
  word-break: break-word !important;
  font-weight: 500;
}

h1 {
  line-height: 40px;
  font-size: 36px;
}

h2 {
  line-height: 36px;
  font-size: 30px;
}

h3 {
  line-height: 30px;
  font-size: 24px;
}

h4 {
  line-height: 26px;
  font-size: 21px;
}

a {
  color: #4a5682;
  text-decoration: none;
  background-color: transparent;
  -webkit-text-decoration-skip: objects;
}

.item-name h3 {
  color: #9e9c9c;
  font-size: 1.2em;
}

.card-sabiorealm {
  width: 50%;
  animation: fadeIn 0.5s ease-in;
  background-color: white;
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 10px, rgba(0, 0, 0, 0.23) 0px 3px 10px;
  padding: 20px;
  transform: translateX(-50%) translateY(-50%);
  z-index: 10;
  position: absolute;
  left: 50%;
  margin-top: 18%;
}

@media only screen and (max-width: 600px) {
  .card-sabiorealm {
    width: 80%;
    animation: fadeIn 0.5s ease-in;
    background-color: white;
    border-radius: 10px;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 10px,
      rgba(0, 0, 0, 0.23) 0px 3px 10px;
    padding: 20px;
    transform: translateX(-50%) translateY(-50%);
    z-index: 10;
    position: absolute;
    left: 50%;
    margin-top: 70%;
  }
}
</style>
