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
      const url =
        process.env.NODE_ENV === 'production'
          ? this.company.domain + '/' + controler + '/' + model
          : process.env.VUE_APP_URL_DEV + controler + '/' + model;
      return url;
    }
  }
};

export default domains;
