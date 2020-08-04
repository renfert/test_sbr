<template>
  <div class="main">
    <bullet-list-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></bullet-list-loader>

    <div v-else>
      <li v-for="element in lessons" :key="element.id">
        <div class="lectures_lists_title">
          <i class="ti-control-play"></i>Lecture: 01
        </div>
        {{element.title}}
      </li>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { BulletListLoader } from "vue-content-loader";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  components: {
    BulletListLoader
  },
  data: () => {
    return {
      lessons: null,
      loadingContent: false
    };
  },
  computed: {
    ...mapState(["lang"])
  },
  props: ["module-id"],
  mounted() {
    this.getLessons();
  },
  methods: {
    getLessons: function() {
      this.loadingContent = true;
      var formData = new FormData();
      formData.set("moduleId", this.moduleId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "lesson",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.lessons = response.data;
          setTimeout(
            function() {
              this.loadingContent = false;
            }.bind(this),
            1000
          );
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
.lesson-box {
  box-shadow: 0px 0px 5px 0px #aca9a9;
  padding: 15px;
  border-radius: 30px;
  margin: 2% 10% 0% 5%;
}

.lesson-title {
  font-family: "Poppins", sans-serif !important;
  font-weight: 400;
  font-size: 16px;
  margin-left: 5px;
}

.btn-link {
  text-align: left !important;
}

.action-buttons {
  padding: 10px;
}

#accordion > .card {
  margin-bottom: 2%;
}

.card-header {
  padding: 0px !important;
}

.btn-eadtools-rounded {
  border-radius: 50%;
  cursor: pointer;
  display: inline-block;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
  position: relative;
  height: 40px;
  width: 40px;
  background-color: #d696ef;
  z-index: 2;
  border: none;
  color: white;
  margin: 0 0.2rem;
}

.btn-group {
  position: absolute;
  margin: 1% 75% !important;
}

.sortable-drag {
  opacity: 0;
}

.flip-list-move {
  transition: transform 0.5s;
}

.ghost {
  border-left: 6px solid rgb(0, 183, 255);
  border-radius: 5px;
  opacity: 0.5;
}

.card {
  margin-bottom: 15px;
  max-width: 80% !important;
}

.handle {
  cursor: move !important;
}

li {
  list-style-type: none;
}
</style>
