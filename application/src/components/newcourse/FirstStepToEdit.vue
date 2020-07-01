<template>
<div :class="contentShow == false ? 'hide' : 'main'">
    <form id="form-first-step">
        <div class="form-wizard-content show" data-tab-content="info">
            <div class="row">
                <div class="col-12">
                    <div class="card-box"  v-loading="loading">
                        <div class="form-row">
                            <div class="form-group col-12 col-md-6">
                                <!-- Course id -->
                                <input class="hide" type="text" v-model="courseId" name="id">

                                <!-- Course name -->
                                <label class="col-form-label">{{lang["name"]}} *</label>
                                <el-input @change="editCourse(false)" name="title" :class="invalidField ? 'invalid-field' : '' "   v-model="name"></el-input>

                                <br><br>
                                <!-- Course category -->
                                <label class="col-form-label">{{lang["category"]}}</label>
                                <br>
                                <select @change="editCourse(false)" class="form-control" name="mycategory_id" v-model="category">
                                    <option value="1">{{lang['without-category']}}</option>
                                    <option v-for="item in categories" :value="item.id" :key="item.id">
                                        {{item.name}}
                                    </option>
                                </select><br>
                                <br><br>

                                <!-- Advanced configurations button -->
                                <el-button  @click.prevent="modal = true"  type="primary"  size="medium">{{lang["advanced-settings"]}} <i class="el-icon-setting"></i> </el-button>
        
                            </div>
                            
                            
                            <!-- Course description -->
                            <div class="form-group  col-xl-6 col-md-6">
                                <textarea class="hide" v-model="description" name="description"></textarea>
                                <label class="col-form-label">{{lang["description"]}}</label>
                                <wysiwyg  @change="editCourse(false)" v-model="description" />
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Course image -->
                            <div class="form-group col-xl-6 col-md-6">
                                <label class="col-form-label">{{lang["image"]}}</label>
                                <upload 
                                    v-if="srcImg != ''"
                                    :src-img="srcImg"
                                    :src-name="srcName"
                                    do-upload="true" 
                                    box-height = "200"
                                    return-name="photo" 
                                    input-name="file" 
                                    bucket-key="uploads/course" 
                                    acceptable=".png,.jpg">
                                </upload>
                            </div>
                            <!-- Course video preview -->
                            <div class="form-group col-xl-6 col-md-6">
                                <label class="col-form-label">{{lang["video-preview"]}}</label>
                                <upload 
                                    v-if="srcPreview != ''"
                                    :src-img="srcPreview"
                                    :src-name="srcPreviewName"
                                    do-upload= "true"
                                    box-height = "200"
                                    return-name="preview" 
                                    input-name="file"  
                                    bucket-key="uploads/preview"  
                                    acceptable=".mp4,.mov">
                                </upload>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      

        <!-- Modal advanced settings -->
        <el-dialog  :visible.sync="modal" :title="lang['advanced-settings']" center width="40%" top="5vh">
            <!-- Course release date -->
            <div class="form-group">
                <label class="col-form-label">{{lang["start-date"]}}</label>
                <div class="input-group">
                    <el-date-picker
                        v-model="releaseDate"
                        name="release_date"
                        type="date"
                        format="yyyy/MM/dd"
                        value-format="yyyy-MM-dd"
                        placeholder="Pick a day">
                    </el-date-picker>
                </div>
            </div>
            <!-- Course expiration date -->
            <div class="form-group">
                <label class="col-form-label">{{lang["end-date"]}}</label>
                <div class="input-group">
                    <el-date-picker
                        v-model="expirationDate"
                        name="expiration_date"
                        type="date"
                        format="yyyy/MM/dd"
                        value-format="yyyy-MM-dd"
                        placeholder="Pick a day">
                    </el-date-picker>
                </div>
            </div>

            <!-- Course validity -->
            <div class="form-group">
                <label class="col-form-label">{{lang["validity-time"]}}</label>
                <div class="input-group">
                    <el-input-number name="validity" v-model="validity"></el-input-number>
                </div>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label class="col-form-label">{{lang["price"]}}</label>
                <div class="input-group">
                    <money name="price" v-model="price" class="text-field" v-bind="money">12323</money> 
                </div>
            </div>

            <div class="row">
                <!-- Course comments -->
                <div class="col-xl-4 col-md-4">
                    <label for="exampleInputEmail1">{{lang["comments"]}}</label>
                    <div class="input-group">
                        <toggle-button name="comments"  color="#3BB6B6" v-model="comments"/>
                    </div>
                </div>

                <!-- Course spotlight  -->
                <div class="col-xl-4 col-md-4">
                    <label for="exampleInputEmail1">{{lang["spotlight"]}}</label>
                    <div class="input-group">
                        <toggle-button name="spotlight"  color="#3BB6B6" v-model="spotlight"/>
                    </div>
                </div>

                <!-- Course certificate  -->
                <div class="col-xl-4 col-md-4">
                    <label for="exampleInputEmail1">{{lang["certificate"]}}</label>
                    <div class="input-group">
                        <toggle-button color="#3BB6B6" v-model="certificate"/>
                    </div>
                </div>
            </div>

           <h4 v-if="certificate == true" class="text-center mt-5">Select your template</h4>
            <div class="row" v-if="certificate == true">
                <div class="col-xl-4 col-md-4">
                    <p class="text-center">Classic</p>
                    <input :checked="certificateValue == 'classic' ? true:false" id="classic" type="radio" name="certificate" value="classic">
                    <label for="classic"> 
                        <img style="max-width:100%" class="img-responsive" src="@/assets/img/general/certificate/classic_template.png"  alt="">
                    </label>
                </div>

                <div class="col-xl-4 col-md-4">
                    <p class="text-center">Tech</p>
                    <input :checked="certificateValue == 'tech' ? true:false" id="tech" type="radio"  name="certificate" value="tech">
                    <label for="tech"> 
                        <img style="max-width:100%" class="img-responsive" src="@/assets/img/general/certificate/tech_template.png"  alt="">
                    </label>
                </div>

                
                <div class="col-xl-4 col-md-4">
                    <p class="text-center">Artistic</p>
                    <input :checked="certificateValue == 'artistic' ? true:false" id="artistic" type="radio" name="certificate" value="artistic">
                    <label for="artistic"> 
                        <img style="max-width:100%" class="img-responsive" src="@/assets/img/general/certificate/artistic_template.png"  alt="">
                    </label>
                </div>
            </div>
            <el-button class="mt-3" @click.prevent="modal = false; editCourse(false);"  type="primary"  size="medium">{{lang["save-button"]}}</el-button>
        </el-dialog>
    </form>
    <helper-progress></helper-progress>
