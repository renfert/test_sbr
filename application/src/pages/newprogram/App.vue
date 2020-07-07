<template >
    <div id="wrapper">
        <lang></lang>
        <top-bar></top-bar>
        <left-bar></left-bar>
   
        <!-- Content page -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="form-wizard-wrapper">
                        <div class="form-wizard-content-wrapper">
                            <create-program></create-program>
                        </div>
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
import CreateProgram from '@/components/newprogram/CreateProgram'
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
        CreateProgram,
    },
    created: function(){
        this.loadIntegrations();
        this.createFavicon();
    },
    head: {
        title: {
            inner: 'New program'
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
.container-fluid{
    padding-left:0px !important;
    padding-right: 0px !important;
}

.form-wizard-wrapper{
    position:relative !important;
}
</style>
