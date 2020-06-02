<template>
    <div class="col-12">
        <div class="card-box table-responsive mt-5" v-if="courseList != null">
            <div class="dropdown pull-right">
                <a @click="changeCourseVisualization()" href="javascript:void(0)"  class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i v-if="courseVisualization == 'list'" class="mdi mdi-view-list mdi-36px"></i>
                     <i v-else class="mdi mdi-table mdi-36px"></i>
                </a>
            </div>
            <course-list-view v-if="courseVisualization == 'list'"></course-list-view>
            <course-table-view v-else></course-table-view>
        </div>

        <!-- No courses found content -->
        <div class="text-center mt-5" v-else>
            <h4>{{lang["no-courses-found"]}}</h4>
            <img class="image-no-results" src="@/assets/img/general/ux/not_found.png" alt="">
        </div>
        <!-- No courses found content end -->
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
import CourseListView from '@/components/courses/views/CourseListView'
import CourseTableView from '@/components/courses/views/CourseTableView'


locale.use(lang)
Vue.use(DataTables)
Vue.use(DataTablesServer)
Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    components: { 
       CourseListView,
       CourseTableView
    },
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
            courseVisualization: 'list',
        }
    },
    created(){
        this.updateCourseListArray();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));

        eventBus.$on("course-deleted", function(){
            this.updateCourseListArray();
        }.bind(this));
    },
    methods:{
        changeCourseVisualization: function(){
            this.courseVisualization == 'list' ? this.courseVisualization = 'table' : this.courseVisualization = 'list';
        },
        editCourse:function(id){
            window.location.href="editcourse/"+id+"";
        },
        viewCourse: function(id){
             window.location.href="viewcourse/"+id+"";
        },
        updateCourseListArray(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.courseList = response.data; 
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }
            );
        },
    },
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    .image-no-results{
        width:15%;
    }
    .box-no-results{
       background-color: #FCFCFC;
    }
    .text-no-results{
        margin-top:25%;
    }

</style>
