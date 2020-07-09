<template>
    <div class="col-12">  
        <div class="card-box table-responsive" v-if="userList != null">

            <facebook-loader 
                v-if="loadingContent == true"
                :speed="2"
                width="700"
                primaryColor = "#f0f0f0"
                secondaryColor = "#d9d9d9"  
            >
            </facebook-loader>

            <div v-else>
                <div>
                    <h4><b>{{lang["list-user"]}}</b></h4>
                    <div style="margin-bottom: 10px">
                        <el-row>
                            <el-col :span="6">
                                <el-input v-model="filters[0].value" placeholder="Search"></el-input>
                            </el-col>
                            <el-col v-if="userList != null" :span="6">
                                <export-excel
                                    :data="userList"
                                    name = "users.xls"
                                >
                                    <el-tooltip class="item" effect="dark" :content="lang['export']" placement="top">
                                        <el-button class="sbr-btn sbr-purple ml-3"  type="primary" icon="el-icon-download" circle></el-button>
                                    </el-tooltip>
                                
                                </export-excel>
                            </el-col>
                        </el-row>
                    </div>
                    <data-tables :pagination-props="{ background: true, pageSizes: [5] }"  :data="userList"  :filters="filters">
                        <el-table-column 
                            v-for="title in titles"  
                            sortable="custom" 
                            :prop="title.prop" 
                            :label="title.label" 
                            :key="title.label"
                        >
                        </el-table-column>
                        
                        <el-table-column  label="Actions" align="center">
                            <template slot-scope="scope">
                                <!-- Manage user -->
                                <el-button @click="viewUser(scope.row.id)" class="sbr-btn sbr-primary" icon="el-icon-user" circle></el-button>
                            
                                <!-- Delete User -->
                                <el-popconfirm  
                                confirmButtonText='Ok'
                                cancelButtonText='No, Thanks'
                                placement="right"
                                :title="lang['question-delete-user'] + scope.row.name  + '?'"
                                @onConfirm="deleteUser(scope.row.id)"
                                >
                                <el-button  class="sbr-btn sbr-danger ml-1"  slot="reference" icon="el-icon-delete" circle></el-button>
                                </el-popconfirm>
                            </template>
                        </el-table-column>
                    </data-tables>
                </div> 
            </div>
        </div>  <!-- End User list -->

        <div class="row mb-5 mt-5" v-else>
            <div class="col-12 text-center">
                <img class="no-results-img" src="@/assets/img/general/ux/no_persons.png" alt="No persons">
                <h4 class="no-results-text">{{lang["no-results-user-title"]}}</h4>
            </div>
        </div>
    </div><!-- End col-12 -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { DataTables, DataTablesServer } from 'vue-data-tables'
import {eventBus} from '@/pages/categories/App'
import {eventLang} from '@/components/helper/HelperLang'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import excel from 'vue-excel-export'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import { FacebookLoader } from 'vue-content-loader';

Vue.use(excel)
locale.use(lang)
Vue.use(DataTables)
Vue.use(DataTablesServer)
Vue.use(ElementUI)
Vue.use(VueAxios, axios)
export default {
    components: {
        FacebookLoader
    },
    mixins: [domains,alerts],
    data: function() {
        return {   
            titles : [{prop: "name",label: "Name"}, {prop: "role", label: "Role"}],
            userList: [], // Data information to Datatable   
            filters: [{prop: 'name',value: ''}],
            tableProps: {defaultSort: {prop: 'name',order: 'descending'}},
            lang: {},
            loadingContent : false
        }
    },
    created(){
        this.getUsers();
        eventBus.$on('new-user', function(){
            this.getUsers();
        }.bind(this));
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        deleteUser(id){
            var formData = new FormData();
            formData.set('id', id);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "delete");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.successMessage();
                this.getUsers();  // Update list state
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
              
        },
        viewUser: function(id){
            sessionStorage.setItem('sbr_user_id', ''+id+'');
            window.location.href="user";
        },
        getUsers(){
            this.loadingContent = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.userList = response.data; 
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
    }
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
