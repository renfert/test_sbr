<template>
    <div class="row construction">
        <div class="col-12 text-center">
            <img class="no-results-img" src="@/assets/img/general/ux/no_persons.png" alt="No courses">
            <h4 class="no-results-text">{{lang["under-construction-title"]}}</h4>
            <p>{{lang["under-construction-subtitle"]}}</p>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '@/components/helper/HelperLang'


Vue.use(VueAxios, axios)
export default {
  name: 'Create',
  data: function() {
    return {
      name: '',
      color: '',
      lang: {},
      invalidField: false
    }
  },
  mounted(){
    /* Get a language */
    var ins = this;
      eventLang.$on('lang', function(response){
      ins.lang = response;
    });
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
  .construction{
    margin-top: 15%;
  }
</style>
