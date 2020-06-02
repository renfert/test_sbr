<template >
    <div>
        <lang></lang>
            <site-preview :full-screen-button="false"></site-preview>
        <login></login>
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
export const eventBus = new Vue();
import VueGtag from "vue-gtag";
import VueGtm from 'vue-gtm';
Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts],
    components: { 
        Lang,
        SitePreview,
        Login
    },
    data: () => {
        return {
            favicon: '',
        }
    },
    created(){
        eventBus.$on("full-screen", function(){
        if(this.fullScreen == true){
            this.fullScreen = false;
        }else{
            this.fullScreen = true;
        }
        }.bind(this));

        this.getIntegrations();
    
    },
    methods: {
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
    head: {
        title: {
        inner: 'Home'
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
  .col-xl-8, .col-xl-4, .col-xl-12, .col-xl-3 {
        padding: 0px !important;
  }
  .content-page .content{
        padding: 0px !important;
  }
</style>
