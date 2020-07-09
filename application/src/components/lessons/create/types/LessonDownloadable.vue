<template>
<!--  Modal new lesson -->
  <div>
    <el-dialog  :visible.sync="modalCreateDownloadable" :title="lang['create-new-lesson']" center  top="5vh">
        <form id="form-lesson-downloadable" @submit.prevent="create()">
            <div class="form-row">
                <!-- Module id -->
                <input type="number" class="hide"  name="moduleId" :value="moduleId">
                 <input type="text" class="hide" name="type_mylesson_id" value="4">
                <div class="form-group col-xl-12 col-md-12">
                    <!-- Lesson name -->
                    <label class="col-form-label">{{lang["name"]}} *</label>
                    <el-input required v-model="name" name="title"></el-input>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-xl-12 col-md-12">
                    <!-- Downloadable file upload -->
                    <label class="col-form-label">Downloadable file *</label>
                    <upload 
                        do-upload= "true"
                        box-height = "200"
                        return-name="path" 
                        input-name="file"  
                        bucket-key="uploads/content" 
                        acceptable=".*">
                    </upload>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-xl-6 col-md-6">
                  <el-button class="sbr-btn sbr-primary" v-loading="loading"  native-type="submit">{{lang["save-button"]}}</el-button>
              </div>
          </div>
        </form>  
      </el-dialog>
  </div>
<!-- End  modal new lesson -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventBus} from '@/pages/newcourse/App'
import {eventLang} from '@/components/helper/HelperLang'
import {eventUpload} from '@/components/helper/HelperUpload'
import Upload from '@/components/helper/HelperUpload'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    props: ['module-id'],
    components: {
        Upload, 
    },
    data: () => {
        return {
            lang: {},
            name: '',
            modalCreateDownloadable : false,
            loading: false
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on('new-downloadable', function(){
            this.modalCreateDownloadable = true;
        }.bind(this));
    },
    methods: {
        /* Create a new lesson */
        create: function(){
            this.loading = true;
            var form = document.getElementById('form-lesson-downloadable')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "create");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                /* Success callback */
                this.successMessage();
                this.actionsToBePerformedAfterRegistration();
                this.loading = false;
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        actionsToBePerformedAfterRegistration(){
            this.name = '';
            this.modalCreateDownloadable = false;
            eventBus.$emit("new-lesson");  
            eventUpload.$emit("clear");
        }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
  
</style>
