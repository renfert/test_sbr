<template>
    <div class="main">
        <lang></lang>

        
        <bullet-list-loader 
            v-if="loadingContent == true"
            :speed="2"
            width="700"
            height="200"
            primaryColor = "#f0f0f0"
            secondaryColor = "#d9d9d9"
        >
        </bullet-list-loader>

        <div v-else>

            <div>
                <draggable v-model="lessons" ghost-class="ghost" @end="finishRepositioning" >
                    <transition-group type="transition" name="flip-list">
                        <div class="sortable"  v-for="element in lessons" :key="element.id">
                            <li :class="'lesson'+moduleId" :id="element.id" >
                                <div class="lesson-box">

                                    <template class="action-buttons" v-if="actionButtons != false">

                                        <!-- Edit lesson -->   
                                        <el-tooltip class="item" effect="dark" :content="lang['edit-lesson']" placement="top-start">
                                            <el-button class="sbr-btn sbr-primary mr-1" @click.prevent="editLesson(element.id,element.title,element.path,element.ext, element.real_name, element.date, element.time,element.description,element.url,element.approval,element.retest,element.type_mylesson_id,element.status)" type="primary"  size="mini" icon="el-icon-edit" circle></el-button>
                                        </el-tooltip>

                                        <!-- Delete lesson -->
                                        <template>
                                            <el-popconfirm
                                                confirmButtonText='Ok'
                                                cancelButtonText='No, Thanks'
                                                placement="right"
                                                :title="lang['question-delete-lesson'] +element.title  + '?'"
                                                @onConfirm="deleteLesson(element.id)"
                                            >
                                                <el-button class="sbr-btn sbr-danger mr-1"  slot="reference" type="danger"  size="mini" icon="el-icon-delete" circle></el-button>
                                            </el-popconfirm>
                                        </template>
                                            
                                        <!-- Move lesson -->
                                        <el-tooltip class="item" effect="dark" :content="lang['reposition-lesson']" placement="top-start">
                                            <el-button class="handle sbr-btn sbr-neutral mr-1" type="purple"   size="mini" icon="el-icon-rank" circle></el-button>
                                        </el-tooltip>
                                        <el-divider direction="vertical"></el-divider>
                                    </template>


                                    <!-- Video icon -->
                                    <i v-if="element.type_mylesson_id == 1" class="far fa-play-circle text-eadtools fa-lg"></i>
                                    <!-- Audio icon -->
                                    <i v-if="element.type_mylesson_id == 2" class="fas fa-volume-up fa-lg text-eadtools"></i>
                                    <!-- Pdf icon -->
                                    <i v-if="element.type_mylesson_id == 3" class="far fa-file-pdf fa-lg text-eadtools"></i>
                                    <!-- Downloadable icon -->
                                    <i v-if="element.type_mylesson_id == 4" class="fas fa-file-download fa-lg text-eadtools"></i>
                                    <!-- Video conf icon -->
                                    <i v-if="element.type_mylesson_id == 5" class="fas fa-microphone fa-lg text-eadtools"></i>
                                    <!-- Webinar icon -->
                                    <i v-if="element.type_mylesson_id == 6" class="fas fa-video fa-lg text-eadtools"></i>
                                    <!-- Html icon -->
                                    <i v-if="element.type_mylesson_id == 7" class="fas fa-code fa-lg text-eadtools"></i>
                                    <!-- Exam icon -->
                                    <i v-if="element.type_mylesson_id == 8" class="fas fa-question fa-lg text-eadtools"></i>
                                    <span class="lesson-title">
                                        {{element.title}}
                                    </span> 
                                </div>
                            </li>
                        </div>
                    </transition-group>
                </draggable>           
            </div> <!-- End accordion -->
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ToggleButton from 'vue-js-toggle-button'
import ElementUI from 'element-ui'
import Lang from '@/components/helper/HelperLang.vue'
import draggable from 'vuedraggable'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/newcourse/App'
import $ from 'jquery'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import { BulletListLoader } from 'vue-content-loader';

Vue.use(ToggleButton)
Vue.use(VueTheMask)
locale.use(lang)
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
            lessons: null,
            modal: false,
            loadingContent: false,
        }
    },
    mounted(){
    
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on('new-lesson', function(){
            this.getLessons();
        }.bind(this));

        this.getLessons();
    },
    props: ['module-id', 'action-buttons'],
    methods: {
        editLesson: function(id,title,path,ext, real_name, date, time,description,url,approval,retest,type_mylesson_id,status){
            var data = [{
                'id' : id,
                'title': title,
                'path': path,
                'ext': ext,
                'real_name': real_name,
                'date': date,
                'time': time,
                'description': description,
                'url': url,
                'approval': approval,
                'retest': retest,
                'status': status
            }]
            eventBus.$emit("edit-lesson-"+type_mylesson_id+"", data);
        },
        deleteLesson: function(id){
            var formData = new FormData();
            formData.set('lessonId', id);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "delete");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.getLessons();  
                this.successMessage();
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        finishRepositioning: function(){
            this.reorderLessonPositions();
        },
        reorderLessonPositions: function(){
            var ar  = [];
            $('.lesson'+this.moduleId+'').each(function(index){
                var id = $(this).attr('id');
                ar.push({'id' : id,'index' : index});
            })
            var formData = new FormData()
            $.each(ar, function( index, value){
               formData.set('lesson['+value.id+']', value.index );
            });
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "reorder");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
            /* Success callback */
            },
                function(){
                    this.errorMessage();
                }.bind(this)
            );

        },
        getLessons: function(){
            this.loadingContent = true;
            var formData = new FormData()
            formData.set('moduleId', this.moduleId)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "listing");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.lessons = response.data;
                setTimeout(function(){ 
                    this.loadingContent = false;
                }.bind(this), 1000);
            },
                /* Error callback */
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
.lesson-box{
    box-shadow: 0px 0px 5px 0px #aca9a9;
    padding:15px;
    border-radius: 30px;
    margin:2% 10% 0% 5%;
}

.lesson-title{
    font-family: 'Poppins', sans-serif !important;
    font-weight: 400;
    font-size: 16px;
    margin-left: 5px;
}

.btn-link{
    text-align:left !important;
}

.action-buttons{
    padding:10px;
}

#accordion > .card{
    margin-bottom:2%;
}

.card-header{
    padding:0px !important;
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

.btn-group{
    position:absolute;
    margin: 1% 75% !important;
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
    max-width: 80% !important;
}

.handle{
    cursor:move !important;
}

li{
    list-style-type: none;
}

</style>
