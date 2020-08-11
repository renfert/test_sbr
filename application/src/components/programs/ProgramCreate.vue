<template>
  <div class="col-12">
    <div class="card-box" v-if="loadingContent == true">
      <facebook-loader
        :speed="2"
        width="700"
        height="200"
        primaryColor="#f0f0f0"
        secondaryColor="#d9d9d9"
      ></facebook-loader>
    </div>

    <div class="box-programs" v-else>
      <div class="row">
        <div class="col-1"></div>
        <div class="col-xl-4 col-md-4" v-if="programList == null">
          <div class="text-programs">
            <h4>{{lang["no-results-program-title"]}}</h4>
            <br />
            <router-link class="sbr-btn sbr-primary" to="/newprogram">{{lang["new-program-button"]}}</router-link>
          </div>
        </div>

        <div class="col-12 col-md-4" v-else>
          <div class="text-programs">
            <h3>
              {{lang["programs-already-created"]}}
              <b
                class="text-eadtools"
              >{{numberTotalOfProgramsCreated}}</b>
            </h3>
            <br />
            <router-link class="sbr-btn sbr-primary" to="/newprogram">{{lang["new-program-button"]}}</router-link>
          </div>
        </div>

        <el-divider style="height:auto;" direction="vertical"></el-divider>
        <div class="col-1"></div>
        <div class="col-12 col-md-5 text-center">
          <h3 class="text-box">See how is easy to create a program</h3>
          <a
            id="play-video"
            class="video-play-button"
            @click.prevent="videoOverlay = true"
            href="#"
          >
            <span></span>
          </a>
          <div id="video-overlay" class="video-overlay" :class="videoOverlay == true?'open': ''">
            <a @click.prevent="videoOverlay = false" class="video-overlay-close">&times;</a>
            <iframe
              width="560"
              height="315"
              src="https://www.youtube.com/embed/lQyl0PUle5E"
              frameborder="0"
              allowfullscreen
            ></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End col-12 -->
</template>

<script>
import { eventLang } from "@/components/helper/HelperLang";
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import { FacebookLoader } from "vue-content-loader";

Vue.use(ElementUI);
Vue.use(VueAxios, axios);
export default {
  components: {
    FacebookLoader
  },
  mixins: [domains, alerts],
  data: () => {
    return {
      lang: {},
      programList: [],
      numberTotalOfProgramsCreated: "",
      videoOverlay: false,
      loadingContent: false
    };
  },
  created() {
    this.getProgram();
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );
  },
  methods: {
    getProgram() {
      this.loadingContent = true;
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "program",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          setTimeout(
            function() {
              this.loadingContent = false;
            }.bind(this),
            1000
          );
          this.programList = response.data;
          this.numberTotalOfProgramsCreated = response.data.length;
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.image-new-program {
  width: 50%;
}

.text-programs {
  margin-top: 15%;
}

.el-divider--vertical {
  height: auto !important;
}

.video-play-button {
  position: relative;
  z-index: 10;
  margin-top: 15%;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
  box-sizing: content-box;
  display: block;
  width: 32px;
  height: 44px;
  /* background: #fa183d; */
  border-radius: 50%;
  padding: 18px 20px 18px 28px;
}

.video-play-button:before {
  content: "";
  position: absolute;
  z-index: 0;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
  display: block;
  width: 80px;
  height: 80px;
  background: #009cd8;
  border-radius: 50%;
  animation: pulse-border 1500ms ease-out infinite;
}

.video-play-button:after {
  content: "";
  position: absolute;
  z-index: 1;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
  display: block;
  width: 80px;
  height: 80px;
  background: #009cd8;
  border-radius: 50%;
  transition: all 200ms;
}

.video-play-button:hover:after {
  background-color: darken(#009cd8, 10%);
}

.video-play-button img {
  position: relative;
  z-index: 3;
  max-width: 100%;
  width: auto;
  height: auto;
}

.video-play-button span {
  display: block;
  position: relative;
  z-index: 3;
  width: 0;
  height: 0;
  border-left: 32px solid #fff;
  border-top: 22px solid transparent;
  border-bottom: 22px solid transparent;
}

@keyframes pulse-border {
  0% {
    transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1.5);
    opacity: 0;
  }
}

.video-overlay {
  position: fixed;
  z-index: -1;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.8);
  opacity: 0;
  transition: all ease 500ms;
}

.video-overlay.open {
  position: fixed;
  z-index: 1000;
  opacity: 1;
}

.video-overlay-close {
  position: absolute;
  z-index: 1000;
  top: 15px;
  right: 20px;
  font-size: 36px;
  line-height: 1;
  font-weight: 400;
  color: #fff;
  text-decoration: none;
  cursor: pointer;
  transition: all 200ms;
}

.video-overlay-close:hover {
  color: #009cd8;
}

.video-overlay iframe {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
  /* width: 90%; */
  /* height: auto; */
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.75);
}
</style>
