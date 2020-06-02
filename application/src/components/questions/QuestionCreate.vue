<template>
  <!--  Modal new question -->
  <div>
    <el-dialog  :visible.sync="modalCreateQuestion" :title="lang['create-new-question']" center  top="5vh">
      <form id="form-question" @submit.prevent="verifyIfExistCorrectAnswer()">
          <div class="form-row">
              <div class="form-group col-xl-6 col-md-6">
                  <!-- Question id -->
                  <input type="number" class="hide" v-model="questionId" name="questionId">
                  <!-- Question type -->
                  <h4>{{lang["question-type"]}}</h4>
                  <br>
                  <el-radio-group @change="updateAnswersList()" v-model="type">
                      <el-radio name="type" :label="1">{{lang["descriptive"]}}</el-radio>
                      <el-radio name="type" :label="2">{{lang["multiple-choice"]}}</el-radio>
                      <el-radio name="type" :label="3">{{lang["free"]}}</el-radio>
                  </el-radio-group>
              </div>
              <div class="form-group col-xl-6 col-md-6">
                  <!-- Question weight -->
                  <h4>{{lang["question-weight"]}}</h4>
                  <br>
                  <div class="block">
                      <input type="number" class="hide" name="weight" v-model="weight">
                      <el-rate  v-model="weight"></el-rate>
                  </div>
              </div>
          </div>
          <hr>
          <div class="form-row">
              <div class="form-group col-xl-6 col-md-6">
                  <input class="hide" type="text" name="examId" :value="examId">
                  <!-- Question -->
                  <h4>{{lang["write-your-question"]}} *</h4>
                  <el-input rows="4" type="textarea" v-model="question" required name="question"></el-input>
                  <br><br>
                  <div v-if="type == 2">
                        <answer-list :question-id="questionId"></answer-list>
                        <br>
                        <el-button 
                            class="btn-sabiorealm"
                            type="primary"  
                            @click.prevent="createNewAnswerEvent()" 
                            size="medium">{{lang["add-new-answer"]}}
                        </el-button>
                  </div>
              </div>
              <div class="form-group col-xl-6 col-md-6">
                  <!-- Question image -->
                  <h4>{{lang["question-image"]}}</h4>
                  <div class="drop-area" style="height:100px !important;"> 
                    <input :value="questionImageName" name="questionImageName" type="text">
                    <input 
                        class="upload"  
                        @change.prevent="render($event)"  
                        type="file"
                        acceptable=".png,.jpg,.jpeg"
                    >
                    <div class="drop-message">
                        <span class="file-icon" :class="icon"></span>
                        <p>{{message}}</p>
                    </div>
                    <div class="drop-preview on" style="text-align:center;">
                        <div class="drop-img">
                            <img id="previewQuestionImage" class="preview" :src="previewImg">
                        </div>
                    </div>
                  </div>
                  <input class="hide" type="text" name="realName" :value="realName">
              </div>
          </div>
          <div class="form-row" v-if="type == 2">
              <div class="form-group col-xl-12 col-md-12">
                  <!-- Automatic feedback -->
                  <h4>{{lang["automatic-feedback"]}}</h4>
                  <el-input rows="5" type="textarea" v-model="automaticFeedback"  name="feedback" class="textarea-question"></el-input>
              </div>
          </div>
          <br>
          <div class="form-row">
              <div class="form-group col-xl-6 col-md-6">
                  <el-button class="btn-sabiorealm" v-loading="loading"  native-type="submit"  type="primary"  size="medium">{{lang["save-button"]}}</el-button>
              </div>
          </div>
      </form>  
    </el-dialog>
  </div>
<!-- End  modal new module -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ToggleButton from 'vue-js-toggle-button'
import AnswerList from '@/components/answers/AnswerList'
import {eventBus} from '@/pages/newcourse/App'
import {eventLang} from '@/components/helper/HelperLang'
import {eventProgress} from '@/components/helper/HelperProgress'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import $ from 'jquery'
Vue.use(ToggleButton)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    components: {
        AnswerList
    },
    data: () => {
        return {
            lang: {},
            question: '',
            questionId: '',
            questionImageName: '',
            weight: 1,
            type: 1,
            modalCreateQuestion : false,
            loading : false,
            automaticFeedback: '',
            checked: '',
            previewImg: '',
            realName: '',
            icon: 'fas fa-cloud-upload-alt',
            message:"Upload a file",
            examId: ''
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
   
        eventBus.$on("open-question-modal", function(response){
        this.questionId = response["questionId"];
        this.examId = response["examId"];
        this.modalCreateQuestion = true;
        }.bind(this));
    },
    methods: {
        updateAnswersList: function(){
            if(this.type == 2){
                eventBus.$emit("new-answer");
            }
        },
        createNewAnswerEvent: function(){
            eventBus.$emit("open-answer-modal", this.questionId);
        },
        editQuestion: function(){
            this.loading = true
            var form = document.getElementById('form-question')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("question", "edit")
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
                this.actionsToBePerformedAfterRegistration();
                this.loading = false
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();        
                }.bind(this)
            ); 
        },
        verifyIfExistCorrectAnswer: function(){
            if(this.type != 2){
                this.editQuestion();
            }else{
                var formData = new FormData();
                formData.set("questionId", this.questionId);
                var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("verify", "correctAnswerExist")
                axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                    if(response.data == true){
                        this.editQuestion();
                    }else{
                        this.unansweredQuestion();
                    }
                }, 
                    function(){
                    this.errorMessage();        
                    }
                ); 
            }
        },
        render: function(event){
            this.upload(event);
            this.message = '';
            this.icon = '';
            var input = event.target; 
            var fullName = input.value;  
            var fileName = fullName.split(/(\\|\/)/g).pop();
            var fileExtension = fullName.split('.').pop();
            this.realName = fileName;
            if(fileExtension == 'png' || fileExtension == 'jpg' || fileExtension == 'jpeg' ){
            var reader = new FileReader();
                reader.onload = function (e) {
                var div = input.parentElement; 
                var img = div.getElementsByTagName('img')[0];
                img.src = e.target.result;
            };  
            reader.readAsDataURL(input.files[0]);
            }else{
            this.message = fileName;
            this.icon = "far fa-thumbs-up text-default";
            }
        },
        upload: function(event){
            eventProgress.$emit("new-progress");
            const config = {
                onUploadProgress: function(progressEvent) {
                var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                eventProgress.$emit("new-percent", percentCompleted);
                }
            }
            var formData = new FormData()
            formData.append('file', event.target.files[0])
            formData.append('type', 'question-image')
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("upload", "upload_file");
            axios.post(urlToBeUsedInTheRequest,formData,config).then((response) => {
                this.questionImageName = response.data;
                event.target.value = null
                eventProgress.$emit("finish-progress");
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        actionsToBePerformedAfterRegistration(){

            $("#previewQuestionImage").removeAttr("src");
            $("#previewQuestionImage").show();

            this.question = '',
            this.weight = 1,
            this.type = 1,
            this.automaticFeedback = '',
            this.message = 'Upload a file';
            this.icon = 'fas fa-cloud-upload-alt';
            this.questionImageName = '';
            this.previewImg = '',
            this.realName = '',
            this.modalCreateQuestion = false;
            eventBus.$emit('new-question'); 
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

.el-divider--vertical{
    height: auto !important;
}
</style>
