<template>
    <div>
      <el-dialog  :visible.sync="modal" :title="lang['add-new-social']" center width="40%" top="5vh">
        <form id="form-social" @submit.prevent="createSocialMedia()">
            <div class="form-group">
              <label>{{lang["social-media"]}}</label>
              <div class="block">
                <select class="form-select" name="socialMedia" v-model="socialMedia">
                  <option value="facebook">Facebook</option>
                  <option value="instagram">Instagram</option>
                  <option value="linkedin">Linkedin</option>
                  <option value="twitter">Twitter</option>
                  <option value="pinterest">Pinterest</option>
                  <option value="youtube">Youtube</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label>{{lang["url"]}}</label>
              <el-input  name="url" v-model="url"></el-input>
            </div>
            <div class="form-group">
              <el-button class="sbr-btn sbr-primary" native-type="submit">{{lang["save-button"]}}</el-button>
            </div>
        </form>
      </el-dialog>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import {eventBus} from '@/components/site/App'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'


Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: function() {
      return {
        socialMedia: '',
        url: '',
        modal : false,
        lang: {}
      }
    },
    mounted(){
      eventLang.$on('lang', function(response){  
        this.lang = response;
      }.bind(this));

      eventBus.$on("open-social-modal", function(){
          this.modal = true;
      }.bind(this));
    },
    methods: {
      createSocialMedia: function(){
        var form = document.getElementById('form-social')
        var formData = new FormData(form)
        var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("social", "create")
        axios.post(urlToBeUsedInTheRequest, formData).then(() => {
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
        this.socialMedia = ''; 
        this.url = '';
        this.modal = false;
        eventBus.$emit('social-media-list-update');  
        eventBus.$emit('new-change-footer');
      }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

</style>
