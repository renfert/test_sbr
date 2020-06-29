<template>
    <div>
        <lang></lang>
            <site-preview :full-screen-button="false"></site-preview>
        <login></login>
        <Loader></Loader>
    </div> <!-- End of wrapper -->
</template>

<script>
import Lang from '@/components/helper/HelperLang'
import SitePreview from '@/components/site/SitePreview'
import Login from '@/components/login/Login'
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueHead from 'vue-head'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import headerTags from '@/mixins/headerTags'
import integrations from '@/mixins/integrations'
import Loader from '@/components/template/TheLoader.vue'

export const eventBus = new Vue();
Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts,integrations,headerTags],
    components: { 
        Lang,
        SitePreview,
        Login,
        Loader
    },
    created(){
        eventBus.$on("full-screen", function(){
            if(this.fullScreen == true){
                this.fullScreen = false;
            }else{
                this.fullScreen = true;
            }
        }.bind(this));

        this.loadIntegrations();
        this.createFavicon();
    
    },
    head: {
        title: {
            inner: 'Home'
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
    .col-xl-8, .col-xl-4, .col-xl-12, .col-xl-3 {
        padding: 0px !important;
    }
    .content-page .content{
        padding: 0px !important;
    }
</style>
