<template>
    <div class="section sbr-external-top-10" v-loading="loading">
        <lang></lang>
        <div class="text-box inner-section">
            <h1 class="sbr-h1-external mb-4">{{header}}</h1>
            <h3 class="sbr-h4-external">{{subheader}}</h3>
        </div>
        <div class="row" id="myCheck">
            <div class="col-md-12">
                <div class="inner-section">
                    <carousel 
                        :navigationEnabled="true" 
                        :paginationEnabled="false" 
                        :autoplayHoverPause="true" 
                        :perPage="3"
                        zIndex= "100 !important"
                        >
                        <slide v-for="element in courses" :key="element.id" class="card-courses"> 
                            <!-- Course card -->
                            <div class="card">

                                <a @click.prevent="viewProduct(element.id,element.expirationDays,element.releaseDays)" v-if="element.photo != '' && element.photo != null">
                                    <!-- Course image -->
                                    <img :src="getUrlToContents() + 'course/'+element.photo+''" style="height:200px;"   class="card-img-top">
                                </a>

                                <a  @click.prevent="viewProduct(element.id,element.expirationDays,element.releaseDays)" v-else>
                                    <img style="height:200px;" class="card-img-top" src="@/assets/img/general/ux/course_image_default.jpg" alt="Card image cap">
                                </a>

                                <!-- Course content -->
                                <div class="card-body">
                                    <!-- Title -->
                                    <h3 class="course-title"><a href="javascript:void(0)" @click.prevent="viewProduct(element.id,element.expirationDays,element.releaseDays)">{{element.title}}</a></h3>
                                    <p>{{element.name}}</p>
                        
                                    <!-- 
                                    <el-rate
                                        v-model="rate"
                                        disabled
                                        text-color="#ff9900"
                                    >
                                    </el-rate> -->
                                    <hr>
                                    <div class="text-center">
                                        <h3 v-if="element.price == null || element.price == '' || element.price == ' 0,00 ' ">FREE</h3>
                                        <h3 v-else class="course-price">{{element.currency}} {{element.price}}</h3>
                                        <br>

                                        <el-tag
                                            class="mt-2"
                                            style="margin:1.3rem 0px;"
                                            v-if="element.expirationDays < 0"
                                            type="danger">
                                            {{lang["course-expired"]}} {{element.expiration_date}}
                                        </el-tag>

                                        <el-tag
                                            class="mt-2"
                                            style="margin:1.3rem 0px;"
                                            v-if="element.releaseDays > 0"
                                            type="primary">
                                            {{lang["course-avaiable-in"]}} {{element.release_date}}
                                        </el-tag>
                                        <button v-if="formatExpirationDays(element.expirationDays) > 0  && formatReleasedDays(element.releaseDays) < 0" @click="viewProduct(element.id,element.expirationDays,element.releaseDays)" class="sbr-btn sbr-primary">VER CURSO</button>
                                    </div>
                                </div>
                            </div>
                            <!--  Course card -->
                        </slide>
                    </carousel>
                </div>
            </div>
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
            loading: false,
            courses: [],
            title: '',
            description: '',
            photo: '',
            price: '',
            preview: '',
            header: '',
            subheader: '',
            rate: 5
        }
    },
    mounted(){

        /****************** 
        Fix carousel bug 
        ********************/
        setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 2000)
    

        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on('new-change-product-list', function(){  
            this.getCourses();
        }.bind(this));

        this.getCourses();
    },
    methods: {
        getCourses: function(){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("site-elements/productList", "get");
            var formData = new FormData();
            formData.set("sectionId", this.sectionId);
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.header = response.data["productList"][0]["header"];
                this.subheader = response.data["productList"][0]["subheader"];
                this.courses = response.data["courses"];
                this.loading = false;
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

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.card-courses{
    padding: 5px;
    cursor:pointer;
}

.course-title {
    font-family: 'Poppins', sans-serif;
    font-size:20px;
}

.course-price{
    font-family: 'Poppins', sans-serif !important;
}


.VueCarousel-slide {
    isibility: visible !important;
}


</style>
