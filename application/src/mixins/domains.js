const domains = {
    methods: {
        getCurrentDomainName(){
            var domainName =  getDomain();
            if(process.env.NODE_ENV === 'production'){
                return domainName + '/';
            }else{
                return process.env.VUE_APP_URL_DEV;
            }
        },
        getUrlToMakeRequest(controler,model){
            var domainName =  getDomain();
            var url = process.env.NODE_ENV === 'production' ? ''+domainName+'/'+controler+'/'+model : ''+process.env.VUE_APP_URL_DEV+controler+'/'+model
            return url;
        },
        getDomainNameToNavigation(){
            if(process.env.NODE_ENV === 'production'){
                return this.getCurrentDomainName();
            }else{
                return 'http://localhost:8080/';
            }
        },
        getUrlParameters(){
            var url = window.location.href;
            var params = {};
            var parser = document.createElement('a');
            parser.href = url;
            var query = parser.search.substring(1);
            var vars = query.split('&');
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split('=');
                params[pair[0]] = decodeURIComponent(pair[1]);
            }
            return params;
        }
    }
}

function getDomain(){
    var entireUrl = window.location.href;
    var entireUrlDividedIntoTwoParts = entireUrl.split("/");
    var domainName = entireUrlDividedIntoTwoParts[0] + "//" + entireUrlDividedIntoTwoParts[2];
    return domainName;
}

export default domains;