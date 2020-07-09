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
        
            <!-- Program list content -->
            <div class="course-content" v-if="programsInsideGroup != null">
                <div class="mb-5">
                    <el-row>
                        <el-col :span="6" class="mr-5">
                            <el-input v-model="filters[0].value" placeholder="Search"></el-input>
                        </el-col>
                        <el-col :span="2">
                            <el-button  @click.prevent="addProgram"  class="sbr-btn sbr-purple" icon="el-icon-plus" circle></el-button>
                        </el-col>
                    </el-row>
                </div>
                <data-tables :pagination-props="{ background: true, pageSizes: [5] }"  :data="programsInsideGroup"  :filters="filters">
                    <el-table-column v-for="title in titles"  sortable="custom" :prop="title.prop" :label="title.label" :key="title.label">
                    </el-table-column>
                    
                    <el-table-column label="Actions" align="center">
                        <template slot-scope="scope">
                            <!-- Remove program -->
                            <el-popconfirm  
                            confirmButtonText='Ok'
                            cancelButtonText='No, Thanks'
                            :title="lang['remove-program-question'] + scope.row.title  + '?'"
                            @onConfirm="removeProgramFromGroup(scope.row.id)"
                            >
                                <el-button class="sbr-btn sbr-danger" slot="reference"  icon="el-icon-delete" circle></el-button>
                            </el-popconfirm>
                        </template>
                    </el-table-column>
                </data-tables>
            </div> <!-- Program list content -->

            <!-- No programs found content -->
            <div  v-else>
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <img class="no-results-img" src="@/assets/img/general/ux/not_found.png" alt="No activities">
                        <h4 class="no-results-text mb-3">{{lang["no-results-programs-in-group"]}}</h4>
                         <el-button   
                            class="sbr-btn sbr-primary"
                            @click="addProgram()"
                        >
                            {{lang["add-program"]}}
                        </el-button>
                    </div>
                </div>
            </div>
            <!-- No programs found content end -->
        </div>

        
        <!-- Add new course dialog -->
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

                <div v-if="programsOutsideGroup != null">
                    <template>
                        <el-transfer
                            filterable
                            :titles="['Programs', 'Group']"
                            v-model="programs"
                            :data="programsOutsideGroup">
                        </el-transfer>
                    </template>
                    <br>
                    <el-button   
                        v-loading="loadingButton" 
                        class="sbr-btn sbr-primary"
                        @click="savePrograms()"
                    >
                        {{lang["save-button"]}}
                    </el-button>
                </div>

                 <!-- No programs found  -->
                <div  v-else>
                    <div class="row mb-5">
                        <div class="col-12 text-center">
                            <img class="no-results-img" src="@/assets/img/general/ux/not_found.png" alt="No activities">
                            <h4>{{lang["all-programs-already-added"]}}</h4>
                        </div>
                    </div>
                </div>
                <!-- No programs found content end -->
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
            titles : [{prop: "title",label: "Title"}],
            programsInsideGroup : [],
            programsOutsideGroup: [],
            filters: [{prop: 'title',value: ''}],
            tableProps: {defaultSort: {prop: 'title',order: 'descending'}},
            lang: {},
            loadingButton: false,
            loadingContent : false,
            loadingContentModal: false,
            modal : false,
            programs: [],
        }
    },
    created(){
        this.getProgramsInsideTheGroup();
        this.getProgramsOutsideTheGroup();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        removeProgramFromGroup: function(programId){
            var formData = new FormData();
            formData.set("programId", programId);
            formData.set("groupId", this.groupId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "removeProgramFromGroup");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.getProgramsInsideTheGroup();
                this.getProgramsOutsideTheGroup();
                this.successMessage();
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        savePrograms: function(){
            this.loadingButton = true;
            var formData = new FormData();
            formData.set("groupId", this.groupId);
            formData.set("programs", this.programs);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "saveProgramsIntoGroup");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.loadingButton = false;
                this.modal = false;
                this.getProgramsInsideTheGroup();
                this.getProgramsOutsideTheGroup();
                this.programs = [];
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
        getProgramsInsideTheGroup(){
            this.loadingContent = true;
            var formData = new FormData();
            formData.set("groupId", this.groupId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "getProgramsInsideGroup");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.programsInsideGroup = response.data; 
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
        getProgramsOutsideTheGroup: function(){
            this.loadingContentModal = true;
            var formData = new FormData();
            formData.set("groupId", this.groupId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "getProgramsOutsideGroup");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.programsOutsideGroup = response.data; 
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
