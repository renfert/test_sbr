<template>
    <div>
        <div v-for="element in footerArray" :key="element.id">
            <el-submenu index="3" >
                <template slot="title">
                    <i class="el-icon-menu"></i>
                    <span>Footer</span>
                </template>
                <form id="form-footer">
                    <el-menu-item-group  :title="lang['copyright']">
                        <el-menu-item>
                            <el-input name="copyright" @change="editFooter()" v-model="copyright"></el-input>
                        </el-menu-item>
                    </el-menu-item-group>
                    <el-menu-item-group  :title="lang['primary-color']">
                        <el-menu-item>
                            <input type="text" v-model="color" name="color" class="hide">
                            <el-color-picker @change="changeColor()" v-model="color"></el-color-picker>
                        </el-menu-item>
                    </el-menu-item-group>
                </form>
                <el-menu-item-group :title="lang['social-medias']">
                    <div class="list-block">
                        <social-media-list></social-media-list>
                        <br>
                        <el-button class="btn-sabiorealm" @click.prevent="openSocialModal()">{{lang["add-new-social"]}} <i class="el-icon-circle-plus-outline"></i> </el-button>
                    </div>
                </el-menu-item-group>
            </el-submenu>
            <social-media-create></social-media-create>
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
import {eventBus} from '@/pages/site/App'
import SocialMediaCreate from '@/components/social/SocialMediaCreate'
import SocialMediaList from '@/components/social/SocialMediaList'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    mixins: [domains,alerts],
    components: {
        SocialMediaCreate,
        SocialMediaList,
    },
    data: () => {
        return {
            lang: {},
            footerArray: [],
            color: '',
            copyright: false,
            
        }
    },
    mounted(){
        eventLang.$on("lang", function(response){  
            this.lang = response;
        }.bind(this));
        this.listFooter();
    },
    methods: {
        changeColor: function(){
            setTimeout(function(){
                this.editFooter();
            }.bind(this), 100);
        },
    
        openSocialModal: function(){
            eventBus.$emit("open-social-modal");
        },
        listFooter: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("builder", "listFooter");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.footerArray = response.data;
                this.color = response.data[0].color;
                this.copyright = response.data[0].copyright;
            },
                /* Error callback */
                function (){
                    this.errorMessage();
                }.bind(this)
            );
        },
        editFooter: function(){
            var form = document.getElementById('form-footer')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("builder", "editFooter");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                eventBus.$emit("new-change-footer");
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
