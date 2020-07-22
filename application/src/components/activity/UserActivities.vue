<template>
    <div class="main"  v-loading="loading">
        <lang></lang> 
        <div class="row" v-if="activities != null">
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
                                <el-avatar :size="70" fit="contain"  :src="getUrlToContents() + 'avatar/'+element.avatar+''"></el-avatar>
                            </div>
                            <div class="col-10 text-left">

                                <!-- Course created -->
                                <div class="activity-info" v-if="element.type == 'course-created' ">
                                    <h4>
                                        <a 
                                            @click.prevent="viewUser(element.create_user)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.name}} </b>
                                        </a> 
                                        {{lang["activity-course-created"]}}
                                        <a 
                                            @click.prevent="viewCourse(element.mycourse_id)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.title}} </b>
                                        </a> 
                                        <i class="ti-blackboard text-success"></i>
                                     </h4>
                                    <span>{{processDateTime(element.date)}}</span>
                                </div>

                                <!-- Course deleted -->
                                <div class="activity-info" v-if="element.type == 'course-deleted' ">
                                    <h4>
                                        <a 
                                            @click.prevent="viewUser(element.create_user)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.name}} </b>
                                        </a> 
                                        {{lang["activity-course-deleted"]}}
                                        <b class="sbr-text-primary">{{element.course_title}} </b>
                                        <i class="ti-trash text-danger"></i>
                                     </h4>
                                    <span>{{processDateTime(element.date)}}</span>
                                </div>

                                <!-- Course edited -->
                                <div class="activity-info" v-if="element.type == 'course-edited' ">
                                    <h4>
                                        <a 
                                            @click.prevent="viewUser(element.create_user)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.name}} </b>
                                        </a> 
                                        {{lang["activity-course-edited"]}}
                                        <a 
                                            @click.prevent="viewCourse(element.mycourse_id)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.title}} </b>
                                        </a> 
                                        <i class="ti-pencil-alt text-warning"></i>
                                     </h4>
                                    <span>{{processDateTime(element.date)}}</span>
                                </div>

                                <!-- Lesson finished -->
                                <div class="activity-info" v-if="element.type == 'lesson-finished' ">
                                    <h4>
                                        <a 
                                            @click.prevent="viewUser(element.create_user)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.name}} </b>
                                        </a> 
                                        {{lang["activity-finished-lesson"]}}
                                        <b class="sbr-text-primary">{{element.lessonTitle}} </b>
                                        {{lang["in-the-course"]}}
                                        <a 
                                            @click.prevent="viewCourse(element.mycourse_id)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.title}} </b>
                                        </a> 
                                        <i class="ti-arrow-circle-down text-success"></i>
                                     </h4>
                                    <span>{{processDateTime(element.date)}}</span>
                                </div>

                                <!-- Course finished -->
                                <div class="activity-info" v-if="element.type == 'course-finished' ">
                                    <h4>
                                        <a 
                                            @click.prevent="viewUser(element.create_user)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.name}} </b>
                                        </a> 
                                        {{lang["activity-course-finished"]}}
                                        <a 
                                            @click.prevent="viewCourse(element.mycourse_id)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.title}} </b>
                                        </a> 
                                        <i class="ti-arrow-circle-down text-success"></i>
                                     </h4>
                                    <span>{{processDateTime(element.date)}}</span>
                                </div>

                                <!-- Logout -->
                                <div class="activity-info" v-if="element.type == 'logout' ">
                                    <h4>
                                        <a 
                                            @click.prevent="viewUser(element.create_user)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.name}} </b>
                                        </a> 
                                        {{lang["activity-logout"]}}
                                        <i class="ti-shift-left text-danger"></i>
                                     </h4>
                                    <span>{{processDateTime(element.date)}}</span>
                                </div>

                                <!-- Login -->
                                <div class="activity-info" v-if="element.type == 'login' ">
                                    <h4>
                                        <a 
                                            @click.prevent="viewUser(element.create_user)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.name}} </b>
                                        </a> 
                                        {{lang["activity-login"]}}
                                        <i class="ti-shift-right text-success"></i>
                                     </h4>
                                    <span>{{processDateTime(element.date)}}</span>
                                </div>

                                <!-- Program created -->
                                <div class="activity-info" v-if="element.type == 'program-created' ">
                                    <h4>
                                        <a 
                                            @click.prevent="viewUser(element.create_user)" href="javascript:void(0)">
                                            <b class="sbr-text-primary">{{element.name}} </b>
                                        </a> 
                                        {{lang["activity-program-created"]}}
                                        <i class="ti-layers-alt text-success"></i>
                                     </h4>
                                    <span>{{processDateTime(element.date)}}</span>
                                </div>

                            </div>
                        </div>
                    </div> <!-- End Activity -->
                </div>
            </div>
        </div>

        <div class="row mb-5" v-else>
            <div class="col-12 text-center">
                <img class="no-results-img" src="@/assets/img/general/ux/no_notification.png" alt="No activities">
                <h4 class="no-results-text">{{lang["no-activities"]}}</h4>
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


locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    components: {
        Lang,
    },
    props:["user-id"],
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            loading: false,
            activities: [],
            currentDate: ''
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.getCurrentDate();
        this.listActivities();
    
    },
    methods: {
        listActivities: function(){
            var formData = new FormData();
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("activity", "listingUserActivities");
            axios.post(urlToBeUsedInTheRequest,formData).then((response) => {
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
            window.location.href="user";
        },
        viewCourse: function(id){
            sessionStorage.setItem('sbr_course_id', ''+id+'');
            window.location.href="viewcourse";
        },
        getCurrentDate(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("verify", "getCurrentDate");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.currentDate = response.data;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        processDateTime: function(date){
            var dt1 = new Date(this.currentDate);
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
