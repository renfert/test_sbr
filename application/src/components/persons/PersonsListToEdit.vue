<template>
    <div v-loading="loading">  
        <lang></lang> 
        <div>
            <ul class="list-group">
                <draggable v-model="personsArray" ghost-class="ghost" @end="finishRepositioning" > 
                    <transition-group type="transition" name="flip-list">
                        <li v-for="element in personsArray" :key="element.id" class="list-group-item d-flex justify-content-between align-items-center sortable">
                            {{element.name}}
                            <div class="action-icons">
                                <!-- Edit person -->
                                <el-button @click.prevent="openEditPersonModal(element.id,element.name,element.occupation,element.comment,element.photo)" class="sbr-btn sbr-primary" icon="el-icon-edit" circle></el-button>
                                <!-- Delete person -->
                                <el-button @click.prevent="deletePerson(element.id)"  slot="reference" class="sbr-btn sbr-danger" icon="el-icon-delete" circle></el-button>
                                <!-- Change position -->
                                <el-button  icon="el-icon-rank" class="handle positionPerson sbr-btn sbr-neutral" :id="element.id" circle></el-button>
                            </div>
                        </li>
                    </transition-group>
                </draggable>     
            </ul>      
        </div>

        <!-- Person edit -->
        <el-dialog  :visible.sync="modal" append-to-body :title="lang['person']" center width="40%" top="5vh">
            <form id="form-person" @submit.prevent="editPerson()">
                <!-- Person id -->
                <input type="number" v-model="personId" name="personId" class="hide">
                <div class="form-group">
                    <div class="image-upload" style="text-align:center;">
                        <label for="file-input">
                            <el-avatar style="cursor:pointer" :size="100">
                               <img :src="getUrlToContents() + 'testimonial/'+photo+''">
                            </el-avatar>
                        </label>
                        <input :value="avatar" name="avatar" type="text">
                        <input id="file-input" type="file"  @change.prevent="uploadAvatar($event)"/>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{lang["name"]}}</label>
                    <el-input  name="name" v-model="name"></el-input>
                </div>
                <div class="form-group">
                    <label>{{lang["occupation"]}}</label>
                    <el-input  name="occupation" v-model="occupation"></el-input>
                </div>
                <div class="form-group">
                    <label>{{lang["comment"]}}</label>
                    <el-input type="textarea" name="comment" v-model="comment"></el-input>
                </div>
                <div class="form-group">
                    <el-button native-type="submit"  class="sbr-btn sbr-primary">{{lang["save-button"]}}</el-button>
                </div>
            </form>
        </el-dialog>
        <helper-progress></helper-progress>
    </div> 
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import draggable from 'vuedraggable'
import Lang from '@/components/helper/HelperLang.vue'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/components/site/App'
import {eventProgress} from '@/components/helper/HelperProgress'
import $ from 'jquery'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import HelperProgress from '@/components/helper/HelperProgress.vue'
import AWS from 'aws-sdk/global';
import S3 from 'aws-sdk/clients/s3';

locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    components: {
        draggable,
        Lang,
        HelperProgress
    },
    mixins: [domains,alerts],
    props:["testimonial-id"],
    data: () => {
        return {
            lang: {},
            modal: false,
            personsArray: [],
            loading: false,
            name: '',
            occupation: '',
            comment: '',
            photo: '',
            personId: '',
            avatar: '',
            subDomainName: ''
        }
    },
    mounted(){
        this.getSubDomainName();

        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on('edit-person', function(){  
            this.updatePersonsListArray();
        }.bind(this));
        this.updatePersonsListArray();
    },
    methods: {
        uploadAvatar: function(event){
            this.upload(event);
            var input = event.target; 
            if(input.files && input.files[0]){ 
                this.render(input)
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
        upload: function(event){

            var file = event.target.files[0];
            var fileName = file.name;
            var fileExt = fileName.split('.').pop();
            var newFileName = this.generateFileName(40) + '.' + fileExt;
            eventProgress.$emit("new-progress");

            AWS.config.update({
                accessKeyId: "AKIA5AQZS5JMAWUELDG7",
                secretAccessKey: "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",
                "region": "us-east-1"  
            }); 

            var bucket = new S3({params: {Bucket: 'sabiorealm'}});
            var params = {Key: ''+this.subDomainName+'/uploads/testimonial/'+newFileName +'', ContentType: file.type, Body: file};

            bucket.upload(params).on('httpUploadProgress', function(evt) {
                var percentCompleted = Math.round(parseInt((evt.loaded * 100) / evt.total));
                eventProgress.$emit("new-percent", percentCompleted);
            }).send(function() {
                this.avatar = newFileName;
                eventProgress.$emit("finish-progress");
            }.bind(this));
        },
        deletePerson: function(id){
            var formData = new FormData();
            formData.set('personId', id);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("persons", "delete");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.updatePersonsListArray();  
                this.successMessage();
                eventBus.$emit("edit-person");
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        generateFileName: function(length){
            var today = new Date();   
            var time = today.getHours()  + today.getMinutes() + today.getSeconds();

            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result + time;
        },
        getSubDomainName: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("verify", "getSubDomainName");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.subDomainName = response.data;
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        openEditPersonModal: function(id,name,occupation,comment,photo){
            this.personId = id;
            this.name = name;
            this.occupation = occupation;
            this.comment = comment;
            this.photo = photo;
            this.avatar = photo;
            this.modal = true;
        },
        editPerson: function(){
            var form = document.getElementById('form-person')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("persons", "edit");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
                this.actionsToBePerformedAfterEdit();
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        finishRepositioning: function(){
            this.reorderPersonsPositions();
        },
        reorderPersonsPositions: function(){
            var ar  = [];
            $('.positionPerson').each(function(index){
                var id = $(this).attr('id');
                ar.push({'id' : id,'index' : index});
            })
            var formData = new FormData()
            $.each(ar, function( index, value){
               formData.set('persons['+value.id+']', value.index );
            });
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("persons", "reorder");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.updatePersonsListArray();
                eventBus.$emit("edit-person");
            },
                function(){
                    this.errorMessage();
                }.bind(this)
            );

        },
        updatePersonsListArray: function (){
            this.loading = true;
            var formData = new FormData();
            formData.set("testimonialId",this.testimonialId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("persons", "listing");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.personsArray = response.data;
                this.loading= false;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        actionsToBePerformedAfterEdit(){
            this.updatePersonsListArray();
            this.modal = false; 
            eventBus.$emit("edit-person");
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

.action-icons{
    float:right;
    margin-left:0%;
}

.links{
    cursor: pointer;
}

.custom-control-label {
    padding-top: 4px !important;
}

#accordion > .card{
    margin-bottom:2%;
}

.btn-link{
    padding: 0px !important;
    font-size:13px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
}


.btn.link:hover{
    text-decoration: none !important;
}

.card-header{
    padding:10px !important;
}

.btn-eadtools-rounded{
    border-radius: 50%;
    cursor: pointer;
    display: inline-block;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
    position: relative;
    height: 40px;
    width: 40px;
    background-color: #D696EF;
    z-index: 2;
    border:none;
    color:white;
    margin: 0 0.2rem;
}


.sortable-drag{
    opacity: 0;
}

.flip-list-move{
    transition: transform 0.5s;
}

.ghost{
    border-left:6px solid rgb(0, 183, 255);
    border-radius:5px;
    opacity: .5;
}


.card{
    margin-bottom: 15px;
}



.handle{
    cursor:move;
}


li{
    list-style-type: none;
}

.lesson{
    text-align:center;
    text-transform: uppercase;
    font-size:10px;
}

.lesson span{
    font-family: 'Poppins', sans-serif;
    margin-top:3em;
    font-size:1em;
}

</style>
