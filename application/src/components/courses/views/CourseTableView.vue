<template>
   <div class="col-auto" v-loading="loading">
        <h4><b>{{lang["list-course"]}}</b></h4>
        <div style="margin-bottom: 10px">
            <el-row>
                <el-col :span="6">
                <el-input v-model="filters[0].value" placeholder="Search"></el-input>
                </el-col>
            </el-row>
        </div>
        <data-tables :pagination-props="{ background: true, pageSizes: [5] }"  :data="courseList"  :filters="filters">
            <el-table-column v-for="title in titles"  sortable="custom" :prop="title.prop" :label="title.label" :key="title.label">
            </el-table-column>

            <el-table-column label="Actions" align="center">
                <template slot-scope="scope">
                    <el-button class="btn-sabiorealm" v-if="roleId != 3" @click.prevent="editCourse(scope.row.id)" type="primary"  size="medium" icon="el-icon-edit" circle></el-button>
                    <el-button class="btn-sabiorealm-danger" v-if="roleId != 3" type="danger"  size="medium" icon="el-icon-delete" circle></el-button>
                    <el-button class="btn-sabiorealm-secondary" @click.prevent="viewCourse(scope.row.id)" type="success"  size="medium" icon="el-icon-video-play" circle></el-button>
                </template>
            </el-table-column>
        </data-tables>
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
            courseList : [],
            filters: [{prop: 'title',value: ''}],
            tableProps: {defaultSort: {prop: 'title',order: 'descending'}},
            validatorName: {F: {pattern: /^[a-zA-Z0-9\u00C0-\u00FF ]*$/,}},
            categoryId: '',
            categoryName: '',
            newCategoryName: '',
            lang: {},
            loading: false,
            modal : false,
            roleId: ''
        }
    },
    created(){
        this.updateCourseListArray();
        this.getUserProfile();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        editCourse:function(id){
            window.location.href="pages/editcourse/"+id+"";
        },
        viewCourse: function(id){
            window.location.href="pages/viewcourse/"+id+"";
        },
        updateCourseListArray(){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.courseList = response.data; 
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
    },
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    .image-no-results{
        width:100%;
    }
    .box-no-results{
       background-color: #FCFCFC;
    }
    .text-no-results{
        margin-top:25%;
    }

</style>
