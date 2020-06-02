<template >
    <div id="wrapper" class="forced enlarged">
        <lang></lang>
        <top-bar></top-bar>
        <left-bar :collapse="true"></left-bar>
        
        <!-- Content page -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-4" v-if="fullScreen == false">
                            <toolbar></toolbar>
                        </div>
                        <div :class="fullScreen == false ? 'col-xl-8' : 'col-xl-12'">
                            <site-preview :full-screen-button="true"></site-preview>
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
import Toolbar from '@/components/site/toolbar/Toolbar.vue'
import SitePreview from '@/components/site/SitePreview.vue'
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueHead from 'vue-head'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
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
            fullScreen: false
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
        inner: 'Site'
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
        Lang,Toolbar,
        SitePreview
    }
}
</script>

<style scoped>

    .el-menu--collapse{
        width:71px !important;
    }
    .col-xl-8, .col-xl-4, .col-xl-12, .col-xl-3 {
        padding: 0px !important;
    }
    .content-page .content{
        padding: 0px !important;
    }
  
</style>
