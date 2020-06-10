<template>
    <nav class="navbar navbar-expand-lg navbar-dark special-color-dark">

        <div class="mobile-topbar">
            <i @click="changeLeftBarClass()" class="mdi mdi-menu mdi-24px pr-5"></i>
            <a class="pr-5" :href="getDomainNameToNavigation() + 'courses'">
                <el-button size="medium"  icon="el-icon-back" circle></el-button>
            </a>
            <el-button  class="btn-sabiorealm-secondary mr-3" @click="prevLesson()" icon="el-icon-arrow-left"></el-button>
            <el-button class="btn-sabiorealm-secondary" @click="nextLesson()"  ><i class="el-icon-arrow-right"></i></el-button>
        </div>

        <!-- Navbar brand -->
        <a  class="navbar-brand brand-viewcourse" :href="getDomainNameToNavigation() + 'pages/courses'">
            <img style="width:120px"  :src="''+getCurrentDomainName()+'assets/uploads/settings/' + logo"  alt="logo" />
        </a>
       
        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">
            <!-- Course name -->
            <ul class="navbar-nav mr-auto">

                <li class="nav-item mr-2 ml-2">
                    <a :href="getDomainNameToNavigation() + 'courses'">
                        <el-button size="medium"  icon="el-icon-back" circle></el-button>
                    </a>
                </li>
             
                
                 <li class="nav-item" v-if="certificate != null">

                    <a @click.prevent="printCertificate" v-if="progress == 100"  class="nav-link course-title" href="javascript:void(0)">
                         <img   src="@/assets/img/general/certificate/certificate.png" alt=""> 
                    </a>

                    <a v-else style="cursor:not-allowed;"  class="nav-link course-title" href="javascript:void(0)">
                         <img class="disable" src="@/assets/img/general/certificate/certificate.png" alt=""> 
                    </a>
                    
                    
                </li>

            </ul>

            
            <ul class="navbar-nav mr-6">
                <li class="nav-item">
                    <el-button-group>
                        <el-button class="btn-sabiorealm-secondary" @click="prevLesson()" icon="el-icon-arrow-left">Previous lesson</el-button>
                        <el-button class="btn-sabiorealm-secondary" @click="nextLesson()"  >Next lesson<i class="el-icon-arrow-right"></i></el-button>
                    </el-button-group>
                </li>
                
            </ul>     
           

            <ul class="navbar-nav mr-4">
                <li class="nav-item">
                    <a class="nav-link course-title" href="#"></a>
                </li>
            </ul>    
 
        </div>
        <!-- Collapsible content -->

                
        <div class="col-2 progress progress-viewcourse">
            <div class="progress-bar" role="progressbar" :style="style" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div> 
        </div>

        <certificate-print v-if="courseId != null && certificate != null" :course-id="courseId" :show="showCertificate"></certificate-print>
      
    </nav>
</template>

<script>    
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/viewcourse/App'
import {eventCertificate} from '@/components/certificates/CertificatePrint'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import $ from 'jquery'
import CertificatePrint from '@/components/certificates/CertificatePrint'


Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    components: {
        CertificatePrint
    },
    data: () => {
        return {
            lang: {},
            title: null,
            logo: '',
            progress: '',
            certificate: null,
            companyName: '',
            courseId: null,
            showCertificate: false
        }
    },
    created: function(){
        this.getCompanyLogo();
        var courseId = sessionStorage.getItem('sbr_course_id');
        this.courseId = courseId;
        this.getCourse(courseId);
        this.getCourseProgress(courseId);
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response
        }.bind(this));

        eventBus.$on("update-progress-bar", function(){
            this.getCourseProgress(this.courseId);
        }.bind(this));
    },
    methods: {
        changeLeftBarClass: function(){
            eventBus.$emit("change-leftbar-class");
        },
        printCertificate: function(){
            eventCertificate.$emit("print-certificate");
        },
        nextLesson(){
            var currentLesson = $(".el-menu-item.is-active");
            var nextLesson = currentLesson.next('li.el-menu-item');

            /* verify if the next lesson belongs to another module */
            if(nextLesson.length == 1){
                nextLesson.click();
            }else{
                var currentModule = currentLesson.closest(".el-submenu");
                var nextModule = currentModule.next("li.el-submenu");

                /* Open menu */
                var nextModuleId = nextModule.attr("id");
                eventBus.$emit("open-menu", nextModuleId);

                /* Click on the first lesson in the next module*/
                var nextModuleFirstLesson = nextModule.children(".el-menu").children().children().first();
                nextModuleFirstLesson.click();
            }
        },
        prevLesson: function(){
            var currentLesson = $(".el-menu-item.is-active");
            var prevLesson = currentLesson.prev('li.el-menu-item');

            /* verify if the next lesson belongs to another module */
            if(prevLesson.length == 1){
                prevLesson.click();
            }else{
                var currentModule = currentLesson.closest(".el-submenu");
                var prevModule = currentModule.prev("li.el-submenu");

                /* Open menu */
                var prevModuleId = prevModule.attr("id");
                eventBus.$emit("open-menu", prevModuleId);

                /* Click on the first lesson in the prev module*/
                var prevModuleFirstLesson = prevModule.children(".el-menu").children().children().first();
                prevModuleFirstLesson.click();
            }
        },
        getCompanyLogo: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("settings", "getSettingsInformation");
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.logo = response.data["logo"];
            }.bind(this));
        },
        getCourseProgress: function(courseId){
            var formData = new FormData();
            formData.set("courseId", courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "progress");
            axios.post(urlToBeUsedInTheRequest, formData).then(function (response) {
                this.progress = response.data;
            }.bind(this));
        },
        getCourse: function(courseId){
            var formData = new FormData();
            formData.set("courseId", courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "get");
            axios.post(urlToBeUsedInTheRequest, formData).then(function (response) {
                this.title = response.data["title"];
                this.courseId = response.data["id"];
                this.certificate = response.data["certificate"];
            }.bind(this));
        },
    },
    computed: {
        style: function(){
            return {
                'width': this.progress + '%',
            }
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
    font-size:1.1vw;
}

.el-submenu__title *{
    font-family: 'Montserrat', sans-serif;
    font-size:1.1vw;
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

.progress-bar{
    background-color: #3734A9;
}

.col-2{
    padding: 0px !important;
}

.disable{
    filter: grayscale(100%);
}


</style>
