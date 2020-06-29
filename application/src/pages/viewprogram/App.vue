<template >
    <div id="wrapper">
        <lang></lang>
        <top-bar></top-bar>

        <!-- Left side menu -->
        <div class="left side-menu">
            <left-bar></left-bar>
        </div> <!-- End Left side menu -->

        <!-- Content page -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <view-program v-if="programId != ''" :program-id="programId"></view-program>
                </div>
            </div>
        </div> <!-- End of content page -->
        <Loader></Loader>
    </div> <!-- End of wrapper -->
</template>

<script>

import TopBar from '@/components/template/TheTopBar.vue' 
import LeftBar from '@/components/template/TheLeftBar.vue'   
import Lang from '@/components/helper/HelperLang.vue'
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueHead from 'vue-head'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import ViewProgram from '@/components/viewprogram/Viewprogram'
import headerTags from '@/mixins/headerTags'
import integrations from '@/mixins/integrations'
import Loader from '@/components/template/TheLoader.vue'
export const eventBus = new Vue();



Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts,integrations,headerTags],
    components: { 
        TopBar,
        LeftBar,
        Lang,
        ViewProgram,
        Loader
    },
    data: function() {
        return {
            programId: '',
        }
    },
    created(){
        this.loadIntegrations();
        this.createFavicon();
        this.programId = sessionStorage.getItem('sbr_program_id');
    },
    head: {
        title: {
            inner: 'View program'
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

</style>
