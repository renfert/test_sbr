<template >
    <div id="wrapper">
        <lang></lang>
        <top-bar></top-bar>
        <left-bar></left-bar>
    
        <!-- Content page -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- Create category  -->
                    <div class="row gap-5" v-if="roleId != 3">
                        <program-create></program-create>
                    </div>

                    <!-- List category  -->
                    <div class="row">
                        <program-list></program-list>
                    </div>
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
import ProgramCreate from '@/components/programs/ProgramCreate.vue'
import ProgramList from '@/components/programs/ProgramList.vue'
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
    mixins: [domains,alerts, integrations, headerTags],
    data: () => {
        return {
            roleId: ''
        }
    },
    created(){
        this.loadIntegrations();
        this.createFavicon();
        this.getUserProfile();
    },
    methods: {
        getUserProfile(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserProfile");
            axios.get( urlToBeUsedInTheRequest).then(function (response) {
                this.roleId = response.data["myrole_id"];
            }.bind(this));
        },
    },
    head: {
        title: {
            inner: 'Programs'
        },
        meta: [
            { name: 'charset', content: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1.0'}, 
            { name: 'author', content: 'Sabiorealm' },
        ]
    },
    components: { 
        TopBar,
        LeftBar,
        ProgramCreate,
        ProgramList,
        Lang,
        Loader
    }
}
</script>

<style>

</style>
