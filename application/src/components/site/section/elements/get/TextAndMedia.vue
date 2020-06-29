<template>
    <div class="section" v-loading="loading">
        <div class="inner-section"  v-for="element in textAndMediaArray" :key="element.id">
            <!-- Left side media position -->
            <div v-if="element.media_align == 'left' " class="row">
                <div class="col-12 col-md-6">
                    
                    <img :src="getUrlToContents() + 'builder/body/'+element.media+''" v-if="mediaExtension == 'png' || mediaExtension == 'jpg' || mediaExtension == 'jpeg'" style="max-width:100%;">
                   
                    <div class="player-container"  v-else>
                        <vue-plyr>
                            <video :src="getUrlToContents() + 'builder/body/'+element.media+''"></video>
                        </vue-plyr>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 text-align-right">
                    <h1>{{element.header}}</h1>
                    <h3>{{element.subheader}}</h3>
                    <p>{{element.content}}</p>
                    <a 
                        class="btn-marketplace-sabiorealm"
                        :style="styleButton" 
                        :href="element.url"
                        :target="element.target"
                    >
                        {{element.title}}
                    </a>
                </div>
            </div>
            <!-- End side media position -->


            <!-- Right side media position -->
            <div v-if="element.media_align == 'right'" class="row">
                <div class="col-12 col-md-6 text-align-left">
                    <h1>{{element.header}}</h1>
                    <h3>{{element.subheader}}</h3>
                    <p>{{element.content}}</p>
                    <a 
                        class="btn-marketplace-sabiorealm"
                        :style="styleButton" 
                        :href="element.url"
                        :target="element.target"
                    >
                        {{element.title}}
                    </a>
                </div>
                <div class="col-12 col-md-6 right-side">
                    <img :src="getUrlToContents() + 'builder/body/'+element.media+''" v-if="mediaExtension == 'png' || mediaExtension == 'jpg' || mediaExtension == 'jpeg'" style="max-width:100%;">
                    <div class="player-container"  v-else>
                        <vue-plyr>
                            <video :src="getUrlToContents() + 'builder/body/'+element.media+''"></video>
                        </vue-plyr>
                    </div>
                </div>
            </div>
            <!-- End side media position -->

            <br><br>

            <!-- Top side media position -->
            <div v-if="element.media_align == 'top'"  class="text-box">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <img :src="getUrlToContents() + 'builder/body/'+element.media+''" v-if="mediaExtension == 'png' || mediaExtension == 'jpg' || mediaExtension == 'jpeg'" style="max-width:100%;"> 
                        <div class="player-container"  v-else>
                            <vue-plyr>
                                <video :src="getUrlToContents() + 'builder/body/'+element.media+''"></video>
                            </vue-plyr>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 text-align-bottom">
                        <h1>{{element.header}}</h1>
                        <h3>{{element.subheader}}</h3>
                        <p>{{element.content}}</p>
                        <a 
                        class="btn-marketplace-sabiorealm"
                        :style="styleButton" 
                        :href="element.url"
                        :target="element.target"
                        >
                        {{element.title}}
                        </a>
                    </div>
                </div>
            </div>
            <!-- End side media position -->

            <br><br>

            <!-- Bottom side media position -->
            <div v-if="element.media_align == 'bottom'"  class="text-box">
                <div class="row">
                    <div class="col-12 col-md-12 text-align-top">
                        <h1>{{element.header}}</h1>
                        <h3>{{element.subheader}}</h3>
                        <p>{{element.content}}</p>
                        <a 
                        class="btn-marketplace-sabiorealm"
                        :style="styleButton" 
                        :href="element.url"
                        :target="element.target"
                        >
                        {{element.title}}
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <img :src="getUrlToContents() + 'builder/body/'+element.media+''" v-if="mediaExtension == 'png' || mediaExtension == 'jpg' || mediaExtension == 'jpeg'" style="max-width:100%;"> 
                        <div class="player-container"  v-else>
                            <vue-plyr>
                                <video :src="getUrlToContents() + 'builder/body/'+element.media+''"></video>
                            </vue-plyr>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End side media position -->
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'    
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import VuePlyr from 'vue-plyr'
import {eventBus} from '@/pages/site/App'

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
    props:["section-id"],
    data: () => {
        return {
            lang: {},
            loading: false,
            textAndMediaArray: [],
            mediaExtension: '',
            buttonColor: '',
            buttonStyle: '',
            buttonTitle: '',
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on('new-change-text-and-media', function(){  
            this.getTextAndMedia();
        }.bind(this));

        this.getTextAndMedia();
    },
    methods: {
        getTextAndMedia: function(){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("site-elements/TextAndMedia", "get");
            var formData = new FormData();
            formData.set("sectionId", this.sectionId);
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.loading = false;
                this.textAndMediaArray = response.data;
                this.buttonStyle = response.data[0].style;
                this.buttonColor = response.data[0].color;
                this.buttonTitle = response.data[0].title;
                this.getMediaExtension(response.data[0].media);
            },
                /* Error callback */
                function (){
                this.errorMessage();
                }.bind(this)
            );
        },
        getMediaExtension(media){
            var mediaNameArray = media.split(".");
            this.mediaExtension = mediaNameArray[1];
        }
    },
    computed: {
        styleButton: function() {
            return {
            'background-color': this.buttonColor,
            'display': this.buttonTitle == null ? 'none' : 'initial',
            '--color-hover': this.buttonColorHover,
            'border-radius': this.buttonStyle == 'plain'? '0px' : '30px'
            }
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.col-12, .col-md-6{
    padding: 0 !important;
}

.text-align-right{
    padding-left:50px !important;
}

.text-align-left{
    padding-right:50px !important;
}

.text-align-bottom{
    padding-top:30px !important;
}

.text-align-top{
    padding-bottom:30px !important;
}

p{
    padding-bottom:20px;
}
</style>
