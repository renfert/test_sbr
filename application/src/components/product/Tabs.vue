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
      <li class="nav-item">
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
          {{ description }}
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
                    class="d-block position-relative text-dark collapsible-link py-2 collapsed"
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
            <p>{{instructorDescription}}</p>
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
            <span class="rating-overview-box-total">4.2</span>
            <span class="rating-overview-box-percent">out of 5.0</span>
            <div class="star-rating" data-rating="5">
              <i class="ti-star"></i>
              <i class="ti-star"></i>
              <i class="ti-star"></i>
              <i class="ti-star"></i>
              <i class="ti-star"></i>
            </div>
          </div>

          <div class="rating-bars">
            <div class="rating-bars-item">
              <span class="rating-bars-name">5 Star</span>
              <span class="rating-bars-inner">
                <span class="rating-bars-rating high" data-rating="4.7">
                  <span class="rating-bars-rating-inner" style="width: 85%;"></span>
                </span>
                <strong>85%</strong>
              </span>
            </div>
            <div class="rating-bars-item">
              <span class="rating-bars-name">4 Star</span>
              <span class="rating-bars-inner">
                <span class="rating-bars-rating good" data-rating="3.9">
                  <span class="rating-bars-rating-inner" style="width: 75%;"></span>
                </span>
                <strong>75%</strong>
              </span>
            </div>
            <div class="rating-bars-item">
              <span class="rating-bars-name">3 Star</span>
              <span class="rating-bars-inner">
                <span class="rating-bars-rating mid" data-rating="3.2">
                  <span class="rating-bars-rating-inner" style="width: 52.2%;"></span>
                </span>
                <strong>53%</strong>
              </span>
            </div>
            <div class="rating-bars-item">
              <span class="rating-bars-name">1 Star</span>
              <span class="rating-bars-inner">
                <span class="rating-bars-rating poor" data-rating="2.0">
                  <span class="rating-bars-rating-inner" style="width:20%;"></span>
                </span>
                <strong>20%</strong>
              </span>
            </div>
          </div>
        </div>

        <!-- Reviews -->
        <div class="list-single-main-item fl-wrap">
          <div class="list-single-main-item-title fl-wrap">
            <h3>
              Item Reviews -
              <span>3</span>
            </h3>
          </div>
          <div class="reviews-comments-wrap">
            <!-- reviews-comments-item -->
            <div class="reviews-comments-item">
              <div class="review-comments-avatar">
                <img src="assets/img/user-1.jpg" class="img-fluid" alt />
              </div>
              <div class="reviews-comments-item-text">
                <h4>
                  <a href="#">Josaph Manrty</a>
                  <span class="reviews-comments-item-date">
                    <i class="ti-calendar theme-cl"></i>27 Oct 2019
                  </span>
                </h4>

                <div class="listing-rating high" data-starrating2="5">
                  <i class="ti-star active"></i>
                  <i class="ti-star active"></i>
                  <i class="ti-star active"></i>
                  <i class="ti-star active"></i>
                  <i class="ti-star active"></i>
                  <span class="review-count">4.9</span>
                </div>
                <div class="clearfix"></div>
                <p>
                  " Commodo est luctus eget. Proin in nunc laoreet justo
                  volutpat blandit enim. Sem felis, ullamcorper vel aliquam non,
                  varius eget justo. Duis quis nunc tellus sollicitudin mauris.
                  "
                </p>
                <div class="pull-left reviews-reaction">
                  <a href="#" class="comment-like active">
                    <i class="ti-thumb-up"></i> 12
                  </a>
                  <a href="#" class="comment-dislike active">
                    <i class="ti-thumb-down"></i> 1
                  </a>
                  <a href="#" class="comment-love active">
                    <i class="ti-heart"></i> 07
                  </a>
                </div>
              </div>
            </div>
            <!--reviews-comments-item end-->

            <!-- reviews-comments-item -->
            <div class="reviews-comments-item">
              <div class="review-comments-avatar">
                <img src="assets/img/user-2.jpg" class="img-fluid" alt />
              </div>
              <div class="reviews-comments-item-text">
                <h4>
                  <a href="#">Rita Chawla</a>
                  <span class="reviews-comments-item-date">
                    <i class="ti-calendar theme-cl"></i>2 Nov May 2019
                  </span>
                </h4>

                <div class="listing-rating mid" data-starrating2="5">
                  <i class="ti-star active"></i>
                  <i class="ti-star active"></i>
                  <i class="ti-star active"></i>
                  <i class="ti-star active"></i>
                  <i class="ti-star"></i>
                  <span class="review-count">3.7</span>
                </div>
                <div class="clearfix"></div>
                <p>
                  " Commodo est luctus eget. Proin in nunc laoreet justo
                  volutpat blandit enim. Sem felis, ullamcorper vel aliquam non,
                  varius eget justo. Duis quis nunc tellus sollicitudin mauris.
                  "
                </p>
                <div class="pull-left reviews-reaction">
                  <a href="#" class="comment-like active">
                    <i class="ti-thumb-up"></i> 12
                  </a>
                  <a href="#" class="comment-dislike active">
                    <i class="ti-thumb-down"></i> 1
                  </a>
                  <a href="#" class="comment-love active">
                    <i class="ti-heart"></i> 07
                  </a>
                </div>
              </div>
            </div>
            <!--reviews-comments-item end-->

            <!-- reviews-comments-item -->
            <div class="reviews-comments-item">
              <div class="review-comments-avatar">
                <img src="assets/img/user-3.jpg" class="img-fluid" alt />
              </div>
              <div class="reviews-comments-item-text">
                <h4>
                  <a href="#">Adam Wilsom</a>
                  <span class="reviews-comments-item-date">
                    <i class="ti-calendar theme-cl"></i>10 Nov 2019
                  </span>
                </h4>

                <div class="listing-rating good" data-starrating2="5">
                  <i class="ti-star active"></i>
                  <i class="ti-star active"></i>
                  <i class="ti-star active"></i>
                  <i class="ti-star active"></i>
                  <i class="ti-star"></i>
                  <span class="review-count">4.2</span>
                </div>
                <div class="clearfix"></div>
                <p>
                  " Commodo est luctus eget. Proin in nunc laoreet justo
                  volutpat blandit enim. Sem felis, ullamcorper vel aliquam non,
                  varius eget justo. Duis quis nunc tellus sollicitudin mauris.
                  "
                </p>
                <div class="pull-left reviews-reaction">
                  <a href="#" class="comment-like active">
                    <i class="ti-thumb-up"></i> 12
                  </a>
                  <a href="#" class="comment-dislike active">
                    <i class="ti-thumb-down"></i> 1
                  </a>
                  <a href="#" class="comment-love active">
                    <i class="ti-heart"></i> 07
                  </a>
                </div>
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
      collapsePanelId: ""
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
    "instructor-description"
  ],
  mounted() {
    this.createCustomClass();
  },
  methods: {
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
    }
  }
};
</script>

<style>
/* =============
  == Products page style==

    - Layout
		- Fonts
		- Mobile	

============= */

/* =============
   Layout
============= */

body {
  background-color: #f4f8fa;
}

html {
  background-color: #f4f8fa;
}

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

ul.lectures_lists {
  padding: 0;
  margin: 0;
  border-radius: 2px;
  overflow: hidden;
}

.edu_wraper ul.lectures_lists li {
  background: #fff;
}

ul.lectures_lists li {
  padding: 17px 15px;
  background: #f1f4fb;
  color: #24394e;
  border-bottom: 1px solid #e5e8ef;
  position: relative;
  width: 100%;
  display: flex;
  align-items: center;
  font-weight: 600;
  cursor: pointer;
}

.lectures_lists_title {
  margin-right: 2rem;
  font-weight: 400;
  font-size: 14px;
  color: #647b9c;
}

.lectures_lists_title i {
  margin-right: 5px;
}

.collapse.show {
  display: block;
}

.edu_wraper ul.lectures_lists li {
  background: #fff;
  font-weight: 500;
  font-size: 14px;
  color: #647b9c;
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
</style>
