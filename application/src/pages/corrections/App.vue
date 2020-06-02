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
                        <corrections-list></corrections-list>
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
import CorrectionsList from '@/components/corrections/CorrectionsList.vue'
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
    components: { 
        TopBar,
        LeftBar,
        UpdatePlan,
        CorrectionsList,
        Lang
    },
    created(){
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
            inner: 'Corrections'
        },
        meta: [
            { name: 'charset', content: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1.0'}, 
            { name: 'author', content: 'Eadtools' },
            { property: 'og:title', content: 'Content Title' },
            { p: 'og:image', c: 'teste' },
        ],
        link: [
            { rel: 'icon', href: '../../../../assets/uploads/settings/favicon.png', sizes: '16x16', type: 'image/png' }, 
        ],
    },
}
</script>

<style>

</style>
