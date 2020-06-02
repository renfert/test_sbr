<template>
<div>
    <el-container>
        <el-aside>
            <button class="btn-ead btn-sabiorealm btn-block">Build your site</button>
            <el-menu  class="el-menu-vertical-demo">
                <toolbar-header></toolbar-header>
                <toolbar-body></toolbar-body>
                <toolbar-footer></toolbar-footer>
            </el-menu>
        </el-aside>
    </el-container>
    <edit-banner></edit-banner>
    <edit-testimonial></edit-testimonial>
    <edit-product-list></edit-product-list>
    <edit-text-and-media></edit-text-and-media>
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
import ToolbarHeader from '@/components/site/toolbar/ToolbarHeader'
import ToolbarBody from '@/components/site/toolbar/ToolbarBody'
import ToolbarFooter from '@/components/site/toolbar/ToolbarFooter'
import EditBanner from '@/components/site/section/elements/edit/Banner'
import EditTestimonial from '@/components/site/section/elements/edit/Testimonial'
import EditProductList from '@/components/site/section/elements/edit/ProductList'
import EditTextAndMedia from '@/components/site/section/elements/edit/TextAndMedia'

locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    components: {
        ToolbarHeader,
        ToolbarBody,
        ToolbarFooter,
        EditBanner,
        EditTestimonial,
        EditProductList,
        EditTextAndMedia
    },
    data: () => {
        return {
          
            lang: {},
            value1: 0
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
    },

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

.content-page.content{
    padding: 0px !important;
}

.ead{
    margin:0px !important;
}

.el-menu{
    width:350px !important;
}

.el-menu-item{
    height: auto !important;
}

.el-menu-item-group{
    padding-top:10%;
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


.el-menu-item:focus, .el-menu-item:hover{
    background-color:white !important;
}

.el-aside {
    width: auto !important;
}

@media only screen and (max-width: 600px) {
    .el-aside {
        position: relative !important;
    }
}


</style>
