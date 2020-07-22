<template>
    <nav class="navbar navbar-expand-lg navbar-dark special-color-dark">
    
        <!------------------- 
           Mobile topbar
        ---------------  -->
        <div class="mobile-topbar">
            <i @click="changeLeftBarClass()" class="mdi mdi-menu mdi-24px pr-5"></i>
            <a class="pr-5" :href="getDomainNameToNavigation() + 'courses'">
                <el-button size="medium"  icon="el-icon-back" circle></el-button>
            </a>
            <el-button  class="sbr-btn sbr-primary mr-3" @click="prevLesson()" icon="el-icon-arrow-left"></el-button>
            <el-button class="sbr-btn sbr-primary" @click="nextLesson()"  ><i class="el-icon-arrow-right"></i></el-button>
        </div>


        <div class="collapse navbar-collapse" id="basicExampleNav">
            <ul class="navbar-nav mr-auto">
                
                <!------------------- 
                    Back button
                ---------------  -->
                <li class="nav-item mr-2 ml-2">
                    <a :href="getDomainNameToNavigation() + 'courses'">
                        <el-button size="medium"  icon="el-icon-back" circle></el-button>
                    </a>
                </li>
             
                <!------------------- 
                    Certificate icon
                ---------------  -->
                <li class="nav-item" v-if="certificate != null">
                    <a @click.prevent="printCertificate" v-if="progress == 100"  class="nav-link course-title" href="javascript:void(0)">
                         <img class="cert"  src="@/assets/img/general/ux/certificate.png" alt="certificate"> 
                    </a>

                    <a v-else style="cursor:not-allowed;"  class="nav-link course-title" href="javascript:void(0)">
                        <el-tooltip class="item" effect="dark" :content="lang['certificate-unavailable']" placement="right">
                            <img class="cert"  src="@/assets/img/general/ux/certificate.png" alt="certificate"> 
                        </el-tooltip>
                    </a>
                </li>
            </ul>

            <!------------------- 
               Prev and next buttons
            ---------------  -->
            <ul class="navbar-nav mr-6">
                <li class="nav-item">
                    <el-button-group>
                        <el-button class="sbr-btn sbr-primary mr-4" @click="prevLesson()" icon="el-icon-arrow-left">Previous lesson</el-button>
                        <el-button class="sbr-btn sbr-primary" @click="nextLesson()"  >Next lesson<i class="el-icon-arrow-right"></i></el-button>
                    </el-button-group>
                </li>
            </ul>     
           
            <!------------------- 
                Course title
            ---------------  -->
            <ul class="navbar-nav mr-4">
                <li class="nav-item">
                    <a class="nav-link course-title" href="#"></a>
                </li>
            </ul>    
 
        </div>
    

        <!------------------- 
           Progress bar
        ---------------  -->
        <div class="col-2 progress progress-viewcourse">
            <div class="progress-bar" role="progressbar" :style="style" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div> 
        </div>
        

        <!------------------- 
           Print certificate 
        ---------------  -->
        <certificate-print v-if="courseId != null && certificate != null" :course-id="courseId" :show="showCertificate"></certificate-print>
        
        <!------------------- 
            Review modal 
        ---------------  -->
        <el-dialog  
            :visible.sync="modalReview" 
            center 
            :title="lang['please-rate-my-course']"
            width="50%" 
            top="5vh"
            >   
            <div>  

                <!------------------- 
                    Review card 
                ----------------  -->
                <div v-if="showThanksCard == false">
                    <!-- Instructor information -->
                    <div class="block text-center mb-3">
                        <el-avatar   :src="getUrlToContents() + 'avatar/'+userCreatorAvatar+''"></el-avatar>
                        <h4> <b><i>{{userCreatorName}}</i></b></h4>
                    </div>
                    <!-- Rate -->
                    <div class="block text-center mb-5">
                        <h3>{{lang["how-would-you-rate-this-course"]}}</h3>
                        <el-rate v-model="rate"></el-rate>
                    </div>
                    <!-- Comment -->
                    <div class="block mb-3">
                        <h3 class="text-center">{{lang['leave-a-comment']}}</h3>
                        <textarea v-model="comment" class="form-control"  cols="30" rows="6"></textarea>
                    </div>
                    <!-- Save button -->
                    <div class="block text-center">
                        <el-button @click.prevent="saveReview()" v-loading="loading" class="sbr-btn sbr-primary">{{lang['save-button']}}</el-button>
                    </div>
                </div>
                <!------------------- 
                    End review card 
                ----------------  -->


                <!------------------- 
                    Thanks card
                ----------------  -->
                <div v-else>
                    <!-- Instructor information -->
                    <div class="block text-center mb-3">
                        <el-avatar   :src="getUrlToContents() + 'avatar/'+userCreatorAvatar+''"></el-avatar>
                        <h4> <b><i>{{userCreatorName}}</i></b></h4>
                    </div>

                    <!-- Thanks message -->
                    <div class="block text-center">
                        <h3 class="sbr-text-primary">{{lang['thanks-for-your-feedback']}}</h3>
                        <h2><i class="far fa-grin-wink"></i></h2>
                    </div>

                </div>
                <!------------------- 
                    End thanks card
                ----------------  -->

            </div>
        </el-dialog>
        <!------------------- 
            End Review modal 
        ---------------  -->
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
            reviews: false,
            progress: '',
            certificate: null,
            companyName: '',
            courseId: null,
            showCertificate: false,
            userCreatorName: '',
            userCreatorEmail: '',
            userCreatorAvatar: '',
            rate: 5,
            comment: '',
            loading: false,

            courseHasAlreadyBeenEvaluated: false,

            showThanksCard : false,
            modalReview: false
        }
    },
    created: function(){
        var courseId = sessionStorage.getItem('sbr_course_id');
        this.checkIfCourseHasAlreadyBeenEvaluated(courseId);
        this.getCompanyLogo();
        this.courseId = sessionStorage.getItem('sbr_course_id');
        this.getCourse(courseId);
        this.getCourseProgress(courseId);
    },
    mounted(){
        this.getCourseCreator();
        
        eventLang.$on('lang', function(response){
            this.lang = response
        }.bind(this));

        eventBus.$on("update-progress-bar", function(){
            this.getCourseProgress(this.courseId);
        }.bind(this));
        
    },
    methods: {
        saveReview: function(){
            this.loading = true;
            var formData = new FormData()
            formData.set('courseId', this.courseId);
            formData.set('comment', this.comment);
            formData.set('rate', this.rate);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("reviews", "saveReview");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.loading = false;
                this.showThanksCard = true;
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );  
        },
        getCourseCreator: function(){
            var formData = new FormData()
            formData.set('courseId', this.courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "getCourseCreator");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.userCreatorEmail = response.data["email"];
                this.userCreatorName = response.data["name"];
                this.userCreatorAvatar = response.data["avatar"];
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
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
                if(response.data == 100 && this.courseHasAlreadyBeenEvaluated == false && this.reviews != null){
                    this.modalReview = true;
                }
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
                this.reviews = response.data["reviews"];
            }.bind(this));
        },
        checkIfCourseHasAlreadyBeenEvaluated: function(courseId){
            var formData = new FormData();
            formData.set('courseId', courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("verify", "verifyIfCourseHasAlreadyBeenEvaluated");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.courseHasAlreadyBeenEvaluated = response.data;
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );  
        }
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
    background-color: #009CD8 !important;
}

.col-2{
    padding: 0px !important;
}

.cert {
    width:30px;
}



</style>
