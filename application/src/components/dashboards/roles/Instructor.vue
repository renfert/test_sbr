<template>
    <div class="main"  v-loading="loading">
        <lang></lang> 
        <div class="row">
            <div class="col-12 col-md-6 mb-5">
                <a href="courses">
                    <div class="card-widget">
                        <div class="title-widget text-center">
                            <img src="@/assets/img/general/ux/view_course.png" alt="">
                            <h3 class="text-sabiorealm">{{lang["courses"]}}: <b>{{numberTotalOfCourses}}</b></h3>
                        </div>
                    </div>
                </a>
            </div>
             <div class="col-12 col-md-6 mb-5">
                <a href="javascript:void(0)">
                    <div class="card-widget">
                        <div class="title-widget text-center">
                            <img src="@/assets/img/general/ux/join_persons.png" alt="">
                            <h3 class="text-sabiorealm">{{lang["students"]}}: <b>{{numberTotalOfStudents}}</b></h3>
                        </div>
                    </div>
                </a>
            </div>
        </div><!-- End Widgets -->



        <div class="row">
            <!-- Courses -->
            <div class="col-12 col-md-12 mb-5">
                <div class="card-widget" >
                    <GChart
                        v-if="coursesData != null"
                        type="PieChart"
                        :data="coursesData"
                        :options="coursesChartOptions"
                    />
                    <div class="row mb-5" v-else>
                        <div class="col-12 text-center">
                            <img style="width:20%;" src="@/assets/img/general/ux/not_found.png" alt="No activities">
                            <h4 class="no-results-text">{{lang["no-data"]}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Activities></Activities>
    </div> 
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import Activities from '@/components/activity/Activities.vue'
import Lang from '@/components/helper/HelperLang.vue'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import VueGoogleCharts from 'vue-google-charts'
Vue.use(VueGoogleCharts)


locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    components: {
        Lang,
        Activities
    },
    mixins: [domains,alerts],
    data: () => {
        return {
            coursesData: [],
            coursesChartOptions: {
                title:'Courses',
                colors: ['#00A9B4', '#29277F', "#6959CD"]
            },
            lang: {},
            loading: false,
            numberTotalOfStudents: 0,
            numberTotalOfCourses: '',
            activities: [],   
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.getTotalNumberOfStudents();
        this.getTotalNumberOfCourses();
        this.getCourses();
        this.listActivities();
    },
    methods: {
        getCourses: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("chart","getCourses");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.coursesData = response.data;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        getTotalNumberOfStudents: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("widgets", "getTotalNumberOfStudents");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.numberTotalOfStudents = response.data;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        getTotalNumberOfCourses: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("widgets", "getTotalNumberOfCourses");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.numberTotalOfCourses = response.data;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        listActivities: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("activity", "listingStudentsActivities");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.activities = response.data
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
