<template>
    <ul>
      <li @click.prevent="accessFirstStep">
        <a class="form-wizard-link" :class="active1 == true ? 'active' : '' " href="#">
          <span>
              {{lang["first-step-course"]}} <i v-if="firstStep == true" class="fas fa-check-circle fa-1x text-white pl-2"></i> 
              <div v-if="active1 == true" class="arrow"></div>
          </span>
        </a>
      </li>
      <li @click.prevent="accessSecondStep">
        <a class="form-wizard-link" :class="active2 == true ? 'active' : '' " href="#">
          <span>
            {{lang["second-step-course"]}} <i v-if="secondStep == true" class="fas fa-check-circle fa-1x text-white"></i>
            <div v-if="active2 == true" class="arrow"></div>
          </span>
        </a>
      </li>
      <li @click.prevent="accessThirdStep">
        <a class="form-wizard-link" :class="active3 == true ? 'active' : '' " href="#">
          <span>
          {{lang["third-step-course"]}} <i v-if="thirdStep == true" class="fas fa-check-circle"></i>
          </span>
        </a>
      </li>
    </ul>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/newcourse/App'

Vue.use(VueAxios, axios)
export default {
  data: () => {
    return {
      firstStep: false,
      secondStep: false,
      thirdStep: false,
      active1: true,
      active2: false,
      active3: false,
      color: '',
      lang: {},
      invalidField: false
    }
  },
  mounted(){
    /* Get a language */
    eventLang.$on('lang', function(response){
      this.lang = response;
    }.bind(this));

    eventBus.$on('response-access-second-step', function(response){
      if(response == true){
        this.active1 = false;
        this.active2 = true;
        this.active3 = false;
        this.firstStep = true;
      }
    }.bind(this));

    eventBus.$on("response-access-third-step", function(response){
      if(response == true){
        this.active1 = false;
        this.active2 = false;
        this.active3 = true
        this.firstStep = true;
        this.secondStep = true;
      }
    }.bind(this));
  },
  methods: {
    accessSecondStep: function(){
      // Emit event to inform the attempt to access the second step
      eventBus.$emit('access-second-step');
    },
    accessFirstStep: function(){
      // Emit event to inform the attempt to access the second step
      eventBus.$emit('access-first-step');
      this.active1 = true;
      this.active2 = false;
      this.active3 = false;
    },
    accessThirdStep: function(){
      // Emit event to inform the attempt to access the second step
      eventBus.$emit("access-third-step");
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>



/* ----------------- Default sizes ----------- */

.form-wizard-wrapper ul {
  background-color:#373C41;
  z-index: 1;
  position:absolute;
  width:100%;
  border-radius: 0px 0px;
  display: flex;
  justify-content: center;
  padding: 0;
}

.form-wizard-wrapper ul li {
  list-style-type: none;
  width: 33.3%;
  text-align: center;
  display: flex;
  justify-content: center;
  height:40px;
  cursor: pointer;
}



.form-wizard-wrapper ul li a {
    display: block;
    width: 100%;
    color: white;
    text-decoration: none;
    font-size: 1em;
    line-height: 2;
    font-family: 'Poppins', sans-serif;
    padding:5px;
}

.form-wizard-wrapper ul li a.active {
  display: block;
  left: 0;
  top: 0px;
  bottom: 0px;
  border-radius: 4px;
  width: 100%;
  color: white;
  text-decoration: none;
  font-size: 1em;
  line-height: 2;
  font-family: 'Poppins', sans-serif;
  background-color: #00A9B4 ;
  -webkit-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -moz-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -ms-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  -o-transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
  transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1) 0s;
}

.form-wizard-wrapper ul li a span {
  position: relative;
  z-index: 1;
  font-size: 0.85rem;
  line-height: 2;
  font-style: normal;
  font-family: 'Poppins', sans-serif;
}

/* ----------------- End default sizes ----- */


/* ------------- Max 1024px ---------------- */
@media only screen and (max-width: 1024px) {
    .form-wizard-wrapper ul {
      width:100%;
      margin-top:-11%;
    }

    .form-wizard-wrapper ul li a {
        font-size:0.8em;
    }

    .form-wizard-wrapper ul li a.active {
        font-size:0.8em;
        margin-top:0;
    }
}

/* ------------- End max 1024px ---------------- */

@media only screen and (min-width:1400px){
    .form-wizard-wrapper ul {
        width:100%;
    }
}

.arrow,
.arrow:before {
  position: absolute;
  left: 50%;
}

.arrow {
  top:100%;
  width: 20px;
  height: 20px;
  margin: -20px 0 0 70px;
  -webkit-transform: rotate(-45deg);
  border-left: none;
  border-top: none;
  border-right: 2px #fff solid;
  border-bottom: 2px #fff solid;
}

  
.arrow:before {
  content: '';
  width: 15px;
  height: 15px;
  top: 50%;
  margin: -10px 0 0 -10px;
  border-left: none;
  border-top: none;
  border-right: 1px #fff solid;
  border-bottom: 1px #fff solid;
  animation-duration: 2s;
  animation-iteration-count: infinite;
  animation-name: arrow;
}
  
@keyframes arrow {
  0% {
    opacity: 1; }
  100% {
    opacity: 0; 
    transform: translate(-10px, -10px); }
}

</style>
