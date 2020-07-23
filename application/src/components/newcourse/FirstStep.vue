<template>
<div :class="contentShow == false ? 'hide' : 'main'">
    <form id="form-first-step">
        <div class="form-wizard-content show" data-tab-content="info">
           
            <div class="card-box card-course"  v-loading="loading">
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <!-- Course id -->
                        <input class="hide" type="text" v-model="courseId" name="id">

                        <!-- Course name -->
                        <label class="col-form-label">{{lang["name"]}} *</label>
                        <el-input class="v-step-0" name="title" :class="invalidField ? 'invalid-field' : '' "   v-model="name"></el-input>

                        <br><br>
                        <!-- Course category -->
                        <label class="col-form-label">{{lang["category"]}}</label>
                        <br>
                        <select class="form-control" name="mycategory_id">
                            <option value="1">{{lang['default-category']}}</option>
                            <option v-for="item in categories" :value="item.id" :key="item.id">
                                {{item.name}}
                            </option>
                        </select><br>
                        <br><br>

                        <!-- Advanced configurations button -->
                        <el-button class="sbr-btn sbr-primary"  @click.prevent="modal = true" native-type="submit">{{lang["advanced-settings"]}} </el-button>

                    </div>
                    
                    
                    <!-- Course description -->
                    <div class="form-group  col-xl-6 col-md-6">
                        <textarea class="hide" v-model="description" name="description"></textarea>
                        <label class="col-form-label">{{lang["description"]}}</label>
                        <wysiwyg class="v-step-1"  v-model="description" />
                    </div>
                </div>

                <div class="form-row">
                    <!-- Course image -->
                    <div class="form-group col-xl-6 col-md-6">
                        <label class="col-form-label">{{lang["image"]}} (1900x1200 px)</label>
                        <upload 
                            class="v-step-2"
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
                            do-upload= "true"
                            box-height = "200"
                            return-name="preview" 
                            input-name="filePreview"  
                            bucket-key="uploads/preview" 
                            acceptable=".mp4,.mov">
                        </upload>
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
                <!-- Course reviews -->
                <div class="col-xl-4 col-md-4">
                    <label for="exampleInputEmail1">{{lang["reviews"]}}</label>
                    <div class="input-group">
                        <toggle-button name="reviews"  color="#009CD8" v-model="reviews"/>
                    </div>
                </div>

                <!-- Course spotlight  -->
                <div class="col-xl-4 col-md-4">
                    <label for="exampleInputEmail1">{{lang["spotlight"]}}</label>
                    <div class="input-group">
                        <toggle-button name="spotlight"  color="#009CD8" v-model="spotlight"/>
                    </div>
                </div>

                <!-- Course certificate  -->
                <div class="col-xl-4 col-md-4">
                    <label for="exampleInputEmail1">{{lang["certificate"]}}</label>
                    <div class="input-group">
                        <toggle-button color="#009CD8" v-model="certificate"/>
                    </div>
                </div>
            </div>

            <h4 v-if="certificate == true" class="text-center mt-5">Select your template</h4>
            <div class="row" v-if="certificate == true">
                <div class="col-xl-4 col-md-4">
                    <p class="text-center">Classic</p>
                    <input id="classic" type="radio" name="certificate" value="classic">
                    <label for="classic"> 
                        <img style="max-width:100%" class="img-responsive" src="@/assets/img/general/certificate/classic_template.png"  alt="">
                    </label>
                </div>

                <div class="col-xl-4 col-md-4">
                    <p class="text-center">Tech</p>
                    <input id="tech" type="radio" name="certificate" value="tech">
                    <label for="tech"> 
                        <img style="max-width:100%" class="img-responsive" src="@/assets/img/general/certificate/tech_template.png"  alt="">
                    </label>
                </div>

                
                <div class="col-xl-4 col-md-4">
                    <p class="text-center">Artistic</p>
                    <input id="artistic" type="radio" name="certificate" value="artistic">
                    <label for="artistic"> 
                        <img style="max-width:100%" class="img-responsive" src="@/assets/img/general/certificate/artistic_template.png"  alt="">
                    </label>
                </div>
            </div>

            <el-button class="sbr-btn sbr-primary mt-5" @click.prevent="modal = false"  type="primary"  size="medium">{{lang["save-button"]}}</el-button>
        </el-dialog>
    </form>
    <helper-progress></helper-progress>
    <!-------- 
        Tour
    ---------->
    <v-tour name="first-step-tour" :options="tourOptions" :steps="steps"></v-tour>
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
    hideModules: { "image": true},
});

