<template>  
    <div>
        <div :style="style" class="drop-area"> 
            <input :value="name" :name="returnName" type="text">
            <input 
                :name="inputName" 
                class="upload"  
                @change.prevent="preview($event,doUpload,type)" 
                :accept="acceptable" 
                type="file"
            >
            <div class="drop-message" :class="messageClass">
                <span class="file-icon" :class="icon"></span>
                <p>{{message}}</p>
            </div>
            <div class="drop-preview on" style="text-align:center;">
                <div class="drop-img">
                    <img class="preview" :src="previewImg" alt="">
                </div>
            </div>
        </div>
        <input class="hide" type="text" name="realName" :value="realName">
   </div>
</template>


<script>
import {eventLang} from '@/components/helper/HelperLang'
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import toastr from 'toastr'
import {eventProgress} from '@/components/helper/HelperProgress'
Vue.use(VueAxios, axios)
Vue.use(toastr)

/* Event bus to handle communication between components */
export const eventUpload = new Vue();
export default {
    data: function() {
         return {
             lang: {},
             icon: 'fas fa-cloud-upload-alt',
             message:"Upload a file",
             src: '',
             messageClass: '',
             realName: '',
             name: '',
             previewImg: ''
         }
    },
    methods: {
        preview: function(event, upload, type){
            var ins = this;
            if(upload != undefined){
                ins.upload(event,type);
            }
            var input = event.target; 
            var fullName = input.value;  
            var fileName = fullName.split(/(\\|\/)/g).pop();
            var fileExtension = fullName.split('.').pop(); 

            this.realName = fileName;

            if(input.files && input.files[0]){ 
                /* Verify acceptable files extensions*/
                var acceptable = ins.acceptable;
                if(acceptable.indexOf(fileExtension) == -1 && acceptable != "*"){
                    ins.message = ""+ins.lang["invalid-extension"]+": "+fileExtension+"";
                    ins.icon = "fas fa-exclamation-triangle text-danger"
                    input.value = ''
                }else{            
                                    
                    /*  Chance image or icon preview */
                    switch(fileExtension) {
                        case 'png': 
                            ins.messageClass = "hide"
                            ins.render(input)
                            break;
                        case 'jpg':
                            ins.render(input)
                            ins.messageClass = "hide"
                            break;
                        case 'jpeg':
                            ins.render(input)
                            ins.messageClass = "hide"
                            break;
                        case 'xlsx':
                            ins.icon = "fas fa-file-pdf text-default"
                            ins.message = fileName
                            break;
                        case 'pdf':
                            ins.icon = "fas fa-file-excel text-default"
                            ins.message = fileName
                            break;
                        case 'docx':
                            ins.icon = "fas fa-file-word text-default"
                            ins.message = fileName
                            break;
                        case 'mp4':
                            ins.icon = "fas fa-file-video text-default"
                            ins.message = fileName
                            break;
                        case 'mov':
                            ins.icon = "fas fa-file-video text-default"
                            ins.message = fileName
                            break;
                        case 'mp3':
                            ins.icon = "fas fa-file-audio text-default"
                            ins.message = fileName
                            break;
                        case 'pptx':
                            ins.icon = "fas fa-file-powerpoint text-default"
                            ins.message = fileName
                            break;
                        case 'zip':
                            ins.icon = "fas fa-file-archive text-default"
                            ins.message = fileName
                            break;
                    }
                }
            }
        },
        render: function(input){
            var reader = new FileReader();
            reader.onload = function (e) {
                var div = input.parentElement; 
                var img = div.getElementsByTagName('img')[0];
                img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        },
        upload: function(event,type){
            eventProgress.$emit("new-progress");
            const config = {
                onUploadProgress: function(progressEvent) {
                var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                eventProgress.$emit("new-percent", percentCompleted);
                }
            }
            /* Get a url root to production enviroment */
            var loc = window.location.href;
            var arr = loc.split("/");
            var url = arr[0] + "//" + arr[2]
            let data = new FormData()
            data.append('file', event.target.files[0])
            data.append('type', type)
            axios.post(process.env.NODE_ENV === 'production' ? ''+url+'/upload/upload_file' : ''+process.env.VUE_APP_URL_DEV+'upload/upload_file',data,config
            ).then((response) => {
                event.target.value = null
                var el = event.target.parentElement.children[0];
                el.value = response.data;
                eventProgress.$emit("finish-progress");
                eventUpload.$emit("finish-upload");
            }, () => {
                /* Error callback */
                toastr.error(''+this.lang["error-callback-message"]+'');
            });
        },
        loadDefaultName(){
            this.name = this.srcName;
        },
        loadDefaultImg(){
            if(this.srcName != null){
                var array = this.srcName.split(".",2);
                var extension = array[1];
                if(extension == 'png'){
                    this.messageClass = "hide";
                }
                if(extension == 'mp4' || extension == 'mov'){
                    this.icon = "fas fa-file-video text-default"
                    this.message = this.srcName;
                }
                this.previewImg = this.srcImg;
            }
        },
        chooseDomainForDevOrProductonEnviroment(controler,model){
            var entireUrl = window.location.href;
            var entireUrlDividedIntoTwoParts = entireUrl.split("/");
            var domainName = entireUrlDividedIntoTwoParts[0] + "//" + entireUrlDividedIntoTwoParts[2];
            var url = process.env.NODE_ENV === 'production' ? ''+domainName+'/'+controler+'/'+model : ''+process.env.VUE_APP_URL_DEV+controler+'/'+model
            return url;
        },
    },
    props: ['acceptable', 'val', 'input-name', 'do-upload', 'return-name', 'type', 'box-height','src-name','src-img'],
    computed: {
      style () {
        return 'height: ' +this.boxHeight+ 'px';
      }
    },
    mounted(){

        if(this.srcName != undefined && this.srcName != null){
            this.loadDefaultName();
        }    
        
        if(this.srcImg != undefined && this.srcImg != null){
            this.loadDefaultImg();
        }

        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));
    },
}   
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.hide{
    display:none !important;
}

.drop-area{
    display: block;
    position: relative;
    cursor: pointer;
    overflow: hidden;
    width: 100%;
    max-width: 100%;
    padding: 5px 10px;
    font-size: 14px;
    line-height: 22px;
    color: #585858;
    background-color: #fff;
    background-image: none;
    text-align: center;
    border: 2px solid #ccc;
    -webkit-transition: border-color .15s linear;
    transition: border-color .15s linear;
    border-radius: 4px;
    border: 2px solid #ccc;
}

.drop-area:hover{
    background-size:30px 30px;background-image:linear-gradient(-45deg,#f6f6f6 25%,transparent 0,transparent 50%,#f6f6f6 0,#f6f6f6 75%,transparent 0,transparent);-webkit-animation:stripes 2s linear infinite;animation:stripes 2s linear infinite
}

.drop-preview{
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
}

.drop-img {
    width: 100%;
    height: 210px;
    display: inline-block;
    overflow: hidden;
    padding: 2px;
    position: relative;
}

.drop-preview img {
    max-width: 100%;
    margin-top: 3%;
    width: 60%;
    vertical-align: middle;
    border-style: none;
}


.drop-message {
    position: relative;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
}

.file-icon {
    font-size: 40px;
    padding-bottom:10px;
    color: #ccc;
}

.drop-area input {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    height: 100%;
    width: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 5;
}
</style>
