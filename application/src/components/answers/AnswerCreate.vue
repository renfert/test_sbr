<template>
  <div>
    <el-dialog  :visible.sync="modalCreateAnswer" :title="lang['create-new-answer']" center  top="5vh">
        <form id="form-answer" @submit.prevent="createAnswer()">
            <div class="form-row">
                <div class="form-group col-xl-12 col-md-12">
                    <!-- Question id -->
                    <input type="number" class="hide" v-model="questionId" name="questionId">
                    <!-- Answer -->
                    <h4>{{lang["answer"]}}</h4>
                    <el-input type="textarea" rows="5" required v-model="answer" name="answer"></el-input>
                </div>
            </div>  
            <div class="form-row">
                <div class="form-group col-xl-6 col-md-6">
                    <el-button  
                        class="btn-sabiorealm"
                        type="primary" 
                        native-type="submit"  
                        size="medium">{{lang["save-button"]}}
                    </el-button>
                </div>
            </div>
        </form>  
    </el-dialog>
  </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ToggleButton from 'vue-js-toggle-button'
import {eventBus} from '@/pages/newcourse/App'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
Vue.use(ToggleButton)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            answer: '',
            modalCreateAnswer : false,
            loading : false,
            questionId: '',
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
        this.lang = response;
        }.bind(this));
        /* Get new answer click event */
        eventBus.$on("open-answer-modal", function(questionId){
            this.modalCreateAnswer = true;
            this.questionId = questionId;
        }.bind(this));
    },
    methods: {
        createAnswer: function(){
            this.loading = true
            var form = document.getElementById('form-answer')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("answer", "create")
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
                this.actionsToBePerformedAfterRegistration();
                this.loading = false
            }, 
            /* Error callback */
            function(){
            this.errorMessage();        
            }
        ); 
    },
    actionsToBePerformedAfterRegistration(){
        this.answer = '',
        this.modalCreateAnswer = false;
        eventBus.$emit('new-answer'); 
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

.textarea-question{
    height:100px !important; 
}


.el-divider--vertical{
    height: auto !important;
}
</style>
