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
        
            <!-- Instructors list  -->
            <div class="course-content" v-if="instructorsInsideGroup != null">
                <div style="margin-bottom: 10px" >
                    <el-row>
                        <el-col :span="6">
                            <el-input v-model="filters[0].value" placeholder="Search"></el-input>
                        </el-col>
                        <el-col :span="6">
                            <el-button  @click.prevent="addInstructor" style="margin-left:15%;" class="btn-sabiorealm" icon="el-icon-plus" circle></el-button>
                        </el-col>
                    </el-row>
                </div>
                <data-tables :pagination-props="{ background: true, pageSizes: [5] }"  :data="instructorsInsideGroup"  :filters="filters">
                    <el-table-column v-for="title in titles"  sortable="custom" :prop="title.prop" :label="title.label" :key="title.label">
                    </el-table-column>

                    <el-table-column label="Actions" align="center">
                        <template slot-scope="scope">
                            <!-- Remove instructor -->
                            <el-popconfirm  
                            confirmButtonText='Ok'
                            cancelButtonText='No, Thanks'
                            :title="lang['remove-instructor-question'] + scope.row.name  + '?'"
                            @onConfirm="removeInstructorFromGroup(scope.row.id)"
                            >
                                <el-button 
                                    class="btn-sabiorealm-danger" 
                                    slot="reference" 
                                    type="danger"  
                                    size="medium" 
                                    icon="el-icon-delete" 
                                    circle>
                                </el-button>
                            </el-popconfirm>
                        </template>
                    </el-table-column>
                </data-tables>
            </div> <!-- Instructors list content -->

            <!-- No instructors found  -->
            <div class="card-box box-no-results" v-else>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="text-no-results">
                            <h4 class="mb-4">{{lang["no-results-instructors-in-group"]}}</h4>
                            <el-button  
                                class="btn-sabiorealm" 
                                @click="addInstructor()"
                                type="primary"  
                                size="medium">
                                {{lang["add-instructor"]}}
                            </el-button>
                        </div>
                    </div>
                    <div class="col-6">
                        <img class="image-no-results" src="@/assets/img/general/ux/no_persons.png" alt="">
                    </div>
                </div>
            </div>
            <!-- No instructors found content end -->
        </div>

        
        <!-- Add new instructor dialog -->
        <el-dialog  :visible.sync="modal" :title="lang['join-instructors']" center  top="5vh">

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

                <div v-if="instructorsOutsideGroup != null">
                    <template>
                        <el-transfer
                            filterable
                            :titles="['Instructors', 'Group']"
                            v-model="instructors"
                            :data="instructorsOutsideGroup">
                        </el-transfer>
                    </template>
                    <br>
                    <el-button   
                        v-loading="loadingButton" 
                        class="btn-sabiorealm"
                        @click="saveInstructors()"
                        type="primary"  
                        size="medium">
                        {{lang["save-button"]}}
                    </el-button>
                </div>

                <!-- No instructors found content -->
                <div class="card-box box-no-results" v-else>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-5">
                            <div class="text-no-results">
                                <h5>{{lang["all-instructors-already-added"]}}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <img class="image-no-results" src="@/assets/img/general/ux/no_persons.png" alt="">
                        </div>
                    </div>
                </div>
                <!-- No instructors found content end -->
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
    props: ['group-id'],
    data: function() {
        return {   
            titles : [{prop: "name",label: "Name"}],
            instructorsInsideGroup : [],
            instructorsOutsideGroup: [],
            filters: [{prop: 'name',value: ''}],
            tableProps: {defaultSort: {prop: 'name',order: 'descending'}},
            lang: {},
            loadingButton: false,
            loadingContent : false,
            loadingContentModal: false,
            modal : false,
            instructors: [],
        }
    },
    created(){
        this.getInstructorsInsideTheGroup();
        this.getInstructorsOutsideTheGroup();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        removeInstructorFromGroup: function(instructorId){
            var formData = new FormData();
            formData.set("userId", instructorId);
            formData.set("groupId", this.groupId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "removeUserFromGroup");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.getInstructorsInsideTheGroup();
                this.getInstructorsOutsideTheGroup();
                this.successMessage();
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        saveInstructors: function(){
            this.loadingButton = true;
            var formData = new FormData();
            formData.set("groupId", this.groupId);
            formData.set("users", this.instructors);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "saveUsersIntoGroup");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.loadingButton = false;
                this.modal = false;
                this.getInstructorsInsideTheGroup();
                this.getInstructorsOutsideTheGroup();
                this.instructors = [];
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        addInstructor: function(){
            this.modal=true;
        },
        getInstructorsInsideTheGroup(){
            this.loadingContent = true;
            var formData = new FormData();
            formData.set("groupId", this.groupId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "getInstructorsInsideGroup");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.instructorsInsideGroup = response.data; 
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
        getInstructorsOutsideTheGroup: function(){
            this.loadingContentModal = true;
            var formData = new FormData();
            formData.set("groupId", this.groupId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "getInstructorsOutsideGroup");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.instructorsOutsideGroup = response.data; 
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
        margin-top:10%;
    }

</style>
