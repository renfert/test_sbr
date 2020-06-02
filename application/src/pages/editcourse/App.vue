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
        <update-plan></update-plan> <!-- Update plan modal -->
  </div> <!-- End of wrapper -->
</template>

<script>

import TopBar from '@/components/template/TheTopBar' 
import LeftBar from '@/components/template/TheLeftBar'  
import UpdatePlan from '@/components/template/TheUpdatePlan'  
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
        inner: 'Edit course'
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
        WizardNav,
        FirstStepToEdit,
        SecondStep,
        ThirdStepToEdit
    },
}
</script>

<style>
.form-wizard-wrapper{
  position:relative !important;
}
</style>
