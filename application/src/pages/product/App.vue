<template >
    <div id="wrapper">
        <lang></lang>
        <nav-bar></nav-bar>
        <div class="main">

            <!-- Subnav -->
            <div class="font-up-bold text-uppercase">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb indigo lighten-4 breadcrumb-course">
                        <li class="breadcrumb-item"><a class="black-text" href="/">Home</a><i class="fas fa-caret-right mx-2"
                            aria-hidden="true"></i></li>
                        <li class="breadcrumb-item"><a class="black-text" href="products">Courses</a><i class="fas fa-caret-right mx-2"
                            aria-hidden="true"></i></li>
                    </ol>
                </nav> 
            </div>
            <!-- Subnav -->

            <div class="row">
                <!-- Left content -->
                <div  class="col-12 col-md-8">
                    <course-details :currency="currency"></course-details>
                </div>

                <!-- Right content -->
                <div  class="col-12 col-md-3">
                    <right-widget></right-widget>
                </div>
            </div>
        </div>
    </div> <!-- End of wrapper -->
</template>

<script>

import Vue from 'vue'
import VueHead from 'vue-head'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Lang from '@/components/helper/HelperLang.vue'
import {eventLang} from '@/components/helper/HelperLang'    
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import NavBar from '@/components/template/TheNavBar'
import CourseDetails from '@/components/product/CourseDetails'
import RightWidget from '@/components/product/RightWidget'
import headerTags from '@/mixins/headerTags'
import integrations from '@/mixins/integrations'
export const eventBus = new Vue();


Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts,integrations,headerTags],
    data: () => {
        return {
            img: '',
            lang: [],
            videoOverlay: false,
            currency: '',
        }
    },
    components: { 
        Lang,
        NavBar,
        CourseDetails,
        RightWidget,
    },
    created(){
        var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("settings", "getSettingsInformation")
        axios.get(urlToBeUsedInTheRequest).then(function (response) {
            this.currency = response.data["currency"];
        }.bind(this));

        this.loadIntegrations();
        this.createFavicon();
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
    },
    head: {
        title: {
            inner: 'Product'
        },
        meta: [
            { name: 'charset', content: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1.0'}, 
            { name: 'author', content: 'Sabiorealm' },
        ]
    },
}
</script>

<style>
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




</style>
