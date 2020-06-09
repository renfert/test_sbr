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
                            <el-tooltip class="item" effect="dark" :content="totalStorageUsed + ' GB / ' + totalStorageAvaiable + ' GB' " placement="bottom">
                                <h3 class="text-sabiorealm">{{lang["storage"]}} <b>0,6%</b></h3>
                            </el-tooltip>
                        </div>
                    </div>
                </a>
            </div>
        </div><!-- End Widgets -->


        <div class="row">
            <!-- Students -->
            <div class="col-12 col-md-6 mb-5">
                <div class="card-widget" style="height:350px;">
                    <div class="chart">
                        <line-chart :data="students" smooth  />
                    </div>
                </div>
            </div>

            <!-- Students -->
            <div class="col-12 col-md-6">
                <div class="card-widget" style="height:350px;">
                    <div class="chart">
                        <line-chart :data="students" smooth  />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 mb-5">
                <div class="card-widget" style="overflow-y: scroll; height:500px;border-radius:10px 0px 0px 10px !important;">
                    <div class="activities-title text-center mb-5">
                        <h3>Last activities</h3>
                    </div>
            
                     <!-- Activity -->
                    <div 
                        class="activity-item mb-4"
                        v-for="element in activities"
                        :key="element.id"    
                    >
                        <div class="row">
                            <div class="col-12 col-md-2">
                                <img   :src="''+getCurrentDomainName()+'assets/uploads/avatar/'+element.avatar+''" class="rounded-circle img-thumbnail img-responsive user-avatar" alt="">
                            </div>
                            <div class="col-10 text-left">

                                <!-- Course created -->
                                <div class="activity-info" v-if="element.type == 'course-created' ">
                                    <h4>
                                        <a 
                                            @click.prevent="viewUser(element.create_user)" href="javascript:void(0)">
                                            <b class="text-sabiorealm">{{element.name}} </b>
                                        </a> 
                                        {{lang["activity-course-created"]}}
                                        <a 
                                            @click.prevent="viewCourse(element.mycourse_id)" href="javascript:void(0)">
                                            <b class="text-sabiorealm">{{element.title}} </b>
                                        </a> 
                                     </h4>
                                    <span>{{processDateTime(element.date)}}</span>
                                </div>

                                <!-- Course deleted -->
                                <div class="activity-info" v-if="element.type == 'course-deleted' ">
                                    <h4>
                                        <a 
                                            @click.prevent="viewUser(element.create_user)" href="javascript:void(0)">
                                            <b class="text-sabiorealm">{{element.name}} </b>
                                        </a> 
                                        {{lang["activity-course-deleted"]}}
                                        <b class="text-danger">{{element.course_title}} </b>
                                     </h4>
                                    <span>{{processDateTime(element.date)}}</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Activity -->

                    <div class="text-center mt-3">
                        <a href="javascript:void(0)" class="text-sabiorealm">Load more...</a>
                    </div>
                </div>
            </div>
        </div>
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
import DrVueEcharts from 'dr-vue-echarts/packages/line';
Vue.use(DrVueEcharts)




locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    components: {
        Lang,
    },
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            loading: false,
            numberTotalOfUsers: '',
            numberTotalOfCourses: '',
            plan: '',
            activities: [],
            totalStorageAvaiable: '',
            totalStorageUsed:'',    
            colors: ['#c3c3c3', '#c7c7c6'],
            students: [
                {
                    name: "Students",
                    data: []
                },
                {
                    name: "Instructors",
                    data: []
                },

            ],
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
        this.getStorage();
        this.getRegisteredStuentsPerMonth();
        this.getRegisteredInstructorsPerMonth();
        this.listActivities();
    },
    methods: {
        getRegisteredStuentsPerMonth: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("chart", "getRegisteredStuentsPerMonth");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.students[0].data = response.data;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        getRegisteredInstructorsPerMonth: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("chart","getRegisteredInstructorsPerMonth");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.students[1].data = response.data;
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
                this.numberTotalOfUsers = response.data["total"];
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
                this.numberTotalOfCourses = response.data["total"];
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        getStorage: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("widgets", "getStorage");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.totalStorageUsed = response.data
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
                    this.totalStorageAvaiable = 64;
                }

                if(response.data["plan"] == "growth"){
                    this.totalStorageAvaiable = 128;
                }

                if(response.data["plan"] == "bussiness"){
                    this.totalStorageAvaiable = 512;
                }
                
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
            if(process.env.NODE_ENV === 'production'){
                window.location.href="pages/user/"+id+"";
            }else{
                window.location.href="user/"+id+"";
            }
        },
        viewCourse: function(id){
            if(process.env.NODE_ENV === 'production'){
                window.location.href="pages/viewcourse/"+id+"";
            }else{
                window.location.href="viewcourse/"+id+"";
            }
        },
        processDateTime: function(date){
            var dt1 = new Date();
            var dt2 = new Date(date);
            var diffTime = Math.abs(dt2 - dt1); 
            var diffinMinutes = diffTime / (1000 * 60); 
            var diffInHours = diffTime / (1000 * 60 * 60); 

            var day = dt2.getDate();
            var month = dt2.getMonth();
            var year = dt2.getFullYear()


            if(diffinMinutes > 60){
                if(diffInHours < 24){
                    return this.lang["activity-about-time-hour"] + Math.round(diffInHours) + this.lang["activity-time-hour-ago"];
                }else{
                    return day + '/' + month + '/' + year;
                }
            }else{
                return this.lang["activity-few-minutes-ago"];
            }
          
            
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.chart {
  width: 100%;
  height:100%;
  max-height: 100%;
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

.activities-title h3{
    color: #9e9c9c;
}

.activity-item{
    height:70px;
    cursor: pointer;
    background-color: rgba(230, 230, 230, 0.4);
    padding:0px 0px 30px 30px;
    border-radius: 20px;
}

.activity-item:hover{
    background-color: rgba(214, 211, 211, 0.4);
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
