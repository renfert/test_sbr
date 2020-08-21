<template>
  <div>
    <nav-bar></nav-bar>
    <banner
      :title="courseTitle"
      :category="category"
      :lessons="totalLessons"
      :modules="totalModules"
      :color="color"
      :reviews="reviews"
      :total-reviews="totalReviews"
      :total-rate="totalRate"
    ></banner>
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8">
            <thumb
              :instructor-photo="instructorPhoto"
              :instructor-name="instructorName"
              :reviews="reviews"
              :title="courseTitle"
              :photo="photo"
              :category="category"
              :modules-total="totalModules"
              :lessons-total="totalLessons"
              :total-reviews="totalReviews"
              :total-rate="totalRate"
            ></thumb>
            <tabs
              :description="description"
              :modules="modules"
              :color="color"
              :instructor-name="instructorName"
              :instructor-photo="instructorPhoto"
              :instructor-description="instructorDescription"
              :total-reviews="totalReviews"
              :total-rate="totalRate"
              :course-id="courseId"
              :reviews="reviews"
            ></tabs>
          </div>

          <div class="col-lg-4 col-md-4">
            <price
              :course-title="courseTitle"
              :course-id="courseId"
              :color="color"
              :price="price"
              :description="description"
              :preview="preview"
            ></price>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- End of wrapper -->
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import NavBar from "@/components/template/TheNavBar";
import Banner from "@/components/product/Banner";
import Thumb from "@/components/product/Thumb";
import Tabs from "@/components/product/Tabs";
import Price from "@/components/product/Price";

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      courseId: "",
      courseTitle: "",

      totalModules: "",
      totalLessons: "",

      modules: [],

      instructorName: "",
      instructorPhoto: "",
      instructorDescription: "",

      totalReviews: "",
      totalRate: "",

      category: "",
      description: "",
      photo: "",
      preview: "",
      reviews: "",
      color: "",
      price: ""
    };
  },
  components: {
    Banner,
    Thumb,
    Tabs,
    Price,
    NavBar
  },
  mounted() {
    let title = this.$route.params.title;
    this.courseTitle = title.split("-").join(" ");
    this.getColor();
    this.createMetaTags();
    this.getCourse();
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
    getCourse() {
      var formData = new FormData();
      formData.set("courseTitle", this.courseTitle);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "course",
        "getCourseByTitle"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          // success callback
          this.courseId = response.data["id"];
          this.courseTitle = response.data["title"];
          this.category = response.data["category"];
          this.description = response.data["description"];
          this.photo = response.data["photo"];
          this.preview = response.data["preview"];
          this.price = response.data["price"];
          this.reviews = response.data["reviews"];
          this.totalModules = response.data["totalModules"];
          this.totalLessons = response.data["totalLessons"];
          this.instructorName = response.data["instructorName"];
          this.instructorPhoto = response.data["instructorAvatar"];
          this.instructorDescription = response.data["instructorDescription"];
          this.totalReviews = response.data["totalReviews"];
          this.totalRate = response.data["totalRate"];
          this.getModules(response.data["id"]);
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getModules(courseId) {
      var formData = new FormData();
      formData.set("courseId", courseId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "module",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          // success callback
          this.modules = response.data;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getColor() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.color = response.data["color"];
        }.bind(this)
      );
    },
    createMetaTags() {
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

<style scoped>
body {
  background-color: #f4f8fa;
}

html {
  background-color: #f4f8fa;
}

section {
  padding: 80px 0;
  position: relative;
}

.main ol {
  padding-left: 70px;
}

.main h1.course-title {
  padding: 30px 0px 10px 70px;
}

.course-card {
  margin: 0px 80px 30px 70px;
}
</style>
