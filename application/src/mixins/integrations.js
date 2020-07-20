import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueGtag from "vue-gtag";
import VueGtm from 'vue-gtm';

Vue.use(VueAxios, axios)
const integrations = {
    data: () => {
        return {
           currentRote:''
        }
    },
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

                /* Hotjar */
                (function(h,o,t,j,a,r){
                    h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                    h._hjSettings={hjid:1871028,hjsv:6};
                    a=o.getElementsByTagName('head')[0];
                    r=o.createElement('script');r.async=1;
                    r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                    a.appendChild(r);
                })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');

                /* Tawk to */
                if(this.currentRote != '/' && this.currentRote != '/site' && this.currentRote != '/products' && this.currentRote != '/product'){
                    var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserProfile");
                    axios.get(urlToBeUsedInTheRequest).then(function (response) {
                        let role = response.data["myrole_id"];
                        if(role == 1){
                            var Tawk_API=Tawk_API||{};
                            (function(){
                                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                                s1.async=true;
                                s1.src='https://embed.tawk.to/5f0cb00d67771f3813c0f72a/default';
                                s1.charset='UTF-8';
                                s1.setAttribute('crossorigin','*');
                                s0.parentNode.insertBefore(s1,s0);
                            })();
                        }
                    }.bind(this));
                }
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
    },
    mounted(){
        this.currentRote = this.$router.currentRoute.path;
    },

}

function getDomain(){
    var entireUrl = window.location.href;
    var entireUrlDividedIntoTwoParts = entireUrl.split("/");
    var domainName = entireUrlDividedIntoTwoParts[0] + "//" + entireUrlDividedIntoTwoParts[2];
    return domainName;
}



export default integrations;