import { mapState } from 'vuex';
const domains = {
  data: () => {
    return {
      domain: ''
    };
  },
  computed: {
    ...mapState(['company'])
  },
  methods: {
    $getCurrentDomainName() {
      if (process.env.NODE_ENV === 'production') {
        return this.company.subdomain + '/';
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
