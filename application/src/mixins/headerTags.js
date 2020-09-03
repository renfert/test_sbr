const headerTags = {
  methods: {
    createFavicon() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        const fav = response.data.favicon;
        const link = document.createElement('link');
        link.rel = 'icon';

        const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
          'verify',
          'getSubDomainName'
        );
        this.$request.get(urlToBeUsedInTheRequest).then((response) => {
          const subDomaiName = response.data;
          link.href =
            'https://files.sabiorealm.com/' +
            subDomaiName +
            '/uploads/settings/' +
            fav +
            '';
        });
        document.head.appendChild(link);
      });
    }
  }
};

export default headerTags;
