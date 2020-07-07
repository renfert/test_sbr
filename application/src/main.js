import Vue from 'vue'
import App from './App.vue'
import router from '@/router'
import "@/assets/css/bootstrap.min.css"
import "@/assets/css/icons.css"
import "@/assets/css/style.scss"
import "@/assets/fontawesome/css/all.css"
import 'mdbvue/lib/css/mdb.min.css'
import '@/assets/css/vueWysiwyg.css'


new Vue({
  render: h => h(App),
  router
}).$mount('#sbr')   
