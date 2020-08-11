<template>
  <!-- All Info Show in Tab -->
  <div class="tab_box_info mt-4">
    <ul class="nav nav-pills mb-3 light" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a
          @click="
            tabDescription = true;
            tabCurriculum = false;
            tabInstructor = false;
            tabReviews = false;
          "
          class="nav-link"
          :class="tabDescription == true ? 'active' : ''"
          id="overview-tab"
          data-toggle="pill"
          role="tab"
          aria-controls="overview"
          aria-selected="true"
          aria-expanded="false"
        >{{ lang["description"] }}</a>
      </li>
      <li class="nav-item">
        <a
          @click="
            tabDescription = false;
            tabCurriculum = true;
            tabInstructor = false;
            tabReviews = false;
          "
          class="nav-link"
          :class="tabCurriculum == true ? 'active' : ''"
          id="curriculum-tab"
          data-toggle="pill"
          role="tab"
          aria-controls="curriculum"
          aria-selected="false"
          aria-expanded="true"
        >Curriculum</a>
      </li>
      <li class="nav-item">
        <a
          @click="
            tabDescription = false;
            tabCurriculum = false;
            tabInstructor = true;
            tabReviews = false;
          "
          class="nav-link"
          :class="tabInstructor == true ? 'active' : ''"
          id="instructor-tab"
          data-toggle="pill"
          role="tab"
          aria-controls="instructor"
          aria-selected="false"
          aria-expanded="false"
        >{{ lang["instructor"] }}</a>
      </li>
      <li v-if="reviews == 'on' " class="nav-item">
        <a
          @click="
            tabDescription = false;
            tabCurriculum = false;
            tabInstructor = false;
            tabReviews = true;
          "
          class="nav-link"
          :class="tabReviews == true ? 'active' : ''"
          id="reviews-tab"
          data-toggle="pill"
          role="tab"
          aria-controls="reviews"
          aria-selected="false"
          aria-expanded="false"
        >Reviews</a>
      </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
      <!-- Description  -->
      <div
        class="tab-pane fade"
        :class="tabDescription == true ? 'active show' : ''"
        id="overview"
        role="tabpanel"
        aria-labelledby="overview-tab"
        aria-expanded="true"
      >
        <div class="edu_wraper">
          <h4 class="edu_title">{{ lang["description"] }}</h4>
          <div v-html="description"></div>
        </div>
      </div>

      <!-- Curriculum Detail -->
      <div
        class="tab-pane fade"
        :class="tabCurriculum == true ? 'active show' : ''"
        id="curriculum"
        role="tabpanel"
        aria-labelledby="curriculum-tab"
        aria-expanded="true"
      >
        <div class="edu_wraper">
          <h4 class="edu_title">Curriculum</h4>
          <div id="accordionExample" class="accordion circullum">
            <!-- Part 1 -->
            <div class="card" v-for="element in modules" :key="element.id">
              <div class="card-header bg-white border-0">
                <h6 class="mb-0 accordion_title">
                  <a
                    @click="
                      collapsePanelId == element.id
                        ? (collapsePanelId = 0)
                        : (collapsePanelId = element.id)
                    "
                    data-toggle="collapse"
                    :aria-expanded="
                      collapsePanelId == element.id ? true : false
                    "
                    :aria-controls="'collapse' + element.id"
                    class="d-block position-relative text-dark text-module collapsible-link py-2 collapsed"
                  >{{ element.title }}</a>
                </h6>
              </div>
              <div
                :id="'collapse' + element.id"
                class="collapse"
                :class="collapsePanelId == element.id ? 'show' : ''"
              >
                <div class="card-body pl-3 pr-3">
                  <ul class="lectures_lists">
                    <lesson-list-product-page :module-id="element.id"></lesson-list-product-page>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Instructor Detail -->
      <div
        :class="tabInstructor == true ? 'active show' : ''"
        class="tab-pane fade"
        id="instructor"
        role="tabpanel"
        aria-labelledby="instructor-tab"
        aria-expanded="false"
      >
        <div class="single_instructor">
          <div class="single_instructor_thumb">
            <a href="#">
              <img :src="getUrlToContents() + 'avatar/' + instructorPhoto + ''" class="img-fluid" />
            </a>
          </div>
          <div class="single_instructor_caption">
            <h4>
              <a href="#">{{ instructorName }}</a>
            </h4>
            <p>{{ instructorDescription }}</p>
          </div>
        </div>
      </div>

      <!-- Reviews Detail -->
      <div
        class="tab-pane fade"
        id="reviews"
        :class="tabReviews == true ? 'active show' : ''"
        role="tabpanel"
        aria-labelledby="reviews-tab"
        aria-expanded="false"
      >
        <!-- Overall Reviews -->
        <div class="rating-overview">
          <div class="rating-overview-box">
            <span class="rating-overview-box-total mb-2">{{ rate }}</span>
            <span class="mb-2">{{lang["average-rating"]}}</span>
            <el-rate v-model="rate" disabled show-score text-color="#ff9900"></el-rate>
          </div>

          <div class="rating-bars">
            <!-- 1 Star -->
            <div class="rating-bars-item">
              <span class="rating-bars-name">1 Star</span>
              <span class="rating-bars-inner">
                <span class="rating-bars-rating poor" data-rating="4.7">
                  <span
                    class="rating-bars-rating-inner"
                    :style="totalReviews == 0 ? 'width:0%' : 'width:'+parseInt((100 * reviewWithOneStar / totalReviews)) + '%' "
                  ></span>
                </span>
                <strong
                  v-if="totalReviews"
                >{{ totalReviews == 0 ? '0%' : parseInt((100 * reviewWithOneStar / totalReviews)) + '%' }}</strong>
              </span>
            </div>

            <!-- 2 Star -->
            <div class="rating-bars-item">
              <span class="rating-bars-name">2 Star</span>
              <span class="rating-bars-inner">
                <span class="rating-bars-rating mid" data-rating="3.9">
                  <span
                    class="rating-bars-rating-inner"
                    :style="totalReviews == 0 ? 'width:0%' : 'width:'+parseInt((100 * reviewWithTwoStars / totalReviews)) + '%' "
                  ></span>
                </span>
                <strong
                  v-if="totalReviews"
                >{{ totalReviews == 0 ? '0%' : parseInt((100 * reviewWithTwoStars / totalReviews)) + '%' }}</strong>
              </span>
            </div>

            <!-- 3 Star -->
            <div class="rating-bars-item">
              <span class="rating-bars-name">3 Star</span>
              <span class="rating-bars-inner">
                <span class="rating-bars-rating good" data-rating="3.9">
                  <span
                    class="rating-bars-rating-inner"
                    :style="totalReviews == 0 ? 'width:0%' : 'width:'+parseInt((100 * reviewWithTreeStars / totalReviews)) + '%' "
                  ></span>
                </span>
                <strong
                  v-if="totalReviews"
                >{{ totalReviews == 0 ? '0%' : parseInt((100 * reviewWithTreeStars / totalReviews)) + '%' }}</strong>
              </span>
            </div>

            <!-- 4 Star -->
            <div class="rating-bars-item">
              <span class="rating-bars-name">4 Star</span>
              <span class="rating-bars-inner">
                <span class="rating-bars-rating good" data-rating="3.2">
                  <span
                    class="rating-bars-rating-inner"
                    :style="totalReviews == 0 ? 'width:0%' : 'width:'+parseInt((100 * reviewWithFourStars / totalReviews)) + '%' "
                  ></span>
                </span>
                <strong
                  v-if="totalReviews"
                >{{ totalReviews == 0 ? '0%' : parseInt((100 * reviewWithFourStars / totalReviews)) + '%' }}</strong>
              </span>
            </div>

            <!-- 5 Star -->
            <div class="rating-bars-item">
              <span class="rating-bars-name">5 Star</span>
              <span class="rating-bars-inner">
                <span class="rating-bars-rating high" data-rating="2.0">
                  <span
                    v-if="totalReviews"
                    class="rating-bars-rating-inner"
                    :style="totalReviews == 0 ? 'width:0%' : 'width:'+parseInt((100 * reviewWithFiveStars / totalReviews)) + '%' "
                  ></span>
                </span>
                <strong
                  v-if="totalReviews"
                >{{ totalReviews == 0 ? '0%' : parseInt((100 * reviewWithFiveStars / totalReviews)) + '%' }}</strong>
              </span>
            </div>
          </div>
        </div>

        <!-- Reviews -->
        <div class="list-single-main-item fl-wrap">
          <div class="reviews-comments-wrap">
            <!-- reviews-comments-item -->
            <div
              class="reviews-comments-item"
              v-for="element in usersReviews"
              :key="element.comment"
            >
              <div class="review-comments-avatar">
                <img
                  :src="getUrlToContents() + 'avatar/' + element.avatar + ''"
                  class="img-fluid"
                  alt
                />
              </div>
              <div class="reviews-comments-item-text">
                <h4>
                  <a href="javascript:void(0)">{{element.name}}</a>
                  <span class="reviews-comments-item-date">
                    <i :style="primaryColor" class="ti-calendar theme-cl"></i>
                    {{element.date}}
                  </span>
                </h4>

                <div class="listing-rating high" data-starrating2="5">
                  <el-rate :value="parseInt(element.rate)" disabled show-score text-color="#ff9900"></el-rate>
                </div>
                <div class="clearfix"></div>
                <p>
                  " {{element.comment}}
                  "
                </p>
              </div>
            </div>
            <!--reviews-comments-item end-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import LessonListProductPage from "@/components/lessons/LessonListProductPage";

