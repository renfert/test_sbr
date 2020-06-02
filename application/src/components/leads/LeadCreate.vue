<template>
    <div>
        <el-dialog :visible.sync="modal" :title="lang['create-account']" center  top="5vh">
            <el-alert
                :title="lang['create-account-to-continue']"
                type="info"
            >
            </el-alert>
            <form id="form-lead" @submit.prevent="createLead()" v-loading="loading" class="form-login text-center border border-light p-5">
                <input required type="text" name="name" id="defaultLoginFormEmail" class="form-control mb-4" :placeholder="lang['name']">
                
                <input required type="email" name="email" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="E-mail">
               
                <input v-model="password" required type="password" id="defaultLoginFormPassword" name="password" class="form-control mb-4" :placeholder="lang['password']">

                <input v-model="confirmPassword" required type="password" id="defaultLoginFormPassword" class="form-control mb-4" :placeholder="lang['confirm-password']">

                <input class="hide" type="number" name="courseId" :value="courseId">

                <!-- Sign in button -->
                <button class="btn btn-info btn-block my-4" type="submit">{{lang['create-account']}}</button>
            </form>
        </el-dialog>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
export const eventLead = new Vue();


Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    props:['course-id'],
    data: function() {
        return {
            modal : false,
            loading: false,
            lang: {},
            password: '',
            confirmPassword: ''
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventLead.$on("open-lead-modal", function(){
            this.modal = true;
        }.bind(this));
    },
    methods: {
        createLead: function(){
            if(this.password == this.confirmPassword){
                this.loading = true;
                var form = document.getElementById('form-lead');
                var formData = new FormData(form);
                var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lead", "create");
                axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                    if(response.data == false){
                        this.userAlreadyExists();
                        this.loading = false;
                    }else{
                        window.location.href = this.getDomainNameToNavigation() + 'courses';
                    }
                }, 
                    function(){
                        this.errorMessage();
                    }.bind(this)
                );
            }else{
                this.diferentPasswords();
            }
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

</style>
