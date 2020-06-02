<template>
    <div class="card-box gap5">
        <h4>{{lang["create-program"]}}</h4><br>
        <form @submit.prevent="create()" id="form-program" v-loading="loading">
            <el-tabs tab-position="top">
                <el-tab-pane label="Basic information">
                    <div class="row gap5">
                        <div class="col-10">
                            <div class="form-group">
                                <!-- Program name -->
                                <label>{{lang['name']}}</label>
                                <el-input required name="title" :placeholder="lang['name']" v-model="name"></el-input>
                            </div>
                            <div class="form-group">
                                <!-- Program release date -->
                                <label>{{lang['start-date']}}</label>
                                <br>
                                <el-date-picker
                                    name="release_date"
                                    v-model="release"
                                    type="date"
                                    format="yyyy/MM/dd"
                                    value-format="yyyy-MM-dd"
                                    placeholder="Pick a day">
                                </el-date-picker>
                            </div>
                            <div class="form-group">
                                <!-- Program expiration date -->
                                <label>{{lang['end-date']}}</label>
                                <br>
                                <el-date-picker
                                    name="expiration_date"
                                    v-model="expiration"
                                    type="date"
                                    format="yyyy/MM/dd"
                                    value-format="yyyy-MM-dd"
                                    placeholder="Pick a day">
                                </el-date-picker>
                            </div>
                            <div class="form-group">
                                <!-- Program description -->
                                <textarea class="hide" v-model="description" name="description"></textarea>
                                <label class="col-form-label">{{lang["description"]}}</label>
                                <wysiwyg  v-model="description" />
                            </div>
                        </div>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="Courses">
                    <div class="row gap5">
                        <div class="col-12">
                            <el-transfer
                                filterable
                                :titles="['Courses', 'Program']"
                                v-model="courses"
                                :data="coursesList">
                            </el-transfer>
                        </div>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="Image">
                    <div class="row gap5">
                        <div class="col-6">
                            <upload        
                                do-upload= "true"
                                box-height = "200"
                                return-name="photo" 
                                input-name="image"  
                                type="program" 
                                acceptable=".png,.jpg,.jpeg">
                            </upload>
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
            <br>
            <el-button native-type="submit"  type="primary"  size="medium">{{lang["save-button"]}}</el-button>
        </form>

        <!-- Success dialog -->
        <el-dialog  :visible.sync="modal" :title="lang['program-created']" center width="80%" top="5vh">
            <div class="form-wizard-content show" data-tab-content="info">
                <div class="row">
                    <div class="col-12">
                        <div style="text-align:center;" >
                            <h3><span class="text-sabiorealm">{{lang["congratulations"]}}</span> {{lang["program-created-message"]}} <a class="text-sabiorealm" href="https://sabiorealm.com">Sabiorealm {{programId}}  </a></h3>
                            <h4>{{lang["what-would-you-like-to-do"]}}</h4>
                            <hr>
                            <div class="row" style="text-align:center">
                                <div class="col-4">
                                    <a class="text-sabiorealm" :href="viewProgramUrl">
                                        <h4>{{lang["view-program"]}}</h4>
                                        <i class="fas fa-desktop fa-lg fa-3x text-sabiorealm"></i>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="text-sabiorealm" href="javascript:void(0)" @click.prevent="modalJoinStudents = true">
                                        <h4>{{lang["join-students"]}}</h4>
                                        <i class="fas fa-user-graduate fa-lg fa-3x  text-sabiorealm"></i>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="text-sabiorealm" href="javascript:void(0)" @click.prevent="reloadPage()">
                                        <h4>{{lang["create-new-program"]}}</h4>
                                        <i class="fas fa-plus-square fa-lg fa-3x  text-sabiorealm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        </el-dialog>

        <!-- Join users -->
        <el-dialog  :visible.sync="modalJoinStudents" :title="lang['join-persons']" center  top="5vh">
            <div v-if="usersList != null" v-loading="loading">
                <template>
                    <el-transfer
                        filterable
                        :titles="['Persons', 'Course']"
                        v-model="users"
                        :data="usersList">
                    </el-transfer>
                </template>
                <br>
                <el-button   
                    @click="enrollUsers()"
                    type="primary"  
                    size="medium">
                    {{lang["save-button"]}}
                </el-button>
            </div>

            <!-- No persons found content -->
            <div class="card-box box-no-results" v-else>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="text-no-results">
                            <h5>{{lang["all-students-already-added"]}}</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <img class="image-no-results" src="@/assets/img/general/ux/no_persons.png" alt="">
                    </div>
                </div>
            </div>
            <!-- No users found content end -->
        </el-dialog>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '../../components/helper/HelperLang'
import wysiwyg from "vue-wysiwyg"
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import Upload from '@/components/helper/HelperUpload'


Vue.use(wysiwyg, {
    hideModules: { "image": true, "code": true, "table": true, "hyperlink": true },
});

locale.use(lang)
Vue.use(ElementUI)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: function() {
        return {
            lang: {},
            name: '',
            release: '',
            expiration: '',
            description: '',
            courses: [],
            coursesList: [],
            loading: false,
            modal : false,
            modalJoinStudents: false,
            viewProgramUrl: '',
            usersList : [],
            users: [],
            programId: ''
        }
    },
    components: {
        Upload
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));

        this.getCourses();
    },
    methods: {
        getCourses: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("program", "getCourses");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.coursesList = response.data; 
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        getPersonsOutsideTheProgram(programId){
            var formData = new FormData();
            formData.set("programId", programId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("program", "getPersonsOutsideTheProgram");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.usersList = response.data; 
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        create: function(){
            this.loading =  true; 
            var form = document.getElementById('form-program');
            var formData = new FormData(form);
            formData.set("courses", this.courses);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("program", "create");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.viewProgramUrl =  this.getCurrentDomainName() + 'pages/viewprogram/' + response.data;
                this.programId = response.data;
                this.getPersonsOutsideTheProgram(response.data);
                this.modal = true;
                this.loading  = false;
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
    
        reloadPage: function(){
           location.reload();
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.img-program{
  width:30%;
  margin-left:35%;
}

</style>
