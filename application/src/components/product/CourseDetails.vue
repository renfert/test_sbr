<template>
    <div>       
        <!-- Title -->
        <h1 class="course-title text-sabiorealm">{{title}}</h1>
        <!-- Course cta -->
        <div class="course-cta">
            <div class="row">
                <div class="col-12 col-md-6">
                    <!-- Price -->
                    <h3 v-if="price == null || price == '' || price == ' 0,00 ' ">FREE</h3>
                    <h3 v-else class="course-price"> {{currency}} {{price}}</h3>
                </div>

                <div class="col-12 col-md-6">

                    <!-- Free course  -->
                    <div v-if="price == null || price == '' || price == ' 0,00 ' ">

                        <!-- Active session -->
                        <div v-if="session == true">

                            <!-- Already registered -->
                            <div v-if="registeredUser">   
                                <el-button 
                                    class="btn-sabiorealm btn-fix" 
                                    @click.prevent="seeCourse()"
                                    icon="el-icon-video-play">{{lang["watch-course"]}}
                                </el-button>
                            </div>
                            
                            <!-- Unregistered user -->
                            <div v-else>
                                <el-button
                                    class="btn-sabiorealm btn-fix"
                                    @click.prevent="enrollFreeCourse()"
                                    icon="el-icon-notebook-1"
                                    v-loading="loading"
                                >   
                                {{lang["take-this-course"]}}

                                </el-button>
                            </div>

                        </div>

                        <!-- Inactive session -->
                        <div v-else>
                            <el-button
                                class="btn-sabiorealm btn-fix"
                                @click.prevent="openLeadModal()"
                                icon="el-icon-notebook-1"
                            >

                            {{lang['take-this-course']}}

                            </el-button>
                        </div>
                        
                    </div>

                    <!-- Paid course -->
                    <div v-else>

                        <!-- Active session -->
                        <div v-if="session == true">

                            <!-- Already registered -->
                            <div v-if="registeredUser == true">
                                <el-button 
                                    class="btn-sabiorealm btn-fix" 
                                    @click.prevent="seeCourse()"
                                    icon="el-icon-video-play">{{lang["watch-course"]}}
                                </el-button>
                            </div>

                            <!-- Unregistered user -->
                            <div v-else>
                                <form action="process" method="POST" v-if="preferenceId != null" >
                                    <script 
                                    src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
                                    :data-preference-id="preferenceId"
                                    type="application/javascript"
                                    >
                                    </script>
                                </form>        
                            </div>
                              
                        </div>

                        <!-- inactive session -->
                        <div v-else>
                            <el-button
                                @click.prevent="openAccountModal()"
                                class="btn-sabiorealm btn-fix"
                            >
                               {{lang["buy-this-course"]}}
                            </el-button>
                        </div>

                    </div>

                
                </div>
            </div>
        </div>

        

        <!-- Course card -->
        <div class="course-card">
            <a v-if="preview != null" id="play-video" class="video-play-button" @click.prevent="videoOverlay = true" href="#">
                <span></span>
            </a>
            <div v-if="preview != null" id="video-overlay" class="video-overlay" :class="videoOverlay == true?'open': ''">
                <a @click.prevent="videoOverlay = false" class="video-overlay-close">&times;</a>
                <div class="player-container">
                    <vue-plyr>
                        <video class="video-preview" :src="''+getCurrentDomainName()+'assets/uploads/preview/' + preview"></video>
                    </vue-plyr>
                </div>
            </div>
            <img  v-if="photo != null" class="card-img-top" :src="''+getCurrentDomainName()+'assets/uploads/course/' + photo">

            <el-tabs type="border-card">

                <!-- Description -->
                <el-tab-pane :label="lang['description']">
                    <div v-html="description"></div>
                </el-tab-pane>

                <!-- Curriculum -->
                <el-tab-pane v-if="modules != null" :label="lang['curriculum']">
                    <el-collapse accordion>
                        <!-- Course module -->
                        <el-collapse-item v-for="element in modules" :key="element.id" :title="element.title" :name="element.id">
                            <div>
                                <ul class="list-group">
                                    <!-- Course lesson -->
                                    <li class="list-group-item">
                                       <lesson-list :action-buttons="false"  :module-id="element.id"></lesson-list>
                                    </li>
                                </ul>
                            </div>
                        </el-collapse-item>
                    </el-collapse>
                </el-tab-pane>
                
            </el-tabs>
        </div>
        <lead-create :course-id="courseId"></lead-create>


        <!-- Create account modal -->
        <el-dialog :visible.sync="modal" :title="lang['create-account']" center  top="5vh">

            <div v-if="createAnAccount" class="fade-in">
                <el-alert
                    :title="lang['create-account-to-continue']"
                    type="info"
                >
                </el-alert>
                <form id="form-account" @submit.prevent="createNewAccount()" v-loading="loading" class="form-login text-center border border-light p-5">
                    <input required type="text" name="name"  class="form-control mb-4" :placeholder="lang['name']">
                    
                    <input required type="email" name="email"  class="form-control mb-4" placeholder="E-mail">
                
                    <input v-model="password" required type="password" name="password" class="form-control mb-4" :placeholder="lang['password']">

                    <input v-model="confirmPassword" required type="password" class="form-control mb-4" :placeholder="lang['confirm-password']">

                    <input type="text" name="role" value="Student" class="hide">

                
                    <!-- Sign in button -->
                    <button class="btn btn-info btn-block my-4" type="submit">{{lang['create-account']}}</button>

                    <div class="options text-center">
                        <p class="pt-1">{{lang["already-have-account"]}} <a href="javascript:void(0)" @click="createAnAccount = false; login = true;" class="blue-text">Log In</a></p>
                    </div>
                </form>
            </div>

            <!-- Login -->
            <div v-if="login" class="fade-in">
                <form @submit.prevent="doLogin" id="form-login" v-loading="loading" class="form-login text-center border border-light p-5">
                    <el-alert
                        @close="wrongPasswordOrUser = false"
                        :title="lang['wrong-password']"
                        type="error"
                        v-if="wrongPasswordOrUser == true"
                        show-icon>
                    </el-alert>
                    <br>
                    <!-- Email -->
                    <input type="email" name="email" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="E-mail">
                    <!-- Password -->
                    <input type="password" id="defaultLoginFormPassword" name="password" class="form-control mb-4" placeholder="Password">

                    <div class="d-flex justify-content-around">
                        <div>
                            <!-- Forgot password -->
                            <a href="javascript:void(0)" @click="modalRecover = true">Forgot password?</a>
                        </div>
                    </div>

                    <!-- Sign in button -->
                    <button class="btn btn-info btn-block my-4" type="submit">Sign in</button>

                    <!-- Register -->
                    <p>{{lang["not-a-member"]}}
                        <a @click="login = false; createAnAccount = true" href="javascript:void(0)">{{lang["register"]}}</a>
                    </p>

                </form>
            </div>


            <div v-if="proceedToPayment" class="fade-in">
                <div class="row">
                    <div class="col-8 mt-3">
                        <h2 class="text-sabiorealm">{{lang["congratulations"]}}</h2>
                        <h3>{{lang["you-are-logged-in-now"]}}</h3>
                        <form v-if="preferenceId != null" action="process" method="POST">
                            <script 
                            src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
                            :data-preference-id="preferenceId"
                            type="application/javascript"
                            >
                            </script>
                        </form>     
                    </div>

                    <div class="col-4">
                        <img style="width:80%;margin-right:0px;margin-left:calc(20% + 41px);margin-top:-35%;" src="@/assets/img/general/ux/payment_proceed.png" alt="payment_proceed">
                    </div>
                </div>
            </div>
        </el-dialog>
    </div> 
