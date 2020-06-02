<template>
    <div class="section" v-loading="loading">
        <div class="text-box">
            <h1>{{header}}</h1>
            <h3>{{subheader}}</h3>
        </div>
        <div class="inner-section">
            <persons-list v-for="element in testimonialArray" :key="element.id" :testimonial-id="element.id"></persons-list>
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
import {eventBus} from '@/pages/site/App'
import PersonsList from '@/components/persons/PersonsList'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
locale.use(lang)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)
export default {
    mixins: [domains,alerts],
    components: {
        PersonsList
    },
    props:["section-id"],
    data: () => {
        return {
            lang: {},
            loading: false,
            header: '',
            subheader: '',
            testimonialArray: []
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
        this.lang = response;
        }.bind(this));

        eventBus.$on("new-testimonial", function(){
            this.getTestimonial();
        }.bind(this));

        eventBus.$on("new-change-testimonial", function(){
            this.getTestimonial();
        }.bind(this));

        this.getTestimonial();
    },
    methods: {
        getTestimonial: function(){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("site-elements/testimonial", "get");
            var formData = new FormData();
            formData.set("sectionId", this.sectionId);
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.loading= false;
                this.testimonialArray = response.data;
                this.header = response.data[0]["header"];
                this.subheader = response.data[0]["subheader"];
            },
                /* Error callback */
                function (){
                this.errorMessage();
                }.bind(this)
            );
        },
    },
    computed: {
        styleButtonPlain: function() {
            return {
            'background-color': this.buttonColor,
            'display': this.banner["title"] == null ? 'none' : 'initial',
            '--color-hover': this.buttonColorHover,
            'border-radius': this.buttonStyle == 'plain'? '0px' : '30px'
            }
        },
        styleHeader: function(){
             return {
            'background-image': 'url('+this.image+')',
            }
        },
        styleBannerHeader: function(){
             return {
            'color': this.headerColor,
            }
        },
         styleBannerSubHeader: function(){
             return {
            'color': this.subHeaderColor,
            }
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>


</style>
