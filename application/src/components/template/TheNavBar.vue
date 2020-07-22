<template>
    <div>
        <login></login>
       
        <nav dark class="navbar navbar-expand-lg navbar-dark" :style="styleHeader">
            <a class="navbar-brand" :href="getDomainNameToNavigation()">
                <img class="sabio-logo" :src="logo" :width="logoSize" >
            </a>
            <button  @click.prevent="changeMobileButtonClass()" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div :style="navMobile" class="collapse navbar-collapse" id="navbarSupportedContent-4">
                <ul class="navbar-nav ml-auto" style="float:right;">
                    <li class="nav-item" v-for="element in links"  :key="element.id">
                        <a  
                            class="nav-link" 
                            :href="element.url"
                            :target="element.target"
                            :style ="styleLinks"
                        >
                            {{element.title}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a 
                            :href="getDomainNameToNavigation() + 'products'" 
                            class="nav-link" 
                            :style ="styleLinks"
                        >
                            Cursos
                        </a>
                    </li>
                    <li class="nav-item" v-if="activeSession == false">
                        <a 
                            href="javascript:void(0)" 
                            @click.prevent="openLoginModal()" 
                            class="nav-link"
                            :style ="styleLinks"
                        >
                            <span  :style="styleBorder" >Login</span>
                        </a>
                    </li>
                    <li class="nav-item" v-else>
                        <a 
                            href="javascript:void(0)"
                            @click.prevent="enterPlatform()"
                            class="nav-link"
                            :style ="styleLinks"
                        >
                            <span :style="styleBorder">{{lang["go-to-platform"]}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
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
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import Login from '@/components/login/Login'


locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    mixins: [domains,alerts],
    props: ['full-screen-button'],
    components: {
        Login
    },
    data: () => {
        return {
            lang: {},
            logo: '',
            logoSize: "",
            sections: null,
            loadingHeader: false,
            loadingSection: false,
            loadingFooter: false,
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

        eventLogin.$on("new-login", function(){
            this.getSession();
        }.bind(this));

        this.getSession();
        this.listHeader();
      
    },
    computed: {
        styleHeader: function(){
             return {
                'background-color': this.headerColor,
                'width': '100%'
            }
        },
        styleFooter: function(){
             return {
                'background-color': this.footerColor+'!important',
            }
        },
        styleLinks: function(){
            return{
                'color': this.headerColor == 'transparent' ? '#969bb5': 'white'
            }
        },
        styleBorder: function(){
             return{
                'border': this.headerColor == 'transparent' ? '1px solid #969bb5': '1px solid white',
                'padding': '5px 15px 5px 15px'
            }
        }
    },
    methods: {
        enterPlatform: function(){
            window.location.href=  "home";
        },
        openLoginModal: function(){
            eventLogin.$emit("open-login-modal");
        },
        listHeader: function(){
            this.loadingHeader = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("builder", "listHeader");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.logo = this.getUrlToContents() + 'builder/header/'+response.data[0].logo+'';
                this.logoSize = response.data[0].logo_size + "%";
                this.headerColor = response.data[0].color;
                this.loadingHeader = false;
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
            this.loadingFooter = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("builder", "listFooter");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.footerColor = response.data[0].color;
                this.copyright = response.data[0].copyright;
                this.loadingFooter = false;
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
            this.loadingSection = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("section", "listing");
            axios.post(urlToBeUsedInTheRequest).then((response) => {
                this.sections = response.data;
                this.loadingSection = false;
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
    font-family: 'Poppins', sans-serif;
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
