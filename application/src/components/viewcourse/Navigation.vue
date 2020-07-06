<template>
    <el-aside  v-loading="loading" class="leftside-viewcourse" :class="mobile" width="350x" style="background-color:#545c64">
        <el-menu
            style="width:351px;"
            background-color="#545c64"
            text-color="#fff"
            active-text-color="#09dfff"
            default-active = "lesson00"
            ref="menu"
        >
            <div  v-for="(element,index) in modules" :key="index">
                <el-submenu :disabled="element.disable" v-if="element.daysDiff <= 0"  :id="'module' + index" :index="'module' + index">
                    
                    <template slot="title">
                        <i class="el-icon-menu"></i>
                        <span>{{element.title}}</span>
                    </template>
                    
                    <lesson-list-to-view-course :module-id="element.id" :module-index="index"></lesson-list-to-view-course>

                </el-submenu>

                <el-tooltip v-else  class="item" effect="dark" :content="lang['module-available-in'] + element.release_date" placement="top">
                    <el-submenu :disabled="true"  :id="'module' + index" :index="'module' + index">
                        <template slot="title">
                            <i class="el-icon-date"></i>
                            <span>{{element.title}}</span>
                        </template>
                    </el-submenu>
                </el-tooltip>
            </div>
        </el-menu>  
    </el-aside>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/viewcourse/App'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import LessonListToViewCourse from '@/components/viewcourse/LessonListToViewCourse'

Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            logo: '',
            title: '',
            modules: [],
            courseId: '',
            currentDate: '',
            mobile: 'retracted',
            loading: false
        }
    },
    components: {
        LessonListToViewCourse,
    },
    created: function(){
        this.getCompanyLogo();
        var courseId = sessionStorage.getItem('sbr_course_id');
        this.courseId = courseId;
        this.getCourse(courseId);
        this.getModules(courseId);
    },
    mounted(){
        eventLang.$on('lang', function(response){
        this.lang = response
        }.bind(this));

        eventBus.$on("open-menu", function(response){
            this.openmenu(response);
        }.bind(this));

        eventBus.$on("update-modules", function(){
            this.getModules(this.courseId);
        }.bind(this));

        eventBus.$on("change-leftbar-class", function(){
            this.mobile == "retracted" ? this.mobile = "opened" : this.mobile = "retracted";
        }.bind(this));
    },
    methods: {
        getCompanyLogo: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("settings", "getSettingsInformation");
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.logo = response.data["logo"];
            }.bind(this));
        },
        openmenu: function(index) {
            this.$refs.menu.open(index);
        },
      
        getCourse: function(courseId){
            var formData = new FormData();
            formData.set("courseId", courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "get");
            axios.post(urlToBeUsedInTheRequest, formData).then(function (response) {
                this.title = response.data["title"];
            }.bind(this));
        },
        getModules: function(courseId){
            this.loading = true;
            var formData = new FormData();
            formData.set("courseId", courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("module", "listing");
            axios.post(urlToBeUsedInTheRequest, formData).then(function (response) {
                this.modules = response.data;
                this.loading = false;
            }.bind(this));
        },
    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.el-submenu{
    border-bottom: 1px solid rgb(67, 74, 80);
}


.course-title{
    font-family: 'Montserrat', sans-serif;
    font-size:1.1em;
}

.el-submenu__title *{
    font-family: 'Montserrat', sans-serif;
    font-size:1.1em;
    border: 0;
    font-weight: normal;
    line-height: 1;
    list-style: none;
    margin: 0;
    padding: 0;
    position: relative;
    text-decoration: none;
}


.progress{
    margin-bottom: 0px !important;
}

.col-2{
    padding: 0px !important;
}





</style>
