<template >
    <div id="wrapper">
        <lang></lang>
        <top-bar></top-bar>
        <left-bar></left-bar>
  
        <!-- Content page -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- Settings  -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card-box">
                                <h4><b>{{lang["integrations"]}}</b></h4><br>
                                <template>
                                    <el-tabs v-model="tab" tab-position="left" style="height: 300px;">
                                        <el-tab-pane name="gtm" label="Google tag manager">
                                            <google-tag-manager></google-tag-manager>
                                        </el-tab-pane>

                                        
                                        <el-tab-pane name="fb" label="Facebook pixel">
                                            <facebook-pixel></facebook-pixel>
                                        </el-tab-pane>

                                        <el-tab-pane name="ga" label="Google analytics">
                                            <google-analytics></google-analytics>
                                        </el-tab-pane>

                                        <el-tab-pane name="mp" label="Mercado pago">
                                            <mercado-pago></mercado-pago>
                                        </el-tab-pane>
                                    </el-tabs>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of content page -->
        <update-plan></update-plan> <!-- Update plan modal -->
    </div> <!-- End of wrapper -->
</template>

<script>

import TopBar from '@/components/template/TheTopBar.vue' 
import LeftBar from '@/components/template/TheLeftBar.vue'  
import UpdatePlan from '@/components/template/TheUpdatePlan.vue'  
import Lang from '@/components/helper/HelperLang.vue'
import ElementUI from 'element-ui'
import {eventLang} from '@/components/helper/HelperLang'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import GoogleTagManager from '@/components/integrations/GoogleTagManager'
import GoogleAnalytics from '@/components/integrations/GoogleAnalytics'
import MercadoPago from '@/components/integrations/MercadoPago'
import FacebookPixel from '@/components/integrations/FacebookPixel'

locale.use(lang)
Vue.use(ElementUI)


import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueHead from 'vue-head'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import VueGtm from 'vue-gtm';
import VueGtag from "vue-gtag";
export const eventBus = new Vue();


Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            favicon: '',
            lang: [],
            tab: 'gtm'
        }
    },
    created: function(){
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
        inner: 'Integrations'
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
    components: { 
        TopBar,
        LeftBar,
        UpdatePlan,
        Lang,
        GoogleTagManager,
        GoogleAnalytics,
        MercadoPago,
        FacebookPixel
    },
    mounted() {
        eventLang.$on('lang', function(response){
        this.lang = response;
        }.bind(this));
    },
}
</script>

<style>

</style>
