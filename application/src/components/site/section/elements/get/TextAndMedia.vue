<template>
  <div class="container-site top-10">
    <div v-for="element in textAndMediaArray" :key="element.id">
      <!-- Left side media position -->

      <div class="row" v-if="element.media_align == 'left'">
        <div class="col-md-6 col-12">
          <img
            :src="getUrlToContents() + 'builder/body/'+element.media+''"
            v-if="mediaExtension == 'png' || mediaExtension == 'jpg' || mediaExtension == 'jpeg'"
            style="max-width:100%;"
          />
          <div class="player-container" v-else>
            <vue-plyr>
              <video :src="getUrlToContents() + 'builder/body/'+element.media+''"></video>
            </vue-plyr>
          </div>
        </div>
        <div class="col-md-6 col-12 content-right">
          <h1>{{element.header}}</h1>
          <h3>{{element.subheader}}</h3>
          <p class="mb-4 mt-4">{{element.content}}</p>
          <a :href="element.url" :target="element.target">
            <span class="link-button" :style="styleButton">{{element.title}}</span>
          </a>
        </div>
      </div>
      <!-- End side media position -->

      <!-- Right side media position -->

      <div class="row" v-if="element.media_align == 'right'">
        <div class="col-md-6 col-12 content-left">
          <h1>{{element.header}}</h1>
          <h3>{{element.subheader}}</h3>
          <p class="mb-4 mt-4">{{element.content}}</p>
          <a :href="element.url" :target="element.target">
            <span class="link-button" :style="styleButton">{{element.title}}</span>
          </a>
        </div>
        <div class="col-md-6 col-12">
          <img
            :src="getUrlToContents() + 'builder/body/'+element.media+''"
            v-if="mediaExtension == 'png' || mediaExtension == 'jpg' || mediaExtension == 'jpeg'"
            style="max-width:100%;"
          />
          <div class="player-container" v-else>
            <vue-plyr>
              <video :src="getUrlToContents() + 'builder/body/'+element.media+''"></video>
            </vue-plyr>
          </div>
        </div>
      </div>
      <!-- End side media position -->

      <!-- Top side media position -->
      <div v-if="element.media_align == 'top'" class="text-center">
        <div class="row">
          <div class="col-12 col-md-12">
            <img
              :src="getUrlToContents() + 'builder/body/'+element.media+''"
              v-if="mediaExtension == 'png' || mediaExtension == 'jpg' || mediaExtension == 'jpeg'"
              style="max-width:100%;"
            />
            <div class="player-container" v-else>
              <vue-plyr>
                <video :src="getUrlToContents() + 'builder/body/'+element.media+''"></video>
              </vue-plyr>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-12 text-align-bottom">
            <h1>{{element.header}}</h1>
            <h3>{{element.subheader}}</h3>
            <p class="mb-4 mt-4">{{element.content}}</p>
            <a :href="element.url" :target="element.target">
              <span class="link-button" :style="styleButton">{{element.title}}</span>
            </a>
          </div>
        </div>
      </div>
      <!-- End side media position -->

      <!-- Bottom side media position -->
      <div v-if="element.media_align == 'bottom'" class="text-center">
        <div class="row">
          <div class="col-12 col-md-12 text-align-top">
            <h1>{{element.header}}</h1>
            <h3>{{element.subheader}}</h3>
            <p class="mb-4 mt-4">{{element.content}}</p>
            <a :href="element.url" :target="element.target">
              <span class="link-button" :style="styleButton">{{element.title}}</span>
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-12">
            <img
              :src="getUrlToContents() + 'builder/body/'+element.media+''"
              v-if="mediaExtension == 'png' || mediaExtension == 'jpg' || mediaExtension == 'jpeg'"
              style="max-width:100%;"
            />
            <div class="player-container" v-else>
              <vue-plyr>
                <video :src="getUrlToContents() + 'builder/body/'+element.media+''"></video>
              </vue-plyr>
            </div>
          </div>
        </div>
      </div>
      <!-- End side media position -->
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import { eventLang } from "@/components/helper/HelperLang";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VuePlyr from "vue-plyr";
import { eventBus } from "@/components/site/App";

