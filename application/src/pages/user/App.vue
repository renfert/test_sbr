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
                        <div class="svg-wrapper">
                            <svg height="60" width="320" xmlns="http://www.w3.org/2000/svg">
                            <rect class="shape" height="60" width="320" />
                            </svg>
                            <div class="text">{{name}}</div>
                        </div>

                        <!-- Group tabs -->
                        <div class="col-12">
                            <el-tabs type="border-card">
                                <el-tab-pane>
                                    <span slot="label"><i class="mdi mdi-book-outline"></i> {{lang["courses"]}} </span>
                                    <courses :user-id="userId"></courses>
                                </el-tab-pane>

                                <el-tab-pane>
                                    <span slot="label"><i class="mdi mdi-account-star-outline"></i> {{lang["programs"]}} </span>
                                    <programs :user-id="userId"></programs>
                                </el-tab-pane>
                            </el-tabs>
                        </div>
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
import ElementUI from 'element-ui'
import {eventLang} from '@/components/helper/HelperLang'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import Courses from '@/components/user/Courses'
import Programs from '@/components/user/Programs'
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueHead from 'vue-head'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import VueGtag from "vue-gtag";
import VueGtm from 'vue-gtm';
export const eventBus = new Vue();

locale.use(lang)
Vue.use(ElementUI)
Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            favicon: '',
            lang: [],
            userId: '',
            name: '',
            avatar: '',
        }
    },
    created(){
        this.getIntegrations();
        this.userId = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
        this.getUser();
    },
    methods: {
        getUser: function(){
            var formData = new FormData();
            formData.set("userId", this.userId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "get");
            axios.post(urlToBeUsedInTheRequest, formData).then(function (response) {
                this.name = response.data["name"];
                this.avatar = response.data["avatar"];
            }.bind(this));
        },
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
            inner: 'Manage user'
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
    Courses,
    Programs,
  },
  mounted() {
    eventLang.$on('lang', function(response){
      this.lang = response;
    }.bind(this));
  }
}
</script>

<style>
.svg-wrapper {
  cursor:pointer;
  height: 60px;
	margin: 0 auto;
  position: relative;
  top: 50%;
  transform: translateY(-50%);
  width: 320px;
}

.shape {
  fill: transparent;
  stroke-dasharray: 140 540;
  stroke-dashoffset: -474;
  stroke-width: 8px;
  stroke: #009CD8 ;
}

.text {
  color: #4F4F4F;
  font-family: 'Poppins', sans-serif;
  font-size: 22px;
  letter-spacing: 5px;
  position: relative;
  top: -48px;
  text-align:center;
}

@keyframes draw {
  0% {
    stroke-dasharray: 140 540;
    stroke-dashoffset: -474;
    stroke-width: 8px;
  }
  100% {
    stroke-dasharray: 760;
    stroke-dashoffset: 0;
    stroke-width: 2px;
  }
}

.svg-wrapper:hover .shape {
  -webkit-animation: 0.5s draw linear forwards;
  animation: 0.5s draw linear forwards;
}

</style>
