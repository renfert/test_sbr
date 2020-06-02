<template>
    <div class="loader" v-loading.fullscreen="loading">
      
    </div>
</template>

<script>
import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import {eventLang} from '../../components/helper/HelperLang'
Vue.use(ElementUI)
export default {
  data: () => {
    return {
      src: '',
      lang: {},
      loading: true
    }
  },
  mounted(){
    eventLang.$on('lang', function(response){  
      this.lang = response;
    }.bind(this));

    window.addEventListener("load", function(){
      this.loading = false;
    }.bind(this));
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

</style>
