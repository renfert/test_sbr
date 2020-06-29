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
                        <wizard-nav></wizard-nav>
                        <div class="form-wizard-content-wrapper">
                            <first-step></first-step>
                            <second-step></second-step>
                            <third-step></third-step>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of content page -->
        <Loader></Loader>
    </div> <!-- End of wrapper -->
</template>

<script>

import TopBar from '@/components/template/TheTopBar' 
import LeftBar from '@/components/template/TheLeftBar'  
import WizardNav from '@/components/newcourse/WizardNav'
import FirstStep from '@/components/newcourse/FirstStep'
import SecondStep from '@/components/newcourse/SecondStep'
import ThirdStep from '@/components/newcourse/ThirdStep'
import Lang from '@/components/helper/HelperLang'
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
    mixins: [domains,alerts,integrations,headerTags],
    created: function(){
        this.loadIntegrations();
        this.createFavicon();
    },
    head: {
        title: {
            inner: 'New course'
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
        Lang,
        WizardNav,
        FirstStep,
        SecondStep,
        ThirdStep,
        Loader
    },
}
</script>

<style scoped>
.form-wizard-wrapper{
    position:relative !important;
}

.container-fluid{
    padding-left: 0px !important;
    padding-right: 0px !important;
}
</style>
