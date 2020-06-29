<template>
<el-dialog
    :title="lang['upgrade-your-plan-to-access']"
    :visible.sync="modal"
    width="30%"
    >
    <div class="text-center">
        <a :href="getDomainNameToNavigation() + 'plans'" class="btn-ead btn-sabiorealm">UPGRADE NOW</a>
    </div>
</el-dialog>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import VueSwal from 'vue-swal'
export const eventPlan = new Vue();


const options = {
    confirmButtonText: 'Yes, I am sure!',
};
Vue.use(VueSwal,options )
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: () => {
        return {
            plan: '',
            lang: {},
            modal:false
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));

        eventPlan.$on("upgrade-plan", function(){
            //this.modal = true;
            this.alert();
        }.bind(this))
    },
    methods: {
        alert:function(){
            this.$swal({
                icon: "warning",
                text: this.lang['upgrade-your-plan-to-access'],
                button: {
                    text: "UPGRADE NOW",
                    closeModal: false,
                },
                 content: {
                    element: "image",
                    attributes: {
                        src: "https://sabiorealm.com/mailmarketing/sbr.png",
                    },
                },
            })
            .then(willDelete => {
                if (willDelete) {
                    window.open(
                        'https://sabiorealm.com/pricing-plans-2/',
                        '_blank' 
                    );
                }
            });
        }
    }
 
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">


.swal-overlay {
    background-color: rgba(50, 107, 94, 0.45) !important;
}

.swal-button {
    background-color: #00A9B4;
    color:white !important;
}

.swal-button:hover {
    background-color: #00E1F0 !important;
}

.swal-footer{
    text-align:center !important;
}
</style>
