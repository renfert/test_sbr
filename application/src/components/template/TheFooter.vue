<template>
        <!-- Footer secion -->   
        <footer class="page-footer font-small blue" :style="styleFooter"  v-loading="loadingFooter">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 py-5">
                        <div class="mb-5 flex-center">
                            <!-- Facebook -->
                            <a target="_blank" :href="element.url" v-for="element in socialMedias"  :key="element.id">
                                <i v-if="element.name == 'facebook'" class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                                <i v-if="element.name == 'instagram'" class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                                <i v-if="element.name == 'linkedin'" class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                                <i v-if="element.name == 'twitter'" class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                                <i v-if="element.name == 'pinterest'" class="fab fa-pinterest fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                                <i v-if="element.name == 'youtube'" class="fab fa-youtube fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
                <a href="#"> {{copyright}}</a>
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->
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


locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            loadingFooter: false,
            footerColor: '',
            copyright: '',
            socialMedias: [],
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.listFooter();
    },
    computed: {
        styleFooter: function(){
             return {
            'background-color': this.footerColor+'!important',
            }
        },
    },
    methods: {
        listFooter: function(){
            this.loadingFooter = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("builder", "listFooter");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.footerColor = response.data[0].color;
                this.copyright = response.data[0].copyright;
                this.loadingFooter = false;
                this.getSocialMedia();
            },
                /* Error callback */
                function (){
                    this.errorMessage();
                }.bind(this)
            );
        },
        getSocialMedia: function (){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("social", "listing");
            axios.post(urlToBeUsedInTheRequest).then((response) => {
                this.socialMedias = response.data;
                this.loading= false;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>


</style>
