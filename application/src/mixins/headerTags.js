const headerTags = {
  methods: {
    createFavicon() {
      let urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      this.$request.get(urlToBeUsedInTheRequest).then(response => {
        var fav = response.data["favicon"];
        const link = document.createElement("link");
        link.rel = "icon";

        let urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
          "verify",
          "getSubDomainName"
        );
        this.$request.get(urlToBeUsedInTheRequest).then(response => {
          var subDomaiName = response.data;
          link.href =
            "https://files.sabiorealm.com/" +
            subDomaiName +
            "/uploads/settings/" +
            fav +
            "";
        });
        document.head.appendChild(link);
      });
    }
  }
};

export default headerTags;
