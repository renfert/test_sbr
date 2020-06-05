<template >
    <div>
        <div id="wrapper">
            <lang></lang>
            <nav-bar></nav-bar>
            <div>
                <div class="row">
                    <purchase-success></purchase-success>
                </div>
            </div>
        </div> <!-- End of wrapper -->
    </div>
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
import PurchaseSuccess from '@/components/purchase/PurchaseSuccess'
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
            videoOverlay: false,
            currency: '',
        }
    },
    components: { 
        Lang,
        NavBar,
        PurchaseSuccess
    },
    created(){
        var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("settings", "getSettingsInformation")
        axios.get(urlToBeUsedInTheRequest).then(function (response) {
        this.currency = response.data["currency"];
        }.bind(this));

        this.getIntegrations();
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
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
    head: {
        title: {
        inner: 'Product'
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

</style>
