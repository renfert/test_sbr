<template >
    <div id="wrapper">
        <lang></lang>
        <top-bar></top-bar>
        <left-bar></left-bar>
   
        <!-- Content page -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row gap-5">

                        <!-- Group title -->
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
                                <courses :group-id="groupId"></courses>
                                </el-tab-pane>

                                <el-tab-pane>
                                <span slot="label"><i class="mdi mdi-account-multiple-outline"></i> {{lang["students"]}} </span>
                                <students :group-id="groupId"></students>
                                </el-tab-pane>

                                <el-tab-pane>
                                <span slot="label"><i class="mdi mdi-account-star-outline"></i> {{lang["instructors"]}} </span>
                                <instructors :group-id="groupId"></instructors>
                                </el-tab-pane>

                                <el-tab-pane>
                                <span slot="label"><i class="mdi mdi-account-star-outline"></i> {{lang["programs"]}} </span>
                                <programs :group-id="groupId"></programs>
                                </el-tab-pane>
                                
                            </el-tabs>
                        </div>
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
import ElementUI from 'element-ui'
import {eventLang} from '@/components/helper/HelperLang'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import Courses from '@/components/group/Courses'
import Students from '@/components/group/Students'
import Instructors from '@/components/group/Instructors'
import Programs from '@/components/group/Programs'
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

locale.use(lang)
Vue.use(ElementUI)
Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts,integrations,headerTags],
    data: () => {
        return {
            lang: [],
            groupId: '',
            name: '',
        }
    },
    created(){
        this.loadIntegrations();
        this.createFavicon();
        this.groupId = sessionStorage.getItem('sbr_group_id');
        this.getGroup();
    },
    methods: {
        getGroup: function(){
            var formData = new FormData();
            formData.set("groupId", this.groupId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "get");
            axios.post(urlToBeUsedInTheRequest, formData).then(function (response) {
                this.name = response.data["name"];
            }.bind(this));
        },
    },
    head: {
        title: {
            inner: 'Manage group'
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
        Courses,
        Students,
        Instructors,
        Programs,
        Loader
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
