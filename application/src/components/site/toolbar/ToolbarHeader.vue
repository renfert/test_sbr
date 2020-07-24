<template>
    <div>
        <div v-for="element in headerArray" :key="element.id">
            <el-submenu index="1" >
                <template slot="title">
                    <i class="el-icon-menu"></i>
                    <span>Header</span>
                </template>
                <form id="form-header">
                    <el-menu-item-group title="Logo (150 x 50 px)">
                        <el-menu-item index="1-0">
                            <upload 
                                :src-name="element.logo"
                                :src-img="getUrlToContents() + 'builder/header/'+element.logo+''"
                                do-upload= "true"
                                box-height = "100"
                                return-name="logoName" 
                                input-name="logo"  
                                bucket-key="uploads/builder/header"
                                acceptable=".png,.jpg,.jpeg">
                            </upload>
                        </el-menu-item>
                    </el-menu-item-group>
                     <el-menu-item-group title="Logo sticker (150 x 50 px)">
                        <el-menu-item index="1-1">
                            <upload 
                                :src-name="element.logoSticky"
                                :src-img="getUrlToContents() + 'builder/header/'+element.logo_sticky+''"
                                do-upload= "true"
                                box-height = "100"
                                return-name="logoStickyName" 
                                input-name="logoSticky"  
                                bucket-key="uploads/builder/header"
                                acceptable=".png,.jpg,.jpeg">
                            </upload>
                        </el-menu-item>
                    </el-menu-item-group>
                    <el-menu-item-group title="Logo size">
                        <el-menu-item>
                            <div class="block">
                                <input class="hide" name="logoSize" type="number" v-model="logoSize">
                                <el-slider @change="editHeader()" v-model="logoSize"></el-slider>
                            </div>
                        </el-menu-item>
                    </el-menu-item-group>
                    <el-menu-item-group  :title="lang['color']">
                        <el-menu-item>
                            <input type="text" v-model="headerColor" name="color" class="hide">
                            <el-color-picker @change="changeHeaderColor()" v-model="headerColor"></el-color-picker>
                        </el-menu-item>
                    </el-menu-item-group>
                    <el-menu-item-group  :title="lang['transparent-header']">
                        <el-menu-item>
                            <el-switch @change="applyTransparentHeader()" v-model="transparentHeader"></el-switch>
                        </el-menu-item>
                    </el-menu-item-group>
                </form>
                <el-menu-item-group title="Links">
                    <div class="list-block">
                        <link-list></link-list>
                        <br>
                        <el-button class="sbr-btn sbr-primary" @click.prevent="openLinksModal()">{{lang["add-new-link"]}} <i class="el-icon-circle-plus-outline"></i> </el-button>
                    </div>
                </el-menu-item-group>
            </el-submenu>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'   
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'
import {eventUpload} from '@/components/helper/HelperUpload'
import {eventBus} from '@/pages/site/App'
import Upload from '@/components/helper/HelperUpload'
import LinkList from '@/components/links/LinkList'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    mixins: [domains,alerts],
    components: {
        Upload,
        LinkList,
    },
    data: () => {
        return {
          
            lang: {},
            logoSize: 0,
            logo: '',
            logoSticky: '',
            headerArray: [],
            headerColor: '',
            transparentHeader: false
        }
    },
    mounted(){
        eventLang.$on("lang", function(response){  
            this.lang = response;
        }.bind(this));
        eventUpload.$on("finish-upload", function(){
            this.editHeader();
        }.bind(this));
        this.listHeader();
    },
    methods: {
        changeHeaderColor: function(){
            setTimeout(function(){
                this.editHeader();
            }.bind(this), 100);
        },
        applyTransparentHeader: function(){
            if(this.transparentHeader == true){
                this.headerColor = 'transparent';
                setTimeout(function(){
                    this.editHeader();
                }.bind(this), 200);
            }else{
                this.headerColor = '#87CEFA';
                setTimeout(function(){
                    this.editHeader();
                }.bind(this), 200);
            }
        },
        openLinksModal: function(){
            eventBus.$emit("open-link-modal");
        },
        listHeader: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("builder", "listHeader");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.headerArray = response.data;
                this.logoSize = parseInt(response.data[0].logo_size);
                this.headerColor = response.data[0].color;
                if(response.data[0].color == 'transparent'){
                    this.transparentHeader = true;
                }
            },
                /* Error callback */
                function (){
                    this.errorMessage();
                }.bind(this)
            );
        },
        editHeader: function(){
            var form = document.getElementById('form-header')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("builder", "editHeader");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                eventBus.$emit("new-change-header");
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

[class*=" el-icon-"], [class^=el-icon-]{
    line-height: 0 !important;
}

.el-menu-item{
    height: auto !important;
}

.el-submenu {
    list-style: none;
    margin: 0;
    padding-left: 0;
    border-bottom: 1px solid #CCC !important;
}

.el-submenu span{
    font-size:1.2em !important;
    font-family: 'Montserrat', sans-serif;
    color: #53536e !important;
}


</style>
