<template>
  <button
    v-if="isVisible"
    class="kc_fab_main_btn corazon"
    @click="hambClick"
    id="fab"
  >
    <i class="ti-menu"></i>
  </button>
</template>

<script>
import { eventTemplate } from '@/components/template/TheTopBar';

import Vue from 'vue';

export const eventHamburger = new Vue();
export default {
  props: ['action'],
  data() {
    return {
      showMobile: false,
      isVisible: true
    };
  },
  mounted() {
    eventHamburger.$on('toggleHamburger', () => {
      this.isVisible = !this.isVisible;
    });
    eventHamburger.$on('hideHamburger', () => {
      this.isVisible = false;
    });
    eventHamburger.$on('showHamburger', () => {
      this.isVisible = true;
    });
  },
  methods: {
    hambClick() {
      eventTemplate.$emit('change-leftbar-class');
      if (this.action) {
        this.action();
      }
    }
  }
};
</script>

<style type="text/css">
@media only screen and (min-width: 768px) {
  #fab {
    display: none;
  }
}

@media only screen and (max-width: 768px) {
  .kc_fab_main_btn {
    display: initial;
    position: absolute;
    bottom: 2vh;
    right: 2vh;
    z-index: 10000;
    background-color: #009cd8;
    width: 50px;
    height: 50px;
    border-radius: 100%;
    background: #009cd8;
    border: none;
    outline: none;
    color: #fff;
    font-size: 20px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    transition: 0.3s;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
  }

  .kc_fab_main_btn:active {
    box-shadow: 0 0 0 rgba(0, 0, 0, 0.6);
    transform: scale(1.2);
    font-size: 25px;
  }

  .hamb {
    display: none;
  }

  #fab {
    /*display: none;*/
    bottom: 5%;
    right: 8%;
  }

  @keyframes latidos {
    from {
      transform: none;
    }
    50% {
      transform: scale(1.2);
    }
    to {
      transform: none;
    }
  }
  .corazon {
    display: inline-block;
    text-shadow: 0 0 0 #222, 1px 1px 0 #450505;
    animation: latidos 1.6s infinite;
    transform-origin: center;
  }
}
</style>
