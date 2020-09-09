<template>
  <div>
    <div class="two-column-card mt-5">
      <div class="item-card">
        <div v-if="programList == null">
          <h4>{{ lang['no-results-program-title'] }}</h4>
          <br />
          <router-link to="/newprogram">
            <el-button class="sbr-primary mt-3">
              {{ lang['new-program-button'] }}
            </el-button>
          </router-link>
        </div>
        <div v-else>
          <h3>
            {{ lang['courses-already-created'] }}
            <b class="sbr-text-primary">{{ totalPrograms }}</b>
          </h3>
          <router-link to="/newprogram">
            <el-button class="sbr-primary mt-3">
              {{ lang['new-program-button'] }}
            </el-button>
          </router-link>
        </div>
      </div>

      <div class="divider"></div>

      <!-- See how to create a program --->
      <div class="item-card item-video-course">
        <h3 class="text-box">See how is easy to create a program</h3>
        <a
          id="play-video"
          class="video-play-button"
          @click.prevent="videoOverlay = true"
          href="#"
        >
          <span></span>
        </a>
        <div
          id="video-overlay"
          class="video-overlay"
          :class="videoOverlay == true ? 'open' : ''"
        >
          <a @click.prevent="videoOverlay = false" class="video-overlay-close"
            >&times;</a
          >
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
</template>

<script>
import { mapState } from 'vuex';

export default {
  props: ['total-programs', 'program-list'],
  data: () => {
    return {
      videoOverlay: false
    };
  },
  computed: {
    ...mapState(['lang'])
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
/* =============
    - Layout
    - Play button
    - Mobile
============= */

/* =============
   Layout
============= */
.two-column-card {
  display: flex;
  flex-direction: row;
  flex: 1;
  flex-wrap: wrap;
  margin: 0 -8px;
  justify-content: space-around;
  align-items: baseline;
}

.two-column-card > * {
  margin: 0 8px;
}

.divider {
  width: 2px;
  margin: 6px 0;
  background: #ebe5e5;
  align-self: stretch;
}

.item-card {
  flex: 1;
  text-align: center;
}

.img-box {
  width: 70%;
}

.text-box {
  font-size: 17px;
}

.image-new-program {
  width: 50%;
}

.text-programs {
  margin-top: 15%;
}

.el-divider--vertical {
  height: auto !important;
}

/* =============
  Play button
============= */
.video-play-button {
  position: relative;
  z-index: 10;
  margin-top: 10%;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
  box-sizing: content-box;
  display: block;
  width: 22px;
  height: 34px;
  /* background: #fa183d; */
  border-radius: 50%;
  padding: 30px 18px 18px 28px;
}

.video-play-button:before {
  content: '';
  position: absolute;
  z-index: 0;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
  display: block;
  width: 60px;
  height: 60px;
  background: #009cd8;
  border-radius: 50%;
  animation: pulse-border 1500ms ease-out infinite;
}

.video-play-button:after {
  content: '';
  position: absolute;
  z-index: 1;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
  display: block;
  width: 60px;
  height: 60px;
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
  border-left: 18px solid #fff;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
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

/* =============
  Mobile
============= */

@media only screen and (max-width: 600px) {
  .divider {
    display: none;
  }

  .item-card {
    flex: initial;
    text-align: center;
    margin-top: 25%;
  }

  .item-video-course {
    display: none;
  }
}
</style>
