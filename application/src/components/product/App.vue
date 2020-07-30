<template>
  <div id="wrapper">
    <lang></lang>
    <nav-bar></nav-bar>
    <banner></banner>
    <information></information>
  </div>
  <!-- End of wrapper -->
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import axios from "axios";
import VueAxios from "vue-axios";
import Lang from "@/components/helper/HelperLang.vue";
import { eventLang } from "@/components/helper/HelperLang";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import NavBar from "@/components/template/TheNavBar";
import Banner from "@/components/product/Banner";
import Information from "@/components/product/Information";

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      courseId: "",
      title: "",
      category: "",
      description: "",
      photo: "",
      preview: "",
      reviews: "",
      currency: "",
      price: "",
      lang: []
    };
  },
  components: {
    Lang,
    Banner,
    Information,
    NavBar
  },
  created() {
    this.getCurrency();
  },
  mounted() {
    console.log(this.$route); // outputs 'yay'
    this.createMetaTags();
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );
  },
  head: {
    title: {
      inner: "Product"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  },
  methods: {
    getCourse: function() {
      var formData = new FormData();
      formData.set("courseId", this.courseId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "get");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          // success callback
          this.courseId = response.data["id"];
          this.title = response.data["title"];
          this.category = response.data["category"];
          this.description = response.data["description"];
          this.photo = response.data["photo"];
          this.preview = response.data["preview"];
          this.price = response.data["price"];
          this.reviews = response.data["reviews"];
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getCurrency: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.currency = response.data["currency"];
        }.bind(this)
      );
    },
    createMetaTags: function() {
      /* Title og metatag */
      var title = document.createElement("meta");
      title.setAttribute("property", "og:title");
      title.content = this.title;
      document.getElementsByTagName("head")[0].appendChild(title);

      /* Description og metatag */
      var description = document.createElement("meta");
      description.setAttribute("property", "og:description");
      description.content = this.description;
      document.getElementsByTagName("head")[0].appendChild(description);

      /* Image og metatag */
      var image = document.createElement("meta");
      image.setAttribute("property", "og:image");
      image.content = this.getUrlToContents() + "course/" + this.photo + "";
      document.getElementsByTagName("head")[0].appendChild(image);

      /* Url og metatag */
      var url = document.createElement("meta");
      url.setAttribute("property", "og:url");
      url.content = this.getCurrentDomainName() + "product" + this.courseId;
      document.getElementsByTagName("head")[0].appendChild(url);
    }
  }
};
</script>

<style>
.main ol {
  padding-left: 70px;
}

.main h1.course-title {
  padding: 30px 0px 10px 70px;
}

.course-card {
  margin: 0px 80px 30px 70px;
}

.course-cta {
  border-radius: 5px;
  background-color: #c5cae9 !important;
  margin: 0px 80px 20px 70px;
  padding: 10px 10px 10px 10px;
  text-align: center;
}

.course-cta h3 {
  font-family: "Poppins", sans-serif;
  font-size: 30px;
  padding: 5px;
}
</style>
