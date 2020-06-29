<template>
    <div class="main">
        <!-- Default checked -->
        <div  v-for="element in answers" :key="element.id" class="custom-control custom-checkbox">
            <input v-model="data"  :value="element.id" :name="'answer['+questionId+']['+element.id+']'" type="checkbox" class="custom-control-input" :id="'answer'+element.id">
            <label class="custom-control-label" :for="'answer'+element.id"> {{element.answer}} </label>
        </div>
        <input class="hide" v-if="data == ''" value="1" type="number" :name="'answer['+questionId+'][1]'">
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
            data: []
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
    },
    watch: {
        questionId: function () {
            this.getAnswers();
        }
    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.custom-checkbox .custom-control-label::before {
    border-radius: .25rem;
    top: -1%;
}

.custom-control {
    position: relative;
    display: block;
    min-height: 1.5rem;
    padding-left: 1.5rem;
    padding-bottom: 2rem;
}

.custom-checkbox .custom-control-input:checked~.custom-control-label::after {
    top: -1%;
}
</style>
