<template>
<!--  Modal new lesson -->
  <div>
      <el-dialog  :visible.sync="modalCreateHtml" :title="lang['create-new-lesson']" center  top="5vh">
        <form id="form-lesson-html" @submit.prevent="create()">
          <div class="form-row">
              <!-- Module id -->
              <input type="number" class="hide"  name="moduleId" :value="moduleId">
              <div class="form-group col-xl-12 col-md-12">
                  <!-- Lesson name -->
                  <label class="col-form-label">{{lang["name"]}} *</label>
                  <el-input required v-model="name" name="title"></el-input>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-xl-12 col-md-12">
                  <!-- Video upload -->
                  <label class="col-form-label">Zip file *</label>
                  <div class="drop-area"> 
                    <!-- Type lesson -->
                    <input type="text" name="type_mylesson_id" value="7">
                    <input :value="htmlName" name="path" type="text">
                    <input 
                        class="upload"  
                        @change.prevent="render($event)"  
                        type="file"
                        acceptable=".zip"
                    >
                    <div class="drop-message">
                        <span class="file-icon" :class="icon"></span>
                        <p>{{message}}</p>
                    </div>
                    <div class="drop-preview on" style="text-align:center;">
                        <div class="drop-img">
                            <img class="preview" :src="previewImg" alt="">
                        </div>
                    </div>
                  </div>
                  <input class="hide" type="text" name="real_name" :value="realName">
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
import {eventProgress} from '@/components/helper/HelperProgress'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
  mixins: [domains,alerts],
  props: ['module-id'],
  data: () => {
    return {
      lang: {},
      name: '',
      htmlName: '',
      previewImg: '',
      realName: '',
      icon: 'fas fa-cloud-upload-alt',
      message:"Upload a file",
      modalCreateHtml : false,
      loading: false
    }
  },
  mounted(){
    eventLang.$on('lang', function(response){  
      this.lang = response;
    }.bind(this));

    eventBus.$on('new-html', function(){
      this.modalCreateHtml = true;
    }.bind(this));
  },
  methods: {
    /* Create a new lesson */
    create: function(){
      this.loading = true;
      var form = document.getElementById('form-lesson-html')
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
        }
      );
    },
    render: function(event){
        this.upload(event);
        this.message = '';
        this.icon = '';
        var input = event.target; 
        var fullName = input.value;  
        var fileName = fullName.split(/(\\|\/)/g).pop();
        var fileExtension = fullName.split('.').pop();
        this.realName = fileName;
        if(fileExtension == 'png' || fileExtension == 'jpg' || fileExtension == 'jpeg' ){
          var reader = new FileReader();
            reader.onload = function (e) {
              var div = input.parentElement; 
              var img = div.getElementsByTagName('img')[0];
              img.src = e.target.result;
          };  
          reader.readAsDataURL(input.files[0]);
        }else{
          this.message = fileName;
          this.icon = "far fa-thumbs-up text-default";
        }
    },
    upload: function(event){
      eventProgress.$emit("new-progress");
      const config = {
          onUploadProgress: function(progressEvent) {
          var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
          eventProgress.$emit("new-percent", percentCompleted);
          }
      }
      var formData = new FormData()
      formData.append('file', event.target.files[0])
      formData.append('type', 'lesson-html')
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("upload", "upload_file");
      axios.post(urlToBeUsedInTheRequest,formData,config).then((response) => {
          this.htmlName = response.data;
          event.target.value = null
          eventProgress.$emit("finish-progress");
      }, 
          /* Error callback */
          function(){
            this.errorMessage();
          }.bind(this)
      );
    },
    actionsToBePerformedAfterRegistration(){
        this.name = '';
        this.message = 'Upload a file';
        this.icon = 'fas fa-cloud-upload-alt';
        this.htmlName = '';
        this.modalCreateHtml = false;
        eventBus.$emit('new-lesson');  
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
  
</style>
