<template>
    <div class="main"  v-loading="loading">
        <lang></lang> 
        <div class="row">
            <!-- Courses -->
            <div class="col-12 col-md-12">
                <div class="card-box">
                    <div class="chart">
                        <label>Courses</label>
                        <pie-chart 
                            label-position="center"
                            legend 
                            :data="courses"/>
                    </div>
                </div>
            </div>
        </div>    
    </div> 
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import Lang from '@/components/helper/HelperLang.vue'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import { 
  BarChart,
  LineChart,
  PieChart,
  //...
} from 'dr-vue-echarts'

Vue.use(BarChart);
Vue.use(LineChart)
Vue.use(PieChart)




locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    components: {
        Lang,
    },
    mixins: [domains,alerts],
    data: () => {
        return {
            lang: {},
            loading: false,
            colors: ['#c3c3c3', '#c7c7c6'],
            students: [
                {
                    name: "Students",
                    data: [
                        {
                        label: "Jan",
                        value: 3
                        },
                        {
                        label: "Fev",
                        value: 15
                        },
                        {
                        label: "Mar",
                        value: 23
                        },
                        {
                        label: "Abr",
                        value: 58
                        }
                    ]
                }
            ],
            sales: [
                {
                name: "Sales U$",
                data: []
                }
            ],
            storage: [
                {
                name: 'Total',
                value: 30,
                },
                {
                name: 'Used',
                value: 15,
                },
            ],
            courses: [
                {
                    name: 'Not started',
                    value: 3,
                },
                {
                    name: 'In progress',
                    value: 5,
                },
                {
                    name: 'Finished',
                    value: 15,
                },
            ],
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.getStudentsChart();
        this.getSalesChart();
    },
    methods: {
        getStudentsChart: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("chart", "getStudentsChart");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                //this.students = response.data;
                this.students[0].data = response.data;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        getSalesChart: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("chart", "getSalesChart");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                //this.students = response.data;
                this.sales[0].data = response.data;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.chart {
  width: 100%;
  height: 300px;
}
</style>
