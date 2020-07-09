<template>
    <div class="main">
        <lang></lang>
        <el-tag class="mb-3" v-if="answers != null">{{lang["correct-answer-information"]}}</el-tag>

        <bullet-list-loader 
            class="mt-3"
            v-if="loadingContent == true"
            :speed="2"
            width="700"
            height="200"
            primaryColor = "#f0f0f0"
            secondaryColor = "#d9d9d9"
        >
        </bullet-list-loader>

        <div v-else>
            <ul class="list-group">
                <draggable v-model="answers" ghost-class="ghost" @end="finishRepositioning" > 
                    <transition-group type="transition" name="flip-list">
                        <li v-for="element in answers" :key="element.id" class="list-group-item d-flex justify-content-between align-items-center sortable">
                            <div :id="element.id" class="custom-control custom-checkbox answer">
                                <input @change="mark($event,element.id)" :checked="element.correct != null? true :false" type="checkbox" :name="'check'+element.id" class="custom-control-input" :id="'correct'+element.id">
                                <label class="custom-control-label" :for="'correct'+element.id">
                                   <span class="answer-text">{{element.answer}}</span>
                                </label>
                            </div>
                            <div class="action-buttons float-right">
                                <!-- Edit answer -->
                                <el-button @click.prevent="openEditAnswerModal(element.id,element.answer)"  class="sbr-btn sbr-primary"  icon="el-icon-edit" circle></el-button>
                                
                                <!-- Delete module -->
                                <el-button @click.prevent="deleteAnswer(element.id)" slot="reference"  class="sbr-btn sbr-danger"  icon="el-icon-delete" circle></el-button>
                                  
                                <!-- Move answer -->
                                <el-button class="handle sbr-btn sbr-neutral"  icon="el-icon-rank" circle></el-button>
                            </div>
                        </li>
                    </transition-group>
                </draggable>     
            </ul>      
        </div> <!-- End accordion -->

        <!--  Modal edit answer -->
        <div>
            <el-dialog  :visible.sync="modalEditAnswer" append-to-body :title="lang['edit-answer']" center  top="5vh">
                <form id="form-edit-answer" @submit.prevent="editAnswer()">
                    <div class="form-row">
                        <!-- Answer id -->
                        <input type="number" class="hide" name="answerId" v-model="answerId">
                        <div class="form-group col-xl-12 col-md-12">
                            <!-- Answer -->
                            <h4>{{lang["answer"]}}</h4>
                            <el-input type="textarea" rows="5" required v-model="answer" name="answer"></el-input>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-xl-6 col-md-6">
                            <el-button  
                                class="sbr-btn sbr-primary"
                                native-type="submit"  
                                size="medium">{{lang["save-button"]}}
                            </el-button>
                        </div>
                    </div>
                </form>  
            </el-dialog>
        </div>
        <!-- End  modal new module -->
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import Lang from '@/components/helper/HelperLang.vue'
import draggable from 'vuedraggable'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/newcourse/App'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import $ from 'jquery'
import { BulletListLoader } from 'vue-content-loader';

locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    mixins: [domains,alerts],
    components: {
        draggable,
        Lang, 
        BulletListLoader
    },
    data: () => {
        return {
            lang: {},
            answers: null,
            answer: '',
            answerId: '',
            modalEditAnswer: false,
            loading: false,
            correct: '',
            loadingContent: false
        }
    },
    props: ['question-id'],
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on('new-answer', function(){
            this.getAnswers(this.questionId);
        }.bind(this));

        eventBus.$on('new-open-modal-edit-question', function(response){
            this.getAnswers(response["questionId"]);
        }.bind(this));

        this.getAnswers(this.questionId);
    },
    methods: {
        editAnswer: function(){
            var form = document.getElementById('form-edit-answer')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("answer", "edit");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
                this.actionsToBePerformedAfterEdit();
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        mark: function(e,id){
            var status;
            e.target.checked == true ? status = "correct" : status = null;
            var formData = new FormData();
            formData.set("answerId", id);
            formData.set("status", status);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("answer", "changeStatus");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {}, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        openEditAnswerModal: function(id,answer){
            this.answerId = id;
            this.answer = answer;
            this.modalEditAnswer = true; 
        },
        deleteAnswer: function(id){
            var formData = new FormData();
            formData.set('answerId', id);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("answer", "delete");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.getAnswers(this.questionId);  
                this.successMessage();
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        finishRepositioning: function(){
            this.reorderAnswerPositions();
        },
        reorderAnswerPositions: function(){
            var ar  = [];
            $('.answer').each(function(index){
                var id = $(this).attr('id');
                ar.push({'id' : id,'index' : index});
            })
            var formData = new FormData()
            $.each(ar, function( index, value){
               formData.set('answer['+value.id+']', value.index );
            });
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("answer", "reorder");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
            /* Success callback */
            },
                function(){
                    this.errorMessage();
                }.bind(this)
            );

        },
        getAnswers: function (questionId){
            this.loadingContent = true;
            var formData = new FormData()
            formData.set('questionId', questionId)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("answer", "listing");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.reorderAnswerPositions();
                this.answers = response.data;
                setTimeout(function(){ 
                    this.loadingContent = false;
                }.bind(this), 1000);
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        actionsToBePerformedAfterEdit(){
            this.getAnswers(this.questionId);
            this.modalEditAnswer = false; 
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

.answer-text{
    display: block;
    width: 100px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.custom-control-label {
    padding-top: 4px !important;
}

#accordion > .card{
    margin-bottom:2%;
}

.btn-link{
    padding: 0px !important;
    font-size:13px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
}


.btn.link:hover{
    text-decoration: none !important;
}

.card-header{
    padding:10px !important;
}

.btn-eadtools-rounded{
    border-radius: 50%;
    cursor: pointer;
    display: inline-block;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
    position: relative;
    height: 40px;
    width: 40px;
    background-color: #D696EF;
    z-index: 2;
    border:none;
    color:white;
    margin: 0 0.2rem;
}


.sortable-drag{
    opacity: 0;
}

.flip-list-move{
    transition: transform 0.5s;
}

.ghost{
    border-left:6px solid rgb(0, 183, 255);
    border-radius:5px;
    opacity: .5;
}


.card{
    margin-bottom: 15px;
}



.handle{
    cursor:move !important;
}


li{
    list-style-type: none;
}

.lesson{
    text-align:center;
    text-transform: uppercase;
    font-size:10px;
}

.lesson span{
    font-family: 'Poppins', sans-serif;
    margin-top:3em;
    font-size:1em;
}

</style>
