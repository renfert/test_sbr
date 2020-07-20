<template>
<div :class="contentShow == false ? 'hide' : 'main'">
    <div class="row">
        <div class="col-12">
            <div  class="card-box card-course">
                <module-list :course="courseId"></module-list>
            </div>
        </div>
    </div>
   
    <!-- Module create modal -->
    <module-create></module-create>
</div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import toastr from 'toastr'
import ModuleList from '@/components/modules/ModuleList'
import ModuleCreate from '@/components/modules/ModuleCreate'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/newcourse/App'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
Vue.use(VueAxios, axios)
Vue.use(toastr)


export default {
    mixins: [domains,alerts],
    components: {
        ModuleList,
        ModuleCreate
    },
    data: () => {
        return {
            lang: {}, // Language 
            contentShow: false,
            courseId: '',
        }
    },
    created(){
        /* New course */
        eventBus.$on('new-course', function(response){
            this.courseId = response;
        }.bind(this));
    },
    mounted(){

        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));

        /* Show this content */
        eventBus.$on('response-access-second-step', function(response){
            if(response == true){
                this.contentShow = true;
            }
        }.bind(this));
        

        /* Access first step */
        eventBus.$on('access-first-step', function(){
            this.contentShow = false;
        }.bind(this));

        /* Access third step */
        eventBus.$on("access-third-step", function(){
            this.contentShow = false;
        }.bind(this));
    },
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>


.form-wizard-wrapper {
  max-width: 100%;
  height:100%;
  margin: 0 auto;
  overflow: hidden;
  position: relative;
  padding-top: 8px;
  z-index: 1;
}

/* Default sizes */
.form-row>.col, .form-row>[class*=col-]{
    padding-right:20px !important;
    padding-left:20px !important;
}

.form-row{
    padding:0px !important;
}
.editr {
    height:200px;
}


.card-course{
    margin: 30px
}


/* End default sizes */


/* ------------- Max 1024px ---------------- */
@media only screen and (max-width: 1024px) {
    .editr--toolbar {
        display:none !important;
    }
}


</style>
