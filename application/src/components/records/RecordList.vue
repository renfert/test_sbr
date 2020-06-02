<template>
   <div class="col-12">
        <div class="card-box table-responsive" v-if="recordList != null">
            <div style="margin-bottom: 10px">
                <el-row>
                    <el-col :span="6">
                    <el-input v-model="filters[0].value" placeholder="Search"></el-input>
                    </el-col>
                </el-row>
            </div>
            <data-tables  :pagination-props="{ background: true, pageSizes: [5] }"  :data="recordList"  :filters="filters">
                <el-table-column 
                    v-for="title in titles"  
                    sortable="custom" 
                    :prop="title.prop" 
                    :label="title.label" 
                    :key="title.label">
                </el-table-column>
                <el-table-column  label="Progress" align="center">
                    <template slot-scope="scope">
                        {{parseInt(((100 * scope.row.finishedLessons) /  scope.row.lessons ))}}
                    </template>
                </el-table-column>
                <el-table-column  label="Status" align="center">
                    <template slot-scope="scope">
                        <p v-if="parseInt(((100 * scope.row.finishedLessons) /  scope.row.lessons )) > 0 && parseInt(((100 * scope.row.finishedLessons) /  scope.row.lessons )) < 100">
                            In progress
                        </p>

                        <p v-if="parseInt(((100 * scope.row.finishedLessons) /  scope.row.lessons )) == 0">
                            NA
                        </p>

                        <p v-if="parseInt(((100 * scope.row.finishedLessons) /  scope.row.lessons )) == 100">
                            Done
                        </p>
                    </template>
                </el-table-column>
            </data-tables>
        </div>        
    </div><!-- End col-12 -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import { DataTables, DataTablesServer } from 'vue-data-tables'
import {eventLang} from '@/components/helper/HelperLang'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
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
            titles : [{prop: "title",label: "Course"}],
            recordList : [],
            filters: [{prop: 'title',value: ''}],
            tableProps: {defaultSort: {prop: 'title',order: 'descending'}},
            lang: {},
            modal : false,
        }
    },
    created(){
        this.getRecords();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        getRecords(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.recordList = response.data; 
            }, function(){
                // Failure callback
                this.errorMessage();
            });
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
       background-color: #F6F9FA;
    }
    .text-no-results{
        margin-top:15%;
    }

</style>
