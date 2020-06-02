<template>
    <el-submenu index="4">
        <template slot="title">
        <i class="el-icon-setting"></i>
        <span>Settings</span>
        </template>
        <el-menu-item-group title="Logo">
            <el-menu-item index="1-1">
                <h3>Teste</h3>
            </el-menu-item>
        </el-menu-item-group>
        <el-menu-item-group title="Logo size">
            <el-menu-item>
                <h3>Teste</h3>
            </el-menu-item>
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
locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    components: {
        
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
  methods: {
       handleOpen(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClose(key, keyPath) {
        console.log(key, keyPath);
      }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>



</style>
