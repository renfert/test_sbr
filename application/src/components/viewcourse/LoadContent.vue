<template>
   
      <el-container v-loading="loading"> 
        <el-main>
            <div class="content">
                <!-- Video -->
                <div class="player-container" v-if="showVideo">
                    <vue-plyr>
                        <video preload="none" v-on:ended="finishLesson()" :src="''+getCurrentDomainName()+'assets/uploads/content/' + path" ></video>
                    </vue-plyr>
                </div>

                <!-- Audio -->
                <div class="player-container" v-if="showAudio">
                    <vue-plyr>
                        <video preload="none" v-on:ended="finishLesson()" :src="''+getCurrentDomainName()+'assets/uploads/content/' + path" ></video>
                    </vue-plyr>
                </div>

                <!-- Videoconference -->
                <div class="videoconference-container" v-if="showVideoConf">
                    <div class="jumbotron text-center stylish-color white-text mx-2 mb-5">

                    <!-- Title -->
                    <h2 class="card-title h2">{{title}}</h2>

                    <!-- Date -->
                    <p class="my-4 h6">
                        {{lang["date"]}}: {{date}}  
                        <el-divider direction="vertical"></el-divider>
                        {{lang["schedule"]}}: {{time}}

                    </p>
               
                    <div class="row d-flex justify-content-center">
                        <div class="col-xl-7 pb-2">
                            <p class="card-text">{{description}}</p>
                        </div>
                    </div>
    

                    <hr class="my-4 rgba-white-light">

                    <div class="pt-2">
                        <a target="_blank" @click="finishLesson()" :href="url" class="btn btn-outline-white">{{lang["enter"]}}</a>
                    </div>

                    </div>
                </div>


                <!-- Webinar -->
                <div class="webinar-container" v-if="showWebinar">
                    <div class="jumbotron text-center stylish-color white-text mx-2 mb-5">

                    <!-- Title -->
                    <h2 class="card-title h2">{{title}}</h2>

                    <!-- Date -->
                    <p class="my-4 h6">
                        {{lang["date"]}}: {{date}}  
                        <el-divider direction="vertical"></el-divider>
                        {{lang["schedule"]}}: {{time}}
                    </p>
               
                    <div class="row d-flex justify-content-center">
                        <div class="col-xl-7 pb-2">
                            <p class="card-text">{{description}}</p>
                        </div>
                    </div>
    

                    <hr class="my-4 rgba-white-light">

                    <div class="pt-2">
                        <a target="_blank" @click="finishLesson()" :href="url" class="btn btn-outline-white">{{lang["enter"]}}</a>
                    </div>

                    </div>
                </div>

                <!-- Downloadable content -->
                <div class="webinar-container" v-if="showDownloadable">
                    <div class="jumbotron text-center stylish-color white-text mx-2 mb-5">

                    <!-- Title -->
                    <h2 class="card-title h2">{{title}}</h2>
    

                    <hr class="my-4 rgba-white-light">

                    <div class="pt-2">
                        <a @click="finishLesson()" :href="''+getCurrentDomainName()+'assets/uploads/content/' + path" class="btn btn-outline-white" download>{{lang["download"]}}</a>
                    </div>

                    </div>
                </div>

                <!-- Html content -->
                <div class="html-container" v-if="showHtml">
                     
                    <!-- Title -->
                    <h2 class="card-title h2 text-center">{{title}}</h2>
    

                    <hr class="my-4 rgba-white-light">
                    <iframe :src="+getCurrentDomainName()+ path" frameborder="0"></iframe>        
                </div>

                <!-- Pdf content -->
                <div class="pdf-container" v-if="showPDf">

                    <iframe :src="getCurrentDomainName() + 'ViewerJS/#' + getCurrentDomainName() + 'assets/uploads/content/' + path" width='100%' height='500px' allowfullscreen webkitallowfullscreen></iframe>
                                      
                </div>


                <!-- Exam -->
                <div  v-if="showExam">
                    <div class="jumbotron text-center stylish-color white-text mx-2 mb-5">

                    <!-- Title -->
                    <h2 class="card-title h2">{{title}}</h2>

                    <!-- Date -->
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-12 col-md-4">
                            <p class="text-center my-4 h6">
                                {{lang["exam-duration"]}}: <span class="text-primary"> {{time}}  {{lang["minutes"]}} </span>
                            </p>   
                        </div>
                        
                        <div class="col-12 col-md-4">
                            <p class="text-center my-4 h6">
                                {{lang["attempts"]}}: <span class="text-primary"> {{userRetests}} / {{retest}} </span>
                            </p>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                   
               

                    <div class="row d-flex justify-content-center">
                        <div class="col-xl-7 pb-2">
                            <el-tag type="danger" v-if="parseInt(overview['yourScore']) < parseInt(approval) && overview['waitingEvaluationQuestions'] == 0">{{lang['not-passed']}}</el-tag>

                            <el-tag type="success" v-if="parseInt(overview['yourScore']) >= parseInt(approval) && overview['waitingEvaluationQuestions'] == 0">{{lang['passed']}}</el-tag>

                            <el-tag type="warning" v-if="overview['waitingEvaluationQuestions'] != 0">{{lang['exam-in-progress']}}</el-tag>

                        </div>
                    </div>
    

                    <hr class="my-4 rgba-white-light">

                    <el-row>
                        <!-- Start exam button -->
                        <el-button v-if="userRetests == 0" @click="openExamModal(lessonId)">{{lang["start-exam"]}}</el-button>

                        <!-- Start retest button -->
                        <el-button  v-if="userRetests < retest && userRetests != 0 && parseInt(overview['yourScore']) < parseInt(approval) && overview['waitingEvaluationQuestions'] == 0" @click="openExamModal(lessonId)">{{lang["start-retest"]}}</el-button>

                         <!-- Correction button -->
                        <el-button type="primary" v-if="userRetests > 0"  @click="openCorrection(lessonId)">{{lang["see-exam-correction"]}}</el-button>


                    </el-row>

                                        

                    <!-- Modal exam -->
                    <exam></exam>
                    
                    <!-- Correction exam -->
                    <exam-correction></exam-correction>

                    <!-- Finished exam modal -->
                    <el-dialog  
                        :visible.sync="modal" 
                        center 
                        :title="lang['exam-finished']"
                        width="50%" 
                        top="30vh"
                    >   
                    <div class="text-center">
                        <el-button @click.prevent="openCorrection(lessonId)" class="text-center" type="primary">Ver resultado</el-button>
                    </div>
        
                    </el-dialog>
    
                    </div>
                </div>


            </div>
        </el-main>
      </el-container>
    
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/viewcourse/App'
import {eventCorrection} from '@/components/viewcourse/correction/ExamCorrection'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import VuePlyr from 'vue-plyr'
import Exam from '@/components/viewcourse/Exam'
import ExamCorrection from '@/components/viewcourse/correction/ExamCorrection'



locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
Vue.use(VuePlyr, {
  plyr: {
    fullscreen: { enabled: true }
  },
  emit: ['ended']
})
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            title: '',
            path: '',
            date: '',
            time: '',
            description: '',
            url: '',
            approval: '',
            retest: '',
            userRetests: '',
            lessonId: '',
            lessonStatus: '',
    
            showVideo: false,
            showAudio : false,
            showPDf: false,
            showDownloadable: false,
            showExam: false,
            showWebinar: false,
            showVideoConf: false,
            showHtml: false,
            overview: '',

            studentId: '',

            modal: false,
            
            loading: false
        }
    },
    
    components: {
       Exam,
       ExamCorrection
    },
    mounted(){

        this.getUserProfile();

        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on("load-lesson", function(data){
            this.loading = true;
            this.lessonId = data["lessonId"];
            this.lessonStatus = data["lessonStatus"];
            this.getLesson(data["lessonId"]);

            if(data["lessonType"] == 3 || data["lessonType"] == 7){
                this.finishLesson();
            }

        }.bind(this));

        eventBus.$on("exam-finished", function(){
            this.modal = true;
            this.getExamOverview();
        }.bind(this));
    },
   
    methods: {
        finishLesson: function(){
            if(this.lessonStatus != "finished"){
                var formData = new FormData()
                formData.set('lessonId', this.lessonId);
                formData.set('studentId', this.studentId);
                var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "finish");
                axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                    /* Success callback */
                    eventBus.$emit("update-progress-bar");
                },
                    /* Error callback */
                    function(){
                        this.errorMessage();
                    }.bind(this)
                );
                this.$notify({
                    title: this.lang["lesson-finished"],
                    position: 'bottom-left',
                    type: 'success'
                });
            }
        },

        getUserRetest: function(examId){
            var formData = new FormData()
            formData.set('lessonId', examId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "getUserRetest");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                /* Success callback */
                this.userRetests = response.data[0]["retest"];
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },

        getExamOverview: function(){
            this.loading = true;
            var formData = new FormData()
            formData.set("examId", this.lessonId);
            formData.set("studentId", this.studentId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("exam", "getExamOverview");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {

                this.overview = response.data[0];
                this.loading = false;
            },
                
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },

        getUserProfile(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserProfile");
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.studentId = response.data["id"];
            }.bind(this));
        },


        getLesson: function(lessonId){
            var formData = new FormData()
            formData.set('lessonId', lessonId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "get");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                /* Success callback */
                this.title = response.data["title"];
                this.description = response.data["description"];
                this.path = response.data["path"];
                this.date = this.convertDate(response.data["date"]);
                this.time = response.data["time"];
                this.url = response.data["url"]; 
                this.approval = response.data["approval"];
                this.retest = response.data["retest"];

                this.renderLesson(response.data["type_mylesson_id"]);
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        openExamModal: function(examId){
            var data = {
                "lessonId": examId,
                "lessonType": this.lessonType,
                "lessonStatus": this.lessonStatus
            };
            eventBus.$emit("open-exam-modal", data);
        },
        openCorrection: function(examId){
            var data = {
                "examId" : examId,
                "studentId": this.studentId
            };
            eventCorrection.$emit("open-exam-correction", data);
        },
        renderLesson: function(lessonType){
            this.hideAllLessons();
            switch (lessonType) {   
                case '1':
                    this.showVideo = true;
                    break;
                case '2':
                    this.showAudio = true;
                    break;
                case '3':
                    this.showPDf = true;
                    break;
                case '4':
                    this.showDownloadable = true;
                    break;
                case '5':
                    this.showVideoConf = true;
                    break;
                case '6':
                    this.showWebinar = true;
                    break;
                case '7':
                    this.showHtml = true;
                    break;
                case '8':
                    this.showExam = true;
                    this.getUserRetest(this.lessonId);
                    this.getExamOverview();
                    break;

            }

            this.loading = false;
        },
        hideAllLessons: function(){
            this.showVideo  = false;
            this.showAudio = false;
            this.showPDf = false;
            this.showDownloadable = false;
            this.showExam = false;
            this.showWebinar = false;
            this.showVideoConf = false;
            this.showHtml = false;
        },
        convertDate: function(inputFormat) {
            function pad(s) { return (s < 10) ? '0' + s : s; }
            var d = new Date(inputFormat)
            return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/')
        }

    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    video{
        max-width:100%;
    }
</style>