</template>


<script>



import Vue from 'vue'
import VueHead from 'vue-head'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '@/components/helper/HelperLang'    
import {eventLead} from '@/components/leads/LeadCreate'    
import {eventLogin} from '@/components/login/Login'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import VuePlyr from 'vue-plyr'
import LessonList from '@/components/lessons/LessonList'
import LeadCreate from '@/components/leads/LeadCreate'


const md5 = require('md5');


Vue.use(VuePlyr, {
  plyr: {
    fullscreen: { enabled: true }
  },
  emit: ['ended']
});



Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts],
    components: {
        LessonList,
        LeadCreate
    },
    props:["currency"],
    data: () => {
        return {
            lang: [],
            videoOverlay: false,
            courseId: '',
            title: '',
            category: '',
            description: '',
            photo: null,
            preview: null,
            price: null,
            comments: '',
            certificate: '',
            modules: null,
            session: false,
            registeredUser: false,
            loading: false,
            userId: '',
            preferenceId: null,
            modal: false,
            password: '',
            confirmPassword: '',
            createAnAccount: true,
            proceedToPayment: false,
            login: false,
            wrongPasswordOrUser: false,
            mpAccessToken: '333'
        }
    },
    created(){
        var courseId = sessionStorage.getItem('sbr_product_id');
        this.courseId = courseId
        this.getCourse(courseId);
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
    
        this.activeSession();

        this.getUserProfile();

        this.checkEnrolledUser();

    },
    methods: {
        createMpPreference:async function(courseTitle,coursePrice,courseId){
            // Mercado pago SDK
            const mercadopago = require ('mercadopago');

            // Get credentials
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("integrations", "getIntegrations")
            await axios.get(urlToBeUsedInTheRequest).then((response) => {
               this.mpAccessToken = response.data["mp_access_token"]; 
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );

            const token = this.mpAccessToken;
            
    
            //Set credentials
            mercadopago.configure({
                sandbox: true,
                access_token: token
            });

            // Create a object with preference
            let preference = {
                items: [
                    {
                        title: courseTitle,
                        unit_price: coursePrice,
                        quantity: 1,
                    }
                ],
                payment_methods: {
                    installments: 1
                },
                external_reference: courseId,
            };

            // Create a preference
            mercadopago.preferences.create(preference)
            .then(function(res){
                this.preferenceId = res.response.id;
                this.savePreferenceId(md5(res.response.id));
            }.bind(this)).catch(function(){
               
            });

            localStorage.setItem('purchase_reference', courseId);
        },
        savePreferenceId: function(preferenceId){
            var formData = new FormData();
            formData.set("preferenceId", preferenceId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("integrations", "saveMpPreference")
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
               
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        createNewAccount: function(){
            if(this.password == this.confirmPassword){
                this.loading = true;
                var form = document.getElementById('form-account');
                var formData = new FormData(form);
                var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "create");
                axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                    if(response.data == false){
                        this.userAlreadyExists();
                        this.loading = false;
                    }else{
                        this.doLoginFromCreateAccountModal();
                    }
                }, 
                    function(){
                        this.errorMessage();
                    }.bind(this)
                );
            }else{
                this.diferentPasswords();
            }
        },

        doLoginFromCreateAccountModal: function(){
            this.loading = true;
            var form = document.getElementById('form-account')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("Login", "doLogin");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                if(response.data == true){
                    this.login = false;
                    this.createAnAccount = false;
                    this.proceedToPayment = true;
                    this.activeSession();
                    eventLogin.$emit("new-login");
                }else{
                    this.wrongPasswordOrUser = true;
                }
                this.loading = false;
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        doLogin: function(){
            this.loading = true;
            var form = document.getElementById('form-login')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("Login", "doLogin");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                if(response.data == true){
                    this.login = false;
                    this.createAnAccount = false;
                    this.proceedToPayment = true;
                    this.activeSession();
                    eventLogin.$emit("new-login");
                }else{
                    this.wrongPasswordOrUser = true;
                }
                this.loading = false;
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        openAccountModal: function(){
            this.modal = true;
        },
        getCourse: function(){
            var formData = new FormData();
            formData.set("courseId", this.courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "get")
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.title = response.data["title"];
                this.category = response.data["category"];
                this.description = response.data["description"];
                this.photo = response.data["photo"];
                this.preview = response.data["preview"];
                this.price = response.data["price"];
                response.data["comments"] == null ? this.comments = false : this.comments = true;
                this.validity = response.data["validity"]; 
                this.certificate = response.data["certificate"];
                this.getModules();
                this.createMpPreference(response.data["title"],parseInt(response.data["price"]),response.data["id"]);
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
    
        seeCourse: function(){
            window.location.href=  this.getCurrentDomainName() + "pages/viewcourse/"+this.courseId+"";
        },
        getModules: function(){
            var formData = new FormData();
            formData.set("courseId", this.courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("module", "listing")
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.modules = response.data;
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        activeSession: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("mysessions", "activeSession")
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.session = response.data;
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        getUserProfile(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserProfile");
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.userId = response.data["id"];
            }.bind(this));
        },
        enrollFreeCourse: function(){
            var formData = new FormData();
            formData.set("courseId", this.courseId);
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "enrollUserIntoCourse")
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                window.location.href=  this.getCurrentDomainName() + "pages/viewcourse/"+this.courseId+"";
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },

        checkEnrolledUser: function(){
            var formData = new FormData();
            formData.set("courseId", this.courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("verify", "userIsInCourse")
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.registeredUser = response.data;
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        openLeadModal: function(){
            eventLead.$emit("open-lead-modal");
        }
    }
}
</script>

<style>

.player-container{
    width: 560px !important;
    display:block;
    margin:0 auto;
    margin-top: 10% !important;
}

.video-preview{
    display:block;
    margin:0 auto;
}

.main  ol{
  padding-left:70px;
}

.main h1.course-title{
  padding:30px 0px 10px 70px; 
}

.course-card{
  margin: 0px 80px 30px 70px; 
}

.course-cta{
  border-radius: 5px;
  background-color:#c5cae9 !important;
  margin:0px 80px 20px 70px;
  padding:10px 10px 10px 10px;
  text-align:center;
}

.course-cta h3{
  font-family: 'Poppins', sans-serif;
  font-size:30px;
  padding:5px;
}


.video-play-button {
    position: absolute;
    z-index: 10;
    margin-top: 0%;
    left: 15%;
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
    background: #09aec7;
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
    background: #09aec7;
    border-radius: 50%;
    transition: all 200ms;
}

.video-play-button:hover:after {
    background-color: darken(#09aec7, 10%);
}

.btn-fix{
    margin-top:3%;
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
    color: #09aec7;
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

.el-tabs__content{
  padding:50px !important;
}

.el-collapse-item__header{
  font-size:18px;
}

.mercadopago-button{
    border: none;
    text-transform: uppercase;
    font-family: 'Lato', sans-serif;
    font-size:12px;
    color: #fff;
    background: #00A9B4;
    box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.2), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.12);
    margin-top:3%;
}

.mercadopago-button:hover {
  border: none;
  color: #fff;
  background: #00E1F0;
  box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.2), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.12);
}

.fade-in{
    animation: fadein 2s;
    -moz-animation: fadein 2s; /* Firefox */
    -webkit-animation: fadein 2s; /* Safari and Chrome */
    -o-animation: fadein 2s; /* Opera */
}

@keyframes fadein {
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
@-moz-keyframes fadein { /* Firefox */
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
@-webkit-keyframes fadein { /* Safari and Chrome */
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
@-o-keyframes fadein { /* Opera */
    from {
        opacity:0;
    }
    to {
        opacity: 1;
    }
}

</style>
