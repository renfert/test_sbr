<template>
    <div>
        <section class="pt-5 sbr-external-left-10 sbr-external-right-10">
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
                        
                        <div v-if="categories != null">
                            <h4 class="side_title">Course categories</h4>
                            <ul class="no-ul-list mb-3">
                                <li v-for="element in categories" :key="element.id">
                                    <input :id="'check'+element.id" :value="element.id" class="checkbox-custom" name="aa-4" type="checkbox" v-model="checkedNames">
                                    <label :for="'check'+element.id" class="checkbox-custom-label">{{element.name}}</label>
                                </li>
                            </ul>
                        </div>
                        
                    
                        
                        <h4 class="side_title">{{lang['price']}}</h4>
                        <ul class="no-ul-list mb-3">
                            <li>
                                <input v-model="priceFilter" value="all" id="b-7" class="checkbox-custom" name="b-7" type="radio">
                                <label for="b-7" class="checkbox-custom-label">{{lang['all']}}</label>
                            </li>
                            <li>
                                <input v-model="priceFilter" value="free" id="b-8" class="checkbox-custom" name="b-8" type="radio">
                                <label for="b-8" class="checkbox-custom-label">Free</label>
                            </li>
                            <li>
                                <input  v-model="priceFilter" value="paid" id="b-9" class="checkbox-custom" name="b-9" type="radio">
                                <label for="b-9" class="checkbox-custom-label">Paid</label>
                            </li>
                        </ul>
                        
                    </div>
                            
                </div>	
                
                <div class="col-lg-8 col-md-12 col-sm-12 order-1 order-lg-2 order-md-1">
                    
                    <!-- Row -->
                    <div class="row align-items-center mb-3" v-if="courseList != null">
                        <div class="col-lg-6 col-md-6 col-sm-12 founded-courses">
                            We found <strong>{{courseList.length}}</strong> courses for you
                        </div>
                    </div>
                    <!-- /Row -->
                    
                    <div class="row" style="box-shadow: -10px 0px 10px -10px #e6ebf1;" v-if="courseList != null">
                        <!-- Cource Grid  -->
                        <div class="col-lg-6 col-md-6 col-sm-6" v-for="element in courseList" :key="element.id">
                            <div class="education_block_grid style_2">
                                
                                <div class="education_block_thumb">
                                    <a href="course-detail.html"><img v-lazy="getUrlToContents() + 'course/'+element.photo+''"  src="https://sabiorealm.s3.amazonaws.com/demo1/uploads/course/5xzwR4ayidpH2iP21B5ysKQkyt4xOUkmpvWNbCA7100.jpg" class="img-fluid" alt=""></a>
                                    <div class="education_ratting"><i class="fa fa-star"></i>4.8 (70)</div>
                                </div>
                                
                                <div class="education_block_body">
                                    <h4 class="bl-title"><a href="course-detail.html">{{element.title}}</a></h4>
                                </div>
                                
                                <div class="cources_info_style3">
                                    <ul>
                                        <li><i class="ti-agenda mr-2"></i>10 Modulos</li>
                                        <li><i class="ti-control-skip-forward mr-2"></i>63 Lectures</li>
                                    </ul>
                                </div>
                                
                                <div class="education_block_footer">
                                    <div class="education_block_author">
                                        <div class="path-img"><a href="javascript:void(0)"><img :src="getUrlToContents() + 'avatar/'+element.avatar+''" class="img-fluid" alt=""></a></div>
                                        <h5><a href="javascript:void(0)">{{element.name}}</a></h5>
                                    </div>
                                    <div v-if="element.price != null" class="cources_price_foot"><span class="price_off">$ {{element.price}}</span></div>
                                    <div v-else class="foot_lecture"><i class="ti-gift mr-2"></i>Free course</div>
                                </div>
                                
                            </div>	
                        </div> 

                        <!-- Pagination -->
                        <div class="row mb-5">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <ul class="pagination p-center">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                        <span class="ti-arrow-left"></span>
                                        <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">...</a></li>
                                    <li class="page-item"><a class="page-link" href="#">18</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                        <span class="ti-arrow-right"></span>
                                        <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>  
                </div>
            
            </div>
            <!-- Row -->   
        </section>
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
    loading: 'https://sbrfiles.s3.amazonaws.com/gifs/loaderSpin.gif',
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
        }
    },
    created(){
        this.getCourses();
        this.getCategories();
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        getCourses(){
            this.loading = true;
            var formData = new FormData();
            formData.set("categories", this.checkedNames);
            formData.set("price", this.priceFilter);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("course", "listingAll");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                this.courseList = response.data; 
                this.loading = false;
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }
            );
        },
        getCategories(){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("category", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.categories = response.data; 
            }, 
                // Failure callback
                function(){
                    this.errorMessage();
                }
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
        }
    }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.list-courses{
    margin-bottom: 50px !important;
}
.image-no-results{
    width:20%;
}

@media only screen and (max-width: 1024px) {
    .image-no-results{
        width:80%;
    }
}

