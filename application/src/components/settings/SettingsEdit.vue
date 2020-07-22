<template>
    <div class="col-12">
        <div class="card-box">
            <h4><b>{{lang["your-settings"]}}</b></h4><br>
            <form id="form-settings" @submit.prevent="editSettings">
                <div class="row">
                <template>
                    <el-tabs tab-position="left">
                        <el-tab-pane :label="lang['school-information']">
                            <div class="row" style="padding-left:15px;">
                            <div class="col-6">
                                <div class="form-group">
                                    <!-- School name -->
                                    <label>{{lang['school-name']}}</label>
                                    <el-input class="v-settings-step-0" required name="name" :placeholder="lang['school-name']" v-model="name"></el-input>
                                </div>
                                <label>{{lang['logo']}}</label>
                                <upload 
                                    class="v-settings-step-2"
                                    v-if="this.logoName != ''"
                                    :src-img="this.getUrlToContents() + 'settings/'+this.logoName+''"
                                    :src-name="this.logoName"
                                    do-upload= "true"
                                    box-height = "200"
                                    return-name="logo" 
                                    input-name="file"  
                                    bucket-key="uploads/settings" 
                                    acceptable=".png,.jpg,.jpeg">
                                </upload>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>{{lang['description']}}</label>
                                    <el-input class="v-settings-step-1"  name="description" :placeholder="lang['description']" v-model="description"></el-input>
                                </div>
                                <label>{{lang['favicon']}}</label>
                                <upload 
                                    class="v-settings-step-3"
                                    v-if="this.faviconName != ''"
                                    :src-img="this.getUrlToContents() + 'settings/'+this.faviconName+''"
                                    :src-name="this.faviconName"
                                    do-upload= "true"
                                    box-height = "200"
                                    return-name="favicon" 
                                    input-name="file"  
                                    bucket-key="uploads/settings" 
                                    acceptable=".png,.jpg,.jpeg">
                                </upload>
                            </div>
                            </div>            
                        </el-tab-pane>

                        <el-tab-pane :label="lang['contact-information']">
                            
                            <div class="col-12">
                                <div class="form-group">
                                <!-- Email -->
                                <label>{{lang['email']}}</label>
                                <el-input  name="email" :placeholder="lang['email']" v-model="email"></el-input>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                <!-- phone -->
                                <label>{{lang['phone']}}</label>
                                <el-input  name="phone" :placeholder="lang['phone']" v-model="phone"></el-input>
                                </div>
                            </div>
                        
                        </el-tab-pane>

                        <el-tab-pane :label="lang['general-settings']">
                            <div class="col-12">
                                <div class="form-group">
                                    <!-- lang -->
                                    <label>{{lang['language']}}</label>
                                    <br>
                                    <el-select v-model="language" name="language" placeholder="Select your language">
                                        <el-option
                                            label="en"
                                            value="en">
                                            <span style="float: left">en</span>
                                            <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/en.png"  alt="en" /></span>
                                        </el-option>

                                        <el-option
                                            label="es"
                                            value="es">
                                            <span style="float: left">es</span>
                                            <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/es.png"  alt="es" /></span>
                                        </el-option>

                                        <el-option
                                            label="pt-br"
                                            value="pt-br">
                                            <span style="float: left">pt-br</span>
                                            <span style="float: right; color: #8492a6; font-size: 13px"><img src="@/assets/img/general/flags/pt-br.png"  alt="pt-br" /></span>
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <!-- Time/zone -->
                                    <label>Time/zone</label>
                                    <br>
                                    <el-select filterable  v-model="timezone" name="timezone" placeholder="Select your Time/Zone">
                                        <el-option
                                            v-for="item in zones"
                                            :key="item"
                                            :label="item"
                                            :value="item">
                                            <span style="float: left">{{item}}</span>
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <!-- marketplace -->
                                    <label>{{lang['marketplace']}}</label>
                                    <br>
                                    <el-switch name="marketplace" v-model="marketplace">
                                    </el-switch>
                                </div>
                            </div>
                        </el-tab-pane>
                    </el-tabs>
                </template>
                </div>
                <el-button class="sbr-btn sbr-primary v-settings-step-4" native-type="submit"  type="primary"  size="medium">{{lang["save-button"]}}</el-button>
            </form>
        </div>
        <helper-progress></helper-progress>

        <!-------- 
            Tour
        ---------->
        <v-tour name="settings-tour" :options="tourOptions" :callbacks="tourCallbacks"  :steps="steps"></v-tour>
  </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '@/components/helper/HelperLang'
