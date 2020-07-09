<template>
    <div class="main"  v-loading="loading">
        <lang></lang> 
        <div class="row mb-5">
            <!-- Courses -->
            <div class="col-12 col-md-12">
                <div class="card-widget" >
                    <GChart
                        v-if="coursesData"
                        type="PieChart"
                        :data="coursesData"
                        :options="coursesChartOptions"
                    />
                </div>
            </div>
        </div>    
        <user-activities v-if="userId != 0" :user-id="userId"></user-activities>
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
import VueGoogleCharts from 'vue-google-charts'
import UserActivities from '@/components/activity/UserActivities.vue'
Vue.use(VueGoogleCharts)


locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    components: {
        Lang,
        UserActivities
    },
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            userId: 0,
            loading: false,
            coursesData: [],
            coursesChartOptions: {
                title:'Courses',
                colors: ['#00A9B4', '#29277F', "#6959CD"]
            },
        }
    },
    created() {
        this.getUserProfile();
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
    },
    methods: {
        getCourses: function(studentId){
            var formData = new FormData();
            formData.set("studentId", studentId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("chart","getStudentCourses");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.coursesData = response.data;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        getUserProfile: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user","getUserProfile");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.userId = response.data["id"];
                this.getCourses(response.data["id"]);
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        }
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
