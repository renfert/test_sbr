<template>
    <div class="col-auto"  v-loading="loading">
       <div class="row gap5">
           <div class="col-12 col-md-4 list-courses" v-for="element in programList" :key="element.id">
               <!-- Card -->
                <div class="card">
                
                    <a  @click.prevent="viewProgram(element.id,element.expirationDays,element.releaseDays)" v-if="element.photo != '' && element.photo != null">
                        <!-- Card image -->
                        <img :src="getUrlToContents() + 'program/'+element.photo+''" class="card-img-top">
                    </a>

                    <a  @click.prevent="viewProgram(element.id,element.expirationDays,element.releaseDays)" v-else>
                        <img  class="card-img-top" src="@/assets/img/general/ux/course_image_default.png" alt="Card image cap">
                    </a>
                    
                    <!-- Card content -->
                    <div class="card-body">
                        <!-- Title -->
                        <h4 class="card-title"><a @click.prevent="viewProgram(element.id,element.expirationDays,element.releaseDays)">{{element.title}}</a></h4>

                        <el-progress v-if="parseInt(((100 * element.finishedLessons) /  element.lessons )) > 0"  :percentage="parseInt(((100 * element.finishedLessons) /  element.lessons ))"></el-progress>

                        <el-progress v-else  percentage="0"></el-progress>

                        <el-tag
                            class="mt-2"
                            v-if="element.expirationDays < 0"
                            type="danger">
                            {{lang["program-expired"]}} {{element.expiration_date}}
                        </el-tag>

                        <el-tag
                            class="mt-2"
                            v-if="element.releaseDays > 0"
                            type="primary">
                            {{lang["program-avaiable-in"]}} {{element.release_date}}
                        </el-tag>

                        <el-divider v-if="roleId != 3"><i class="el-icon-more-outline"></i></el-divider>
                        <el-row v-if="roleId != 3">
                            <el-button class="btn-sabiorealm" @click.prevent="editProgram(element.id)" type="primary" icon="el-icon-edit" circle></el-button>
                            <template>
                                <el-popconfirm
                                    confirmButtonText='Ok'
                                    cancelButtonText='No, Thanks'
                                    placement="right"
                                    :title="lang['question-delete-program'] + element.title  + '?'"
                                    @onConfirm="deleteProgram(element.id)"
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
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import 'element-ui/lib/theme-chalk/index.css'


locale.use(lang)
Vue.use(DataTables)
Vue.use(DataTablesServer)
Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: function() {
        return {   
            titles : [{prop: "title",label: "Title"}],
            programList : [],
            filters: [{prop: 'title',value: ''}],
            tableProps: {defaultSort: {prop: 'title',order: 'descending'}},
            lang: {},
            modal : false,
            loading: false,
            roleId: ''
        }
    },
    created(){
        this.getProgram();
        this.getUserProfile();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        editProgram:function(id){
            if(process.env.NODE_ENV === 'production'){
                window.location.href="pages/editprogram/"+id+"";
            }else{
                 window.location.href="editprogram/"+id+"";
            }
        },

        deleteProgram: function(id){
            var formData = new FormData();
            formData.set("programId", id);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("program", "delete");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
                this.getProgram();    
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        viewProgram: function(id,expirationDays,releaseDays){
            
            if(releaseDays == null){
                releaseDays = -1;
            }

            if(expirationDays == null){
                expirationDays = 1;
            }

            if(expirationDays > 0  && releaseDays <= 0){
                sessionStorage.setItem('sbr_program_id', ''+id+'');
                if(process.env.NODE_ENV === 'production'){
                    window.location.href="pages/viewprogram";
                }else{
                    window.location.href="viewprogram";
                }
            }
        },
        getProgram(){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("program", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.programList = response.data; 
                this.loading = false;
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }
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
