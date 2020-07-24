<template>
    <div class="top-10">
        <lang></lang>
        <div class="text-center mb-5">
            <h1>{{header}}</h1>
            <h4>{{subheader}}</h4>
        </div>
        
        <div class="container-site">
            <carousel 
                :navigationEnabled="true" 
                :paginationEnabled="false" 
                :autoplayHoverPause="true" 
                :perPage="mobile == true ? 1 : 3 "
                zIndex= "100 !important"
                >
                <slide v-for="element in courses" :key="element.id" class="card-courses"> 
                     <!-- Cource Grid  -->
                    <div class="p-1">
                        <div class="education_block_grid style_2">
                            
                            <a :href="'product/'+element.id">
                                <div class="education_block_thumb">
                                    <a href="course-detail.html"><img v-lazy="getUrlToContents() + 'course/'+element.photo+''"  src="https://sabiorealm.s3.amazonaws.com/demo1/uploads/course/5xzwR4ayidpH2iP21B5ysKQkyt4xOUkmpvWNbCA7100.jpg" class="img-fluid" alt=""></a>
                                    <div v-if="element.reviews != null" class="education_ratting"><i class="fa fa-star"></i>{{ rateAverage(element.totalRate, element.totalReviews) }} ({{element.totalReviews}})</div>
                                </div>
                            </a>
                            
                            <div class="education_block_body">
                                <h4 class="bl-title"><a :href="'product/'+element.id">{{element.title}}</a></h4>
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
                </slide>
            </carousel>
        </div>
            
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'    
import Lang from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import {eventBus} from '@/pages/site/App'
import { Carousel, Slide } from 'vue-carousel';
import VueLazyload from 'vue-lazyload'
import 'element-ui/lib/theme-chalk/index.css'

Vue.use(VueLazyload, {
    preLoad: 1.3,
    error:'https://sbrfiles.s3.amazonaws.com/images/image-not-available.png',
    loading: 'https://sbrfiles.s3.amazonaws.com/gifs/loading7.gif',
    attempt: 1
})

locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    mixins: [domains,alerts],
    props:["section-id"],
    components: {
        Carousel,
        Slide,
        Lang
    },
    data: () => {
        return {
            lang: {},
            courses: [],
            title: '',
            description: '',
            photo: '',
            price: '',
            preview: '',
            header: '',
            subheader: '',
            mobile: false,
            rate: 5,
        }
    },
    mounted(){

        /****************** 
        Fix carousel bug 
        ********************/
      
        setTimeout(function(){ 
            window.dispatchEvent(new Event('resize'));
        }, 5000);

        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on('new-change-product-list', function(){  
            this.getCourses();
        }.bind(this));

        this.getCourses();

        if(window.screen.width <= 800){
            this.mobile = true;
        }
    },
    methods: {
        rateAverage: function(totalRate, totalReviews){
            console.log(totalReviews);
            if(totalRate == null){
                return 0;
            }else{
                return (parseInt(totalRate) / parseInt(totalReviews)).toFixed(1);
            }
        },
        getCourses: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("site-elements/productList", "get");
            var formData = new FormData();
            formData.set("sectionId", this.sectionId);
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.header = response.data["productList"][0]["header"];
                this.subheader = response.data["productList"][0]["subheader"];
                this.courses = response.data["courses"];
            },
                /* Error callback */
                function (){
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
                window.location.href="product";
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
        }
    },
}
</script>


<style lang="scss" scoped>

/* =============
  == Products page style==

    - Layout
    - Fonts
    - Course list
    - Mobile

============= */

/* =============
   Layout
============= */

.top-10{
    margin-top:10%;
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
    line-height: 36px;
    font-size: 32px;
}

h2 {
    line-height: 32px;
    font-size: 28px;
}

h3 {
    line-height: 24px;
    font-size: 18px;
}

h4 {
    line-height: 24px;
    font-size: 18px;
}

a {
    color: #4a5682;
    text-decoration: none;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
}

/* =============
   Courses list
============= */
.education_block_grid {
    width: 100%;
    background: #ffffff;
    border-radius: 0.4rem;
    overflow: hidden;
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
    padding:  0px 0px 20px 20px;
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


/* =============
   Mobile
============= */

@media only screen and (max-width: 1024px) {

    h1  {
        line-height: 24px;
        font-size: 22px;
    }

    h2 {
        line-height: 22px;
        font-size: 18px;
    }

    h3 {
        line-height: 16px;
        font-size: 14px;
    }

    h4 {
        line-height: 14px;
        font-size: 12px;
    }

    .link-button[data-v-059bd9ee] {
        font-weight: 500;
        -webkit-transition: 0.5s;
        transition: 0.5s;
        color: white;
        font-size: 1em;
        font-family: 'Poppins', sans-serif;
        border-radius: 5px;
        padding: 8px 18px 8px 18px;
    }

}



</style>
