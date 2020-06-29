import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueGtag from "vue-gtag";
import VueGtm from 'vue-gtm';
Vue.use(VueAxios, axios)
const integrations = {
    methods: {
        loadIntegrations(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("integrations", "getIntegrations");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                
                /* Google analytics */
                var gaId = response.data["ga_id"];
                Vue.use(VueGtag, {
                    config: { 
                        id: gaId
                    }
                });

                /* Google tag manager */
                var gtmId = response.data["gtm_id"];
                Vue.use(VueGtm, {
                    id: gtmId
                });

            });
        },
        getCurrentDomainName(){
            var domainName =  getDomain();
            if(process.env.NODE_ENV === 'production'){
                return domainName + '/';
            }else{
                return process.env.VUE_APP_URL_DEV;
            }
        },
       
    }
}

function getDomain(){
    var entireUrl = window.location.href;
    var entireUrlDividedIntoTwoParts = entireUrl.split("/");
    var domainName = entireUrlDividedIntoTwoParts[0] + "//" + entireUrlDividedIntoTwoParts[2];
    return domainName;
}



export default integrations;