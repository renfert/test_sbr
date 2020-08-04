<template>
    <div>
        <el-menu-item   :index="'lesson' + moduleIndex + index" :id="'lesson' + moduleIndex + index"  v-for="(element, index) in lessons" :key="index" @click="sendEventToLoadLesson(element.id, element.type_mylesson_id,element.lessonStatus)">
            <el-divider style="color: red !important;"  direction="vertical"></el-divider>
            <!-- Video icon -->
            <i v-if="element.type_mylesson_id == 1 && element.lessonStatus != 'finished'" class=" mdi mdi-play-speed lesson-icon"></i>
            <!-- Audio icon -->
            <i v-if="element.type_mylesson_id == 2 && element.lessonStatus != 'finished'" class=" mdi mdi-volume-high lesson-icon"></i>
            <!-- Pdf icon -->
            <i v-if="element.type_mylesson_id == 3 && element.lessonStatus != 'finished'" class=" mdi mdi-file-pdf lesson-icon"></i>
            <!-- Downloadable icon -->
            <i v-if="element.type_mylesson_id == 4 && element.lessonStatus != 'finished'" class=" mdi mdi-cloud-download-outline lesson-icon"></i>
            <!-- Video conf icon -->
            <i v-if="element.type_mylesson_id == 5 && element.lessonStatus != 'finished'" class=" mdi mdi-microphone lesson-icon"></i>
            <!-- Webinar icon -->
            <i v-if="element.type_mylesson_id == 6 && element.lessonStatus != 'finished'" class=" mdi mdi-message-video lesson-icon"></i>
            <!-- Html icon -->
            <i v-if="element.type_mylesson_id == 7 && element.lessonStatus != 'finished'" class=" mdi mdi-code-tags lesson-icon"></i>
            <!-- Exam icon -->
            <i v-if="element.type_mylesson_id == 8 && element.lessonStatus != 'finished'" class=" mdi mdi-comment-question lesson-icon"></i>

            <!-- Finished icon -->
            <i v-if="element.lessonStatus == 'finished'" class="  mdi mdi-checkbox-marked-circle-outline lesson-icon lesson-finished"></i>
         
            <span :class="element.lessonStatus == 'finished' ? 'lesson-finished' : ''">{{element.title}}</span>
        </el-menu-item>
    </div>
    
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/components/viewcourse/App'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'


locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            lessons: null,
            currentLesson: '',
        }
    },
    mounted(){    
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on("update-progress-bar", function(){
            this.getLessons(false);
        }.bind(this));

        this.getLessons(true);
    },
    props: ['module-id', 'module-index'],
    methods: {
        sendEventToLoadLesson: function(lessonId, lessonType, lessonStatus){
            var data = {
                "lessonId": lessonId,
                "lessonType": lessonType,
                "lessonStatus": lessonStatus
            };
            eventBus.$emit("load-lesson",data );
        },
        openFirstLesson(){
            document.getElementById("lesson00").click(); 
        },
        getLessons: function(firstLesson){
            var formData = new FormData()
            formData.set('moduleId', this.moduleId)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "listing");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                /* Success callback */
                this.lessons = response.data;
                if(firstLesson == true){
                    setTimeout(function(){ 
                        this.openFirstLesson();
                    }.bind(this), 500);
                }
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
.lesson-finished {
    color: rgb(0, 195, 255) !important;
}

.lesson-icon{
    font-size:1.3em !important;
    padding-right:10px;
}

.el-menu-item{
    font-family: 'Montserrat', sans-serif;
    font-size: 1.1em;
    font-weight: 100 !important;
}

.el-divider--vertical {
    height: 100% !important;
}

.is-active{
    color:white !important;
    background-color: rgb(67, 74, 80) !important;
}
</style>