</div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import ToggleButton from 'vue-js-toggle-button'
import VueAxios from 'vue-axios'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/newcourse/App'
import wysiwyg from "vue-wysiwyg";
import Upload from '@/components/helper/HelperUpload'
import VueTheMask from 'vue-the-mask'
import {Money} from 'v-money'
import HelperProgress from '@/components/helper/HelperProgress.vue'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'


Vue.use(wysiwyg, {
    hideModules: { "image": true, "code": true, "table": true },
});

Vue.use(VueTheMask)
Vue.use(ToggleButton)
Vue.use(VueAxios, axios)


export default {
    mixins: [domains,alerts],
    components: {
        Upload, 
        Money,
        HelperProgress,
    },
    data: () => {
        return {
            modal: false,
            name: '', // Course name
            price: '', 
            lang: {}, // Language 
            invalidField: false, // Control the invalid class to input's
            categories : {}, // List of categories
            certificates: {}, // List of certificates
            description: '', // Course description
            comments: false, // Course comments
            spotlight: false,// Course spotlight
            certificate: false, 
            certificateValue: '',
            multiple: false,
            releaseDate: '',
            expirationDate: '',
            validity: '',
            category: '',
            contentShow: true,
            courseMode: 'edit', // Course mode can be create or edit mode
            courseId: '',
            loading: false,
            srcImg: '',
            srcName :'',
            srcPreview: '',
            srcPreviewName: '',
            money: {
                decimal: ',',
                thousands: '.',
                prefix: ' ',
                suffix: ' ',
                precision: 2,
                masked: false,
            }
        }
    },
    created(){
        this.courseId = sessionStorage.getItem('sbr_course_id');
        this.getCategories();
        this.getCourse();
    },
    mounted(){

        eventBus.$emit('new-course', this.courseId);
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));

        /* Show this content */
        eventBus.$on('access-first-step', function(){
            this.contentShow = true;
        }.bind(this));

        /*  Access second step */
        eventBus.$on('access-second-step', function(){
            if(this.name == ''){
                this.invalidField = true;
                this.requiredInputNameMessage();
                eventBus.$emit('response-access-second-step', false);
            }else{
                this.editCourse();
                eventBus.$emit('response-access-second-step', true);
            }
        }.bind(this));

        /*  Access Third step */
        eventBus.$on('access-third-step', function(){
            if(this.name == ''){
                this.invalidField = true;
                this.requiredInputNameMessage();
                eventBus.$emit('response-access-third-step', false);
            }else{
                this.courseMode == 'create' ?  this.createCourse() : this.editCourse();
                eventBus.$emit('response-access-third-step', true);
            }
        }.bind(this));    

    },
    methods:{
        getCourse: function(){
            var formData = new FormData();
            formData.set("courseId", this.courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "get")
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.name = response.data["title"];
                this.category = response.data["mycategory_id"];
                this.description = response.data["description"];
                this.srcName = response.data["photo"];
                this.srcImg = this.getUrlToContents() + 'course/'+response.data["photo"]+'';
               
                this.srcPreviewName = response.data["preview"];
                this.srcPreview = this.getUrlToContents() + 'preview/'+response.data["preview"]+'';
               
                response.data["price"] == null ? this.price = '' : this.price =  response.data["price"];

                if(response.data["release_date"] == null || response.data["release_date"] == '' || response.data["release_date"] == '0000-00-00' ){
                    this.releaseDate = '';
                }else{
                    this.releaseDate = response.data["release_date"];
                }

                if(response.data["expiration_date"] == null || response.data["expiration_date"] == '' || response.data["expiration_date"] == '0000-00-00' ){
                    this.expirationDate = '';
                }else{
                    this.expirationDate = response.data["expiration_date"];
                }
            
    
                response.data["spotlight"] == null ? this.spotlight = false : this.spotlight = true;
                response.data["comments"] == null ? this.comments = false : this.comments = true;
                this.validity = response.data["validity"]; 
                response.data["certificate"] == null ? this.certificate = false : this.certificate = true; 
                this.certificateValue = response.data["certificate"];

                this.modal = true;
                this.fixAdvancedModal();
        
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        getCategories: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("category", "listing")
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.categories = response.data; 
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }
            );
        },
        fixAdvancedModal: function(){
            this.loading = true; 
            setTimeout(function(){ 
                this.modal = false;
                this.loading = false;
            }.bind(this), 500);
        },
        editCourse: function(update){
            this.loading = true;
            setTimeout(function(){
                var form = document.getElementById('form-first-step')
                var formData = new FormData(form)
                var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "edit")
                axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                    this.loading = false;
                    if(update != false){
                        this.actionsToBePerformedAfterEdit();   
                    }
                }, 
                    /* Error callback */
                    function(){
                        this.errorMessage();
                    }.bind(this)
                );
            }.bind(this), 2000);
        },
        requiredInputNameMessage(){
            this.$notify({
                title: this.lang['error'],
                message: this.lang["required-name"],
                type: 'error',
                duration: 3500
            });
        },
        actionsToBePerformedAfterEdit(){
            eventBus.$emit('new-course', this.courseId);
            this.contentShow = false;
        },
    }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>


.main{
    transition-timing-function: ease-in-out;
}

/* Default sizes */
.form-row>.col, .form-row>[class*=col-]{
    padding-right:20px !important;
    padding-left:20px !important;
}

.form-row{
    padding:0px !important;
}
.editr {
    height:200px;
    border-radius: 4px;
    border: 2px solid #ccc;
    transition: border-color .15s linear !important;
}

.editr--content{
    font-family: 'Poppins', sans-serif !important;
    font-size:15px !important;
}

.form-wizard-wrapper .form-wizard-content {
  background-color: #F3F6F6;
  padding-top: 50px;
  color: #777777;
  left: 0;
  right: 0;
  bottom: 0;
  top: 0;
}

/* End default sizes */


/* ------------- Max 1024px ---------------- */
@media only screen and (max-width: 1024px) {
    .editr--toolbar {
        display:none !important;
    }
}
input[type="radio"] {
    display: none;
}
input[type="radio"]:checked + label {
    border: 5px solid royalblue;
}

</style>
