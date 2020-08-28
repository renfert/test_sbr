<template>
  <div>
    <ul id="container">
      <li
        class="box"
        :class="active2 == true || active3 == true ? 'active' : '' "
        @click.prevent="accessFirstStep"
      >
        <a class="form-wizard-link" href="#">
          <span class="numberCircle active">1</span>
        </a>
      </li>
      <li class="box" :class="active3 == true ? 'active' : '' " @click.prevent="accessSecondStep">
        <a class="form-wizard-link" :class="active2 == true ? 'active' : '' " href="#">
          <span
            class="numberCircle v-step-3"
            :class="active2 == true || active3 == true ? 'active': '' "
          >2</span>
        </a>
      </li>
      <li class="box" @click.prevent="accessThirdStep">
        <a class="form-wizard-link" :class="active3 == true ? 'active' : '' " href="#">
          <span class="numberCircle" :class="active3 == true ? 'active': '' ">3</span>
        </a>
      </li>
    </ul>
    <hr class="mt-5" />

    <!------------------------ 
            Basic information text 
    -------------------------->
    <div clas="row text-center" v-if="active1">
      <div class="col-12 text-center">
        <h3 class="sbr-text-grey">{{lang['basic-information']}}</h3>
      </div>
    </div>

    <!------------------------ 
            Content text 
    -------------------------->
    <div clas="row text-center" v-if="active2">
      <div class="col-12 text-center">
        <h3 class="sbr-text-grey">{{lang['content']}}</h3>
      </div>
    </div>

    <!------------------------ 
            Publish text 
    -------------------------->
    <div clas="row text-center" v-if="active3">
      <div class="col-12 text-center">
        <h3 class="sbr-text-grey">{{lang['publish']}}</h3>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";

import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
export default {
  data: function() {
    return {
      active1: true,
      active2: false,
      active3: false
    };
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    accessSecondStep() {
      // Emit event to inform the attempt to access the second step
      eventBus.$emit("access-second-step");
      this.active1 = false;
      this.active2 = true;
      this.active3 = false;
    },

    accessFirstStep: function() {
      // Emit event to inform the attempt to access the first step
      eventBus.$emit("access-first-step");
      this.active1 = true;
      this.active2 = false;
      this.active3 = false;
    },

    accessThirdStep: function() {
      // Emit event to inform the attempt to access the second step
      eventBus.$emit("access-third-step");
      this.active1 = false;
      this.active2 = false;
      this.active3 = true;
    }
  }
};
</script>

<style lang="scss" scoped>
.form-wizard-wrapper ul {
  z-index: 1 !important;
  position: relative;
  width: 100%;
  border-radius: 0px 0px;
  display: flex;
  justify-content: center;
  padding: 0;
  z-index: 300;
  margin-left: -2%;
}

.form-wizard-wrapper ul li {
  list-style-type: none;
  width: 33.3%;
  text-align: center;
  display: flex;
  justify-content: center;
  height: 40px;
  cursor: pointer;
}

.form-wizard-wrapper ul li a {
  display: block;
  width: 100%;
  color: black;
  text-decoration: none;
  font-size: 1em;
  line-height: 2;
  font-family: "Poppins", sans-serif;
  padding: 5px;
}

.form-wizard-wrapper ul li a.active {
  display: block;
  left: 0;
  top: 0px;
  bottom: 0px;
  border-radius: 4px;
  width: 100%;
  color: black;
  text-decoration: none;
  font-size: em;
  line-height: 2;
  font-family: "Poppins", sans-serif;
  -webkit-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -moz-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -ms-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -o-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
}

.form-wizard-wrapper ul li a span {
  position: absolute;
  background: white;
  z-index: 1;
  font-size: 1.5rem;
  line-height: 2;
  width: 50px;
  height: 50px;
  font-style: normal;
  font-family: "Poppins", sans-serif;
  border-radius: 50%;
  padding: 1px;
  border: 2px solid #9e9c9c;
  color: #9e9c9c;
  text-align: center;
}

/* ----------------- End default sizes ----- */

/* ------------- Max 1024px ---------------- */
@media only screen and (max-width: 1024px) {
  .form-wizard-wrapper ul {
    width: 100%;
    margin-top: 15%;
    margin-left: -7%;
    z-index: 0 !important;
  }

  .form-wizard-wrapper ul li a {
    font-size: 0.8em;
  }

  .form-wizard-wrapper ul li a.active {
    font-size: 0.8em;
    margin-top: 0;
  }
}

/* ------------- End max 1024px ---------------- */

@media only screen and (min-width: 1400px) {
  .form-wizard-wrapper ul {
    width: 100%;
  }
}

.numberCircle.active {
  color: #009cd8 !important;
  border: 2px solid #009cd8;
}

.box {
  position: relative;
  text-align: center;
  display: inline-block;
}

#container .box:not(:last-child):after {
  position: absolute;
  content: "";
  right: -51%;
  top: 30%;
  width: 100%;
  height: 50%;
  border-bottom: 8px solid #9e9c9c;
}

#container .box.active:nth-child(1)::after {
  border-bottom: 8px solid #009cd8 !important;
}

#container .box.active:nth-child(2)::after {
  border-bottom: 8px solid #009cd8 !important;
}
</style>
