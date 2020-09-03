<template>
  <!-- Footer secion -->
  <footer
    class="page-footer font-small blue"
    :style="styleFooter"
    v-loading="loadingFooter"
  >
    <div class="container">
      <div class="row">
        <div class="col-md-12 py-5">
          <div class="mb-5 flex-center">
            <!-- Facebook -->
            <a
              target="_blank"
              :href="element.url"
              v-for="element in socialMedias"
              :key="element.id"
            >
              <i
                v-if="element.name == 'facebook'"
                class="fab fa-facebook-f fa-lg white-text fa-2x social-icon"
              ></i>
              <i
                v-if="element.name == 'instagram'"
                class="fab fa-instagram fa-lg white-text fa-2x social-icon"
              ></i>
              <i
                v-if="element.name == 'linkedin'"
                class="fab fa-linkedin-in fa-lg white-text fa-2x social-icon"
              ></i>
              <i
                v-if="element.name == 'twitter'"
                class="fab fa-twitter fa-lg white-text fa-2x social-icon"
              ></i>
              <i
                v-if="element.name == 'pinterest'"
                class="fab fa-pinterest fa-lg white-text fa-2x social-icon"
              ></i>
              <i
                v-if="element.name == 'youtube'"
                class="fab fa-youtube fa-lg white-text fa-2x social-icon"
              ></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">
      © 2020 Copyright:
      <a href="#">{{ copyright }}</a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
</template>

<script>
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      loadingFooter: false,
      footerColor: '',
      copyright: '',
      socialMedias: []
    };
  },
  mounted() {
    this.listFooter();
  },
  computed: {
    styleFooter() {
      return {
        'background-color': this.footerColor + '!important'
      };
    },
    ...mapState(['lang'])
  },
  methods: {
    listFooter() {
      this.loadingFooter = true;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'builder',
        'listFooter'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.footerColor = response.data[0].color;
          this.copyright = response.data[0].copyright;
          this.loadingFooter = false;
          this.getSocialMedia();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getSocialMedia() {
      this.loading = true;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'social',
        'listing'
      );
      this.$request.post(urlToBeUsedInTheRequest).then(
        (response) => {
          this.socialMedias = response.data;
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.social-icon {
  margin: 0em 1em;
}
</style>
