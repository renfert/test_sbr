<template>
  <div v-loading="loading">
    <el-carousel :interval="4000" type="card" height="350px">
      <el-carousel-item v-for="element in personsArray" :key="element.id">
        <div class="testimonial-persons">
          <el-avatar :size="80">
            <img :src="getUrlToContents() + 'testimonial/'+element.photo+''" />
          </el-avatar>
          <h3>{{element.name}}</h3>
          <h4>{{element.occupation}}</h4>
          <hr style="width:50%;" />
          <p>"{{element.comment}}"</p>
        </div>
      </el-carousel-item>
    </el-carousel>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/site/App.vue";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  props: ["testimonial-id"],
  data: () => {
    return {
      personsArray: [],
      loading: false
    };
  },
  mounted() {
    eventBus.$on(
      "edit-person",
      function() {
        this.getPersons();
      }.bind(this)
    );

    this.getPersons();
    this.getPrimaryColor();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getPrimaryColor() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          /* Create custom classes */
          var style = document.createElement("style");
          style.type = "text/css";
          style.innerHTML =
            ".el-carousel__arrow{background-color:" +
            response.data["color"] +
            " !important;}";
          document.getElementsByTagName("head")[0].appendChild(style);
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getPersons: function() {
      this.loading = true;
      var formData = new FormData();
      formData.set("testimonialId", this.testimonialId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "persons",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.personsArray = response.data;
          this.loading = false;
        },
        /* Error callback */
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
.testimonial-persons {
  text-align: center;
  padding: 10%;
}

.testimonial-persons h3 {
  font-size: 15px;
  line-height: 1;
}

.testimonial-persons h4 {
  font-size: 11px;
}

.el-carousel__item:nth-child(2n) {
  background-color: white;
  border-radius: 15px;
}

.el-carousel__item:nth-child(2n + 1) {
  background-color: white;
  border-radius: 15px;
}

.el-carousel__item.is-active.el-carousel__item--card.is-in-stage {
  box-shadow: 10px 10px 33px -10px #aca9a9;
  border-radius: 15px;
}
</style>
