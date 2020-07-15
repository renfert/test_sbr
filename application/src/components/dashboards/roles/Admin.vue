<template>
    <div class="main"  v-loading="loading">
        <lang></lang> 
        <!-- Widgets -->
        <div class="row">
            <div class="col-12 col-md-4 mb-5">
                <a href="courses">
                    <div class="card-widget">
                        <div class="title-widget text-center">
                            <img src="@/assets/img/general/ux/view_course.png" alt="">
                            <h3 class="text-sabiorealm">{{lang["courses"]}}: <b>{{numberTotalOfCourses}}</b></h3>
                        </div>
                    </div>
                </a>
            </div>
             <div class="col-12 col-md-4 mb-5">
                <a href="users">
                    <div class="card-widget">
                        <div class="title-widget text-center">
                            <img src="@/assets/img/general/ux/join_persons.png" alt="">
                            <h3 class="text-sabiorealm">{{lang["users"]}}: <b>{{numberTotalOfUsers}}</b></h3>
                        </div>
                    </div>
                </a>
            </div>
             <div class="col-12 col-md-4 mb-5">
                <a href="javascript:void(0)">
                    <div class="card-widget">
                        <div class="title-widget text-center">
                            <img src="@/assets/img/general/ux/storage.png" alt="">
                            <el-tooltip  class="item" effect="dark" :content="totalStorageUsed + ' GB / ' + totalStorageAvaiable + ' GB' " placement="bottom">
                                <h3 class="text-sabiorealm">{{lang["storage"]}} <b>{{storagePercent}} %</b></h3>
                            </el-tooltip>
                        </div>
                    </div>
                </a>
            </div>
        </div><!-- End Widgets -->



        <div class="row">
            <!-- Students -->
            <div class="col-12 col-md-6 mb-5">
                <div class="card-widget chart">
                    <GChart
                        v-if="usersData != null"
                        type="ColumnChart"
                        :data="usersData"
                        :options="usersChartOptions"
                    />
                    <div class="row mb-5" v-else>
                        <div class="col-12 text-center">
                            <img style="width:40%;" src="@/assets/img/general/ux/not_found.png" alt="No activities">
                            <h4 class="no-results-text">{{lang["no-data"]}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses -->
            <div class="col-12 col-md-6 mb-5">
                <div class="card-widget chart" >
                    <GChart
                        v-if="coursesData != null"
                        type="PieChart"
                        :data="coursesData"
                        :options="coursesChartOptions"
                    />
                    <div class="row mb-5" v-else>
                        <div class="col-12 text-center">
                            <img style="width:40%;" src="@/assets/img/general/ux/not_found.png" alt="No activities">
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
import Lang from '@/components/helper/HelperLang.vue'
import Activities from '@/components/activity/Activities.vue'
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
            usersData: [],
            coursesData: [],
            usersChartOptions: {
                title:'New users',
                colors: ['#00A9B4', '#29277F']
            },
            coursesChartOptions: {
                title:'Courses',
                colors: ['#00A9B4', '#29277F', "#6959CD"]
            },
            lang: {},
            loading: false,
            numberTotalOfUsers: '',
            numberTotalOfCourses: '',
            plan: '',
            storagePercent:'',
            activities: [],
            totalStorageAvaiable: '',
            totalStorageUsed:'',    
        }
    },
    created(){
        this.getCompanyInformation();
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        
        this.getTotalNumberOfUsers();
        this.getTotalNumberOfCourses();
        this.getRegisteredUsersPerMonth();
        this.getCourses();
        this.listActivities();
    },
    methods: {
        getRegisteredUsersPerMonth: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("chart", "getRegisteredUsersPerMonth");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.usersData = response.data;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
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
        getTotalNumberOfUsers: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("widgets", "getTotalNumberOfUsers");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.numberTotalOfUsers = response.data;
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
        getStorage: function(storageAvaiable){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("widgets", "getStorage");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.totalStorageUsed = response.data;
                this.storagePercent = (100 * parseInt(response.data) / parseInt(storageAvaiable)).toFixed(2);
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        getCompanyInformation: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("company", "getCompanyInformation");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.plan = response.data["plan"];

                if(response.data["plan"] == "basic"){
                    this.totalStorageAvaiable = 32;
                }

                if(response.data["plan"] == "pro"){
                    this.totalStorageAvaiable = 64;
                }

                if(response.data["plan"] == "growth"){
                    this.totalStorageAvaiable = 128;
                }

                if(response.data["plan"] == "bussiness"){
                    this.totalStorageAvaiable = 512;
                }

                if(response.data["plan"] == "trial"){
                    this.totalStorageAvaiable = 64;
                }

                this.getStorage(this.totalStorageAvaiable);
                
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        listActivities: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("activity", "listingAll");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.activities = response.data
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        viewUser: function(id){
            sessionStorage.setItem('sbr_user_id', ''+id+'');
            if(process.env.NODE_ENV === 'production'){
                window.location.href="pages/user";
            }else{
                window.location.href="user";
            }
        },
        viewCourse: function(id){
            sessionStorage.setItem('sbr_course_id', ''+id+'');
            if(process.env.NODE_ENV === 'production'){
                window.location.href="pages/viewcourse";
            }else{
                window.location.href="viewcourse";
            }
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.chart {
  width: 100%;
  height:300px;
  max-height: 100%;
}

@media only screen and (max-width: 600px) {
    .chart {
        height: 100%;
    }
}

.user-avatar{
    width:70px;
}



.card-widget {
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    background-color:white;
    border-radius: 10px;
    padding:30px;
}


.card-widget:hover {
  box-shadow: 0 0px 7px rgba(70, 67, 67, 0.25), 0 5px 5px rgba(70, 67, 67, 0.25);
}



::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
	width: 2px;
	background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    background-color: #0ae;
	
	background-image: -webkit-gradient(linear, 0 0, 0 100%,
    color-stop(.5, rgba(255, 255, 255, .2)),
	color-stop(.5, transparent), to(transparent));
}

</style>
