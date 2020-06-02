<template>

    <div class="col-12">
        <vc-calendar
            :attributes='attrs'
            is-inline
            is-expanded
        >
        </vc-calendar>
    </div><!-- End col-12 -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import {eventLang} from '@/components/helper/HelperLang'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import VCalendar from 'v-calendar';

Vue.use(VCalendar, {
  componentPrefix: 'vc'
});
locale.use(lang)
Vue.use(ElementUI)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: function() {
        return {   
            lang: {},
            attrs: [
                {
                    highlight: true,
                    popover: {
                        label: 'You just hovered over today\'s date!',
                    },
                    dates: "2020-05-05",
                },
            ],
            
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));

        this.getUserEvents();
    },
    methods:{
        getUserEvents: function(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("calendar", "get");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                this.attrs = response.data;
            }, () => {
                // Failure callback
                this.errorMessage();
            });
        }
    }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
   

</style>
