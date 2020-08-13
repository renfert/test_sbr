<template>
  <div>
    <div class="card-box mt-5 text-center card-program">
      <h2>{{programName}}</h2>
      <h3>
        {{lang["total-courses-completed"]}}
        <b class="sbr-text-primary">{{totalCoursesCompleted}}</b>
      </h3>
      <hr />
      <div class="row item-row" v-for="element in courses" :key="element.id">
        <div v-if="element.status == 0" class="col-2 item-icon text-center item">
          <svg
            class="svg-inline--fa fa-check fa-w-2 completed"
            aria-hidden="true"
            data-prefix="fas"
            data-icon="check"
            role="img"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            data-fa-i2svg
          >
            <path
              fill="#00E1F0"
              d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"
            />
          </svg>
        </div>

        <div v-else class="col-2 item-icon text-center item" style="padding:15px 30px 15px 30px;">
          <svg
            class="svg-inline--fa fa-circle fa-w-16 uncompleted"
            aria-hidden="true"
            data-prefix="far"
            data-icon="circle"
            role="img"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            data-fa-i2svg
          >
            <path
              fill="currentColor"
              d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200z"
            />
          </svg>
        </div>

        <div class="col-8 mr-5 text-left item-name">
          <h3>
            <router-link class="sbr-text-primary" :to="'/viewcourse/'+element.id">{{element.course}}</router-link>
          </h3>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueTheMask from "vue-the-mask";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import { eventLang } from "@/components/helper/HelperLang";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

Vue.use(ElementUI);
Vue.use(VueTheMask);
Vue.use(VueAxios, axios);
export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      lang: {},
      courses: [],
      totalCoursesCompleted: "",
      programName: "",
      programId: ""
    };
  },
  created() {
    this.programId = this.$route.params.id;
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );

    this.listingCoursesToViewProgram();
  },
  methods: {
    listingCoursesToViewProgram: function() {
      var formData = new FormData();
      formData.set("programId", this.programId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "program",
        "listingCoursesToViewProgram"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          /* Success callback */
          this.courses = response.data;
          this.programName = response.data[0]["program"];
          this.completedCourses();
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }
      );
    },
    completedCourses: function() {
      var total = 0;
      for (let index = 0; index < this.courses.length; index++) {
        if (this.courses[index]["status"] == 0) {
          total = parseInt(total) + parseInt(1);
        }
      }
      this.totalCoursesCompleted = total;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
svg {
  width: 1.2em;
}

.card-program {
  z-index: 29999 !important;
}

.item-row {
  cursor: pointer;
  display: flex;
  justify-content: start;
  align-items: baseline;
}

.item-row:hover {
  background-color: rgba(230, 230, 230, 0.4);
}

.item-name {
  width: calc(100% - 120px);
  display: inline-block;
  vertical-align: top;
  top: 0;
  position: inherit;
  text-align: left;
  margin-left: -5%;
}

.item-name h3 {
  color: #9e9c9c;
  font-size: 1em;
}
</style>
