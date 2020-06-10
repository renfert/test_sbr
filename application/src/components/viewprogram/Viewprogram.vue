<template>
    <div class="col-12">
        <div class="program-title">
            <h2>{{programName}}</h2>
        </div>
        <div class="items-outer-container">
            <div class="items-container">
                <div class="items">
                    
                    <div id="items-completed__header">
                        <h1 class="total-items text-center">{{lang["total-courses-completed"]}} <b class="text-sabiorealm"> {{totalCoursesCompleted}} </b></h1>
                    </div>

                    <hr class="mt-5 mb-5">

                    
                    <div class="row item-row" v-for="element in courses" :key="element.id">

                        <div v-if="element.status == 0" class="col-2 item-icon text-center" style="padding:15px 30px 15px 30px;">
                            <svg  class="svg-inline--fa fa-check fa-w-2 completed" aria-hidden="true" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="#00E1F0" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                        </div>

                        <div v-else class="col-2 item-icon text-center" style="padding:15px 30px 15px 30px;">
                           <svg class="svg-inline--fa fa-circle fa-w-16 uncompleted" aria-hidden="true" data-prefix="far" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200z"></path></svg>
                        </div>

                        <div class="col-4 mr-5 text-left item-name">
                            <h3><a class="text-sabiorealm" href="javascript:void(0)">{{element.course}}</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-background-accent"></div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'


Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    props:['program-id'],
    data: function() {
        return {
            lang: {},
            courses:[],
            totalCoursesCompleted: '',
            programName: '',
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.listingCoursesToViewProgram();
    },
    methods: {
        listingCoursesToViewProgram: function(){
            var formData = new FormData();
            formData.set("programId", this.programId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("program", "listingCoursesToViewProgram")
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                /* Success callback */
                this.courses = response.data;
                this.programName = response.data[0]["program"];
                this.completedCourses();
            },  
            /* Error callback */
            function(){
                this.errorMessage();  
            }
            );
        },
        completedCourses: function(){
            var total = 0;
            for (let index = 0; index < this.courses.length; index++) {
                if(this.courses[index]["status"] == 0){
                    total = parseInt(total) + parseInt(1);
                }
            }
            this.totalCoursesCompleted = total;
        }   
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

.program-title{
    width:80%;
    margin-left:50%;
    margin-top:5%;
    position: absolute;
    left:-40%;
    text-align:center;
}

.program-title h2{
    color: #9e9c9c;
}

.app-background-accent{
    background-color: #4eb3f1;
    height: 90vh;
    left: 50%;
    position: fixed;
    top: 50%;
    transform: translateX(-50%) rotate(5deg);
    width: 150%;
}

.items-outer-container{
    animation: fadeIn 0.5s ease-in;
    background-color: white;
    border-radius: 10px;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 10px, rgba(0, 0, 0, 0.23) 0px 3px 10px;
    left: 50%;
    padding: 20px;
    position: absolute;
    top: 50%;
    transform: translateX(-50%) translateY(-50%);
    z-index: 10;
}

.items-container{
    overflow: auto;
    width: 460px;
}

.items{
    margin: 20px;
    margin-top: 0px;
    overflow: hidden;
    position: relative;
}

.item-completed{
    left: 0px;
    padding: 20px 0px 0px 0px;
    position: absolute;
    transition: all 0.5s, background-color 0s;
    width: calc(100% - 40px);
    height:60px;
    top:30%;
}

.item-icon svg{
    cursor: pointer;
    position: relative;
    z-index: 2;
    text-align:center; 
}



.items-completed__spacer{
    transition: all 0.5s;
    width: 100%;
}

.item-row{
    cursor: pointer;
}

.item-row:hover{
    background-color: rgba(230, 230, 230, 0.4);
}

.items-completed__header{
    height: 60px;
    margin-top: 20px;
    position: relative;
}


.total-items{
    color: #9e9c9c;
    font-size: 1.2em ;
    font-weight: 400;
    height: 19px;
    margin: 0px;
    padding: 20px;
}

.item-name{
    width: calc(100% - 120px);
    display: inline-block;
    vertical-align: top;
    top: 0;
    position:inherit;
    text-align:left;
    margin-left:-5%;
}

.item-name h3{
    color: #9e9c9c;
    font-size: 1.2em ;
}

</style>
