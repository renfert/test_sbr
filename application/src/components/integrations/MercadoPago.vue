<template>
    <div class="col-6">
        <br>
        <img class="integration-image" src="@/assets/img/apps/mercadopago.png" alt="mercadopago" style="width:100px;padding-bottom:10px;">
        <br>
        <form id="form-mp" @submit.prevent="saveMpAccessToken()" v-loading="loading">
            <div class="form-group">

                <el-input :type="typeInput" v-model="accessToken" name="id" placeholder="ACCESS TOKEN">
                    <el-button @click.prevent="changeInputType()"  slot="append" :icon="typeInput == 'password' ? 'mdi mdi-eye-off' : 'mdi mdi-eye'"></el-button>
                </el-input>
                <el-button class="btn-sabiorealm mt-3" native-type="submit" type="primary">{{lang["save-button"]}}</el-button>
                <br>

                <div class="mt-5">
                    <p>{{lang["how-get-access-token"]}}</p>
                    <el-select  v-model="code" name="country" :placeholder="lang['select-your-country']">

                        <!-- Argentina -->
                        <a target="_blank" href="https://www.mercadopago.com/mla/account/credentials"> 
                            <el-option
                            label="ar"
                            value="ar">
                                <span style="float: left"> Argentina</span>
                                <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/ar.png"  alt="en" /></span>
                            </el-option> 
                        </a>

                        <!-- Uruguay -->
                        <a target="_blank" href="https://www.mercadopago.com/mlu/account/credentials"> 
                            <el-option
                            label="uy"
                            value="uy">
                                <span style="float: left">Uruguay</span>
                                <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/uy.png"  alt="uy" /></span>
                            </el-option>
                        </a>

                        <a target="_blank" href="https://www.mercadopago.com/mco/account/credentials"> 
                            <!-- Colombia -->
                            <el-option
                            label="co"
                            value="co">
                                <span style="float: left">Colombia</span>
                                <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/co.png"  alt="co" /></span>
                            </el-option>
                        </a>

                        <!-- México -->
                        <a target="_blank" href="https://www.mercadopago.com/mlm/account/credentials"> 
                            <el-option
                            label="mx"
                            value="mx">
                                <span style="float: left">México</span>
                                <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/mx.png"  alt="mx" /></span>
                            </el-option>
                        </a>


                        <!-- Chile -->
                        <a target="_blank" href="https://www.mercadopago.com/mlc/account/credentials"> 
                            <el-option
                            label="cl"
                            value="cl">
                                <span style="float: left">Chile</span>
                                <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/cl.png"  alt="cl" /></span>
                            </el-option>
                        </a>
                        
                        <a target="_blank" href="https://www.mercadopago.com/mlb/account/credentials"> 
                            <el-option
                            label="br"
                            value="br">
                            <span style="float: left">Brasil</span>
                            <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/pt-br.png"  alt="pt-br" /></span>
                            </el-option>
                        </a>

                        <a target="_blank" href="https://www.mercadopago.com/mpe/account/credentials"> 
                            <el-option
                            label="pe"
                            value="pe">
                            <span style="float: left">Peru</span>
                            <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/pe.png"  alt="pe" /></span>
                            </el-option>
                        </a>

                        <a target="_blank" href="https://www.mercadopago.com/mlv/account/credentials"> 
                            <el-option
                            label="ven"
                            value="ven">
                            <span style="float: left">Venezuela</span>
                            <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/ven.png"  alt="ven" /></span>
                            </el-option>
                        </a>
                    </el-select>
                </div>
            </div>
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
Vue.use(ElementUI)
Vue.use(VueAxios, axios)
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            code: '',
            lang: {},
            loading: false,
            accessToken: '',
            typeInput: "password"
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.getMpAccessToken();
    },
    methods: {
        goToMpUrl: function(){
            this.loading = true;
            var mpAppCode = "4167639943437679";
            var mpReturnUrl = "https%3A%2F%2Fmp.eadtools.com";
            switch (this.code) {
                case 'br':
                    window.location.href="https://auth.mercadopago.com.br/authorization?client_id="+mpAppCode+"&response_type=code&platform_id=mp&redirect_uri="+mpReturnUrl+"";
                    break;
            }
        },
        changeInputType: function(){
            if(this.typeInput == "password"){
                this.typeInput = "text";
            }else{
                this.typeInput = "password";
            }
        },
        getMpAccessToken: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("integrations", "getIntegrations")
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                response.data["mp_access_token"] == "default" ? this.accessToken = "teste" : this.accessToken =  response.data["mp_access_token"];
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        saveMpAccessToken: function(){
            var formData = new FormData(); 
            formData.set("id", this.accessToken);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("integrations", "saveMpAccessToken")
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
                this.getMpAccessToken();
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
