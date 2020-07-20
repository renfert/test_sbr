<template>
    <div class="block" style="margin-top:-5%;">
        <lang></lang> 

        <!-------------- 
            Introduction
        --------------->
        <div class="row text-center">
            <div class="col-12">
                <img class="waiter" src="@/assets/img/general/ux/gifs/waiter-rev1.gif" alt="">
                <h2 class="sbr-text-grey text-center">{{lang['welcome-to-sabiorealm']}} <b>{{userName}}</b></h2>  
                <h3>{{lang['welcome-message-pt1']}}</h3>
                <h4 class="sbr-text-grey">{{lang['welcome-message-pt2']}}</h4>
            </div>
        </div> 
        <!-------------- 
            End  Introduction
        --------------->

        <!-------------- 
            Steps
        --------------->
        <div class="block text-center mb-5 mt-5">
            <hr class="divisor">
            <div class="row text-center">
                <div class="col-md-3 col-12 mb-5">
                    <img v-if="userStep != null" src="@/assets/img/general/ux/tour/check.png">
                    <img v-else src="@/assets/img/general/ux/tour/1.png">
                    <h3>{{lang['create-user']}}</h3>
                    <div v-if="userStep == null">
                        <a href="users?tour=true" class="sbr-btn sbr-primary mb-3">{{lang['create']}}</a>
                        <br>
                        <span>
                            <a class="sbr-text-grey" href="#">{{lang['skip-this-step']}} <i class="el-icon-right"></i></a>
                        </span>
                    </div>
                </div>
                 <div class="col-md-3 col-12 mb-5">
                    <img v-if="courseStep != null" src="@/assets/img/general/ux/tour/check.png">
                    <img v-else src="@/assets/img/general/ux/tour/2.png">
                    <h3>{{lang['new-course-button']}}</h3>
                    <div v-if="courseStep == null">
                        <a href="newcourse?tour=true" class="sbr-btn sbr-primary mb-3">{{lang['create']}}</a>
                        <br>
                        <span>
                            <a  class="sbr-text-grey" href="#">{{lang['skip-this-step']}} <i class="el-icon-right"></i></a>
                        </span>
                    </div>
                </div>
                 <div class="col-md-3 col-12 mb-5">
                    <img v-if="customizeStep != null" src="@/assets/img/general/ux/tour/check.png">
                    <img v-else src="@/assets/img/general/ux/tour/3.png">
                    <h3>{{lang['customize-your-platform']}}</h3>
                    <div v-if="customizeStep == null">
                        <button class="sbr-btn sbr-primary mb-3">{{lang['personalize']}}</button>
                        <br>
                        <span>
                            <a class="sbr-text-grey" href="#">{{lang['skip-this-step']}} <i class="el-icon-right"></i></a>
                        </span>
                    </div>
                </div>
                <div class="col-md-3 col-12 mb-5">
                    <img v-if="settingsStep != null" src="@/assets/img/general/ux/tour/check.png">
                    <img v-else src="@/assets/img/general/ux/tour/4.png">
                    <h3>{{lang['change-settings']}}</h3>
                    <div v-if="settingsStep == null">
                        <button class="sbr-btn sbr-primary mb-3">{{lang['to-set-up']}}</button>
                        <br>
                        <span>
                            <a class="sbr-text-grey" href="#">{{lang['skip-this-step']}} <i class="el-icon-right"></i></a>
                        </span>
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
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import Lang from '@/components/helper/HelperLang.vue'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'


locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    components: {
        Lang,
    },
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            userName: '',
            userStep: null,
            courseStep: null,
            customizeStep: null,
            settingsStep: null
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.getUserProfile();
        this.getStepsStatus();
    },
    methods: {
        getUserProfile(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserProfile");
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.userName = response.data["name"];
            }.bind(this));
        },
        getStepsStatus: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("verify", "stepsStatus");
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.userStep = response.data[0]["status"];
                this.courseStep = response.data[1]["status"];
                this.customizeStep = response.data[2]["status"];
                this.settingsStep = response.data[3]["status"];
            }.bind(this));
        },  
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>


@media only screen and (max-width: 600px) {
    .divisor{
        position:absolute;
        width:100%;
        border-top: 3px solid #8c8b8b;
        margin-top:3.5%;
        margin-left:-20px;
        display: none !important;
    }
}

.divisor{
    position:absolute;
    width:100%;
    border-top: 3px solid #8c8b8b;
    margin-top:3.5%;
    margin-left:-20px;
}

.waiter{
    width: 18%;
}

@media only screen and (max-width: 600px) {
    .waiter{
        width: 90%;
    }
}
</style>
