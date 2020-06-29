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
import headerTags from '@/mixins/headerTags'
import integrations from '@/mixins/integrations'
export const eventBus = new Vue();


Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts,integrations,headerTags],
    data: () => {
        return {
            lang: [],
        }
    },
    components: { 
        Lang,
        NavBar,
        PurchaseSuccess
    },
    created(){
        this.createFavicon();
        this.loadIntegrations();
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
    },
    head: {
        title: {
            inner: 'Purchase success '
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

</style>
