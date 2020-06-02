<template >
    <div id="wrapper">
        <lang></lang>
        <nav-bar></nav-bar>

        <div class="main">

            <!-- Subnav -->
            <div class="font-up-bold text-uppercase">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb indigo lighten-4 breadcrumb-course">
                        <li class="breadcrumb-item"><a class="black-text" :href="getDomainNameToNavigation() + 'index'">Home</a><i class="fas fa-caret-right mx-2"
                            aria-hidden="true"></i></li>
                        <li class="breadcrumb-item"><a class="black-text" :href="getDomainNameToNavigation() + 'products'">Courses</a><i class="fas fa-caret-right mx-2"
                            aria-hidden="true"></i></li>
                    </ol>
                </nav> 
            </div>
            <!-- Subnav -->

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-12 col-md-10">
                    <products-list></products-list>
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
import ProductsList from '@/components/products/ProductsList'
import VueGtag from "vue-gtag";
import VueGtm from 'vue-gtm';
export const eventBus = new Vue();

Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            favicon: '',
            img: '',
            lang: [],
            videoOverlay: false
        }
    },
    components: { 
        Lang,
        NavBar,
        ProductsList
    },
    created(){
        this.getIntegrations();
    },
    methods:{
        getIntegrations: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("integrations", "getIntegrations");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                
                /* Google analytics */
                var gaId = response.data["ga_id"];
                Vue.use(VueGtag, {
                    config: { 
                        id: gaId
                    }
                });

                /* Google tag manager */
                var gtmId = response.data["gtm_id"];
                Vue.use(VueGtm, {
                    id: gtmId
                });

            },
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
    },
    head: {
        title: {
        inner: 'Products'
        },
        meta: [
        { name: 'charset', content: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1.0'}, 
        { name: 'author', content: 'Eadtools' },
    
        // Facebook / Open Graph
        { property: 'og:title', content: 'Content Title' },
        // with shorthand
        { p: 'og:image', c: 'teste' },
        ],
        link: [
        { rel: 'icon', href: require('assets/uploads/settings/favicon.png'), sizes: '16x16', type: 'image/png' }
        ],
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


body,html{
    background-color:#F6F9FA !important;
}

</style>
