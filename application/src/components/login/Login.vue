<template>
    <div>
        <el-dialog :visible.sync="modalLogin" title="Sign in" center  top="5vh">
            <form @submit.prevent="doLogin()" id="form-login" v-loading="loading" class="form-login text-center border border-light p-5">
                <el-alert
                    @close="wrongPasswordOrUser = false"
                    :title="lang['wrong-password']"
                    type="error"
                    v-if="wrongPasswordOrUser == true"
                    show-icon>
                </el-alert>
                <br>
                <!-- Email -->
                <input type="email" name="email" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="E-mail">
                <!-- Password -->
                <input type="password" id="defaultLoginFormPassword" name="password" class="form-control mb-4" placeholder="Password">

                <div class="d-flex justify-content-around">
                    <div>
                        <!-- Forgot password -->
                        <a href="#" @click="modalRecover = true">Forgot password?</a>
                    </div>
                </div>

                <!-- Sign in button -->
                <button class="btn btn-info btn-block my-4" type="submit">Sign in</button>

            </form>
        </el-dialog>

        <el-dialog :visible.sync="modalRecover" title="Recover password" center width="40%" top="5vh">
            <form  v-loading="loadingRecover" id="form-recover" @submit.prevent="recoverPassword()" action="recover">
                <el-input v-model="email" required placeholder="Email" name="email"></el-input>
                <button class="btn-ead btn-sabiorealm">Recover</button>
                <el-alert
                    v-if="failedRecover == true"
                    :title="lang['this-email-doesnt-exist']"
                    type="error">
                </el-alert>

                <el-alert
                    v-if="successRecover == true"
                    :title="lang['please-review-your-email']"
                    type="success">
                </el-alert>
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
export const eventLogin = new Vue();


Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: function() {
      return {
        modalLogin : false,
        modalRecover: false,
        loading: false,
        loadingRecover: false,
        wrongPasswordOrUser: false,
        recoverEmail: '',
        failedRecover: false,
        successRecover: false,
        email: '',
        lang: {}
      }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventLogin.$on("open-login-modal", function(){
            this.modalLogin = true;
        }.bind(this));
    },
    methods: {
        doLogin: function(){
            this.loading = true;
            var form = document.getElementById('form-login')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("Login", "doLogin");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                if(response.data == true){
                    window.location.href = this.getDomainNameToNavigation() + 'courses';
                }else{
                    this.wrongPasswordOrUser = true;
                }
                this.loading = false;
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        recoverPassword: function(){
            this.successRecover = false;
            this.failedRecover = false;
            this.loadingRecover = true;
            var form = document.getElementById('form-recover')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("Login", "recoverPassword");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                if(response.data == true){
                    this.successRecover = true;
                }else{
                    this.failedRecover = true;
                }
                this.loadingRecover = false;
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.custom-control-label{
    padding-top:4px !important;
}
</style>
