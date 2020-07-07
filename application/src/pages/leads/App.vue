<template >
    <div id="wrapper">
        <lang></lang>
        <top-bar></top-bar>
        <left-bar></left-bar>
    
        <!-- Content page -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <lead-list></lead-list>
                    </div>
                </div>
            </div>
        </div> <!-- End of content page -->
    </div> <!-- End of wrapper -->
</template>

<script>


import Vue from 'vue'
import VueHead from 'vue-head'
import axios from 'axios'
import VueAxios from 'vue-axios'
import TopBar from '@/components/template/TheTopBar.vue' 
import LeftBar from '@/components/template/TheLeftBar.vue'  
import Lang from '@/components/helper/HelperLang.vue'
import LeadList from '@/components/leads/LeadList.vue'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import headerTags from '@/mixins/headerTags'
import integrations from '@/mixins/integrations'
export const eventBus = new Vue();


Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts,integrations,headerTags],
    data: () => {
        return {
            lang: {}
        }
    },
    components: { 
        TopBar,
        LeftBar,
        Lang,
        LeadList,
    },
    created: function(){
        this.loadIntegrations();
        this.createFavicon();
    },
    head: {
        title: {
            inner: 'Leads'
        },
        meta: [
            { name: 'charset', content: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1.0'}, 
            { name: 'author', content: 'Sabiorealm' },
        ]
    }
}
</script>

<style>
    .image-no-results{
        width:100%;
    }
    .box-construction{
      background-color: #FCFCFC !important;
    }
    .text-no-results{
        margin-top:25%;
    }
</style>