import { mapState } from "vuex";

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  components: {
    LessonListProductPage
  },
  data: () => {
    return {
      tabDescription: true,
      tabCurriculum: false,
      tabInstructor: false,
      tabReviews: false,
      collapsePanelId: "",

      rate: 0,

      reviewWithOneStar: 0,
      reviewWithTwoStars: 0,
      reviewWithTreeStars: 0,
      reviewWithFourStars: 0,
      reviewWithFiveStars: 0,

      usersReviews: []
    };
  },
  props: [
    "course-id",
    "title",
    "description",
    "category",
    "modules-total",
    "lessons-total",
    "color",
    "reviews",
    "photo",
    "modules",
    "instructor-name",
    "instructor-photo",
    "instructor-description",
    "total-reviews",
    "total-rate"
  ],
  mounted() {
    this.createCustomClass();
  },
  methods: {
    listingReviews: function() {
      var formData = new FormData();
      formData.set("courseId", this.courseId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "reviews",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          // success callback
          this.usersReviews = response.data;
          if (response.data) {
            response.data.forEach(element => {
              let rate = element.rate;
              if (rate == 1) {
                this.reviewWithOneStars++;
              }
              if (rate == 2) {
                this.reviewWithTwoStars++;
              }
              if (rate == 3) {
                this.reviewWithTreeStars++;
              }
              if (rate == 4) {
                this.reviewWithFourStars++;
              }
              if (rate == 5) {
                this.reviewWithFiveStars++;
              }
            });
          }
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    createCustomClass: function() {
      /* Create custom classes */
      var style = document.createElement("style");
      style.type = "text/css";
      style.innerHTML =
        ".nav-link.active{background-color:" + this.color + " !important;}";
      document.getElementsByTagName("head")[0].appendChild(style);
    }
  },
  computed: {
    primaryColorBg: function() {
      return {
        "background-color": this.color + "!important"
      };
    },
    primaryColor: function() {
      return {
        color: this.color + "!important"
      };
    },
    ...mapState(["lang"])
  },
  watch: {
    color: function() {
      this.createCustomClass();
    },
    totalRate: function() {
      this.rate = parseInt((this.totalRate / this.totalReviews).toFixed(0));
    },
    courseId: function() {
      this.listingReviews();
    }
  }
};
</script>

<style scoped>
/* =============
  == Products page style==

    - Layout
    - Fonts
    - Reviews tab
    - Mobile	

============= */

/* =============
   Layout
============= */

.mt-4 {
  margin-top: 1.5rem !important;
}

.nav-pills .nav-link.active,
.show > .nav-pills .nav-link {
  color: #fff;
}

.nav-pills.light .nav-link {
  background: #fff;
}

.nav-pills .nav-link {
  border-radius: 0.25rem;
  background: #f0f3f7;
  margin-right: 0.5rem;
}

.nav-link {
  font-weight: 600;
  display: block;
  padding: 0.8rem 1.5rem;
}

.nav-link.active:hover {
  color: white !important;
}

.tab-content {
  padding: 0 !important;
  border: none !important;
}

.tab-content > .tab-pane {
  padding: 0 0 1rem;
}

.tab-content > .active {
  display: block;
}

.edu_wraper {
  border: 2px solid #f4f8fa;
  width: 100%;
  padding: 2rem;
  background: #fff;
  border-radius: 0.5rem;
  margin-bottom: 30px;
}

.edu_wraper .edu_title {
  margin-bottom: 1rem;
  font-size: 18px;
}

.fade.show {
  opacity: 1;
}

.fade {
  opacity: 0;
  transition: opacity 0.15s linear;
}

.card {
  margin-bottom: 30px;
  border: none;
  box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.09) !important;
  border-radius: 0.25rem;
  overflow: hidden;
}

