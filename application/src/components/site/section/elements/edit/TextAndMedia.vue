<template>
    <div class="main">
        <lang></lang>
        <div>
            <el-dialog  :visible.sync="modal" title="Banner" center width="40%" top="5vh">
                <form id="form-text-and-media" @submit.prevent="editTextAndMedia()"  v-loading="loading">
                    <!-- Text and media id -->
                    <input type="number" name="textAndMediaId" class="hide" :value="textAndMediaId">
                    <!-- Cta id -->
                    <input type="number" name="buttonId" class="hide" :value="buttonId">
                    <el-tabs type="border-card">
                        <el-tab-pane>
                            <span slot="label"><i class="el-icon-picture-outline"></i> {{lang["media"]}}</span>
                            <div class="form-row">
                                <div class="form-group col-xl-12 col-md-12">
                                    <!-- Media  -->
                                    <label class="col-form-label">{{lang["media"]}} *</label>
                                    <upload 
                                        v-if="media != ''"
                                        :src-name="mediaName"
                                        :src-img="media"
                                        do-upload="true" 
                                        box-height = "200"
                                        return-name="mediaName" 
                                        input-name="file" 
                                        type="media" 
                                        acceptable=".png,.jpg,.jpeg,.mov,.mp4,.avi">
                                    </upload>
                                </div>
                                <div class="form-group col-xl-12 col-md-12">
                                    <!-- Media align -->
                                    <label class="col-form-label">{{lang["media-align"]}}</label>
                                    <select class="form-select" name="mediaAlign" v-model="mediaAlign">
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                        <option value="top">Top</option>
                                        <option value="bottom">Bottom</option>
                                    </select>
                                </div>
                            </div>
                        </el-tab-pane>
            
                        <el-tab-pane>
                            <span slot="label"><i class="el-icon-document"></i> {{lang["header"]}}</span>
                            <div class="form-row" :class="activeHeader == false ? 'disabled' : ''">
                                <div class="form-group col-xl-12 col-md-12">
                                    <!-- Header -->
                                    <label class="col-form-label">{{lang["header"]}}</label>
                                    <el-input :disabled="activeHeader == false ? true : false " name="header" v-model="header"></el-input>
                                </div>
                            </div>
                            <hr> 
                            <el-alert
                                :title="lang['disable-section-message']"
                                type="info"
                                show-icon>
                            </el-alert>
                            <br>
                            <el-switch @change="showHeader()" v-model="activeHeader"></el-switch>
                        </el-tab-pane>


                        <el-tab-pane>
                            <span slot="label"><i class="el-icon-document-copy"></i> {{lang["sub-header"]}}</span>
                            <div class="form-row" :class="activeSubHeader == false ? 'disabled' : ''">
                                <div class="form-group col-xl-12 col-md-12">
                                    <!-- SubHeader -->
                                    <label class="col-form-label">{{lang["sub-header"]}}</label>
                                    <el-input :disabled="activeSubHeader == false ? true : false "  name="subHeader" v-model="subHeader"></el-input>
                                </div>
                            </div><hr>
                            <el-alert
                                :title="lang['disable-section-message']"
                                type="info"
                                show-icon>
                            </el-alert><br>
                            <el-switch @change="showSubHeader()" v-model="activeSubHeader"></el-switch>
                        </el-tab-pane>

                          <el-tab-pane>
                            <span slot="label"><i class="el-icon-document"></i> {{lang["content"]}}</span>
                            <div class="form-row" :class="activeContent == false ? 'disabled' : ''">
                                <div class="form-group col-xl-12 col-md-12">
                                    <!-- Content -->
                                    <label class="col-form-label">{{lang["content"]}}</label>
                                    <el-input type="textarea" :disabled="activeContent == false ? true : false " name="content" v-model="content"></el-input>
                                </div>
                            </div>
                            <hr> 
                            <el-alert
                                :title="lang['disable-section-message']"
                                type="info"
                                show-icon>
                            </el-alert>
                            <br>
                            <el-switch @change="showContent()" v-model="activeContent"></el-switch>
                        </el-tab-pane>


                        <el-tab-pane>
                            <span slot="label"><i class="el-icon-s-opportunity"></i> {{lang["button"]}}</span>
                            <div class="form-row" :class="activeButton == false ? 'disabled' : ''">
                                <div class="form-group col-xl-6 col-md-6">
                                    <!-- Cta title -->
                                    <label class="col-form-label">{{lang["button-title"]}} *</label>
                                    <el-input :disabled="activeButton == false ? true : false "  name="buttonTitle" v-model="buttonTitle"></el-input>
                                </div>
                                <div class="form-group col-xl-6 col-md-6">
                                    <!-- Cta url -->
                                    <label class="col-form-label">{{lang["button-url"]}} *</label>
                                    <el-input  name="buttonUrl" v-model="buttonUrl"></el-input>
                                </div>
                            </div>
                            <div class="form-row" :class="activeButton == false ? 'disabled' : ''">
                                <div class="form-group col-xl-6 col-md-6">
                                    <!-- Cta target -->
                                    <label class="col-form-label">{{lang["button-target"]}} *</label>
                                    <select class="form-select" name="buttonTarget" v-model="buttonTarget">
                                        <option value="_self">Same window</option>
                                        <option value="_blank">New window</option>
                                    </select>
                                </div>
                                <div class="form-group col-xl-6 col-md-6">
                                    <!-- Cta style -->
                                    <label class="col-form-label">{{lang["button-style"]}} *</label>
                                    <select class="form-select" name="buttonStyle" v-model="buttonStyle">
                                        <option value="plain">Plain</option>
                                        <option value="rounded">Rounded</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row" :class="activeButton == false ? 'disabled' : ''">
                                <div class="form-group col-xl-6 col-md-6">
                                    <!-- Cta bg color -->
                                    <label class="col-form-label">{{lang["button-bg-color"]}} *</label>
                                    <div class="block">
                                        <input name="buttonColor" type="text" class="hide" v-model="buttonColor">
                                        <el-color-picker v-model="buttonColor"></el-color-picker>
                                    </div>
                                </div>
                                <div class="form-group col-xl-6 col-md-6">
                                    <!-- Cta hover color -->
                                    <label class="col-form-label">{{lang["button-hover-color"]}} *</label>
                                    <div class="block">
                                        <input name="buttonHoverColor" type="text" class="hide" v-model="buttonColorHover">
                                        <el-color-picker  v-model="buttonColorHover"></el-color-picker>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <el-alert
                                :title="lang['disable-section-message']"
                                type="info"
                                show-icon>
                            </el-alert>
                            <br>
                            <el-switch @change="showButton()" v-model="activeButton"></el-switch>
                        </el-tab-pane>

                    </el-tabs>
                    <br>
                    <div class="form-row">
                        <div class="form-group col-xl-12 col-md-12">
                           <el-button class="btn-sabiorealm" native-type="submit"  v-loading="loadingButton"  type="primary"  size="medium">{{lang["save-button"]}}</el-button>
                        </div>
                    </div>
                </form>  
                <helper-progress></helper-progress>
            </el-dialog>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import Upload from '@/components/helper/HelperUpload'
