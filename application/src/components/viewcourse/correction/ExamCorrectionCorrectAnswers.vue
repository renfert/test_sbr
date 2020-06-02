<template>
    <div class="main">
        <!-- Default checked -->
        <div  v-for="element in answers" :key="element.id" class="custom-control custom-checkbox">
            <input :checked="element.correct == 'correct' ? true : false" :value="element.id" :name="'answer['+questionId+']['+element.id+']'" type="checkbox" class="custom-control-input" :id="'answer'+element.id">
            <label class="custom-control-label" :for="'answer'+element.id"> {{element.answer}} </label>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui'
import {eventLang} from '@/components/helper/HelperLang'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
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
            answers: null,
            answer: '',
        }
    },
    mounted(){
        /* Get a language */
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.getAnswers();
    },
    props: ['question-id'],
    methods: {
        getAnswers: function(){
            var formData = new FormData()
            formData.set('questionId', this.questionId)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("answer", "listing");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                /* Success callback */
                this.answers = response.data;
                //this.reorder();
            },
                /* Error callback */
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

</style>
