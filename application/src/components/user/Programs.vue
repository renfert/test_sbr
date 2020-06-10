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
            
            <!-- Programs list content -->
            <div class="program-content" v-if="enrolledPrograms != null">
                <div style="margin-bottom: 10px" >
                    <el-row>
                        <el-col :span="6">
                            <el-input v-model="filters[0].value" placeholder="Search"></el-input>
                        </el-col>
                        <el-col :span="6">
                            <el-button  @click.prevent="addProgram" style="margin-left:15%;" class="btn-sabiorealm" icon="el-icon-plus" circle></el-button>
                        </el-col>
                    </el-row>
                </div>
                <data-tables :pagination-props="{ background: true, pageSizes: [5] }"  :data="enrolledPrograms"  :filters="filters">
                    <el-table-column v-for="title in titles"  sortable="custom" :prop="title.prop" :label="title.label" :key="title.label">
                    </el-table-column>

                    <el-table-column label="Actions" align="center">
                        <template slot-scope="scope">
                            <!-- Remove program -->
                            <el-popconfirm  
                            confirmButtonText='Ok'
                            cancelButtonText='No, Thanks'
                            :title="lang['remove-program-question'] + scope.row.title  + '?'"
                            @onConfirm="removeProgramFromUser(scope.row.id)"
                            >
                                <el-button class="btn-sabiorealm-danger" slot="reference" type="danger"  size="medium" icon="el-icon-delete" circle></el-button>
                            </el-popconfirm>
                        </template>
                    </el-table-column>
                </data-tables>
            </div> <!-- Programs list content -->

            <div class="row mb-5 mt-5" v-else>
                <div class="col-12 text-center">
                    <img class="no-results-img" src="@/assets/img/general/ux/no_programs.png" alt="No programs">
                    <h4 class="no-results-text">{{lang["no-results-programs-in-user"]}}</h4>
                    <el-button   
                        class="btn-sabiorealm"
                        @click="addProgram()"
                        type="primary"  
                        size="medium">
                        {{lang["add-program"]}}
                    </el-button>
                </div>
            </div>

        </div>

        
        <!-- Add new program dialog -->
        <el-dialog  :visible.sync="modal" :title="lang['join-programs']" center  top="5vh">

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
                <div v-if="notEnrolledPrograms != null">
                    <template>
                        <el-transfer
                            filterable
                            :titles="['Courses', 'User']"
                            v-model="programs"
                            :data="notEnrolledPrograms">
                        </el-transfer>
                    </template>
                    <br>
                    <el-button   
                        class="btn-sabiorealm"
                        v-loading="loadingButton" 
                        @click="enrollUserIntoPrograms()"
                        type="primary"  
                        size="medium">
                        {{lang["save-button"]}}
                    </el-button>
                </div>

                <div class="row mb-5 mt-5" v-else>
                    <div class="col-12 text-center">
                        <img class="no-results-img" src="@/assets/img/general/ux/no_programs.png" alt="No programs">
                        <h4 class="no-results-text">{{lang["all-programs-already-added"]}}</h4>
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
            enrolledPrograms : [],
            notEnrolledPrograms: [],
            filters: [{prop: 'title',value: ''}],
            tableProps: {defaultSort: {prop: 'title',order: 'descending'}},
            lang: {},
            modal : false,
            programs: [],
            loadingButton: false,
            loadingContent : false,
            loadingContentModal: false
        }
    },
    created(){
        this.getEnrolledPrograms();
        this.getNotEnrolledPrograms();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        removeProgramFromUser: function(programId){
            var formData = new FormData();
            formData.set("programId", programId);
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "removeProgramFromUser");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.getEnrolledPrograms();
                this.getNotEnrolledPrograms();
                this.successMessage();
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
      
        addProgram: function(){
            this.modal=true;
        },
        enrollUserIntoPrograms: function(){
            this.loadingButton = true;
            var formData = new FormData();
            formData.set("userId", this.userId);
            formData.set("programs", this.programs);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "enrollUserIntoPrograms");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.loadingButton = false;
                this.successMessage();
                this.modal = false;
                this.getEnrolledPrograms();
                this.getNotEnrolledPrograms();
                this.programs = [];
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        getEnrolledPrograms(){
            this.loadingContent = true;
            var formData = new FormData();
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getEnrolledPrograms");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.enrolledPrograms = response.data; 
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
        getNotEnrolledPrograms: function(){
            this.loadingContentModal = true;
            var formData = new FormData();
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getNotEnrolledPrograms");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.notEnrolledPrograms = response.data; 
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
