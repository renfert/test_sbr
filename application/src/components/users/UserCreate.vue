<template>
    <div class="col-12">
        <div class="card-box">
            <div class="float-right">
                <!-- Massive import button -->
                <el-button class="btn-sabiorealm"  v-if="plan == 'bussiness' || plan == 'trial'"  @click.prevent="modal = true" type="primary"  size="medium">{{lang["massive-import"]}}</el-button>

                <el-button @click.prevent="upgradePlan()" v-else class="btn-eadtools"   type="primary"    size="medium">{{lang["massive-import"]}}</el-button>
            </div>
            <h4>{{lang["create-user"]}}</h4><br>
            <form id="form-user" @submit.prevent="createUser">
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <!-- Username -->
                        <div class="form-group">
                            <el-input required name="name" :placeholder="lang['name']" v-model="name"></el-input>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <el-input required type="password" name="password" :placeholder="lang['password']" v-model="password"></el-input>
                        </div>
                
                        <div class="form-group">
                            <el-button 
                                v-loading="loadingButton" 
                                class="btn-sabiorealm" 
                                native-type="submit"  
                                type="primary"  
                                size="medium">
                                {{lang["save-button"]}}
                            </el-button>
                        </div>
                    </div>

                    <div  class="col-xl-4 col-md-4">
                        <!-- Email -->
                        <div class="form-group">
                            <el-input required type="email" name="email" :placeholder="lang['email']" v-model="email"></el-input>
                        </div>
                        <!-- Role -->
                        <div class="form-group">
                            <template>
                                <el-select required name="role" v-model="role" :placeholder="lang['select-role']">
                                    <el-option 
                                        value="2"
                                        :label="lang['instructor']"
                                    >
                                        {{lang["instructor"]}}
                                    </el-option>
                                    <el-option 
                                        value="3"
                                        :label="lang['student']"
                                    >
                                        {{lang["student"]}}
                                    </el-option>
                                </el-select>
                            </template>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Massive import -->
            <div>
                <el-dialog  :visible.sync="modal" :title="lang['massive-import']" center width="40%" top="5vh">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 left">
                            <a download href="https://cdn.eadtools.com/files/import_user.xlsx" class="btn-ead-md btn-sabiorealm-secondary">{{lang["download-template"]}}</a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 center">
                            <form id="form-massive" @submit.prevent="massivelyCreateUsers">
                                <upload 
                                    input-name="file" 
                                    acceptable=".xlsx" 
                                    box-height = "200"
                                >
                                </upload>
                                <br>
                                <el-button 
                                    v-loading="loadingButton" 
                                    class="btn-sabiorealm" 
                                    native-type="submit"  
                                    type="primary"  
                                    size="medium">
                                    {{lang["save-button"]}}
                                </el-button>
                            </form>
                        </div>
                    </div>
                </el-dialog>
            </div> <!-- End massive import -->  
        </div>
        <upgrade-plan></upgrade-plan>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventBus} from '@/pages/categories/App'
import {eventLang} from '@/components/helper/HelperLang'
import {eventPlan} from '@/components/plans/UpgradePlan'
import {eventUpload} from '@/components/helper/HelperUpload'
import ElementUI from 'element-ui'
import VueTheMask from 'vue-the-mask'
import Upload from '@/components/helper/HelperUpload'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import UpgradePlan from '@/components/plans/UpgradePlan'

locale.use(lang)
Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: function() {
        return {
            modal : false,
            url: '',
            target: '',
            title: '',
            name: '',
            email: '',
            role: '',
            password: '',
            lang: {},
            plan: '',
            loadingButton : false
        }
    },
    components: {
        Upload,
        UpgradePlan
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));    
    },
    created: function(){
        this.getCompanyInformation();
    },
    methods: {
        upgradePlan: function(){
            eventPlan.$emit("upgrade-plan");
        },
        getCompanyInformation(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("company", "getCompanyInformation");
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.plan = response.data["plan"];
            }.bind(this));
        },
        createUser: function(){
            this.loadingButton = true;
            var form = document.getElementById('form-user');
            var formData = new FormData(form);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "create");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                /* Success callback */
                if(response.data == "upgrade-plan"){
                    eventPlan.$emit("upgrade-plan");
                }else{
                    if(response.data == false){ 
                        this.userAlreadyExistsMessage();
                    }else{
                        this.successMessage();
                        this.actionsToBePerformedAfterRegistration();
                    }
                }
                this.loadingButton = false;
            },
                /* Error callback */ 
                function(){
                    this.errorMessage();       
                }.bind(this)
            );
        },
        massivelyCreateUsers: function(){
            this.modal = false;
            var form = document.getElementById('form-massive');
            var formData = new FormData(form);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "massivelyCreateUsers");
            axios.post(urlToBeUsedInTheRequest,formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(() => {
                this.successMessage();   
                eventBus.$emit('new-user');  
                eventUpload.$emit("clear");
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        userAlreadyExistsMessage(){
            this.$notify({
                title: this.lang['error'],
                message: this.lang["user-already-exists"],
                type: 'warning',
                duration: 3500
            });
        },
        actionsToBePerformedAfterRegistration(){
            eventBus.$emit('new-user');  
            this.name = '';
            this.email = '';
            this.password = '';
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.col-md-4{
  padding-right: 15px !important;
  padding-left: 15px !important;
}
</style>
