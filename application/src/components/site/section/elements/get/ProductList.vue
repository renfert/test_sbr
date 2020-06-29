<template>
    <div class="section" v-loading="loading">
        <div class="text-box">
            <h1>{{header}}</h1>
            <h3>{{subheader}}</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="inner-section">
                    <carousel :autoplay="true" :navigationEnabled="true" :paginationEnabled="false" :autoplayHoverPause="true" :perPage="3">
                        <slide v-for="element in courses" :key="element.id" class="card-courses"> 
                            <!-- Course card -->
                            <div v-if="new Date(element.release_date) <= new Date() && new Date(element.expiration_date) >= new Date() || element.release_date == null && element.expiration_date == null || element.release_date == '0000-00-00' && element.expiration_date == '0000-00-00'"  class="card">
                                
                                <!-- Course image -->
                                <img  style="height:200px;" v-if="element.photo != '' && element.photo != null"  class="card-img-top" :src="getUrlToContents() + 'course/'+element.photo+''" >
                            

                                <img style="height:200px;" v-else class="card-img-top" src="@/assets/img/general/ux/course_image_default.png" alt="Card image cap">
                                <!-- Course content -->
                                <div class="card-body">
                                    <!-- Title -->
                                    <h3 class="course-title"><a>{{element.title}}</a></h3>
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
                                        <button @click="viewProduct(element.id)" class="btn-ead btn-sabiorealm">VER CURSO</button>
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
        Slide
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
        viewProduct:function(id){
            if(process.env.NODE_ENV === 'production'){
                window.location.href="pages/product/"+id+"";
            }else{
                 window.location.href="product/"+id+"";
            }
        },
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

</style>