import Upload from '@/components/helper/HelperUpload'
import HelperProgress from '@/components/helper/HelperProgress.vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import VueTour from 'vue-tour'
require('vue-tour/dist/vue-tour.css')
Vue.use(VueTour)

Vue.use(ElementUI)
Vue.use(VueAxios, axios)

export default {
    mixins: [domains,alerts],
    data: function() {
        return {
            name: '',
            email: '',
            description: '',
            phone: '',
            logoName: '',
            faviconName: '',
            language: '',
            marketplace: false, 
            lang: {},
            timezone: '',
            zones: [],
            tourCallbacks: {
                onFinish: this.finishTour
            },
            tourOptions: {
                useKeyboardNavigation: true,
                labels: {
                    buttonSkip:'',
                    buttonPrevious: '',
                    buttonNext: '',
                    buttonStop: ''
                }
            },
            steps: [
                {
                    target: ".v-settings-step-0",
                    header: {
                        title: ''
                    },
                    params: {
                        placement: 'top',
                        highlight: true
                    },
                    content: ''
                },
                {
                    target: ".v-settings-step-1",
                    header: {
                        title: ''
                    },
                    params: {
                        placement: 'right',
                        highlight: true
                    },
                    content: ''
                },
                {
                    target: ".v-settings-step-2",
                    header: {
                        title: ''
                    },
                    params: {
                        placement: 'right',
                        highlight: true
                    },
                    content: ''
                },
                {
                    target: ".v-settings-step-3",
                    header: {
                        title: ''
                    },
                    params: {
                        placement: 'left',
                        highlight: true
                    },
                    content: ''
                },
                {
                    target: ".v-settings-step-4",
                    header: {
                        title: ''
                    },
                    params: {
                        placement: 'right',
                        highlight: true
                    },
                    content: ''
                },
              
            ],
        }
    },
    components: { 
        Upload,
        HelperProgress
    },
    created(){
        this.getSettings();
        this.getTimeZone();
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;

            /* Tour labels */
            this.tourOptions.labels.buttonSkip = this.lang["skip-tour"];
            this.tourOptions.labels.buttonPrevious = this.lang["previous-step-button"];
            this.tourOptions.labels.buttonNext = this.lang["next-step-button"];
            this.tourOptions.labels.buttonStop = this.lang["finish"];

            /* Tour step 0 - Name */
            this.steps[0].header.title = this.lang["name"];
            this.steps[0].content = this.lang["tour-settings-name-message"];

            /* Tour step 1 - Description */
            this.steps[1].header.title = this.lang["description"];
            this.steps[1].content = this.lang["tour-settings-description-message"];

            /* Tour step 2 - Logo */
            this.steps[2].header.title = this.lang["logo"];
            this.steps[2].content = this.lang["tour-settings-logo-message"];

            /* Tour step 3 - Favicon */
            this.steps[3].header.title = this.lang["favicon"];
            this.steps[3].content = this.lang["tour-settings-favicon-message"];

            /* Tour step 4 - Save button */
            this.steps[4].header.title = this.lang["save-button"];
            this.steps[4].content = this.lang["tour-settings-finish"];

            setTimeout(() => {
                if(this.$route.query.tour == 'true'){
                    this.$tours['settings-tour'].start();
                }
            }, 2500)

        }.bind(this));  
    },
    methods: {
        finishTour () {
            window.location.href="/home";
        },
        getSettings: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("settings", "getSettingsInformation")
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.faviconName = response.data["favicon"];
                this.name = response.data["name"];
                this.description = response.data["description"];
                this.email = response.data["email"];
                this.phone = response.data["phone"];
                this.timezone = response.data["zone"];
                this.language = response.data["lang"];
                response.data["marketplace"] == 'on' ? this.marketplace = true : this.marketplace = false;
                this.logoName = response.data["logo"];
                this.faviconName = response.data["favicon"];
            }.bind(this));
        },
        getTimeZone: function(){
            axios.get("https://worldtimeapi.org/api/timezone").then(function (response) {
                this.zones = response.data;
            }.bind(this));
        },
        editSettings: function(){
            var form = document.getElementById('form-settings')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("settings", "edit");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
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
  
</style>
