<template>
    <div></div>
</template>

<script>

import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'


/* Event bus to handle communication between components */
export const eventLang = new Vue();

Vue.use(VueAxios, axios)

export default {
  created(){
    this.getSettingsInformation();
  },
  methods: {
    getSettingsInformation(){
      var urlToBeUsedInTheRequest = this.chooseDomainForDevOrProductonEnviroment("settings", "getSettingsInformation");
      axios.get(urlToBeUsedInTheRequest).then(function (response) {
        var lang = require('../../../language/'+response.data["lang"]+'/lang.json');
        eventLang.$emit('lang', lang); 
      }.bind(this));
    },
    chooseDomainForDevOrProductonEnviroment(controler,model){
        var entireUrl = window.location.href;
        var entireUrlDividedIntoTwoParts = entireUrl.split("/");
        var domainName = entireUrlDividedIntoTwoParts[0] + "//" + entireUrlDividedIntoTwoParts[2];
        var url = process.env.NODE_ENV === 'production' ? ''+domainName+'/'+controler+'/'+model : ''+process.env.VUE_APP_URL_DEV+controler+'/'+model
        return url;
    },
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
