<template>
    <div class="col-12">
        <div class="card-box text-center">
            <h3>{{lang["current-plan"]}} 
                <span v-if="plan == 'starter'" class="text-eadtools">starter<i class="far fa-paper-plane"></i></span>
                <span v-if="plan == 'pro'" class="text-eadtools">pro <i class="fas fa-plane-departure"></i> </span>
                <span v-if="plan == 'enterprise'" class="text-eadtools">enterprise <i class="fas fa-fighter-jet"></i></span>
            </h3>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '../../components/helper/HelperLang'


Vue.use(VueAxios, axios)
export default {
  data: () => {
    return {
      plan: '',
      lang: {},
    }
  },
  mounted(){
    eventLang.$on('lang', function(response){
      this.lang = response;
    }.bind(this));
  },
  created: function(){
    /* Get a url root to production enviroment */
    var loc = window.location.href;var arr = loc.split("/");var url = arr[0] + "//" + arr[2]
    /* Do a http get request to get company plan */
    axios.get(process.env.NODE_ENV === 'production' ? ''+url+'/company/get_company' : 'http://localhost/company/get_company')
    .then(function (response){
        this.plan = response.data["plan"];
    }.bind(this));
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
  .ead-md{margin-left: 0.8em;}
</style>
