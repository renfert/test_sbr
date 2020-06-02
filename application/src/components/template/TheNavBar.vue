<template>
    <div>
        <login></login>
        <!-- Header section -->
        <mdb-navbar expand="large" dark class="navbar navbar-expand-lg navbar-dark" :style="styleHeader" v-loading="loadingHeader">
            <!-- Header section -->
            <mdb-navbar-brand>
                <img class="sabio-logo" :src="logo" :width="logoSize" >
            </mdb-navbar-brand>

            <mdb-navbar-toggler>
                <mdb-navbar-nav right>

                    <mdb-nav-item :target="element.target" v-for="element in links"  :key="element.id" class="nav-link" :href="element.url" active>{{element.title}}</mdb-nav-item>

                    <mdb-nav-item class="nav-link" :href="getDomainNameToNavigation() + 'products'">Cursos</mdb-nav-item>

                    <mdb-nav-item v-if="activeSession == false" class="nav-link" href="javascript:void(0)" @click.prevent="openLoginModal()"> <span class="nav-login">Login</span> </mdb-nav-item>

                    <mdb-nav-item v-else  class="nav-link" href="javascript:void(0)" @click.prevent="enterPlatform()"> <span class="nav-login">{{lang["go-to-platform"]}}</span></mdb-nav-item>

                </mdb-navbar-nav>
            </mdb-navbar-toggler>

        </mdb-navbar>
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



import * as mdbvue from 'mdbvue'

for (const component in mdbvue) {
  Vue.component(component, mdbvue[component])
}

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
            activeSession: false
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
        enterPlatform: function(){
            window.location.href=  this.getDomainNameToNavigation() + "dashboard";
        },
        openLoginModal: function(){
            eventLogin.$emit("open-login-modal");
        },
        listHeader: function(){
            this.loadingHeader = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("builder", "listHeader");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.logo = ""+this.getCurrentDomainName()+"assets/uploads/builder/header/"+response.data[0].logo;
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
