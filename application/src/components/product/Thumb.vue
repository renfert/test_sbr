<template>
  <div>
    <div class="inline_edu_wrap">
      <div class="inline_edu_first">
        <h4>{{ title }}</h4>
        <ul class="edu_inline_info">
          <li>
            <i class="ti-agenda mr-2"></i>
            {{ lang['modules'] }}: {{ modulesTotal }}
          </li>
          <li>
            <i class="ti-control-forward"></i>
            {{ lang['lessons'] }}: {{ lessonsTotal }}
          </li>
        </ul>
      </div>
    </div>
    <div class="property_video xl">
      <div class="thumb">
        <img
          :key="elementKey"
          class="pro_img img-fluid w100"
          v-lazy="$getUrlToContents() + 'course/' + photo + ''"
        />
      </div>

      <div class="instructor_over_info">
        <ul>
          <li>
            <div class="ins_info">
              <div class="ins_info_thumb">
                <img
                  :src="$getUrlToContents() + 'avatar/' + instructorPhoto + ''"
                  class="img-fluid"
                />
              </div>
              <div class="ins_info_caption">
                <span>{{ lang['instructor'] }}</span>
                <h4>{{ instructorName }}</h4>
              </div>
            </div>
          </li>
          <li v-if="category != 'default'">
            <span>{{ lang['category'] }}</span>
            {{ category }}
          </li>
          <li v-if="reviews != null">
            <span>Reviews</span>
            <div class="eds_rate">
              <el-rate
                v-model="rate"
                disabled
                show-score
                text-color="#ff9900"
                :score-template="totalReviews"
              ></el-rate>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import VueLazyload from 'vue-lazyload';

import { mapState } from 'vuex';

Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: 'https://sbrfiles.s3.amazonaws.com/images/image-not-available.png',
  loading: 'https://sbrfiles.s3.amazonaws.com/gifs/loading7.gif',
  attempt: 1
});

export default {
  props: [
    'title',
    'category',
    'modules-total',
    'lessons-total',
    'reviews',
    'photo',
    'instructor-name',
    'instructor-photo',
    'total-reviews',
    'total-rate'
  ],
  data: () => {
    return {
      rate: 0,
      elementKey: 0
    };
  },

  computed: {
    ...mapState(['lang'])
  },
  watch: {
    totalRate() {
      this.rate = parseInt((this.totalRate / this.totalReviews).toFixed(0));
    },
    photo() {
      this.elementKey++;
    }
  }
};
</script>

<style scoped>
/* =============
   Layout
============= */

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

.inline_edu_wrap {
  width: 100%;
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.inline_edu_first {
  flex: 1;
}

ul:last-child {
  margin: 0;
}

ul {
  padding: 0;
  margin: 0;
  list-style-type: none;
}

.ed_header_caption ul li,
.edu_inline_info li {
  display: inline-block;
  margin-right: 1.5rem;
  list-style: none;
  font-size: 14px;
}

.ed_header_caption ul li i,
.edu_inline_info li i {
  margin-right: 7px;
}

.thumb {
  background-color: #ffffff;
  border-radius: 3px;
  -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.1);
  box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.1);
  padding-bottom: 0px;
  padding-left: 0px;
  padding-right: 0px;
  padding-top: 0px;
  width: 100%;
  margin-top: 0 !important;
}

[class*=' ti-'],
[class^='ti-'] {
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

.property_video {
  position: relative;
}

.property_video:before {
  background: #17203a;
  left: 0;
  right: 0;
  top: 0;
  position: absolute;
  content: '';
  bottom: 0;
  opacity: 0.5;
  border-radius: 1rem;
}

.property_video .thumb {
  border-radius: 1rem;
  overflow: hidden;
}

.property_video.xl .thumb .pro_img {
  min-height: 490px;
  max-height: 490px;
}

.property_video .thumb .pro_img {
  width: 100%;
  object-fit: cover;
}

.img-fluid {
  max-width: 100%;
  height: auto;
}

img {
  vertical-align: middle;
  border-style: none;
}

.instructor_over_info {
  position: absolute;
  bottom: 20px;
  left: 20px;
}

.instructor_over_info ul {
  padding: 0;
  margin: 0;
  display: flex;
  align-items: center;
  width: 100%;
}

.instructor_over_info ul li {
  margin-right: 2.5rem;
  font-size: 15px;
  color: #fff;
  font-weight: 600;
}

.ins_info {
  display: flex;
  align-items: center;
}

.ins_info .ins_info_thumb {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  overflow: hidden;
  margin-right: 7px;
}

.instructor_over_info ul li span {
  font-size: 13px;
  font-weight: 400;
  display: block;
  color: #fff;
}

.ins_info_caption h4 {
  font-size: 15px;
  color: #fff;
  margin: 0;
  line-height: 1.2;
}

.eds_rate {
  display: flex;
  align-items: center;
  color: #fff;
  font-weight: 600;
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
  font-family: 'Poppins', sans-serif;
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
  .instructor_over_info ul li:nth-child(3) {
    display: none;
  }
  .instructor_over_info ul li:nth-child(2) {
    display: none;
  }
}
</style>