.card-header:first-child {
  border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}

.card-header {
  background: #fff;
  border-color: #e6eaf1;
  position: relative;
  padding: 0.75rem 1.25rem;
  margin-bottom: 0;
}

.py-2 {
  padding-top: 0.5rem !important;
  padding-bottom: 0.5rem !important;
}

.card-header h6 {
  margin: 0;
  font-size: 12px;
}

.collapsible-link[aria-expanded="true"]::before {
  transform: rotate(180deg);
}

.collapsible-link[aria-expanded="true"]::after {
  transform: rotate(90deg) translateX(-1px);
}

.collapsible-link::before {
  content: "";
  width: 14px;
  height: 2px;
  background: #333;
  position: absolute;
  top: calc(50% - 1px);
  right: 1rem;
  display: block;
  transition: all 0.3s;
}

.collapsible-link::after {
  content: "";
  width: 2px;
  height: 14px;
  background: #333;
  position: absolute;
  top: calc(50% - 7px);
  right: calc(1rem + 6px);
  display: block;
  transition: all 0.3s;
}

.collapse {
  display: none;
  animation: smoothScroll 1s forwards;
}

@keyframes smoothScroll {
  0% {
    transform: translateY(-40px);
  }
  100% {
    transform: translateY(0px);
  }
}
.circullum .card-body {
  padding-top: 0;
}

