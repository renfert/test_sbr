<template>
    <div class="col-12" v-loading="loading">
        <lang></lang> 
        <admin v-if="roleId == 1"></admin>  
        <instructor v-if="roleId == 2"></instructor>
        <student v-if="roleId == 3"></student>
    </div> 
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import Lang from '@/components/helper/HelperLang.vue'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import Admin from '@/components/home/roles/Admin'
import Instructor from '@/components/home/roles/Instructor'
import Student from '@/components/home/roles/Student'



locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    components: {
        Lang,
        Admin,
        Instructor,
        Student
    },
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            loading: false,
            roleId: '',
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.getProfile();

    },
    methods: {
        getProfile: function (){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserProfile");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.roleId = response.data["myrole_id"];
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.chart {
  width: 100%;
  height: 300px;
}
</style>
