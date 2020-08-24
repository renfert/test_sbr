import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios)
const headerTags = {
    methods: {
        createFavicon(){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("settings", "getSettingsInformation");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                var fav = response.data["favicon"]
                const link = document.createElement('link');
                link.rel = "icon";

                var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("verify", "getSubDomainName");
                axios.get(urlToBeUsedInTheRequest).then((response) => {
                    var subDomaiName = response.data;
                    link.href = "https://files.sabiorealm.com/"+subDomaiName+"/uploads/settings/"+fav+""
                });

            
                document.head.appendChild(link); 
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



export default headerTags;