locale.use(lang);
Vue.use(VueAxios, axios);
Vue.use(ElementUI);
Vue.use(VuePlyr, {
  plyr: {
    fullscreen: { enabled: true }
  },
  emit: ["ended"]
});
export default {
  mixins: [domains, alerts],
  props: ["section-id"],
  data: () => {
    return {
      lang: {},
      primaryColor: "",
      textAndMediaArray: [],
      mediaExtension: "",
      buttonColor: "",
      buttonStyle: "",
      buttonTitle: ""
    };
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );

    eventBus.$on(
      "new-change-text-and-media",
      function() {
        this.getTextAndMedia();
      }.bind(this)
    );
    this.getPrimaryColor();
    this.getTextAndMedia();
  },
  methods: {
    getTextAndMedia: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "site-elements/TextAndMedia",
        "get"
      );
      var formData = new FormData();
      formData.set("sectionId", this.sectionId);
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.textAndMediaArray = response.data;
          this.buttonStyle = response.data[0].style;
          this.buttonColor = response.data[0].color;
          this.buttonTitle = response.data[0].title;
          this.getMediaExtension(response.data[0].media);
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getMediaExtension(media) {
      var mediaNameArray = media.split(".");
      this.mediaExtension = mediaNameArray[1];
    },
    getPrimaryColor: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.primaryColor = response.data["color"];
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  },
  computed: {
    styleButton: function() {
      return {
        "background-color": this.buttonColor,
        display: this.buttonTitle == null ? "none" : "initial"
      };
    }
  }
};
</script>


<style lang="scss" scoped>
/* =============
  == Products page style==

    - Layout
    - Fonts
    - Button
    - Mobile

============= */

/* =============
   Layout
============= */

.text-align-right {
  padding-left: 50px !important;
}

.text-align-left {
  padding-right: 50px !important;
}

.text-align-bottom {
  padding-top: 30px !important;
}

.text-align-top {
  padding-bottom: 30px !important;
}

.top-10 {
  margin-top: 10%;
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
  color: #2d3954;
  font-family: "Poppins", sans-serif;
  word-break: break-word !important;
}

h1 {
  line-height: 34px;
  font-size: 28px;
}

h2 {
  line-height: 28px;
  font-size: 22px;
}

h3 {
  line-height: 24px;
  font-size: 18px;
}

h4 {
  line-height: 24px;
  font-size: 18px;
}

a {
  color: #4a5682;
  text-decoration: none;
  background-color: transparent;
  -webkit-text-decoration-skip: objects;
}

/* =============
   Button
============= */
.link-button {
  font-weight: 500;
  color: white;
  font-size: 1.3em;
  font-family: "Poppins", sans-serif;
  border-radius: 5px;
  padding: 8px 18px 8px 18px;
}

/* =============
   Mobile
============= */

@media only screen and (max-width: 1024px) {
  .text-align-right {
    padding-left: 0px !important;
    margin-top: 10%;
  }

  .text-align-left {
    padding-right: 0px !important;
    margin-top: 10%;
  }

  .text-box {
    padding-bottom: 0px;
  }

  h1 {
    line-height: 24px;
    font-size: 22px;
  }

  h2 {
    line-height: 22px;
    font-size: 18px;
  }

  h3 {
    line-height: 16px;
    font-size: 14px;
  }

  h4 {
    line-height: 14px;
    font-size: 12px;
  }

  .link-button[data-v-059bd9ee] {
    font-weight: 500;
    -webkit-transition: 0.5s;
    transition: 0.5s;
    color: white;
    font-size: 1em;
    font-family: "Poppins", sans-serif;
    border-radius: 5px;
    padding: 8px 18px 8px 18px;
  }

  .content-left {
    margin-bottom: 15%;
  }
}
</style>
