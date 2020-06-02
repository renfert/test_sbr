<template>
<!--  Modal edit lesson video -->
  <div>
    <el-dialog  :visible.sync="modalEditLesson" :title="lang['edit-lesson']" center  top="5vh">
      <form id="form-lesson-video-edit" @submit.prevent="edit()">
        <!-- Lesson id -->
        <input type="text" name="lessonId" class="hide" v-model="lessonId">
        <div class="form-row">
            <div class="form-group col-xl-12 col-md-12">
                <!-- Lesson name -->
                <label class="col-form-label">{{lang["name"]}} *</label>
                <el-input required v-model="name" name="title"></el-input>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-xl-12 col-md-12">
                <!-- Video upload -->
                <label class="col-form-label">Video *</label>
                <div class="drop-area"> 
                  <input :value="videoName" name="path" type="text">
                  <input 
                      class="upload"  
                      @change.prevent="render($event)" 
                      accept=".mp4,.avi,.mov" 
                      type="file"
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
                <el-button native-type="submit"  type="primary"  size="medium">{{lang["save-button"]}}</el-button> 
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
      videoName: '',
      previewImg: '',
      realName: '',
      lessonId: '',
      icon: 'fas fa-cloud-upload-alt',
      message:"Upload a file",
      modalEditLesson : false,
      loading: false
    }
  },
  mounted(){
    eventLang.$on('lang', function(response){  
      this.lang = response;
    }.bind(this));
  
    eventBus.$on('edit-lesson-1', function(response){
      this.modalEditLesson = true;
      this.lessonId = response[0]["id"];
      this.name = response[0]["title"];
      this.realName = response[0]["real_name"];
      this.videoName = response[0]["path"];
      this.previewImg = ''+this.getCurrentDomainName()+'assets/uploads/content/'+ response[0]["path"];
      this.message = response[0]["real_name"];
      this.icon = "far fa-thumbs-up text-default";
    }.bind(this));
  },
  methods: {
    /* Edit a lesson */
    edit: function(){
      this.loading = true;
      var form = document.getElementById('form-lesson-video-edit')
      var formData = new FormData(form)
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("lesson", "edit");
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
      formData.append('type', 'lesson-video')
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("upload", "upload_file");
      axios.post(urlToBeUsedInTheRequest,formData,config).then((response) => {
          this.videoName = response.data;
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
        this.videoName = '';
        this.previewImg = '';
        this.realName = '';
        this.modalEditLesson = false;
        eventBus.$emit('new-lesson');  
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
  
</style>
