<template>
    <div class="right-widget">
        <h3 v-if="instructors != null">{{lang["instructors"]}}</h3>
        <hr v-if="instructors != null">
        <div class="card-box" v-for="element in instructors" :key="element.id">
            <div class="instructor-profile">
                <el-avatar :size="50"  :src="getCurrentDomainName()+'assets/uploads/avatar/' + element.avatar"></el-avatar>
                <h4>{{element.name}}</h4>
                <el-popover
                    v-if="element.description != null"
                    placement="bottom"
                    width="200"
                    trigger="hover"
                    :content="element.description">
                    <el-button slot="reference" type="primary" icon="el-icon-user" circle></el-button>
                </el-popover>
            </div> 
        </div>
      
    </div>
</template>


<script>

import Vue from 'vue'
import VueHead from 'vue-head'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '@/components/helper/HelperLang'    
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'

Vue.use(VueAxios, axios)
Vue.use(VueHead)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: [],
            instructors: [],
            courseId: '',
        }
    },
    created(){
        this.courseId = this.$route.params.id;
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.getInstructors();
    },
    methods: {
        getInstructors: function(){
            var formData = new FormData();
            formData.set("courseId", this.courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getInstructors")
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.instructors = response.data;
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        }
    }
}
</script>

<style>

.right-widget{
    padding:100px 0px 0px 0px;  
    margin-right:70px;
}

.instructor-profile{
    display:block;
    margin: 0 auto;
    text-align: center;
}

</style>
