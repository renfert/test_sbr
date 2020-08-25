<template>
  <div class="main">
    <div class="loader">
      <div class="inner one"></div>
      <div class="inner two"></div>
      <div class="inner three"></div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import ElementUI from "element-ui";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(VueHead);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  mounted() {
    this.verifyValidityOfJwt();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    verifyValidityOfJwt() {
      var formData = new FormData();
      formData.set("jwt", this.$route.params.jwt);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "verify",
        "verifyValidityOfJwt"
      );
      axios
        .post(urlToBeUsedInTheRequest, formData)
        .then(response => {
          if (response.data == true) {
            setTimeout(function() {
              this.$router.push({ name: "home" });
            }, 8000);
          } else {
            this.errorMessage();
          }
        })
        .catch(() => {
          this.errorMessage();
        });
    }
  },
  head: {
    title: {
      inner: "Authentication"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "description", content: "Learn and technology" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>

<style scoped>
.loader {
  position: absolute;
  top: calc(50% - 32px);
  left: calc(50% - 32px);
  width: 64px;
  height: 64px;
  border-radius: 50%;
  perspective: 800px;
}

.inner {
  position: absolute;
  box-sizing: border-box;
  width: 100%;
  height: 100%;
  border-radius: 50%;
}

.inner.one {
  left: 0%;
  top: 0%;
  animation: rotate-one 1s linear infinite;
  border-bottom: 3px solid #009cd8;
}

.inner.two {
  right: 0%;
  top: 0%;
  animation: rotate-two 1s linear infinite;
  border-right: 3px solid #29277f;
}

.inner.three {
  right: 0%;
  bottom: 0%;
  animation: rotate-three 1s linear infinite;
  border-top: 3px solid #6a5acd;
}

@keyframes rotate-one {
  0% {
    transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
  }
  100% {
    transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
  }
}

@keyframes rotate-two {
  0% {
    transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
  }
  100% {
    transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
  }
}

@keyframes rotate-three {
  0% {
    transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
  }
  100% {
    transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
  }
}
</style>

