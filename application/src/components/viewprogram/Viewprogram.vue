<template>
    <div class="col-12">
        
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'


Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: function() {
        return {
            lang: {}
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
    },
    methods: {
        getProgram: function(){
            var form = document.getElementById('form-category')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("program", "getCourses")
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
            /* Success callback */
            if(response.data == false){ 
                this.categoryAlreadyExistsMessage();
            }else{
                this.successMessage();
                this.actionsToBePerformedAfterRegistration();       
            }
            },
            /* Error callback */
            function(){
                this.errorMessage();  
            }
            );
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
  
</style>
