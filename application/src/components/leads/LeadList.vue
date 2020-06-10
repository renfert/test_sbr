<template>
    <div class="col-12">
        <div class="card-box table-responsive" v-if="leadList != null">

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
                    <div>
                        <el-row>
                            <el-col :span="6">
                                <el-input v-model="filters[0].value" placeholder="Search"></el-input>
                            </el-col>
                            <el-col v-if="leadList != null" :span="6">
                                <export-excel
                                    :data="leadList"
                                    name = "leads.xls"
                                >
                                    <el-tooltip class="item" effect="dark" :content="lang['export']" placement="top">
                                        <el-button class="btn-export"  type="primary" icon="el-icon-download" circle></el-button>
                                    </el-tooltip>
                                
                                </export-excel>
                            </el-col>
                        </el-row>
                    </div>
                    <data-tables  :pagination-props="{ background: true, pageSizes: [5] }"  :data="leadList"  :filters="filters">
                        <el-table-column 
                            v-for="title in titles"  
                            sortable="custom" 
                            :prop="title.prop" 
                            :label="title.label" 
                            :key="title.label">
                        </el-table-column>
                    </data-tables>
                </div>  
            </div>
        </div>

        <div class="row gap-20" v-else>
            <div class="col-12 text-center">
                <img class="no-results-img" src="@/assets/img/general/ux/not_found.png" alt="No leads">
                <h4 class="no-results-text">{{lang["no-leads-found"]}}</h4>
            </div>
        </div>

      
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import { DataTables } from 'vue-data-tables'
import {eventLang} from '@/components/helper/HelperLang'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import excel from 'vue-excel-export'
import { FacebookLoader } from 'vue-content-loader';

Vue.use(excel)
locale.use(lang)
Vue.use(DataTables)
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
            titles : [{prop: "name",label: "Name"},{prop: "email",label:"Email"},{prop:"creation_date",label:"Date"}],
            leadList : [],
            filters: [{prop: 'name',value: ''}],
            tableProps: {defaultSort: {prop: 'name',order: 'descending'}},
            lang: {},
            modal : false,
            loadingContent: false
        }
    },
    mounted(){
        this.getLeads();
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        getLeads(){
            this.loadingContent = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lead", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.leadList = response.data; 
                setTimeout(function(){ 
                    this.loadingContent = false;
                }.bind(this), 1000);
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        }
    }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    .image-no-results{
        width:15%;
    }
    .text-no-results{
        margin-top:25%;
    }

</style>
