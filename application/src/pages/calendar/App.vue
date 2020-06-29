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
                        <calendar-view></calendar-view>
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
import CalendarView from '@/components/calendar/CalendarView'
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
    mixins: [domains,alerts,headerTags,integrations],
    components: { 
        TopBar,
        LeftBar,
        Lang,
        Loader,
        CalendarView
    },
    created(){
        this.loadIntegrations();
        this.createFavicon();
    },
    head: {
        title: {
            inner: 'Calendar'
        },
        meta: [
            { name: 'charset', content: 'utf-8' },
            { name: 'description', content: 'Learn and technology'},
            { name: 'viewport', content: 'width=device-width, initial-scale=1.0'}, 
            { name: 'author', content: 'Sabiorealm' },
        ]
    }
}
</script>

<style>

</style>