Vue.use(VueTheMask)
Vue.use(ToggleButton)
Vue.use(VueAxios, axios)

import VueTour from 'vue-tour'
require('vue-tour/dist/vue-tour.css')
Vue.use(VueTour)



export default {
    mixins: [domains,alerts],
    components: {
        Upload, 
        Money,
        HelperProgress,
    },
    data: function() {
        return {
            modal: false,
            name: '', // Course name
            price: '', 
            lang: {}, // Language 
            invalidField: false, // Control the invalid class to input's
            categories : {}, // List of categories
            certificates: {}, // List of certificates
            description: '', // Course description
            reviews: false, // Course reviews
            spotlight: true,// Course spotlight
            certificate: false, 
            multiple: false,
            releaseDate: '',
            expirationDate: '',
            validity: '',
            category: '',
            contentShow: true,
            courseMode: 'create', // Course mode can be create or edit mode
            courseId: '',
            loading: false,
            money: {
                decimal: ',',
                thousands: '.',
                prefix: ' ',
                suffix: ' ',
                precision: 2,
                masked: false,
            },
            tourOptions: {
                useKeyboardNavigation: true,
                labels: {
                    buttonSkip:'',
                    buttonPrevious: '',
                    buttonNext: '',
                    buttonStop: ''
                }
            },
            steps: [
                {
                    target: ".v-step-0",
                    header: {
                        title: ''
                    },
                    params: {
                        placement: 'bottom',
                        highlight: true
                    },
                    content: ''
                },
                {
                   target: ".v-step-1",
                    header: {
                        title: ''
                    },
                    params: {
                        placement: 'right',
                        highlight: true
                    },
                    content: ''
                },
                {
                   target: ".v-step-2",
                    header: {
                        title: ''
                    },
                    params: {
                        placement: 'right',
                        highlight: true
                    },
                    content: ''
                },
                {
                   target: ".v-step-3",
                    header: {
                        title: ''
                    },
                    params: {
                        placement: 'left',
                        highlight: true
                    },
                    content: ''
                },
            ],
        }
    },
    created(){
        this.getCategories();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;

            /* Tour labels */
            this.tourOptions.labels.buttonSkip = this.lang["skip-tour"];
            this.tourOptions.labels.buttonPrevious = this.lang["previous-step-button"];
            this.tourOptions.labels.buttonNext = this.lang["next-step-button"];
            this.tourOptions.labels.buttonStop = this.lang["finish"];


            /* Tour step 0 - Course name */
            this.steps[0].header.title = this.lang["name"];
            this.steps[0].content = this.lang["tour-course-name-message"];

            /* Tour step 1 - Course description */
            this.steps[1].header.title = this.lang["description"];
            this.steps[1].content = this.lang["tour-course-description-message"];

            /* Tour step 2 - Course image */
            this.steps[2].header.title = this.lang["image"];
            this.steps[2].content = this.lang["tour-course-image-message"];

            /* Tour step 3 - Second step */
            this.steps[3].header.title = this.lang["next-step-button"];
            this.steps[3].content = this.lang["tour-course-step2-message"];

        }.bind(this));

        setTimeout(() => {
            if(this.$route.query.tour == 'true'){
                this.$tours['first-step-tour'].start();
            }
        }, 2000)

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
                this.courseMode == 'create' ?  this.createCourse() : this.editCourse();
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
        createCourse: function(){
            this.loading = true;
            var form = document.getElementById('form-first-step')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "create")
            const config = {
                headers: {
                    'Content-Type': 'text/html'
                }
            }
            axios.post(urlToBeUsedInTheRequest, formData, config).then((response) => {
                this.loading = false;
                this.actionsToBePerformedAfterRegistration(response.data);
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                 }
            );
        },
        getCategories(){
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
        editCourse: function(){
            this.loading = true;
            var form = document.getElementById('form-first-step')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "edit")
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.loading = false;
                this.actionsToBePerformedAfterEdit();
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                 }
            );
        },
        actionsToBePerformedAfterRegistration(courseId){
            eventBus.$emit('new-course', courseId);
            this.contentShow = false;
            this.courseId = courseId;
            this.courseMode = 'edit';
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



.form-wizard-wrapper .form-wizard-content {
    background-color: #F3F6F6;
    color: #777777;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
}

/* End default sizes */

input[type="radio"] {
    display: none;
}
input[type="radio"]:checked + label {
    border: 5px solid royalblue;
}

.card-course{
    margin: 30px
}


</style>
