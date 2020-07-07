<template>
    <div class="col-12">
        <div class="card-box box-courses">

            <facebook-loader 
                v-if="loadingContent == true"
                :speed="2"
                width="700"
                height="200"
                primaryColor = "#f0f0f0"
                secondaryColor = "#d9d9d9"
            >
            </facebook-loader>


            <div class="row" v-else>
                <div class="col-1"></div>
                <div class="col-xl-5 col-md-5" v-if="courseList == null">
                    <div class="text-courses">
                        <h4>{{lang["no-results-course-title"]}}</h4>
                        <br>
                        <a href="newcourse" class="sbr-btn sbr-primary">{{lang["new-course-button"]}}</a>
                    </div>
                </div>

                <div class="col-12 col-md-4" v-else>
                    <div class="text-courses">
                        <h3>{{lang["courses-already-created"]}} <b class="text-sabiorealm">{{numberTotalOfCoursesCreated}}</b></h3>
                        <br>
                        <a href="newcourse" class="sbr-btn sbr-primary">{{lang["new-course-button"]}}</a>
                    </div>
                </div>
                <el-divider style="height:auto;" direction="vertical"></el-divider>
                 <div class="col-1"></div>
                <div class="col-12 col-md-4 text-center">
                    <h3 class="text-box">See how is easy to create a course</h3>
                    <a id="play-video" class="video-play-button" @click.prevent="videoOverlay = true" href="#">
                        <span></span>
                    </a>
                    <div id="video-overlay" class="video-overlay" :class="videoOverlay == true?'open': ''">
                        <a @click.prevent="videoOverlay = false" class="video-overlay-close">&times;</a>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/lQyl0PUle5E" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End col-12 -->
</template>

<script>

import {eventLang} from '@/components/helper/HelperLang'
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import {eventBus} from '@/pages/courses/App'
import 'element-ui/lib/theme-chalk/index.css'
import { FacebookLoader } from 'vue-content-loader';

Vue.use(ElementUI)
Vue.use(VueAxios, axios)

export default {
    components: {
        FacebookLoader
    },
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            courseList: [],
            numberTotalOfCoursesCreated: '',
            videoOverlay: false,
            loadingContent: false,
        }
    },
    created(){
        this.getCourses();
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on("course-deleted", function(){
            this.getCourses();
        }.bind(this));
    },
    methods: {
        getCourses(){
            this.loadingContent = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.courseList = response.data; 
                setTimeout(function(){ 
                    this.loadingContent = false;
                }.bind(this), 1000);
                if(response.data.length){
                    this.numberTotalOfCoursesCreated = response.data.length;
                }
            }, 
                // Failure callback
                function()  {
                    this.errorMessage();
                }.bind(this)
            );
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>


.text-courses{
    margin-top:15%;
}

.el-divider--vertical{
    height: auto !important;
}

.img-box{
    width:70%;
}

.text-box{
    font-size:17px;
}

.video-play-button {
    position: relative;
    z-index: 10;
    margin-top: 15%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    box-sizing: content-box;
    display: block;
    width: 32px;
    height: 44px;
    /* background: #fa183d; */
    border-radius: 50%;
    padding: 18px 20px 18px 28px;
}

.video-play-button:before {
    content: "";
    position: absolute;
    z-index: 0;
    left: 50%;
    top: 50%;
    transform: translateX(-50%) translateY(-50%);
    display: block;
    width: 80px;
    height: 80px;
    background: #009CD8;
    border-radius: 50%;
    animation: pulse-border 1500ms ease-out infinite;
}

.video-play-button:after {
    content: "";
    position: absolute;
    z-index: 1;
    left: 50%;
    top: 50%;
    transform: translateX(-50%) translateY(-50%);
    display: block;
    width: 80px;
    height: 80px;
    background: #009CD8;
    border-radius: 50%;
    transition: all 200ms;
}

.video-play-button:hover:after {
    background-color: darken(#009CD8, 10%);
}

.video-play-button img {
    position: relative;
    z-index: 3;
    max-width: 100%;
    width: auto;
    height: auto;
}

.video-play-button span {
    display: block;
    position: relative;
    z-index: 3;
    width: 0;
    height: 0;
    border-left: 32px solid #fff;
    border-top: 22px solid transparent;
    border-bottom: 22px solid transparent;
}

@keyframes pulse-border {
  0% {
    transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1.5);
    opacity: 0;
  }
}

.video-overlay {
    position: fixed;
    z-index: -1;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.80);
    opacity: 0;
    transition: all ease 500ms;
}

.video-overlay.open {
    position: fixed;
    z-index: 1000;
    opacity: 1;
}

.video-overlay-close {
    position: absolute;
    z-index: 1000;
    top: 15px;
    right: 20px;
    font-size: 36px;
    line-height: 1;
    font-weight: 400;
    color: #fff;
    text-decoration: none;
    cursor: pointer;
    transition: all 200ms;
}

.video-overlay-close:hover {
    color: #009CD8;
}

.video-overlay iframe {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    /* width: 90%; */
    /* height: auto; */
    box-shadow: 0 0 15px rgba(0,0,0,0.75);
}


</style>
