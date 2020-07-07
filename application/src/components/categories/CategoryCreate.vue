<template>
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4>{{lang["create-category"]}}</h4><br>
            <form @submit.prevent="createCategory()" id="form-category">
              <div class="row">

                <div class="col-xl-4 col-md-4">
                  <!-- Category name -->
                  <div class="form-group">
                    <el-input required name="name" :placeholder="lang['name']" v-model="categoryName"></el-input>
                  </div>
                </div>

                <div  class="col-xl-4 col-md-4">
                  <!-- Save button -->
                  <div class="form-group">
                    <el-button 
                      v-loading="loadingButton"
                      class="sbr-btn sbr-primary" 
                      native-type="submit" 
                      type="primary">
                      {{lang["save-button"]}}
                    </el-button>
                  </div>
                </div>

              </div>
            </form>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import {eventBus} from '@/pages/categories/App'
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
      categoryName: '',
      lang: {},
      loadingButton: false
    }
  },
  mounted(){
    eventLang.$on('lang', function(response){  
      this.lang = response;
    }.bind(this));
  },
  methods: {
    createCategory: function(){
      this.loadingButton = true;
      var form = document.getElementById('form-category')
      var formData = new FormData(form)
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("category", "create")
      axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
        /* Success callback */
        this.loadingButton = false;
        if(response.data == false){ 
          this.categoryAlreadyExistsMessage();
        }else{
          this.successMessage();
          this.actionsToBePerformedAfterRegistration();       
        }
      },
        /* Error callback */
        function(){
          this.errorMessage();  
        }.bind(this)
      );
    },
    categoryAlreadyExistsMessage(){
      this.$notify({
        title: this.lang['error'],
        message: this.lang["category-already-exists"],
        type: 'warning',
        duration: 3500
      });
    },
    actionsToBePerformedAfterRegistration(){
      this.categoryName = ''; // Clear a category name input
      eventBus.$emit('new-category');  // Emit a event to list component update the table of categories.
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
  
</style>
