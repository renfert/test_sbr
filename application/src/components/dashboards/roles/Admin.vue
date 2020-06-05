<template>
    <div class="main"  v-loading="loading">
        <lang></lang> 
        <!-- Widgets -->
        <div class="row mb-5">
            <div class="col-12 col-md-4">
                <a href="courses">
                    <div class="card-widget">
                        <div class="title-widget text-center">
                            <img src="@/assets/img/general/ux/view_course.png" alt="">
                            <h3 class="text-sabiorealm">{{lang["courses"]}}: <b>{{numberTotalOfCourses}}</b></h3>
                        </div>
                    </div>
                </a>
            </div>
             <div class="col-12 col-md-4">
                <a href="users">
                    <div class="card-widget">
                        <div class="title-widget text-center">
                            <img src="@/assets/img/general/ux/join_persons.png" alt="">
                            <h3 class="text-sabiorealm">{{lang["users"]}}: <b>{{numberTotalOfUsers}}</b></h3>
                        </div>
                    </div>
                </a>
            </div>
             <div class="col-12 col-md-4">
                <a href="javascript:void(0)">
                    <div class="card-widget">
                        <div class="title-widget text-center">
                            <img src="@/assets/img/general/ux/storage.png" alt="">
                            <el-tooltip class="item" effect="dark" :content="totalStorageUsed + ' GB / ' + totalStorageAvaiable + ' GB' " placement="bottom">
                                <h3 class="text-sabiorealm">{{lang["storage"]}} <b>10%</b></h3>
                            </el-tooltip>
                        </div>
                    </div>
                </a>
            </div>
        </div><!-- End Widgets -->


        <div class="row mb-5">
            <div class="col-12 col-md-6">
                <div class="card-widget" style="height:350px;overflow-y: scroll;border-radius:10px 0px 0px 10px !important;">
                    <div class="activities-title text-center mb-5">
                        <h3>Last activities</h3>
                    </div>
                
                    <!-- Activity -->
                    <div class="activity-item mb-3">
                        <div class="row">
                            <div class="col-2">
                                <img style="width:70px;margin-top:15%;"  :src="''+getCurrentDomainName()+'assets/uploads/avatar/20.png'" class="rounded-circle img-thumbnail img-responsive" alt="">
                            </div>
                            <div class="col-10 text-left">
                                <div class="activity-info">
                                    <h4><b class="text-sabiorealm">Tom lima </b> liked your work</h4>
                                    <span>About 21 minutes ago</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Activity -->

                    <!-- Activity -->
                    <div class="activity-item mb-3">
                        <div class="row">
                            <div class="col-2">
                                <img style="width:70px;margin-top:15%;"  :src="''+getCurrentDomainName()+'assets/uploads/avatar/20.png'" class="rounded-circle img-thumbnail img-responsive" alt="">
                            </div>
                            <div class="col-10 text-left">
                                <div class="activity-info">
                                    <h4><b class="text-sabiorealm">Tom lima </b> liked your work</h4>
                                    <span>About 21 minutes ago</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Activity -->

                     <!-- Activity -->
                    <div class="activity-item">
                        <div class="row">
                            <div class="col-2">
                                <img style="width:70px;margin-top:15%;"  :src="''+getCurrentDomainName()+'assets/uploads/avatar/20.png'" class="rounded-circle img-thumbnail img-responsive" alt="">
                            </div>
                            <div class="col-10 text-left">
                                <div class="activity-info">
                                    <h4><b class="text-sabiorealm">Tom lima </b> liked your work</h4>
                                    <span>About 21 minutes ago</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Activity -->

                    <div class="text-center mt-3">
                        <a href="javascript:void(0)" class="text-sabiorealm">Load more...</a>
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
import DrVueEcharts from 'dr-vue-echarts';
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
            totalStorageAvaiable: '',
            totalStorageUsed:'',    
            colors: ['#c3c3c3', '#c7c7c6'],
            students: [
                {
                    name: "Students",
                    data: [
                        {
                        label: "Jan",
                        value: 78
                        },
                        {
                        label: "Fev",
                        value: 67
                        },
                        {
                        label: "Mar",
                        value: 87
                        },
                        {
                        label: "Abr",
                        value: 58
                        }
                    ]
                },
                {
                    name: "Instructors",
                    data: [
                        {
                        label: "Jan",
                        value: 15
                        },
                        {
                        label: "Fev",
                        value: 8
                        },
                        {
                        label: "Mar",
                        value: 5
                        },
                        {
                        label: "Abr",
                        value: 3
                        }
                    ]
                },

            ],
            courses: [
                {
                    name: 'Not started',
                    value: 3,
                },
                {
                    name: 'In progress',
                    value: 5,
                },
                {
                    name: 'Finished',
                    value: 15,
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

        this.getStudentsChart();
        this.getSalesChart();
    },
    methods: {
        getStudentsChart: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("chart", "getStudentsChart");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                //this.students = response.data;
                this.students[0].data = response.data;
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
