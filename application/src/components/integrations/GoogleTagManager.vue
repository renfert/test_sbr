<template>
    <div class="col-6">
        <img class="integration-image" src="@/assets/img/apps/tagmanager.jpg" alt="">
        <br>
        <form @submit.prevent="saveTagManager()" id="form-tag-manager">
            <el-input v-model="id" name="id" :placeholder="lang['tracking-id']"></el-input>
            <el-button class="btn-sabiorealm mt-3" native-type="submit" type="primary">{{lang["save-button"]}}</el-button>
        </form>
    </div>
</template>

<script>

import {eventLang} from '@/components/helper/HelperLang'
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'

Vue.use(ElementUI)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            id: '',
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.getTagManager();
    },
    methods: {
        getTagManager(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("integrations", "getIntegrations")
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                response.data["gtm_id"] == "default" ? this.id = "" : this.id =  response.data["gtm_id"];
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        saveTagManager: function(){
            var formData = new FormData(); 
            formData.set("id", this.id);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("integrations", "saveTagManager")
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
                this.getTagManager();
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();    
                }.bind(this)
            );
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.image-new-course{
    width:50%;
}
.box-courses{
    background-color: #F8FAFC;
}
.text-courses{
    margin-top:18%;
}
</style>
