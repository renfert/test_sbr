<template>
    <div>
        <div class="container-site pt-5">
            <!-- Row -->
            <div class="row">
            
                <div class="col-lg-4 col-md-12 col-sm-12 order-2 order-lg-1 order-md-2">							
                    <div class="page_sidebar hide-23">
                        
                        <!-- Search Form -->
                        <form class="form-inline addons mb-3">
                            <el-input
                                :placeholder="lang['search']"
                                prefix-icon="el-icon-search"
                                v-model="search">
                            </el-input>
                        </form>	
                        
                        <!-- Categories filter -->
                        <div v-if="categories != null">
                            <h4 class="side_title">{{lang['category']}}</h4>
                            <ul class="no-ul-list mb-3">
                                <li v-for="element in categories" :key="element.id">
                                    <input :id="'check'+element.id" :value="element.id" class="checkbox-custom"  name="aa-4" type="checkbox" v-model="checkedNames">
                                    <label :for="'check'+element.id" class="checkbox-custom-label">{{element.name}}</label>
                                </li>
                            </ul>
                        </div>
                        
                    
                        <!-- Price filter -->    
                        <h4 class="side_title">{{lang['price']}}</h4>
                        <ul class="no-ul-list mb-3">
                            <li>
                                <input v-model="priceFilter" value="all" id="b-7" class="checkbox-custom"  name="b-7" type="radio">
                                <label for="b-7" class="checkbox-custom-label">{{lang["all"]}}</label>
                            </li>
                            <li>
                                <input v-model="priceFilter" value="free" id="b-8" class="checkbox-custom" name="b-8" type="radio">
                                <label for="b-8" class="checkbox-custom-label">{{lang["free-course"]}}</label>
                            </li>
                            <li>
                                <input  v-model="priceFilter" value="paid" id="b-9" class="checkbox-custom" name="b-9" type="radio">
                                <label for="b-9" class="checkbox-custom-label">{{lang["paid-courses"]}}</label>
                            </li>
                        </ul>
                        
                    </div>

                     <div class="page_sidebar hide-23">
                        
                        <!-- Contact -->
                        <div>
                            <h4 class="side_title">{{lang["contact"]}}</h4>
                            <div class="mb-5 mt-3">
                                <label class="checkbox-custom-label"><i class="ti-email mr-1"></i>  {{companyEmail}} </label>
                                <label class="checkbox-custom-label"><i class="ti-mobile"></i>  {{companyPhone}}</label>
                            </div>
                        </div>
                        
                    
                        <!-- Price filter -->    
                        <h4 class="side_title">Tags</h4>
                        <div class="popular_tags">
                            <!-- Tags -->
                            <div class="tag_cloud" v-for="element in categories" :key="element.id">
                                <a href="javascript:void(0)" class="tag-cloud-lin">{{element.name}}</a>
                            </div>	
                        </div>
                    </div>
                            
                </div>	

                
                
                <div class="col-lg-8 col-md-12 col-sm-12 order-1 order-lg-2 order-md-1">
                    
                    <!-- Row -->
                    <div id="top-list" class="row align-items-center mb-3" v-if="courseList != null">
                        <div class="col-lg-6 col-md-6 col-sm-12 founded-courses">
                            {{lang["we-found"]}} <strong> <b> {{courseList.length}} </b> </strong> {{lang["courses"]}}
                        </div>
                    </div>
                    <!-- /Row -->
                    
                    <div class="row courses-grid" v-if="visibleCourses != null">
                        <!-- Cource Grid  -->
                        <div class="col-lg-6 col-md-6 col-sm-6" v-for="element in visibleCourses" :key="element.id">
                            <div class="education_block_grid style_2">
                                
                                <div class="education_block_thumb">
                                    <a href="course-detail.html"><img v-lazy="getUrlToContents() + 'course/'+element.photo+''"  src="https://sabiorealm.s3.amazonaws.com/demo1/uploads/course/5xzwR4ayidpH2iP21B5ysKQkyt4xOUkmpvWNbCA7100.jpg" class="img-fluid" alt=""></a>
                                    <div v-if="element.reviews != null" class="education_ratting"><i class="fa fa-star"></i>{{ rateAverage(element.totalRate, element.totalReviews) }} ({{element.totalReviews}})</div>
                                </div>
                                
                                <div class="education_block_body">
                                    <h4 class="bl-title"><a href="course-detail.html">{{element.title}}</a></h4>
                                </div>
                                
                                <div class="cources_info_style3">
                                    <ul>
                                        <li><i class="ti-agenda mr-2"></i>Modules: {{element.totalModules}}</li>
                                        <li><i class="ti-control-skip-forward mr-2"></i>Lessons: {{element.totalLessons}}</li>
                                    </ul>
                                </div>
                                
                                <div class="education_block_footer">
                                    <div class="education_block_author">
                                        <div class="pr-2"><a href="javascript:void(0)">  <el-avatar :src="getUrlToContents() + 'avatar/'+element.avatar+''"></el-avatar> </a></div>
                                        <h5><a href="javascript:void(0)">{{element.name}}</a></h5>
                                    </div>
                                    <div v-if="element.price != null" class="cources_price_foot"><span class="price_off">{{element.currency}} {{element.price}}</span></div>
                                    <div v-else class="foot_lecture"><i class="ti-gift mr-2"></i>{{lang["free-course"]}}</div>
                                </div>
                                
                            </div>	
                        </div>                     
                    </div>  

                                
                    <div class="row" v-else>
                        <div class="col-12 text-center">
                            <img class="w-50" src="@/assets/img/general/ux/no_courses_products.png" alt="No activities">
                            <h4 class="sbr-empty-state-text">{{lang["no-courses-found"]}}</h4>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div v-if="courseList != null && courseList.length > 6" class="row text-center mb-5">
                        <div class="col-12 col-md-12">
                            <ul class="pagination p-center">
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                                    <span class="ti-arrow-left"></span>
                                    <span class="sr-only">Previous</span>
                                    </a>
                                </li>

                                <li v-for="pag in parseInt(Math.ceil(courseList.length / perPage))" :key="pag" class="page-item" >
                                    <a class="page-link" :class="pag === currentPage ? 'active': ''" @click.prevent="currentPage = pag" href="javascript:void(0)">{{pag}}</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)" aria-label="Next">
                                    <span class="ti-arrow-right"></span>
                                    <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            
            </div>
            <!-- Row -->   
        </div>
    </div><!-- End col-12 -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import { DataTables, DataTablesServer } from 'vue-data-tables'