.collapse.show {
  display: block;
}

.ed_view_box {
  display: block;
  position: relative;
  border-radius: 0.5rem;
  background: #fff;
  padding: 12px;
  margin-bottom: 30px;
  margin-top: -80%;
  transition: 1s;
}

.ed_view_box.style_3 {
  padding: 0px 0px 10px 0px;
  border-radius: 0.5rem;
}

.ed_view_box.sticky {
  position: fixed !important;
  animation: smoothScroll 1.5s forwards;
  top: 0;
  margin: 75px 2% 0% 0%;
  z-index: 20000;
}

@keyframes smoothScroll {
  0% {
    transform: translateY(100%);
  }
  100% {
    transform: translateY(0%);
  }
}

.ed_view_box .property_video.sm {
  margin-bottom: 1rem;
}

.property_video {
  position: relative;
}

.ed_view_box.style_3 .property_video .thumb,
.ed_view_box.style_3 .property_video:before {
  border-radius: 0 !important;
}

ed_view_box.style_3 .property_video .thumb,
.ed_view_box.style_3 .property_video:before {
  border-radius: 0;
}

.property_video.sm .thumb .pro_img {
  min-height: 220px;
  max-height: 220px;
}

.ed_view_price,
.ed_view_features,
.ed_view_link {
  display: block;
  margin-bottom: 1rem;
  padding-left: 10px;
}

.ed_view_price span {
  font-size: 13px;
}

.theme-cl {
  color: #da0b4e;
}

.ed_view_price,
.ed_view_features,
.ed_view_link {
  display: block;
  margin-bottom: 1rem;
  padding-left: 10px;
}

.ed_view_link .enroll-btn {
  width: 80%;
  margin: 1.5rem auto 0;
  display: flex;
  height: 54px;
  font-weight: 600;
  border-radius: 50px;
  color: #fff !important;
  align-items: center;
  justify-content: center;
}

.single_instructor {
  border: 2px solid #f4f8fa;
  display: flex;
  align-items: center;
  width: 100%;
  padding: 12px;
  border-radius: 0.5rem;
  margin-bottom: 30px;
  background: #fff;
  overflow: hidden;
}

.single_instructor_thumb {
  width: 230px;
  height: 230px;
  border-radius: 4px;
  overflow: hidden;
}

.single_instructor_thumb img {
  max-width: 100%;
  border-radius: 4px;
}

.single_instructor_caption {
  padding-left: 2rem;
  flex: 1;
}

.single_instructor_caption h4 {
  margin-bottom: 3px;
}

ul.instructor_info {
  padding: 0;
  margin: 0;
  margin-bottom: 1rem;
}

ul.instructor_info li {
  display: inline-block;
  margin-right: 1rem;
  font-size: 13px;
}

ul.instructor_info li i {
  margin-right: 7px;
}

