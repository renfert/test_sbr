<template>
    <div class="col-auto">

        <facebook-loader 
            v-if="loadingContent == true"
            :speed="2"
            width="700"
            height="200"
            primaryColor = "#f0f0f0"
            secondaryColor = "#d9d9d9"
        >
        </facebook-loader>

        <div class="row mt-5" v-else>
            <div class="col-12 col-md-4 list-courses" v-for="element in courseList" :key="element.id">
               <!-- Card -->
                <div class="card">
                
                    <a @click.prevent="viewCourse(element.id)" v-if="element.photo != '' && element.photo != null">
                        <!-- Card image -->
                        <img :src="getUrlToContents() + 'course/'+element.photo+''" style="height:200px;" class="card-img-top">
                    </a>

                    <a  @click.prevent="viewCourse(element.id)" v-else>
                        <img style="height:200px;" class="card-img-top" src="@/assets/img/general/ux/course_image_default.png" alt="Card image cap">
                    </a>

                    <!-- Card content -->
                    <div class="card-body">

                        <!-- Title -->
                        <h4 class="card-title"><a @click.prevent="viewCourse(element.id)">{{element.title}}</a></h4>
                        <el-progress v-if="parseInt(((100 * element.finishedLessons) /  element.lessons )) >=0 "  :percentage="parseInt(((100 * element.finishedLessons) /  element.lessons ))"></el-progress>

                        <el-progress v-else  percentage="0"></el-progress>
                        
                        <el-divider v-if="roleId != 3"><i class="el-icon-more-outline"></i></el-divider>
                        <el-row v-if="roleId != 3">
                            <el-button class="btn-sabiorealm" @click.prevent="editCourse(element.id)" type="primary" icon="el-icon-edit" circle></el-button>
                            <template>
                                <el-popconfirm
                                    confirmButtonText='Ok'
                                    cancelButtonText='No, Thanks'
                                    placement="right"
                                    :title="lang['question-delete-course'] + element.title  + '?'"
                                    @onConfirm="deleteCourse(element.id)"
                                >
                                <el-button class="btn-sabiorealm-danger" slot="reference" type="danger" icon="el-icon-delete" circle></el-button>
                                </el-popconfirm>
                            </template>
                        </el-row>

                    </div>

                </div>
                <!-- Card -->
            </div>
        </div>    
    </div><!-- End col-12 -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import { DataTables, DataTablesServer } from 'vue-data-tables'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/courses/App'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import 'element-ui/lib/theme-chalk/index.css'
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
    data: function() {
        return {   
            titles : [{prop: "title",label: "Title"}],
            courseList : [],
            filters: [{prop: 'title',value: ''}],
            tableProps: {defaultSort: {prop: 'title',order: 'descending'}},
            validatorName: {F: {pattern: /^[a-zA-Z0-9\u00C0-\u00FF ]*$/,}},
            categoryId: '',
            categoryName: '',
            newCategoryName: '',
            lang: {},
            modal : false,
            loadingContent: false,
            roleId: ''
        }
    },
    created(){
        this.getCourses();
        this.getUserProfile();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        editCourse:function(id){
            sessionStorage.setItem('sbr_course_id', ''+id+'');
            if(process.env.NODE_ENV === 'production'){
                window.location.href="pages/editcourse";
            }else{
                 window.location.href="editcourse";
            }
        },

        deleteCourse: function(id){
            var formData = new FormData();
            formData.set("courseId", id);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "delete");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
                this.getCourses();
                eventBus.$emit("course-deleted");    
            }, 
            
                function(){
                    this.errorMessage();
                }
            );
        },
        viewCourse: function(id){
            sessionStorage.setItem('sbr_course_id', ''+id+'');
            if(process.env.NODE_ENV === 'production'){
                window.location.href="pages/viewcourse";
            }else{
                 window.location.href="viewcourse";
            }
        },
        getCourses(){
            this.loadingContent = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.courseList = response.data; 
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
        getUserProfile(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserProfile");
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.roleId = response.data["myrole_id"];
            }.bind(this));
        },
    }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.list-courses{
    margin-bottom: 50px !important;
}
</style>