import 'element-ui/lib/theme-chalk/index.css'
import Lang from '@/components/helper/HelperLang.vue'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/site/App'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import HelperProgress from '@/components/helper/HelperProgress.vue'


locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    mixins: [domains,alerts],
    components: {
        Lang, 
        Upload,
        HelperProgress,
    },
    data: () => {
        return {
            lang: {},
            textAndMediaId: '',
            header: '',
            content: '',
            media: '',
            mediaName: '',
            mediaAlign: '',
            buttonId : '',
            buttonAlign: '',
            subHeader: '',
            textAlign: '',
            title: '',
            buttonTitle: '',
            buttonUrl: '',
            buttonTarget: '',
            buttonColor: '',
            buttonColorHover: '',
            buttonStyle: '',
            loading: false,
            loadingButton: false,
            modal: false,
            activeHeader: true,
            activeSubHeader: true,
            activeButton: true,
            activeContent: true,
            sectionId: '',
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on('edit-text-and-media', function(sectionId){
            this.getTextAndMedia(sectionId)
            this.modal = true;
        }.bind(this));
    },
    methods: {
        editTextAndMedia: function(){
            this.loadingButton = true;
            var form = document.getElementById('form-text-and-media')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("site-elements/TextAndMedia", "edit");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
                this.actionsToBePerformedAfterEdit();
                this.loadingButton = false;
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },

        showHeader: function(){
            if(this.activeHeader == false){
                this.header = '';
            }
        },
        showContent: function(){
            if(this.activeContent == false){
                this.content = '';
            }
        },
        showSubHeader: function(){
            if(this.activeSubHeader == false){
                this.subHeader = '';
            }
        },
        showButton: function(){
            if(this.activeButton == false){
                this.buttonTitle = '';
            }
        },

        getTextAndMedia: function(sectionId){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("site-elements/TextAndMedia", "get");
            var formData = new FormData();
            formData.set("sectionId", sectionId);
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.textAndMediaId = response.data[0]["id"];
                this.header = response.data[0]["header"];
                this.content = response.data[0]["content"];
                this.mediaName = response.data[0]["media"];
                this.media = ''+this.getCurrentDomainName()+'assets/uploads/builder/body/'+ this.mediaName;
                this.mediaAlign = response.data[0]["media_align"];
                this.buttonId = response.data[0]["button_id"];
                this.buttonAlign = response.data[0]["button_align"];
                this.subHeader = response.data[0]["subheader"];
                this.textAlign = response.data[0]["text_align"];
                this.buttonTitle = response.data[0]["title"];
                this.buttonUrl = response.data[0]["url"];
                this.buttonTarget = response.data[0]["target"];
                this.buttonColor = response.data[0]["color"];
                this.buttonColorHover = response.data[0]["color_hover"];
                this.buttonstyle = response.data[0]["style"];
               
                this.loading= false;
        

        
                if(response.data[0]["header"] == null){
                    this.activeHeader = false;
                }

                if(response.data[0]["subheader"] == null){
                    this.activeSubHeader = false;
                }

                if(response.data[0]["title"] == null){
                    this.activeButton = false;
                }

                if(response.data[0]["content"] == null){
                    this.activeContent = false;
                }


            },
                /* Error callback */
                function (){
                this.errorMessage();
                }.bind(this)
            );
        },
    

        openEditModuleModal: function(id,title,required,date){
            this.moduleId = id;
            this.moduleTitle = title;
            this.moduleRequired = required;
            this.moduleReleaseDate = date;
            this.modal = true; 
        },
      
        actionsToBePerformedAfterEdit(){
            this.modal = false; 
            eventBus.$emit("new-change-text-and-media");
        }
    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.disabled{
    opacity: 0.2;
}

</style>
