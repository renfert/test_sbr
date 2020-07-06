<template>
    <el-submenu index="2">
        <template slot="title">
            <i class="el-icon-menu"></i>
            <span>Body</span>
        </template>
        <el-menu-item-group title="Sections">
                <div class="list-block">
                    <section-list></section-list>
                    <div class="form-row align-items-center">
                        <div class="col-xl-12">
                            <div class="mt-3">
                                <el-row>
                                    <el-col :span="16">
                                        <el-select v-model="section" :placeholder="lang['select-an-element']">
                                            <el-option :label="lang['banner']" value="Banner">{{lang["banner"]}}</el-option>
                                            <el-option :label="lang['product-list']" value="ProductList">{{lang["product-list"]}}</el-option>
                                            <el-option :label="lang['testimonial']" value="Testimonial">{{lang["testimonial"]}}</el-option>
                                            <el-option :label="lang['text-and-media']" value="TextAndMedia">{{lang["text-and-media"]}}</el-option>
                                        </el-select>
                                    </el-col>
                                    <el-col :span="8">
                                        <el-button v-loading="loading" native-type="submit" @click.prevent="createSection()" size="medium"  icon="el-icon-circle-plus-outline"></el-button>
                                    </el-col>
                                </el-row>
                            </div>
                        </div>
                    </div>
                </div>
        </el-menu-item-group>
    </el-submenu>
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
import SectionList from '@/components/site/section/SectionList'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    mixins: [domains,alerts],
    components: {
        SectionList
    },
    data: () => {
        return {
            lang: {},
            section: 'Banner',
            loading: false,
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
        this.lang = response;
        }.bind(this));
    },
    methods: {
        createSection: function(){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("site-elements/"+this.section+"", "create")
            axios.post(urlToBeUsedInTheRequest).then(() => {
                /* Success callback */
                this.successMessage();
                this.actionsToBePerformedAfterRegistration();       
            },
            /* Error callback */
            function(){
                this.errorMessage();  
            }.bind(this)
            );
        },
        actionsToBePerformedAfterRegistration(){
            eventBus.$emit("new-section");
            this.loading = false;
        },
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
