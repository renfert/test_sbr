<template>
<!--  Modal new lesson -->
  <div>
    <el-dialog  :visible.sync="modalCreateAudio" :title="lang['create-new-lesson']" center  top="5vh">
        <form id="form-lesson-audio" @submit.prevent="create()">
            <div class="form-row">
                <!-- Module id -->
                <input type="number" class="hide"  name="moduleId" :value="moduleId">
                <input type="text" class="hide" name="type_mylesson_id" value="2">
                <div class="form-group col-xl-12 col-md-12">
                    <!-- Lesson name -->
                    <label class="col-form-label">{{lang["name"]}} *</label>
                    <el-input required v-model="name" name="title"></el-input>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-xl-12 col-md-12">
                    <!-- Audio upload -->
                    <label class="col-form-label">Audio *</label>
                    <upload 
                        do-upload= "true"
                        box-height = "200"
                        return-name="path" 
                        input-name="file"  
                        bucket-key="uploads/content" 
                        acceptable=".mp3,.wav">
                    </upload>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-xl-6 col-md-6">
                    <el-button class="btn-sabiorealm" v-loading="loading"  native-type="submit"  type="primary"  size="medium">{{lang["save-button"]}}</el-button> 
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
import VueTheMask from 'vue-the-mask'
import {eventBus} from '@/pages/newcourse/App'
import {eventLang} from '@/components/helper/HelperLang'
import {eventUpload} from '@/components/helper/HelperUpload'
import Upload from '@/components/helper/HelperUpload'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
Vue.use(VueTheMask)
Vue.use(VueTheMask)
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
            modalCreateAudio : false,
            loading: false
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
        /* Get new video click event */
        eventBus.$on('new-audio', function(){
            this.modalCreateAudio = true;
        }.bind(this));
    },
    methods: {
        /* Create a new lesson */
        create: function(){
            this.loading = true;
            var form = document.getElementById('form-lesson-audio')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "create");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                /* Success callback */
                this.successMessage();
                this.actionsToBePerformedAfterEdit();
                this.loading = false;
            },
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        actionsToBePerformedAfterEdit(){
            this.name = '';
            this.modalCreateAudio = false;
            eventBus.$emit("new-lesson");  
            eventUpload.$emit("clear");
        }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
  
</style>
