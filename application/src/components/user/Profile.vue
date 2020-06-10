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
                            <img style="width:180px;" :src="''+getCurrentDomainName()+'assets/uploads/avatar/1.png'" alt="user-img"  class="rounded-circle img-thumbnail img-responsive">
                        </div>
                    </div>
                    <img  src="@/assets/img/general/ux/profile_bg.png">
                </div>
                <div class="profile-info">
                    <h2>Kevin smith</h2>
                    <span class="text-sabiorealm">Instrutor</span>
                    <h4>kevin@studante.com</h4>
                    <br>
                </div>
            </div>    

            <div class="profile-charts mt-5">
                <div class="row">
                    <div class="col-12 col-md-6 mb-5">
                        <div class="card-widget" style="height:350px;">
                            <div class="chart">
                                <BarChart  
                                rainbow 
                                :data="data" 
                                smooth  />
                            </div>
                        </div>
                    </div>
                </div>
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
import { FacebookLoader } from 'vue-content-loader';
import DrVueEcharts from 'dr-vue-echarts';
Vue.use(DrVueEcharts)

locale.use(lang)
Vue.use(DataTables)
Vue.use(DataTablesServer)
Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    components: {
        FacebookLoader
    },
    mixins: [domains,alerts],
    props: ['user-id'],
    data: function() {
        return {   
            titles : [{prop: "title",label: "Title"}],
            enrolledCourses : [],
            notEnrolledCourses: [],
            filters: [{prop: 'title',value: ''}],
            tableProps: {defaultSort: {prop: 'title',order: 'descending'}},
            lang: {},
            modal : false,
            courses: [],
            loadingButton: false,
            loadingContent : false,
            loadingContentModal: false,
            data: [
                {
                name: "Courses",
                data: [
                    {
                        label: "In process",
                        value: 45
                    },
                    {
                        label: "Finished",
                        value: 60
                    },
                    {
                        label: "Not started",
                        value: 60
                    }
                ]
                }
            ]
        }
    },
    created(){
       
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        removeCourseFromUser: function(courseId){
            var formData = new FormData();
            formData.set("courseId", courseId);
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "removeCourseFromUser");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.getEnrolledCourses();
                this.getNotEnrolledCourses();
                this.successMessage();
            }, 
                // Failure callback
                function(){
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

</style>
