<template>
    <div :class="contentShow == false ? 'hide' : 'main'">   
        
        <div class="row mt-5">
            <div class="img-container">
                <div class="text-container">
                    <h4>{{lang["course-created-successfully"]}}</h4>
                    <h1>{{courseName}}</h1>
                    <div id="share" v-if="share == true">
                       
                        <!-- facebook -->
                        <a class="facebook" href="https://www.facebook.com/share.php?u=url&title=titulo" target="blank"><i class="fab fa-facebook-f"></i></a>

                        <!-- twitter -->
                        <a class="twitter" href="https://twitter.com/intent/tweet?status=titulo+url" target="blank"><i class="fab fa-twitter"></i></a>

                        <!-- google plus -->
                        <a class="googleplus" href="https://plus.google.com/share?url=url" target="blank"><i class="fab fa-google-plus-g"></i></a>

                        <!-- linkedin -->
                        <a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=url&title=titulo&source=source" target="blank"><i class="fab fa-linkedin-in"></i></a>
                    
                 
                    </div>
                </div>
        
                <img  src="@/assets/img/general/ux/course_completed.png"/>
            </div>
        </div>

        <div class="row mt-5 ml-5 mr-5 mb-5">
            <div class="col-12 col-md-3">
                <a href="javascript:void(0)" @click.prevent="viewCourse()">
                    <div class="card-box">
                        <h5>{{lang["view-course"]}}</h5>
                        <img src="@/assets/img/general/ux/view_course.png" alt="">
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-3">
                <a href="javascript:void(0)" @click.prevent="modal = true">
                    <div class="card-box">
                        <h5>{{lang["join-persons"]}}</h5>
                        <img src="@/assets/img/general/ux/join_persons.png" alt="">
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-3">
                <a href="javascript:void(0)" @click.prevent="reloadPage()">
                    <div class="card-box">
                        <h5>{{lang["create-new-course"]}}</h5>
                        <img src="@/assets/img/general/ux/create_new_course.png" alt="">
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-3">
                <a href="javascript:void(0)" @click.prevent="share = true">
                    <div class="card-box">
                        <h5>{{lang["share"]}}</h5>
                        <img src="@/assets/img/general/ux/share.png" alt="">
                    </div>
                </a>
            </div>

        </div>

    
    
        <!-- Join users -->
        <el-dialog  :visible.sync="modal" :title="lang['join-persons']" center  top="5vh">
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
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/newcourse/App'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
Vue.use(VueAxios, axios)


export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            contentShow: false,
            lang: [],
            modal: false,
            usersList : [],
            users: [],
            courseId: '',
            loading: false,
            courseName: '',
            courseImage: '',
            share: false
        }
    },
    mounted(){
        /* New course */
        eventBus.$on('new-course', function(response){
            this.courseId = response;
            sessionStorage.setItem('sbr_course_id', ''+response+'');
            this.getUsersOutsideTheCourse(response);
        }.bind(this));

        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));

        /* Access first step */
        eventBus.$on('access-first-step', function(){
            this.contentShow = false;
        }.bind(this));

        
        /* Access second step */
        eventBus.$on('access-second-step', function(){
            this.contentShow = false;
        }.bind(this));

        /* Show this content */
        eventBus.$on('response-access-third-step', function(response){
            if(response == true){
                this.contentShow = true;
                this.getCourse();   
            }
        }.bind(this));
    },
    methods:{
        reloadPage: function(){
           location.reload();
        },
        viewCourse: function(){
            sessionStorage.setItem('sbr_course_id', ''+this.courseId+'');
            window.location.href="viewcourse";
        },
        getCourse: function(){
            var formData = new FormData();
            formData.set("courseId", this.courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "get");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.courseName = response.data["title"]; 
                this.courseImage = response.data["photo"];
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        getUsersOutsideTheCourse(courseId){
            var formData = new FormData();
            formData.set("courseId", courseId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "getPersonsOutsideTheCourse");
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
        enrollUsers: function(){
            this.loading = true;
            var formData = new FormData();
            formData.set("courseId", this.courseId);
            formData.set("users", this.users);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "enrollUsersIntoCourse");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.loading = false;
                this.modal = false;
                this.getUsersOutsideTheCourse(this.courseId);
                this.users = [];
                this.successMessage();
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.img-course{
  width:40%;
}

.card-box{
    text-align:center;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: grey !important;
}

.card-box:hover{
    -webkit-box-shadow: 0px 0px 5px 0px #00A9B4;
    box-shadow: 0px 0px 5px 0px #00A9B4;
}

.course-name{
    text-transform: uppercase;
    letter-spacing: 1px;
}


.img-container{
    width:100%;
    height:380px;
    overflow:hidden;
    margin: 0px !important;
}


.text-container{
    color:white;
    position:absolute;
    width:400px;
    margin-left:50%;
    margin-top:10%;
    left: -200px;
    text-align:center;  
}

.text-container h4{
    text-transform:uppercase;
    font-family: 'Poppins', sans-serif;
    letter-spacing: 1px;    
}

.text-container h1{
    text-transform:uppercase;
}

.img-container img{
    width:inherit !important;
}

.content{
    padding: 0px !important;
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
  background-color: white;
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

.container-fluid{
    padding-left:0px !important;
}

#share {
    width: 100%;
    text-align: center;
}

/* buttons */

#share a {
    width: 50px;
    height: 50px;
    display: inline-block;
    margin: 8px;
    border-radius: 50%;
    font-size: 24px;
    color: #fff;
    transition: opacity 0.15s linear;
}

#share a:hover {
    opacity: 0.75;
}

/* icons */

#share i {
    position: relative;
    top:40%;
    transform: translateY(-50%);
}

    /* colors */

.facebook {
    background: #3b5998;
}

.twitter {
    background: #55acee;
}

.googleplus {
    background: #dd4b39;
}

.linkedin {
    background: #0077b5;
}

.pinterest {
    background: #cb2027;
}


</style>