section {
    padding: 80px 0 80px;
    position: relative;
}

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

.filter-sidebar .closebtn {
    position: relative;
    font-size: 36px;
    margin-left: 00px;
    font-weight: 500;
    text-align: center;
    font-size: 14px;
    padding: 0;
    color: #2d4767;
}

a {
    color: #4a5682;
    text-decoration: none;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
}

.filter-sidebar .show-hide-sidebar {
    padding: 10px 30px 10px 20px;
    overflow-y: scroll;
    position: relative;
    width: calc(100% + 17px);
    min-height: 300px;
    display: block;
    height: 100%;
}

.no-ul-list {
    padding: 0;
}

theme:hover, .red-skin .btn-outline-theme:focus, .red-skin .btn-outline-theme, .red-skin .simple-search-wrap .pk-input-group .pk-subscribe-submit, .red-skin .btn.search-btn-outline, .red-skin .btn.search-btn-outline:hover, .red-skin .btn.search-btn-outline:focus, .red-skin .property-listing.property-1 .listing-detail-btn .more-btn, .red-skin .nav-tabs .nav-item.show .nav-link, .red-skin .nav-tabs .nav-link.active, .red-skin .btn.pop-login, .red-skin .single-widgets.widget_tags ul li a:hover, .red-skin .single-widgets.widget_tags ul li a:focus {
    border-color: #da0b4e;
}

.page_sidebar {
    position: relative;
    width: 90%;
    margin-bottom: 30px;
    border: 2px solid #e6ebf1;
    border-radius: 0.4rem;
    padding: 2rem 1rem;
}


h4 {
    line-height: 26px;
    font-size: 21px;
}

h1, h2, h3, h4, h5, h6 {
    color: #2D3954;
    font-weight: 600;
    text-transform: capitalize;
    font-family: 'Poppins', sans-serif;
}

.dashboard_container_header .form-inline .form-control, .form-inline.addons .form-control {
    border-right: none;
    width: auto;
    border-radius: 5px 0px 0px 5px;
}

.form-control {
    height: 54px;
    border-radius: 4px;
    font-size: 15px;
    box-shadow: none;
    padding: .5rem .75rem;
    border: 1px solid #e6eaf3;
    background-clip: initial;
}

.dashboard_container_header .form-inline button, .form-inline.addons button {
    background-color: #ffffff;
    border: 1px solid #e6eaf3;
    border-left: none;
    border-radius: 0 5px 5px 0;
    height: 54px;
    color: #a8b0c5 !important;
    display: flex;
    align-items: center;
    padding: 0 15px 0 0px;
    justify-content: center;
}

.btn {
    color: #ffffff;
    padding: 12px 25px;
    cursor: pointer;
    -webkit-transition: 0s;
    -o-transition: 0s;
    transition: 0s;
    border-radius: 0.1rem;
}

[type=search] {
    outline-offset: -2px;
    -webkit-appearance: none;
}

button, input {
    overflow: visible;
}

@media (min-width: 576px){
    .my-sm-0 {
        margin-top: 0!important;
        margin-bottom: 0!important;
    }
}

.no-ul-list li {
    list-style: none;
}

input[type=checkbox], input[type=radio] {
    box-sizing: border-box;
    padding: 0;
}



b, strong {
    font-weight: bolder;
}

.filter_wraps {
    display: inline-flex;
    align-items: center;
    justify-content: flex-end;
    width: 100%;
}

body {
    background: #ffffff;
    color: #647b9c;
    font-size: 15px;
    font-family: 'Muli', sans-serif;
    margin: 0;
    overflow-x: hidden !important;
    font-weight: 400;
}

.dropdown, .dropup {
    position: relative;
}

.btn-custom.dropdown-toggle {
    background: #ffffff;
    border: 2px solid #e6ebf1;
    border-radius: 4px;
    color: #647b9c !important;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: .5rem 0;
    margin: .125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: .25rem;
}

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

a {
    color: #4a5682;
    text-decoration: none;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
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

button, input {
    overflow: visible;
}

.checkbox-custom-label, .radio-custom-label {
    position: relative;
    padding-top:3%;
}

.checkbox-custom, .checkbox-custom-label, .radio-custom, .radio-custom-label {
    display: inline-block;
    vertical-align: middle;
    margin: 5px 0;
    cursor: pointerer;
}

[role=button], a, area, button, input, label, select, summary, textarea {
    -ms-touch-action: manipulation;
    touch-action: manipulation;
}

.checkbox-custom:checked + .checkbox-custom-label:before {
    background: #da0b4e;
    border-radius: 10px;
    box-shadow: inset 0px 0px 0px 4px #fff;
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

.founded-courses{
    color: #647b9c;
    font-size: 15px;
    font-family: 'Muli', sans-serif;
    font-weight: 400;
}

.foot_lecture {
    background: rgba(30, 173, 107,0.13);
    color: #1ead6b;
    padding: 6px 15px;
    font-size: 13px;
    border-radius: 50px;
}


</style>
