<template>
    <div class="col-auto gap5">
        
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
            
            <!-- Courses list content -->
            <div class="course-content" v-if="enrolledCourses != null">
                <div style="margin-bottom: 10px" >
                    <el-row>
                        <el-col :span="6">
                            <el-input v-model="filters[0].value" placeholder="Search"></el-input>
                        </el-col>
                        <el-col :span="2">
                            <el-button  @click.prevent="addCourse"  class="sbr-btn sbr-purple" icon="el-icon-plus" circle></el-button>
                        </el-col>
                    </el-row>
                </div>
                <data-tables :pagination-props="{ background: true, pageSizes: [5] }"  :data="enrolledCourses   "  :filters="filters">
                    <el-table-column v-for="title in titles"  sortable="custom" :prop="title.prop" :label="title.label" :key="title.label">
                    </el-table-column>

                    <el-table-column label="Actions" align="center">
                        <template slot-scope="scope">
                            <!-- Remove course -->
                            <el-popconfirm  
                            confirmButtonText='Ok'
                            cancelButtonText='No, Thanks'
                            :title="lang['remove-course-question'] + scope.row.title  + '?'"
                            @onConfirm="removeCourseFromUser(scope.row.id)"
                            >
                                <el-button class="sbr-btn sbr-danger" slot="reference" icon="el-icon-delete" circle></el-button>
                            </el-popconfirm>
                        </template>
                    </el-table-column>
                </data-tables>
            </div> <!-- Courses list content -->

            <div class="row mb-5 mt-5" v-else>
                <div class="col-12 text-center">
                    <img class="no-results-img" src="@/assets/img/general/ux/no_courses.png" alt="No persons">
                    <h4 class="no-results-text">{{lang["no-results-courses-in-user"]}}</h4>
                    <el-button   
                        class="sbr-btn sbr-primary"
                        @click="addCourse()"
                        type="primary"  
                        size="medium">
                        {{lang["add-course"]}}
                    </el-button>
                </div>
            </div>

        </div>

        
        <!-- Add new course dialog -->
        <el-dialog  :visible.sync="modal" :title="lang['join-courses']" center  top="5vh">

            <facebook-loader 
                v-if="loadingContentModal == true"
                :speed="2"
                width="700"
                height="200"
                primaryColor = "#f0f0f0"
                secondaryColor = "#d9d9d9"
            >
            </facebook-loader>

            <div v-else>
                <div v-if="notEnrolledCourses != null">
                    <template>
                        <el-transfer
                            filterable
                            :titles="['Courses', 'User']"
                            v-model="courses"
                            :data="notEnrolledCourses">
                        </el-transfer>
                    </template>
                    <br>
                    <el-button   
                        class="btn-sabiorealm"
                        v-loading="loadingButton" 
                        @click="enrollUserIntoCourses()"
                        type="primary"  
                        size="medium">
                        {{lang["save-button"]}}
                    </el-button>
                </div>

                <div class="row mb-5 mt-5" v-else>
                    <div class="col-12 text-center">
                        <img class="no-results-img" src="@/assets/img/general/ux/no_courses.png" alt="No courses">
                        <h4 class="no-results-text">{{lang["all-courses-already-added"]}}</h4>
                    </div>
                </div>

            </div>

        </el-dialog>

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
            loadingContentModal: false
        }
    },
    created(){
        this.getEnrolledCourses();
        this.getNotEnrolledCourses();
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
      
        addCourse: function(){
            this.modal=true;
        },
        enrollUserIntoCourses: function(){
            this.loadingButton = true;
            var formData = new FormData();
            formData.set("userId", this.userId);
            formData.set("courses", this.courses);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "enrollUserIntoCourses");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.loadingButton = false;
                this.successMessage();
                this.modal = false;
                this.getEnrolledCourses();
                this.getNotEnrolledCourses();
                this.courses = [];
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        getEnrolledCourses(){
            this.loadingContent = true;
            var formData = new FormData();
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getEnrolledCourses");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.enrolledCourses = response.data; 
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
        getNotEnrolledCourses: function(){
            this.loadingContentModal = true;
            var formData = new FormData();
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getNotEnrolledCourses");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.notEnrolledCourses = response.data; 
                setTimeout(function(){ 
                    this.loadingContentModal = false;
                }.bind(this), 1000);
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        }
    },
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    .image-no-results{
        width:60%;
    }
    .box-no-results{
       background-color: #F9FBFC;
    }
    .text-no-results{
        margin-top:15%;
    }

</style>
