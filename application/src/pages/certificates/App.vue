<template >
    <div id="wrapper">
        <lang></lang>
        <top-bar></top-bar>
        <left-bar></left-bar>
   
        <!-- Content page -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row mt-5">
                        <certificates-list></certificates-list>
                    </div>
                </div>
            </div>
        </div> <!-- End of content page -->
    </div> <!-- End of wrapper -->
</template>

<script>
import TopBar from '@/components/template/TheTopBar.vue' 
import LeftBar from '@/components/template/TheLeftBar.vue'   
import Lang from '@/components/helper/HelperLang.vue'
import CertificatesList from '@/components/certificates/CertificatesList.vue'
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueHead from 'vue-head'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import headerTags from '@/mixins/headerTags'
import integrations from '@/mixins/integrations'
import verify from '@/mixins/verify'

export const eventBus = new Vue();



Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts,integrations,headerTags,verify],
    components: { 
        TopBar,
        LeftBar,
        CertificatesList,
        Lang,
    },
    created(){
        this.loadIntegrations();
        this.createFavicon();
        this.verifySession();
    },
    head: {
        title: {
            inner: 'Certificates'
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
