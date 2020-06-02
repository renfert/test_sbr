<template>
    <div>
        <lang></lang>
        <el-dialog  
            :visible.sync="modal" 
            center 
            width="50%" 
            top="5vh"   
            :title="lang['correction']"
        >
        <div class="text-center mb-3">
            <el-radio-group v-model="content">
                <el-radio-button label="Overview"></el-radio-button>
                <el-radio-button label="Questions"></el-radio-button>
            </el-radio-group>
        </div>

        <!-- Exam correction overview -->
        <exam-correction-overview :student-id="studentId" v-if="content == 'Overview' && approval != '' && studentId != ''" :approval="approval" :exam-id="examId"></exam-correction-overview>
     

        <!-- Exam correction questions -->
        <exam-correction-questions :student-id="studentId" :exam-id="examId" v-else></exam-correction-questions>
         
        </el-dialog>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui'
import Lang from '@/components/helper/HelperLang'
import {eventLang} from '@/components/helper/HelperLang'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import ExamCorrectionOverview from '@/components/viewcourse/correction/ExamCorrectionOverview'
import ExamCorrectionQuestions from '@/components/viewcourse/correction/ExamCorrectionQuestions'

export const eventCorrection = new Vue();


locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    components:{
        Lang,
        ExamCorrectionOverview,
        ExamCorrectionQuestions
    },
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            modal: false,
            examId : '', 
            studentId: '',
            approval: '',
            content: 'Overview',
        }
    },
    mounted(){  
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventCorrection.$on("open-exam-correction", function(data){
            this.content = "Overview";
            var examId = data["examId"];
            this.examId = data["examId"];
            this.studentId = data["studentId"];
            this.getExam(examId);
            this.modal = true;
        }.bind(this));

        eventCorrection.$on("finish-correction", function(){
            this.getExam(this.examId);
        }.bind(this));
    },
    methods:{
        getExam: function(examId){
            var formData = new FormData()
            formData.set('examId', examId);

            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("exam", "get");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.approval = response.data[0]["approval"];
            },
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
    }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

</style>
