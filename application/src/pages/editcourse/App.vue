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
                            <first-step-to-edit></first-step-to-edit>
                            <second-step></second-step>
                            <third-step-to-edit></third-step-to-edit>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of content page -->
  </div> <!-- End of wrapper -->
</template>

<script>

import TopBar from '@/components/template/TheTopBar' 
import LeftBar from '@/components/template/TheLeftBar'  
import WizardNav from '@/components/newcourse/WizardNav'
import FirstStepToEdit from '@/components/newcourse/FirstStepToEdit'
import SecondStep from '@/components/newcourse/SecondStep'
import ThirdStepToEdit from '@/components/newcourse/ThirdStepToEdit'
import Lang from '@/components/helper/HelperLang'
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
    mixins: [domains,alerts, headerTags, integrations,verify],
    data: () => {
        return {
            
        }
    },
    created: function(){
        this.blockStudentAccess();
        this.loadIntegrations();
        this.createFavicon();
        this.verifySession();
    },
    head: {
        title: {
            inner: 'Edit course'
        },
        meta: [
            { name: 'charset', content: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1.0'}, 
            { name: 'author', content: 'Sabiorealm' },
        ],

    },
    components: { 
        TopBar,
        LeftBar,
        Lang,
        WizardNav,
        FirstStepToEdit,
        SecondStep,
        ThirdStepToEdit, 
    },
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
