<template>
    <div>
        <facebook-loader 
            v-if="loadingContent == true"
            :speed="2"
            width="700"
            height="200"
            primaryColor = "#f0f0f0"
            secondaryColor = "#d9d9d9"
        >
        </facebook-loader>

        

        <div v-else>
            <div class="row" style="background-color:#F3F6F6;">
                <div class="img-container">
                    <div class="img-profile-container">
                        <div class="user-img">
                            <el-avatar :size="180" fit="contain" :src="getUrlToContents() + 'avatar/'+userAvatar+''"></el-avatar>
                        </div>
                    </div>
                    <img  src="@/assets/img/general/ux/profile_bg.png">
                </div>
                <div class="profile-info">
                    <h2>{{userName}}</h2>
                    <span v-if="role == 2" class="text-sabiorealm">{{lang["instructor"]}}</span>
                    <span v-else class="text-sabiorealm">{{lang["student"]}}</span>
                    <h4>{{userEmail}}</h4>
                    <br>
                </div>
            </div>    

            <div class="profile-charts mt-5">
                <div class="row">
                    <div class="col-12 col-md-6 mb-5">
                        <div class="card-widget" style="height:350px;">
                            <GChart
                                v-if="coursesData != null"
                                class="mt-5"
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
                    <div class="col-12 col-md-6 mb-5">
                        <div class="card-widget" style="overflow-y: scroll; height:350px;border-radius:10px 0px 0px 10px !important;">

                            <div v-if="exams != null">
                                <h3 class="exams-title">{{lang["exams"]}}</h3>
                                
                                <div class="exams-list-header">
                                    <div class="row">
                                        <div class="col-4">
                                            <h4>Exam</h4>
                                        </div>
                                        <div class="col-4">
                                            <h4>Score</h4>
                                        </div>
                                        <div class="col-4">
                                            <h4>Course</h4>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="exams-list-body"> 
                                    <div class="row exam-item" v-for="element in exams" :key="element.id">
                                        <div class="col-4">
                                            <h4>
                                                <i v-if="parseInt(element.score) > parseInt(element.approval)" class=" ti-pin-alt text-sabiorealm"></i> 

                                                <i v-else class=" ti-pin-alt text-danger"></i>
                            
                                                {{element.exam}}
                                            </h4>
                                        </div>
                                        <div class="col-4">
                                            <h4>{{element.score}}</h4>
                                        </div>
                                        <div class="col-4">
                                            <h4>{{element.course}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-5 mt-5" v-else>
                                <div class="col-12 text-center">
                                    <img class="no-results-img" src="@/assets/img/general/ux/no_exams.png" alt="No persons" style="width:30%;">
                                    <br><br>
                                    <h4 class="no-results-text">{{lang["no-results-exam"]}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <user-activities :user-id="userId"></user-activities>
            </div>
        </div>

    
    </div><!-- End col-auto -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import { DataTables, DataTablesServer } from 'vue-data-tables'
import {eventLang} from '@/components/helper/HelperLang'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import UserActivities from '@/components/activity/UserActivities'
import { FacebookLoader } from 'vue-content-loader';
import VueGoogleCharts from 'vue-google-charts'
Vue.use(VueGoogleCharts)


locale.use(lang)
Vue.use(DataTables)
Vue.use(DataTablesServer)
Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    components: {
        FacebookLoader,
        UserActivities
    },
    mixins: [domains,alerts],
    props: ['user-id'],
    data: function() {
        return {   
            lang: {},
            userName: '',
            userEmail: '',
            userAvatar: '',
            role: '',
            exams:[],
            coursesData: [],
            coursesChartOptions: {
                title:'Courses',
                colors: ['#00A9B4', '#29277F', "#6959CD"]
            },
            loadingContent: false,
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));

        this.getCourses(this.userId);
        this.getUser();
        this.getUserExams();
    },
    methods:{
        getUser: function(){
            this.loadingContent = true;
            var formData = new FormData();
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "get");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.userName = response.data["name"];
                this.userEmail = response.data["email"];
                this.userAvatar = response.data["avatar"];
                this.role = response.data["myrole_id"];
                setTimeout(function(){ 
                    this.loadingContent = false;
                }.bind(this), 1000);
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        }, 
        getUserExams: function(){
            var formData = new FormData();
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserExams");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.exams = response.data;
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        }, 
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
    },
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

.img-container{
    width:100%;
    height:200px;
    overflow:hidden;
    margin: 0px !important;
    margin-top: -15px !important;
}



.profile-info{
    margin-top:1%;
    margin-left:30%;
    text-align:left;
}

.profile-info h2,span,h4{
    line-height: 15px;
}

.img-profile-container{
    color:white;
    position:absolute;
    width:400px;
    margin-top:12%;
}

.chart {
  width: 100%;
  height:100%;
  max-height: 100%;
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

.exams-title{
    color: #9e9c9c;
}

.exams-list-header{
    background-color: rgba(230, 230, 230, 0.4);
    border-radius: 10px;
    margin-bottom:5%;
}

.exam-item{
    cursor:pointer;
    border-bottom: 1px  solid rgba(230, 230, 230, 0.4);
    padding:5px;
}

.exam-item:hover{
    background-color: rgba(230, 230, 230, 0.4);
}

</style>
