<template>
    <div class="main" v-loading="loading">
        <nav dark class="navbar navbar-expand-lg navbar-dark" :style="styleHeader">
            <a class="navbar-brand" href="#">
                <img class="sabio-logo" :src="logo" :width="logoSize" >
            </a>
            <button  @click.prevent="changeMobileButtonClass()" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div :style="navMobile" class="collapse navbar-collapse" id="navbarSupportedContent-4">
                <ul class="navbar-nav">
                    <li class="nav-item" v-for="element in links"  :key="element.id">
                        <a  
                            class="nav-link" 
                            :href="element.url"
                            :target="element.target"
                        >
                            {{element.title}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a :href="getDomainNameToNavigation() + 'products'" class="nav-link">
                            Cursos
                        </a>
                    </li>
                    <li class="nav-item" v-if="activeSession == false">
                        <a href="javascript:void(0)" @click.prevent="openLoginModal()" class="nav-link">
                            <span class="nav-login">Login</span>
                        </a>
                    </li>
                    <li class="nav-item" v-else>
                        <a href="javascript:void(0)"  @click.prevent="enterPlatform()" class="nav-link">
                           <span class="nav-login">{{lang["go-to-platform"]}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        
    
       
        <!-- Body section -->
        <section v-for="element in sections" :key="element.id">  
            <banner :section-id="element.id" v-if="element.banner_id != 1"></banner>
            <testimonial :section-id="element.id" v-if="element.testimonial_id != 1"></testimonial>
            <product-list :section-id="element.id" v-if="element.product_list_id != 1"></product-list>
            <text-and-media :section-id="element.id" v-if="element.text_and_media_id != 1"></text-and-media>
        </section>     

        <!-- Footer secion -->   
        <footer class="page-footer font-small blue" :style="styleFooter">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 py-5">
                        <div class="mb-5 flex-center">
                            <!-- Facebook -->
                            <a target="_blank" :href="element.url" v-for="element in socialMedias"  :key="element.id">
                                <i v-if="element.name == 'facebook'" class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                                <i v-if="element.name == 'instagram'" class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                                <i v-if="element.name == 'linkedin'" class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                                <i v-if="element.name == 'twitter'" class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                                <i v-if="element.name == 'pinterest'" class="fab fa-pinterest fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                                <i v-if="element.name == 'youtube'" class="fab fa-youtube fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
                <a href="#"> {{copyright}}</a>
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->

        <!-- Float expand button -->
        <div v-if="fullScreenButton == true" id="container-floating" @click.prevent="fullScreen()">
            <div id="floating-button">
                <p class="full"><i class="el-icon-full-screen"></i></p>
            </div>
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
import {eventBus} from '@/pages/site/App'
import {eventLang} from '@/components/helper/HelperLang'   
import {eventLogin} from '@/components/login/Login'
import Banner from '@/components/site/section/elements/get/Banner' 
import Testimonial from '@/components/site/section/elements/get/Testimonial' 
import ProductList from '@/components/site/section/elements/get/ProductList'
import TextAndMedia from '@/components/site/section/elements/get/TextAndMedia'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'


locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    mixins: [domains,alerts],
    props: ['full-screen-button'],
    components: {
        Banner,
        Testimonial,
        ProductList,
        TextAndMedia
    },
    data: () => {
        return {
            lang: {},
            logo: '',
            logoSize: "",
            sections: null,
            loading: false,
            footerColor: '',
            copyright: '',
            links: [],
            socialMedias: [],
            headerColor: '',
            activeSession: false,
            navMobile: "display:initial !important"
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on("link-list-update", function(){
            this.listHeader();
        }.bind(this));

        eventBus.$on("new-change-header", function(){
            this.listHeader();
        }.bind(this));

        eventBus.$on("new-change-body", function(){
            this.updateSectionListArray();
        }.bind(this));

        eventBus.$on("new-change-footer", function(){
            this.listFooter();
        }.bind(this));

        eventBus.$on("new-section", function(){
            this.updateSectionListArray();
        }.bind(this));

        this.listHeader();
        this.listFooter();
        this.updateSectionListArray();
        this.getSession();
    },
    computed: {
        styleHeader: function(){
             return {
            'background-color': this.headerColor,
            'position': this.headerColor == 'transparent' ? 'absolute' : 'relative',
            'width': '100%'
            }
        },
        styleFooter: function(){
             return {
            'background-color': this.footerColor+'!important',
            }
        },
    },
    methods: {
        openLoginModal: function(){
            eventLogin.$emit("open-login-modal");
        },
        enterPlatform: function(){
            window.location.href=  this.getDomainNameToNavigation() + "dashboard";
        },
        listHeader: function(){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("builder", "listHeader");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.logo = this.getUrlToContents() + 'builder/header/'+response.data[0].logo+'';
                this.logoSize = response.data[0].logo_size + "%";
                this.headerColor = response.data[0].color;
                this.loading = false;
                this.updateLinkListArray();
            },
                /* Error callback */
                function (){
                    this.errorMessage();
                }.bind(this)
            );
        },
        changeMobileButtonClass: function(){
            if(this.navMobile == "display:none !important;"){
                this.navMobile = "display:initial !important;";
            }else{
                this.navMobile = "display:none !important;";
            }
        },
        listFooter: function(){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("builder", "listFooter");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.footerColor = response.data[0].color;
                this.copyright = response.data[0].copyright;
                this.loading = false;
                this.updateSocialMediaListArray();
            },
                /* Error callback */
                function (){
                    this.errorMessage();
                }.bind(this)
            );
        },
        fullScreen: function(){
            eventBus.$emit("full-screen");
        },
        updateSectionListArray: function (){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("section", "listing");
            axios.post(urlToBeUsedInTheRequest).then((response) => {
                this.sections = response.data;
                this.loading = false;
            },
                /* Error callback */
                function (){
                this.errorMessage();
                }.bind(this)
            );
        },
        updateLinkListArray: function (){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("link", "listing");
            axios.post(urlToBeUsedInTheRequest).then((response) => {
                this.links = response.data;
            },
                /* Error callback */
                function (){
                this.errorMessage();
                }.bind(this)
            );
        },
        updateSocialMediaListArray: function (){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("social", "listing");
            axios.post(urlToBeUsedInTheRequest).then((response) => {
                this.socialMedias = response.data;
                this.loading= false;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        getSession: function (){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("Mysessions", "activeSession");
            axios.post(urlToBeUsedInTheRequest).then((response) => {
                this.activeSession = response.data;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

.main{
    width:100%;
    position:relative;    
}

.contact{
    width:400px;
    position:relative;
    margin-left:50%;
    left: -200px;
    text-align:center !important;
}

.sabio-logo{
    padding:1%;
}

.nav-link{
    font-size:1.2em;
    font-family: 'Montserrat', sans-serif;
}

#floating-button{
  width: 45px;
  height: 45px;
  border-radius: 50%;
  background: #09aec7;
  position: fixed;
  bottom: 30px;
  right: 30px;
  cursor: pointer;
  box-shadow: 0px 2px 5px #0e8496;
  padding:10px;
}

.full{
  color: white;
  font-size:15px;
  top: 0;
  display: block;
  bottom: 0;
  left: 0;
  right: 0;
  text-align: center;
  padding: 0;
  margin-top: 0;
  animation: plus-out 0.3s;
  transition: all 0.3s;
}

#container-floating{
  position: fixed;
  width: 70px;
  height: 70px;
  bottom: 30px;
  right: 30px;
  z-index: 50px;
}

#container-floating:hover{
  height: 400px;
  width: 90px;
  padding: 30px;
}

.nav-login{
    border:1px solid white;
    padding:5px 15px 5px 15px;
}

</style>
