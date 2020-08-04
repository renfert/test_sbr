<template>
  <div
    class="image-cover ed_detail_head lg"
    style="background:#f4f4f4 url(https://sbrfiles.s3.amazonaws.com/images/cover.png);"
    data-overlay="8"
  >
    <div class="container">
      <div class="row">
        <div class="col-lg-7 col-md-9">
          <div class="ed_detail_wrap light">
            <ul class="cources_facts_list">
              <li v-if="category != 'default'" class="facts-1">{{ category }}</li>
            </ul>
            <div class="ed_header_caption">
              <h2 class="ed_title">{{ title }}</h2>
              <ul>
                <li>
                  <i class="ti-agenda mr-2"></i>
                  Modules: {{ modules }}
                </li>
                <li>
                  <i class="ti-control-forward"></i>
                  Lessons: {{ lessons }}
                </li>
              </ul>
            </div>

            <div v-if="reviews != null" class="ed_rate_info">
              <div class="star_info">
                <i class="fas fa-star filled"></i>
                <i class="fas fa-star filled"></i>
                <i class="fas fa-star filled"></i>
                <i class="fas fa-star filled"></i>
                <i class="fas fa-star"></i>
              </div>
              <div class="review_counter">
                <strong :style="primaryColor" class="good">4.5</strong> 3572
                Reviews
              </div>
            </div>
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

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  props: ["title", "category", "modules", "lessons", "color", "reviews"],
  computed: {
    primaryColor: function() {
      return {
        color: this.color
      };
    }
  }
};
</script>

<style scoped>
/* =============
  == Products page style==

    - Layout
    - Image
    - Text
    - Fonts
    - Mobile

============= */

/* =============
   Layout
============= */
.ed_detail_head.lg {
  padding: 4rem;
}

/* =============
   Image
============= */
.image-cover {
  background-size: cover !important;
  background-position: center !important;
}

[data-overlay] {
  position: relative;
}

[data-overlay="8"]:before {
  opacity: 0.8;
}

[data-overlay]:before {
  position: absolute;
  content: "";
  background: #052044;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
}

/* =============
  Banner inner
============= */
.ed_header_caption {
  width: 100%;
  display: block;
  margin-top: 0.5rem;
  margin-bottom: 1rem;
}

[data-overlay] :not(.container):not(.bg-img-holder) {
  z-index: 2;
}

.ed_detail_wrap.light {
  color: #fff !important;
}

.ed_detail_wrap {
  width: 100%;
  display: block;
  position: relative;
}

[data-overlay] :not(.container):not(.bg-img-holder) {
  z-index: 2;
}

ul.cources_facts_list {
  margin: 0;
  padding: 0;
}

.ed_header_caption ul {
  padding: 0;
  margin: 0;
}

.ed_detail_wrap.light ul.cources_facts_list li {
  background: rgba(255, 255, 255, 0.1) !important;
  color: #fff !important;
}

ul.cources_facts_list li.facts-1 {
  background: rgba(33, 177, 124, 0.13);
  color: #21b17c;
}

ul.cources_facts_list li {
  padding: 3px 8px;
  font-size: 13px;
  position: relative;
  background: #f4f5f7;
  border-radius: 0 2px 2px 0;
}

ul.cources_facts_list li {
  display: inline-block;
  margin-right: 0.8rem;
}

ul.cources_facts_list li.facts-1:before {
  border-left-color: rgba(33, 177, 124, 0.13);
}

ul.cources_facts_list li:before {
  border-top: 12px solid transparent;
  border-left: 10px solid #eaedf3;
  border-bottom: 13px solid transparent;
  content: "";
  height: 0;
  position: absolute;
  top: 0;
  right: -10px;
  width: 0;
}

ul.cources_facts_list li:after {
  background-color: #fff;
  border-radius: 50%;
  content: "";
  height: 4px;
  position: absolute;
  top: 10px;
  right: -5px;
  width: 4px;
}

.menu__list,
.nav-dropdown,
.nav-menu,
ul {
  list-style: none;
}

.ed_header_caption ul li,
.edu_inline_info li {
  display: inline-block;
  margin-right: 1.5rem;
  list-style: none;
  font-size: 14px;
}

li {
  display: list-item;
  text-align: -webkit-match-parent;
}

[data-overlay] :not(.container):not(.bg-img-holder) {
  z-index: 2;
}

.ed_header_caption ul li i,
.edu_inline_info li i {
  margin-right: 7px;
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

.ti-control-forward:before {
  content: "\e6af";
}

.ed_rate_info {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  width: 100%;
}

.ed_rate_info .star_info {
  margin-right: 10px;
  position: relative;
}

.ed_rate_info .star_info i.filled {
  color: #f1992c;
}

.ed_rate_info .star_info i {
  font-size: 11px;
  color: #ced7e8;
  margin-right: 1px;
}

.fa,
.fas {
  font-family: "Font Awesome 5 Free";
  font-weight: 900;
}

.fa-star:before {
  content: "\f005";
}

.review_counter {
  font-size: 12.5px;
}

.review_counter strong {
  font-size: 16px;
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
  font-weight: 600;
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

h2.ed_title {
  color: white !important;
}

/* =============
   Mobile
============= */
@media (max-width: 575.98px) {
  h2.ed_title {
    font-size: 23px;
  }

  .ed_detail_wrap {
    padding-top: 1rem;
  }
}

@media (max-width: 1199.98px) {
  ul.cources_facts_list li {
    padding: 5px 12px;
    font-size: 12px;
  }
}
</style>
