import { mapState } from 'vuex';
const domains = {
  computed: {
    ...mapState(['company'])
  },
  methods: {
    $getCurrentDomainName() {
      const domainName = getDomain();
      if (process.env.NODE_ENV === 'production') {
        return domainName + '/';
      } else {
        return process.env.VUE_APP_URL_DEV;
      }
    },

    $getUrlToContents() {
      const url =
        'https://files.sabiorealm.com/' + this.company.subdomain + '/uploads/';
      return url;
    },
    $getUrlToMakeRequest(controler, model) {
      const domainName = getDomain();
      const url =
        process.env.NODE_ENV === 'production'
          ? '' + domainName + '/' + controler + '/' + model
          : '' + process.env.VUE_APP_URL_DEV + controler + '/' + model;
      return url;
    },
    $getDomainNameToNavigation() {
      if (process.env.NODE_ENV === 'production') {
        return this.getCurrentDomainName();
      } else {
        return 'http://localhost:8080/';
      }
    },
    $getUrlParameters() {
      const url = window.location.href;
      const params = {};
      const parser = document.createElement('a');
      parser.href = url;
      const query = parser.search.substring(1);
      const vars = query.split('&');
      for (let i = 0; i < vars.length; i++) {
        const pair = vars[i].split('=');
        params[pair[0]] = decodeURIComponent(pair[1]);
      }
      return params;
    }
  }
};

function getDomain() {
  const entireUrl = window.location.href;
  const entireUrlDividedIntoTwoParts = entireUrl.split('/');
  const domainName =
    entireUrlDividedIntoTwoParts[0] + '//' + entireUrlDividedIntoTwoParts[2];
  return domainName;
}

export default domains;