/* =============
   Fonts
============= */
h1,
h2,
h3,
h4,
h5,
h6 {
  font-family: "Poppins", sans-serif;
  word-break: break-word !important;
  color: #2d3954;
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

.text-module {
  font-weight: 700;
  font-size: 14px;
  color: #647b9c !important;
}

.text-module:hover {
  color: #647b9c !important;
}

/* =============
  Reviews tab
============= */

.rating-overview {
  display: flex;
  margin: 35px 0 25px;
  background: #fff;
  padding: 30px;
  padding-right: 20px;
  border-radius: 0.5rem;
}

.rating-overview-box {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  flex-shrink: 0;
  border: #ffdead;
  width: 200px;
  margin-right: 20px;
  text-align: center;
  border-radius: 0;
  border-right: 1px solid #e8e8e8;
  padding-right: 27px;
}

.rating-overview-box-total {
  font-size: 58px;
  font-weight: 700;
  line-height: 1em;
  display: block;
  color: #2a2f3a;
}

.rating-overview-box-percent {
  font-size: 15px;
  margin-bottom: 0;
  display: block;
}

.rating-overview-box .star-rating {
  font-size: 16px;
  margin: 0;
  display: block;
  letter-spacing: -0.5px;
}

.rating-overview-box .star-rating i {
  color: #ff9500;
}

[class*=" ti-"],
[class^="ti-"] {
  font-family: themify;
  speak: none;
  font-style: normal;
  font-weight: 400;
  font-variant: normal;
  text-transform: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.rating-bars {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  flex-basis: 100%;
  margin: 0;
  padding: 0;
  margin-top: 0;
  align-items: center;
}

.rating-bars-item {
  margin: 10px 15px;
  width: calc(50% - 30px);
  justify-content: flex-end;
  align-items: flex-start;
  display: flex;
  flex-direction: column;
}

.rating-bars-name {
  font-weight: 600;
  color: #4c4f5a;
  display: block;
  font-size: 14px;
  line-height: 22px;
}

.rating-bars-inner {
  display: flex;
  width: 100%;
}

.rating-bars-rating {
  display: inline-block;
  vertical-align: baseline;
  background: #f4f5f7;
  width: 100%;
  height: 6px;
  margin-right: 10px;
  border-radius: 3px;
  overflow: hidden;
  background-color: #f4f5f7;
  align-self: center;
}

.rating-bars-rating-inner {
  height: 6px;
  display: block;
  background-color: #f4f5f7;
  position: relative;
  width: 0;
  transition: width 0.5s;
}

.rating-bars-rating.high .rating-bars-rating-inner {
  background-color: #00ba74;
}

.rating-bars-rating.good .rating-bars-rating-inner {
  background-color: #83ce36;
}

.rating-bars-rating.mid .rating-bars-rating-inner {
  background-color: #fbb851;
}

.rating-bars-rating.poor .rating-bars-rating-inner {
  background-color: #e6453c;
}

.list-single-main-item {
  padding: 30px;
  border-radius: 100%;
  background: #fff;
  border-radius: 0.5rem;
  margin-bottom: 20px;
}

.list-single-main-item-title {
  margin: 0 0 20px;
}

.list-single-main-item-title h3 {
  color: #334e6f;
  text-align: left;
  font-size: 18px;
  font-weight: 600;
}

.reviews-comments-wrap {
  display: inline-table;
  margin-top: 30px;
}

.reviews-comments-item {
  padding: 0 0 30px 110px;
  position: relative;
  float: left;
  margin-bottom: 40px;
  width: 100%;
  border-bottom: 1px solid #eee;
}

.review-comments-avatar {
  position: absolute;
  top: 0;
  left: 20px;
  width: 80px;
  height: 80px;
  overflow: hidden;
  border-radius: 100%;
}

.reviews-comments-item-text {
  float: left;
  width: 100%;
  position: relative;
  padding: 0 20px;
}

.reviews-comments-item-text h4 {
  text-align: left;
  padding-bottom: 0;
  font-size: 18px;
  font-weight: 500;
  margin-bottom: 5px;
}

.reviews-comments-item-date {
  float: right;
  font-weight: 500;
  color: #86889a;
  font-size: 14px;
}

.reviews-comments-item-date i {
  margin-right: 10px;
}

.listing-rating {
  margin-bottom: 1rem;
}

.reviews-comments-item-text p {
  text-align: left;
}

/* =============
  Mobile
============= */
@media only screen and (max-width: 600px) {
  .ed_view_box {
    display: block;
    position: relative;
    border-radius: 0.5rem;
    background: #fff;
    padding: 12px;
    margin-bottom: 30px;
    margin-top: 0%;
    transition: 1s;
  }
}

@media (max-width: 575.98px) {
  .single_instructor {
    display: block;
  }
  .single_instructor_caption {
    flex: auto;
    padding-left: 0;
    padding-top: 1rem;
  }
  .rating-overview-box {
    border-right: 0px;
  }

  .rating-overview {
    flex-wrap: wrap;
  }

  .reviews-comments-item-text p {
    margin-top: 50px;
  }
}
</style>
