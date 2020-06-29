<template>
  <div class="topbar">
    <!-- Logo -->
    <div class="topbar-left">
      <a :href="getDomainNameToNavigation() + 'index'" class="logo">
        <span> <img :src="getUrlToContents() + 'settings/'+logo+''"></span>
        <i class="mdi mdi-layers"> </i>
      </a>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <ul class="nav navbar-nav list-inline navbar-left">
            <li class="list-inline-item">
                <button @click="changeLeftBarClass()" class="button-menu-mobile open-left">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
            <li class="list-inline-item"></li>
        </ul>

    
        <nav class="navbar-custom">
        </nav>
      </div><!-- end container -->
    </div><!-- end navbar -->
  </div><!-- end topbar -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '@/components/helper/HelperLang'
import {eventTemplate} from '@/components/template/TheLeftBar'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'

Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
        groupId: 1,
        logo: '',
        lang: {},
        }
    },
    created(){
        this.getCompanyLogo();
    },
    mounted(){
        eventLang.$on('lang', function(response){
        this.lang = response;
        }.bind(this));
    },
    methods: {
        getCompanyLogo(){
        var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("settings", "getSettingsInformation");
        axios.get(urlToBeUsedInTheRequest).then(function (response) {
            this.logo = response.data["logo"];
        }.bind(this));
        },
        changeLeftBarClass: function(){
            eventTemplate.$emit("change-leftbar-class");
        },
        chooseDomainForDevOrProductonEnviroment(controler,model){
            var entireUrl = window.location.href;
            var entireUrlDividedIntoTwoParts = entireUrl.split("/");
            var domainName = entireUrlDividedIntoTwoParts[0] + "//" + entireUrlDividedIntoTwoParts[2];
            var url = process.env.NODE_ENV === 'production' ? ''+domainName+'/'+controler+'/'+model : ''+process.env.VUE_APP_URL_DEV+controler+'/'+model
            return url;
        },
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

  @media only screen and (min-width: 1024px) {
    .navbar {
      display:none;
    }
  }

  .navbar-custom{
    max-width:500px;
  }

  ul.list-unstyled{
    width:70px;
  }

  li.dropdown.notification-list{
      margin-right:5%;
  }
  .view-title{
    text-align:center;
    text-transform: uppercase;
    background-color:#3BB6B6;
    color:white !important;
  }
  .dropdown-menu {
    padding: 0px 0 !important;
    font-size: 14px;
    -webkit-box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
  } 
 
</style>
