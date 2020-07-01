<template>
    <div class="col-auto"  v-loading="loading">
        <div class="row">
            <div class="col-md-4 col-6  text-center">
                <el-input
                    :placeholder="lang['search']"
                    prefix-icon="el-icon-search"
                    v-model="search">
                </el-input>
            </div>
            <div class="col-md-3 col-6 text-center">
                 <el-select @change="getCourses()" v-model="category" :placeholder="lang['select-category']">
                    <el-option
                        key="0"
                        :label="lang['all']"
                        value="1"
                    >
                    </el-option>
                    <el-option
                    v-for="item in categories"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                        
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row gap5" v-if="courseList != null">
            <div class="col-12 col-md-4 list-courses" v-for="element in courseList" :key="element.id">
                <div class="card">

                    <a @click.prevent="viewProduct(element.id,element.expirationDays,element.releaseDays)" v-if="element.photo != '' && element.photo != null">
                        <!-- Course image -->
                        <img :src="getUrlToContents() + 'course/'+element.photo+''" style="height:200px;"   class="card-img-top">
                    </a>

                    <a  @click.prevent="viewProduct(element.id,element.expirationDays,element.releaseDays)" v-else>
                        <img style="height:200px;" class="card-img-top" src="@/assets/img/general/ux/course_image_default.png" alt="Card image cap">
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
                            <button v-if="formatExpirationDays(element.expirationDays) > 0  && formatReleasedDays(element.releaseDays) < 0" @click="viewProduct(element.id,element.expirationDays,element.releaseDays)" class="btn-ead btn-sabiorealm">VER CURSO</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
            <div class="row gap-10">
                <div class="col-12 text-center">
                      <h4>{{lang['no-courses-found']}}</h4>
                    <img class="image-no-results" src="@/assets/img/general/ux/no_courses_products.png">
                </div>
            </div>
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
import 'element-ui/lib/theme-chalk/index.css'


locale.use(lang)
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
            formData.set("category", this.category);
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
                if(process.env.NODE_ENV === 'production'){
                    window.location.href="pages/product";
                }else{
                    window.location.href="product";
                }
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

</style>
