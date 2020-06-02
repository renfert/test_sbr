<template>
    <div class="col-12">
        <div class="card-box table-responsive mt-5" v-if="programList != null">
            <div class="dropdown pull-right">
                <a @click="changeProgramVisualization()" href="javascript:void(0)"  class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i v-if="programVisualization == 'list'" class="mdi mdi-view-list mdi-36px"></i>
                     <i v-else class="mdi mdi-table mdi-36px"></i>
                </a>
            </div>
            <program-list-view v-if="programVisualization == 'list'"></program-list-view>
            <program-table-view v-else></program-table-view>
        </div>

        <!-- No courses found content -->
        <div class="text-center mt-5" v-else>
            <h4>{{lang["no-programs-found"]}}</h4>
            <img class="image-no-results" src="@/assets/img/general/ux/not_found.png" alt="">
        </div>
        <!-- No courses found content end -->

    </div><!-- End col-12 -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'    
import VueTheMask from 'vue-the-mask'
import { DataTables, DataTablesServer } from 'vue-data-tables'
import {eventLang} from '@/components/helper/HelperLang'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import ProgramListView from '@/components/programs/views/ProgramListView'
import ProgramTableView from '@/components/programs/views/ProgramTableView'

locale.use(lang)
Vue.use(DataTables)
Vue.use(DataTablesServer)
Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    components: { 
       ProgramListView,
       ProgramTableView
    },
    data: function() {
        return {   
            programList : [],
            lang: {},
            modal : false,
            programVisualization: 'list',
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));

        this.getProgram();
    },
    methods:{
        changeProgramVisualization: function(){
            this.programVisualization == 'list' ? this.programVisualization = 'table' : this.programVisualization = 'list';
        },
        getProgram(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("program", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.programList = response.data; 
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }
            );
        },
    },
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    .image-no-results{
        width:15%;
    }
    .box-no-results{
       background-color: #FCFCFC;
    }
    .text-no-results{
        margin-top:25%;
    }

</style>
