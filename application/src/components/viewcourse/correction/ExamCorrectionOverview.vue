<template>
    <div>
        <lang></lang>
        <el-divider class="mb-5"><i class="el-icon-edit"></i></el-divider>


        <facebook-loader 
            v-if="loadingContent == true"
            :speed="2"
            width="700"
            height="200"
            primaryColor = "#f0f0f0"
            secondaryColor = "#d9d9d9"
        >
        </facebook-loader>


        <!-- Exam overview -->
        <div class="overview" v-else>
            <el-row>
                <h3 class="text-center">{{lang["exam-status"]}} 
                    <b> 
                        <a class="text-warning" href="#" v-if="overview['waitingEvaluationQuestions'] != 0">
                            {{lang["in-progress"]}}
                        </a>

                        <a class="text-success" href="#" v-else>
                            {{lang["finished"]}}
                        </a>
                    </b>
                </h3>
            </el-row>

            <el-row>
                <el-col :span="12" class="p-3">
                    <h5>{{lang["required-for-approval"]}}</h5>
                    <el-progress :text-inside="true" :stroke-width="26" :percentage="parseInt(approval)"></el-progress>
                </el-col>
                
                <el-col :span="12" class="p-3">
                    <h5>{{lang["your-current-score"]}}</h5>
                    <el-progress :status="yourScoreProgressBar" :text-inside="true" :stroke-width="26" v-if="overview['yourScore']" :percentage="parseInt(overview['yourScore'])"></el-progress>
                </el-col>
            </el-row>

            <ul class="list-group">
                <!-- Total questions -->
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="far fa-question-circle"></i>
                    {{lang['total-questions']}}
                    <span class="badge badge-primary badge-pill">{{overview["totalQuestions"]}}</span>
                </li>

                <!-- Correct questions -->
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="far fa-check-circle text-success"></i>
                    {{lang['correct-questions']}}
                    <span class="badge badge-primary badge-pill">{{overview["totalCorrectQuestions"]}}</span>
                </li>

                <!-- Wrong questions -->
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="far fa-times-circle text-danger"></i>
                    {{lang['wrong-questions']}}
                    <span class="badge badge-primary badge-pill">{{overview["totalWrongQuestions"]}}</span>
                </li>


                <!-- Questions waiting evaluation    -->
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="fas fa-spinner text-warning"></i>
                    {{lang['questions-waiting-evaluation']}}
                    <span class="badge badge-primary badge-pill">{{overview["waitingEvaluationQuestions"]}}</span>
                </li>
            </ul>
        </div>
    </div>
</template>


<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui'
import {eventLang} from '@/components/helper/HelperLang'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import Lang from '@/components/helper/HelperLang'
import { FacebookLoader } from 'vue-content-loader';
import {eventCorrection} from '@/components/viewcourse/correction/ExamCorrection'


locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    props:['approval', 'exam-id', 'student-id'],
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            overview: [],
            loadingContent: false,
        }
    },
    components: {
        Lang,
        FacebookLoader
    },
    created(){
        this.getExamOverview(this.examId,this.studentId);
    },
    mounted(){  
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventCorrection.$on("open-exam-correction", function(data){
            this.getExamOverview(data["examId"],data["studentId"]);
        }.bind(this));
    },
   
    methods: {
        getExamOverview: function(examId,studentId){
            this.loadingContent = true;
            var formData = new FormData()
            formData.set('examId', examId);
            formData.set('studentId', studentId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("exam", "getExamOverview");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                /* Success callback */
                this.overview = response.data[0];
                setTimeout(function(){ 
                    this.loadingContent = false;
                }.bind(this), 1000);
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        }
    },
    watch: {
        studentId: function () {
            this.getExamOverview(this.examId,this.studentId);
        }
    },

    computed: {
        yourScoreProgressBar: function () {
            var type = '';
            if(this.overview['yourScore'] <= (parseInt(this.approval) / 2)){
                type = "exception";
            }

            if(this.overview['yourScore'] > (parseInt(this.approval) / 2) && this.overview['yourScore'] < parseInt(this.approval) ){
                type = "warning";
            }

            if(this.overview['yourScore'] >= parseInt(this.approval)){
                type = "success";
            }
            return type;
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

</style>