import {eventLang} from '@/components/helper/HelperLang'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import VueLazyload from 'vue-lazyload'
import 'element-ui/lib/theme-chalk/index.css'


locale.use(lang)
// or with options
Vue.use(VueLazyload, {
    preLoad: 1.3,
    error:'https://sbrfiles.s3.amazonaws.com/images/image-not-available.png',
    loading: 'https://sbrfiles.s3.amazonaws.com/gifs/loading7.gif',
    attempt: 1
})
Vue.use(DataTables)
Vue.use(DataTablesServer)
Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: function() {
        return {   
            visibleCourses: null,
            courseList : [],
            lang: {},
            modal : false,
            loading: false,
            roleId: '',
            category: '',
            categories: [],
            search: '',
            options: [],
            checkedNames: [],
            priceFilter: [],

            companyEmail: '',
            companyPhone: '',

            currentPage: 1,
            perPage: 6,
        }
    },
    created(){
        this.getSettings();
        this.getCourses();
        this.getCategories();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        rateAverage: function(totalRate, totalReviews){
            console.log(totalReviews);
            if(totalRate == null){
                return 0;
            }else{
                return (parseInt(totalRate) / parseInt(totalReviews)).toFixed(1);
            }
        },
        getCourses(){
            this.loading = true;
            var formData = new FormData();
            formData.set("categories", this.checkedNames);
            formData.set("price", this.priceFilter);
            formData.set("title", this.search);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "listingAll");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.courseList = response.data; 
                if(response.data == null){
                    this.visibleCourses = null;
                }else{
                    this.visibleCourses = response.data.slice((this.currentPage - 1) * this.perPage, ((this.currentPage - 1) * this.perPage) + this.perPage);
                }
                this.loading = false;
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        getCategories(){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("category", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.categories = response.data; 
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        getSettings(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("settings", "getSettingsInformation");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.companyEmail = response.data["email"]; 
                this.companyPhone = response.data["phone"]; 

                /* Create custom classes */
                var style = document.createElement('style');
                style.type = 'text/css';
                style.innerHTML = '.checkbox-custom:checked + .checkbox-custom-label:before { background: '+response.data['color']+';border-radius: 10px;box-shadow: inset 0px 0px 0px 4px #fff;}.tag_cloud a:hover,.tag_cloud a:focus {background: '+response.data["color"]+' ;color: #ffffff !important;}.foot_lecture {background: '+response.data["color"]+';color: white;font-weight: 500;padding: 6px 15px;font-size: 13px;border-radius: 50px;}.page-link.active{background-color: '+response.data["color"]+' !important;color:white;}.page-link.active:focus{background-color: '+response.data["color"]+' !important;color:white;}';
                document.getElementsByTagName('head')[0].appendChild(style);
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        viewProduct:function(id,expirationDays,releaseDays){
            if(releaseDays == null){
                releaseDays = -1;
            }

            if(expirationDays == null){
                expirationDays = 1;
            }

            if(expirationDays > 0  && releaseDays <= 0){
                sessionStorage.setItem('sbr_product_id', ''+id+'');
                window.location.href="product   ";
            }
        },

        formatExpirationDays: function (expirationDays) {
       
            if(expirationDays == null){
                return 1;
            }else{
                return expirationDays;
            }
        },
        formatReleasedDays: function (releasedDays) {
       
            if(releasedDays == null){
                return -1;
            }else{
                return releasedDays;
            }
        },
    },
    watch: {
        checkedNames: function () {
            this.getCourses();
        },
        priceFilter: function(){
            this.getCourses();
        },
        search: function () {
            this.getCourses();
        },
        currentPage: function(){
            this.visibleCourses = this.courseList.slice((this.currentPage - 1) * this.perPage, ((this.currentPage - 1) * this.perPage) + this.perPage);
            document.getElementById("top-list").scrollIntoView({ block: 'end',  behavior: 'smooth' });
        },
    }
}

</script>

<style lang="scss" scoped>

/* =============
  == Products page style==

    - Layout
    - Fonts
    - Checkbox
    - Pagination
    - Tags
    - Filtersidebar
    - Course list

============= */




/* =============
   Layout
============= */

.container-site{
    overflow-x: hidden !important;
    padding: 0 10% 0 10%;
}

.list-courses{
    margin-bottom: 50px !important;
}


/* =============
   Fonts
============= */
h1, h2, h3, h4, h5, h6 {
    color: #2D3954;
    font-family: 'Poppins', sans-serif;
    word-break: break-word !important; 
}

h1  {
    line-height: 40px;
    font-size: 36px;
}

h2 {
    line-height: 36px;
    font-size: 30px;
}

h3 {
    line-height: 30px;
    font-size: 24px;
}

h4 {
    line-height: 26px;
    font-size: 21px;
}

a {
    color: #4a5682;
    text-decoration: none;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
}


/* =============
   Checkbox
============= */
.checkbox-custom + .checkbox-custom-label:before {
    content: '';
    background: #fff;
    border: 2px solid #d8dfe6;
    display: inline-block;
    vertical-align: middle;
    width: 20px;
    height: 20px;
    border-radius: 3px;
    padding: 2px;
    margin-right: 10px;
    text-align: center;
}

.checkbox-custom, .checkbox-custom-label, .radio-custom, .radio-custom-label {
    display: inline-block;
    vertical-align: middle;
    margin: 5px 0;
    cursor: pointerer;
}

.checkbox-custom, .radio-custom {
    opacity: 0;
    position: absolute;
}


.checkbox-custom-label, .radio-custom-label {
    position: relative;
    padding-top:3%;
}



[role=button], a, area, button, input, label, select, summary, textarea {
    -ms-touch-action: manipulation;
    touch-action: manipulation;
}



.checkbox-custom-label{
    color: #647b9c;
    font-size: 15px;
    font-family: 'Muli', sans-serif;
    font-weight: 400;
}

.checkbox-custom + .checkbox-custom-label[data-v-3b9628ad]:before {
    margin-top:-4% !important;
}

/* =============
   Pagination
============= */
.pagination{
    display: inline-flex !important;
}


.pagination>li>a, .pagination>li>a, .pagination>li>span {
    padding: 0;
    margin: 5px;
    width: 40px;
    height: 40px;
    text-align: center;
    line-height: 40px;
}

.page-link{
    border-radius: 50px !important;
}

.page-link.active{
    color: white!important;
}


/* =============
   Tags
============= */
.tag_cloud {
    display: inline-block;
}

.tag_cloud a {
    display: block;
    float: left;
    font-size: 13px !important;
    font-weight: 500;
    line-height: 1.5;
    padding: 7px 15px 6px;
    border-radius: 3px;
    background: #e7eaf1;
    color: #919baf;
    border: 0;
    margin: 5px;
    overflow: hidden;
}


/* =============
   Filter sidebar
============= */
.filter-sidebar {
    height: 100vh;
    width: 0;
    position: fixed;
    z-index: 1000;
    top: 0;
    left: 0;
    background-color: #fff;
    overflow: hidden;
    transition: 0.5s;
    padding-top: 20px;
    padding-bottom: 2rem;
    box-shadow: 0 0 20px 0 rgba(62,28,131,0.1);
}

.filt-head {
    display: flex;
    padding: 0 1rem 1rem 1.5rem;
    flex-wrap: wrap;
    align-items: center;
}

.filt-head .filt-first {
    flex: 1;
    margin: 0;
    font-size: 16px;
    font-weight: 500;
}

.no-ul-list {
    padding: 0;
}


.page_sidebar {
    position: relative;
    width: 90%;
    margin-bottom: 30px;
    border: 2px solid #e6ebf1;
    border-radius: 0.4rem;
    padding: 2rem 1rem;
}


.no-ul-list li {
    list-style: none;
}

input[type=checkbox], input[type=radio] {
    box-sizing: border-box;
    padding: 0;
}

.filter_wraps {
    display: inline-flex;
    align-items: center;
    justify-content: flex-end;
    width: 100%;
}


/* =============
   Courses list
============= */
.education_block_grid {
    width: 100%;
    background: #ffffff;
    border-radius: 0.4rem;
    overflow: hidden;
    margin-bottom: 30px;
    position: relative;
    transition: all ease 0.4s;
    border: 1px solid #e8ebf1;
}

.education_block_thumb {
    overflow: hidden;
    position: relative;
}

.education_block_thumb:before {
    content: "";
    position: absolute;
    background: #2a2f4c;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
    opacity: 0.2;
}

.education_block_grid.style_2 .education_block_body {
    padding: 20px 20px 5px;
}

.education_block_grid .bl-title {
    font-size: 17px;
    margin-bottom: 10px;
}


.cources_info_style3 {
    padding: 0 20px 20px;
}

.cources_info_style3 ul {
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    width: 100%;
    list-style-type: none;
}

.cources_info_style3 ul li {
    flex: 0 0 33.333333%;
    width: 33.333333%;
    font-size: 13px;
    color: #4a5874;
}

.cources_info_style3 ul li i {
    font-size: 14px;
}

.education_block_footer {
    padding: 1rem 1.5rem;
    width: 100%;
    display: flex;
    vertical-align: middle;
    align-items: center;
    border-top: 1px solid #f0f1f5;
}

.education_block_author {
    flex: 1;
}

.education_block_author {
    flex: 1;
    display: flex;
    align-items: center;
}

.education_block_author .path-img {
    max-width: 35px;
    height: 35px;
    border-radius: 50%;
    display: inline-block;
    overflow: hidden;
    margin-right: 7px;
}

.cources_price_foot {
    font-size: 28px;
    font-weight: 800;
    color: #4a5874;
    display: flex;
    align-items: center;
}

.education_ratting {
    position: absolute;
    left: 0px;
    bottom: 30px;
    background: #ffffff;
    padding: 8px 15px;
    border-radius: 0px 50px 50px 0;
    font-size: 13px;
    color: #515a6b;
    font-weight: 600;
}

.education_ratting i {
    margin-right: 6px;
    color: #FF9800;
}

.founded-courses{
    color: #647b9c;
    font-size: 15px;
    font-family: 'Muli', sans-serif;
    font-weight: 400;
}

.courses-grid{
    box-shadow: -10px 0px 10px -10px #e6ebf1;
}

</style>
