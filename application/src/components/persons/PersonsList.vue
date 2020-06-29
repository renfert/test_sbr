<template>
    <div v-loading="loading">
         <el-carousel :interval="4000" type="card" height="350px">
            <el-carousel-item v-for="element in personsArray" :key="element.id">
                <div class="testimonial-persons">
                    <el-avatar :size="80">
                        <img :src="getUrlToContents() + 'testimonial/'+element.photo+''">
                    </el-avatar>
                    <h3>{{element.name}}</h3>
                    <h4>{{element.occupation}}</h4>
                    <hr style="width:50%;">
                    <p>"{{element.comment}}"</p>
                </div>
            </el-carousel-item>
        </el-carousel>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import { eventBus } from '@/pages/site/App.vue'

locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    mixins: [domains,alerts],
    props:["testimonial-id"],
    data: () => {
        return {
            personsArray: [],
            loading: false
        }
    },
    mounted(){
        eventBus.$on("edit-person", function(){
            this.updatePersonsListArray();
        }.bind(this));

        this.updatePersonsListArray();
    },
    methods: {
        updatePersonsListArray: function (){
            this.loading = true;
            var formData = new FormData();
            formData.set("testimonialId",this.testimonialId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("persons", "listing");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.personsArray = response.data;
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

.testimonial-persons{
    text-align:center;
    padding:10%;
    
}

.testimonial-persons h3{
    font-size: 15px;
    line-height: 1;
}


.testimonial-persons h4{
    font-size: 11px;
}


.el-carousel__item:nth-child(2n) {
background-color: #99a9bf;
}

.el-carousel__item:nth-child(2n+1) {
background-color: #d3dce6;
}

</style>
