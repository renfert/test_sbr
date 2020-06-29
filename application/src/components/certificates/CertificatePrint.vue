<template>
    <!-- Certificate -->
    <el-dialog  :visible.sync="modal" :title="lang['your-certificate']" center width="60%" top="5vh">
        <lang></lang>
        <div v-loading="loading" >
            <!-- Print button -->
            <div class="text-center mb-3">
                <div class="text-center">
                    <img src="@/assets/img/general/ux/certificate.png"  class="mb-3">
                    <br>
                    <a @click.prevent="printCertificate" href="javascript:void(0)" class="btn-ead btn-sabiorealm">{{lang["print-certificate"]}}
                    </a>
                </div>
            </div>
        </div>
        <vue-html2pdf
            :show-layout="false"
            :preview-modal="true"
            :paginate-elements-by-height="1400"
            filename="certificate"
            :pdf-quality="2"
            pdf-format="a4"
            pdf-orientation="landscape"
            pdf-content-width="800px"
            ref="html2Pdf"

            @progress="onProgress($event)"
        >
        <section v-if="template == 'classic'" slot="pdf-content">
            <div>
                <div class="classic-template">
                    <h2>{{companyName}}</h2>
                    <h3>{{lang['certificate-of-completition']}}</h3>
                    <h5>{{lang['granted-to']}}</h5>
                    <h1>{{userName}}</h1>
                    <p>{{lang['certify-completition']}}</p>
                    <h3>{{course}}</h3>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <h4>#{{number}}</h4>
                        </div>
                        <div class="col-6">
                            <h4>{{date}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <img src="@/assets/img/general/certificate/classic_template.png" alt="">   
        </section>

        <section v-if="template == 'tech'" slot="pdf-content">
            <div>
                <div class="tech-template">
                    <h2>{{companyName}}</h2>
                    <h3>{{lang['certificate-of-completition']}}</h3>
                    <h5>{{lang['granted-to']}}</h5>
                    <h1>{{userName}}</h1>
                    <p>{{lang['certify-completition']}}</p>
                    <h3>{{course}}</h3>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <h4>#{{number}}</h4>
                        </div>
                        <div class="col-6">
                            <h4>{{date}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <img src="@/assets/img/general/certificate/tech_template.png" alt="">   
        </section>

        <section v-if="template == 'artistic'" slot="pdf-content">
            <div>
                <div class="artistic-template">
                    <h2>{{companyName}}</h2>
                    <h3>{{lang['certificate-of-completition']}}</h3>
                    <h5>{{lang['granted-to']}}</h5>
                    <h1>{{userName}}</h1>
                    <p>{{lang['certify-completition']}}</p>
                    <h3>{{course}}</h3>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <h4>#{{number}}</h4>
                        </div>
                        <div class="col-6">
                            <h4>{{date}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <img src="@/assets/img/general/certificate/artistic_template.png" alt="">   
        </section>

        </vue-html2pdf>
    </el-dialog>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import {eventLang} from '@/components/helper/HelperLang'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import VueHtml2pdf from 'vue-html2pdf'
import Lang from '@/components/helper/HelperLang'

export const eventCertificate = new Vue();

locale.use(lang)
Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    props:['course-id'],
    components: {
        VueHtml2pdf,
        Lang
    },
    data: function() {
        return {
            lang: {},
            modal : false,
            course: '',
            date: '',
            template: null,
            number: '',
            companyName: '',
            userName : '',
            loading: false
        }
    },
    mounted(){
    
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventCertificate.$on("print-certificate", function(){
            this.getCompanyInformation();
            this.getUserProfile();
            this.getCertificate();
            this.modal = true;
        }.bind(this))

    },
    methods: {
        printCertificate: function () {
            this.loading = true;
            this.$refs.html2Pdf.generatePdf()
        },
        onProgress: function(event){
            if(event == 100){
                this.loading = false;
            }
        },
        getUserProfile(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserProfile");
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.userName = response.data["name"];
            }.bind(this));
        },
        getCompanyInformation(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("company", "getCompanyInformation");
            axios.get(urlToBeUsedInTheRequest).then(function (response) {
                this.companyName = response.data["name"];
            }.bind(this));
        },
        getCertificate(){
            var formData = new FormData;
            formData.set("courseId", this.courseId)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("certificate", "get");
            axios.post(urlToBeUsedInTheRequest, formData).then(function (response) {
                this.course = response.data[0]["course"];
                this.date = response.data[0]["date"];
                this.template = response.data[0]["certificate"];
                this.number = response.data[0]["number"];
            }.bind(this));
        }
    },
   
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
