<template>
    <div>
        <lang></lang>
        <!-- Descriptive answer -->
        <div v-if="questionType == 1">
            <div  v-for="element in studentAnswer" :key="element.id">
                <el-input 
                    v-if="element.answer != '' && element.answer != null"
                    :value="element.answer"
                    type="textarea" 
                    :rows="5">
                </el-input>
                <el-tag v-else type="danger mb-2">{{lang["answer-empty"]}}</el-tag>
                <div>
                    <hr>
                    <!-- Progress -->
                    <div v-if="element.score != null">
                        <h3 class="text-sabiorealm">{{lang["score"]}}</h3>
                        <el-progress :percentage="parseInt(element.score)"></el-progress>
                    </div>

                    <div v-else>
                        <el-tag type="warning mb-2">{{lang["question-in-process-of-evaluation"]}}</el-tag>
                    </div>

                    <!-- Feedback -->
                    <div v-if="element.feedback != null && element.feedback != 'null'">
                        <h3 class="text-sabiorealm">{{lang["feedback"]}}</h3>
                        <el-input 
                            type="textarea" 
                            :rows="5"
                            :value="element.feedback"
                        >
                        </el-input>
                        <!-- Feedback useful or not -->
                        <div v-if="element.feedback_useful == null && roleId == 3"> 
                            <a @click.prevent="avaliateFeedback('yes')" class="text-success pr-2"><i class="far fa-thumbs-up"></i></a>

                            <a @click.prevent="avaliateFeedback('no')" class="text-danger"><i class="far fa-thumbs-down"></i></a>
                        </div>
                    </div>

                    <div v-else>
                        <div v-if="element.automaticFeedback != null && element.automaticFeedback != ''">
                            <h3 class="text-sabiorealm">{{lang["feedback"]}}</h3>
                            <el-input 
                                type="textarea" 
                                :rows="5"
                                :value="element.automaticFeedback"
                            ></el-input>
                            <!-- Feedback useful or not -->
                            <div v-if="element.feedback_useful == null && roleId == 3"> 
                                <a @click.prevent="avaliateFeedback('yes')" class="text-success pr-2"><i class="far fa-thumbs-up"></i></a>

                                <a @click.prevent="avaliateFeedback('no')" class="text-danger"><i class="far fa-thumbs-down"></i></a>
                            </div>
                        </div>
                        <div v-else>
                            <el-tag type="info">{{lang["no-feedbacks"]}}</el-tag>
                        </div>
                    </div>
   
                </div>
            </div>
        </div>

        <!-- Multiple answer -->
        <div v-if="questionType == 2">
            
            <div  v-for="element in answers" :key="element.id" class="custom-control custom-checkbox">
                <input :checked="verifyIsAnswerIsCorrect(element.id)" :value="element.id" :name="'answer['+questionId+']['+element.id+']'" type="checkbox" class="custom-control-input" :id="'answer'+element.id">
                <label class="custom-control-label" :for="'answer'+element.id"> {{element.answer}} </label>
            </div><hr>

            <!-- Progress -->
            <div>
                <h3 class="text-sabiorealm">{{lang["score"]}}</h3>
                <el-progress v-if="score != null" :percentage="score"></el-progress>
            </div>

            <!-- Feedback -->
            <div v-if="feedback != null">
                <h3 class="text-sabiorealm">{{lang["feedback"]}}</h3>
                <el-input 
                    type="textarea" 
                    :rows="5"
                    :value="feedback"
                    >
                </el-input>
                <!-- Feedback useful or not -->
                <div v-if="feedbackUseful == null && roleId == 3"> 
                    <a href="javascript:void(0)" @click.prevent="avaliateFeedback('yes')" class="text-success pr-2"><i class="far fa-thumbs-up"></i></a>

                    <a  href="javascript:void(0)" @click.prevent="avaliateFeedback('no')" class="text-danger"><i class="far fa-thumbs-down"></i></a>
                </div>
            </div>


            <div v-else>
                <div v-if="automaticFeedback != null && automaticFeedback != ''">
                    <h3 class="text-sabiorealm">{{lang["feedback"]}}</h3>
                    <el-input 
                        type="textarea" 
                        :rows="5"
                        :value="automaticFeedback"
                    ></el-input>
                    <!-- Feedback useful or not -->
                    <div v-if="feedbackUseful == null  && roleId == 3"> 
                        <a href="javascript:void(0)" @click.prevent="avaliateFeedback('yes')" class="text-success pr-2"><i class="far fa-thumbs-up"></i></a>

                        <a  href="javascript:void(0)" @click.prevent="avaliateFeedback('no')" class="text-danger"><i class="far fa-thumbs-down"></i></a>
                    </div>
                </div>
                <div v-else>
                    <el-tag type="info">{{lang["no-feedbacks"]}}</el-tag>
                </div>
            </div>
           
        </div>
        
        <!-- Free answer -->
        <div v-if="questionType == 3">
            <div v-for="element in studentAnswer" :key="element.id">
                <a 
                    v-if="element.answer != '' && element.answer != null"
                    download
                    class="btn-ead btn-sabiorealm"
                    :href="''+getCurrentDomainName()+'assets/uploads/answers/' + element.answer"
                >
                {{lang["download-answer"]}}
                </a>

                <el-tag v-else type="danger mb-2">{{lang["answer-empty"]}}</el-tag>
                <div>
                    <hr>
                    <!-- Progress -->
                    <div v-if="element.score != null">
                        <h3 class="text-sabiorealm">{{lang["score"]}}</h3>
                        <el-progress :percentage="parseInt(element.score)"></el-progress>
                    </div>

                    <div v-else>
                        <el-tag type="warning mb-2">{{lang["question-in-process-of-evaluation"]}}</el-tag>
                    </div>

                    <!-- Feedback -->
                    <div v-if="element.feedback != null && element.feedback != 'null'">
                        <h3 class="text-sabiorealm">{{lang["feedback"]}}</h3>
                        <el-input 
                            type="textarea" 
                            :rows="5"
                            :value="element.feedback"
                        >
                        </el-input>
                        <!-- Feedback useful or not -->
                        <div v-if="element.feedback_useful == null  && roleId == 3"> 
                            <a href="javascript:void(0)" @click.prevent="avaliateFeedback('yes')" class="text-success pr-2"><i class="far fa-thumbs-up"></i></a>
                            <a href="javascript:void(0)" @click.prevent="avaliateFeedback('no')" class="text-danger"><i class="far fa-thumbs-down"></i></a>
                        </div>
                    </div>

                    <div v-else>
                        <div v-if="element.automaticFeedback != null">
                            <h3 class="text-sabiorealm">{{lang["feedback"]}}</h3>
                            <el-input 
                                type="textarea" 
                                :rows="5"
                                :value="element.automaticFeedback"
                            ></el-input>
                            <!-- Feedback useful or not -->
                            <div v-if="element.feedback_useful == null && roleId == 3"> 
                                <a href="" class="text-success pr-2"><i class="far fa-thumbs-up"></i></a>
                                <a href="" class="text-danger"><i class="far fa-thumbs-down"></i></a>
                            </div>
                        </div>
                        <div v-else>
                            <el-tag  type="info">{{lang["no-feedbacks"]}}</el-tag>
                        </div>
                    </div>
   
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Lang from '@/components/helper/HelperLang'
import ElementUI from 'element-ui'
import {eventLang} from '@/components/helper/HelperLang'
import {eventCorrection} from '@/components/viewcourse/correction/ExamCorrection'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'


locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    components: {
        Lang
    },
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            studentAnswer: [],
            answers: [],
            feedback: '',
            automaticFeedback: '',
            score: null,
            feedbackUseful : null,
            roleId:'',
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventCorrection.$on("finish-correction", function(){
            this.getStudentAnswer();
        }.bind(this));
        
        this.getUserProfile();
        this.getStudentAnswer();
    },
    props: ['question-id', 'question-type', 'student-id'],
    methods: {
        getStudentAnswer: function(){
            var formData = new FormData()
            formData.set('questionId', this.questionId);
            formData.set('studentId', this.studentId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("answer", "getStudentAnswer");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.studentAnswer = response.data;
                this.feedback = response.data[0]['feedback'];
                this.automaticFeedback = response.data[0]['automaticFeedback'];
                this.score = parseInt(response.data[0]['score']);
                this.feedbackUseful = response.data[0]['feedback_useful'];
                this.getAnswers();
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        avaliateFeedback: function(avaliation){
            var formData = new FormData()
            formData.set('questionId', this.questionId);
            formData.set('avaliation', avaliation);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("question", "avaliateFeedback");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.$message({
                    message: this.lang["thanks-for-your-avaliation"],
                    type: 'success'
                });
                this.getStudentAnswer();
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        getAnswers: function(){
            var formData = new FormData()
            formData.set('questionId', this.questionId)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("answer", "listing");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.answers = response.data;
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        verifyIsAnswerIsCorrect: function(answerId){
            var checked = false;
            this.studentAnswer.forEach(element => {
                if(answerId == element['answer']){
                    checked = true;
                }
            });
            return checked;
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

</style>
