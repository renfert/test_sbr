<template>
  <div>
    <!-- Navbar -->
    <div v-if="showMobile" class="sidebar-mobile">
      <span @click.prevent="toogleSidebar" class="sidebar-mobile-close-button"
        >✕</span
      >
      <ul>
        <!-- Products -->
        <li>
          <router-link to="products">
            <span>{{ lang['courses'] }}</span>
          </router-link>
        </li>

        <li v-for="element in links" :key="element.id">
          <a :href="element.url" :target="element.target">{{
            element.title
          }}</a>
        </li>

        <!-- Login button -->
        <li class="pt-5" v-if="activeSession == false">
          <a href="javascript:void(0)" @click.prevent="openLoginModal()">
            <span class="link-button" :style="linkButtonMobile">Login</span>
          </a>
        </li>

        <li class="pt-5" v-else>
          <router-link to="home">
            <span class="link-button" :style="linkButtonMobile">{{
              lang['go-to-platform']
            }}</span>
          </router-link>
        </li>
      </ul>
    </div>

    <header :style="this.styleHeader">
      <a :href="$getDomainNameToNavigation()">
        <img
          v-if="stickyMode == false && logo != null"
          class="logo-nav"
          :src="logo"
          :width="logoSize"
        />
        <img v-else class="logo-nav" :src="logoSticky" :width="logoSize" />
      </a>

      <!-- Icon menu for mobile -->
      <ul class="ul-mobile">
        <li>
          <a @click.prevent="toogleSidebar" href="javascript:void(0)">
            <i class="ti-menu"></i>
          </a>
        </li>
      </ul>

      <ul class="ul-landscape">
        <!-- Products -->
        <li>
          <router-link to="products">
            <span>{{ lang['courses'] }}</span>
          </router-link>
        </li>

        <!-- Links -->
        <li v-for="element in links" :key="element.id">
          <a :href="element.url" :target="element.target">{{
            element.title
          }}</a>
        </li>

        <!-- Login button -->
        <li v-if="activeSession == false">
          <a href="javascript:void(0)" @click.prevent="openLoginModal()">
            <span class="link-button">Login</span>
          </a>
        </li>

        <li v-else>
          <router-link to="home">
            <span class="link-button">{{ lang['go-to-platform'] }}</span>
          </router-link>
        </li>
      </ul>
    </header>
    <!-- End Navbar -->

    <!-- Body section -->
    <section v-for="element in sections" :key="element.id">
      <banner :section-id="element.id" v-if="element.banner_id != 1"></banner>
      <testimonial
        :section-id="element.id"
        v-if="element.testimonial_id != 1"
      ></testimonial>
      <product-list
        :section-id="element.id"
        v-if="element.product_list_id != 1"
      ></product-list>
      <text-and-media
        :section-id="element.id"
        v-if="element.text_and_media_id != 1"
      ></text-and-media>
    </section>

    <!-- Footer secion -->
    <footer class="page-footer font-small blue top-10" :style="styleFooter">
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
                  class="fab fa-pinterest fa-lg white-text fa-2x"
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

    <!-- Float expand button -->
    <div
      v-if="fullScreenButton == true"
      id="container-floating"
      @click.prevent="fullScreen()"
    >
      <div id="floating-button">
        <p class="full">
          <i class="el-icon-full-screen"></i>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import Banner from '@/components/site/section/elements/get/Banner';
import Testimonial from '@/components/site/section/elements/get/Testimonial';
import ProductList from '@/components/site/section/elements/get/ProductList';
import TextAndMedia from '@/components/site/section/elements/get/TextAndMedia';

import { eventLogin } from '@/components/login/Login';
import { eventBus } from '@/components/site/App';
import { mapState } from 'vuex';

export default {
  props: ['full-screen-button'],
  components: {
    Banner,
    Testimonial,
    ProductList,
    TextAndMedia
  },
  data: () => {
    return {
      logo: null,
      logoSticky: '',
      logoSize: '',
      sections: null,
      loading: false,
      footerColor: '',
      copyright: '',
      primaryColor: '',
      links: [],
      socialMedias: [],
      headerColor: '',
      activeSession: false,
      showMobile: false,
      stickyMode: false,

      key: 0,

      fullScreenMode: false
    };
  },
  created() {
    this.navBarSticky();
    this.getPrimaryColor();
    this.getSession();
  },
  mounted() {
    this.getHeader();
    this.getBody();
    this.getFooter();

    // When link`s change
    eventBus.$on('link-list-update', () => {
      this.getLinks();
    });

    // When change header
    eventBus.$on('new-change-header', () => {
      this.getHeader();
    });

    // When new section
    eventBus.$on('new-section', () => {
      this.getBody();
    });

    // When delete section
    eventBus.$on('delete-section', () => {
      this.getBody();
    });

    // When reorder section
    eventBus.$on('reorder-section', () => {
      this.getBody();
    });
  },
  computed: {
    ...mapState(['lang']),
    styleHeader() {
      if (this.$route.name === 'site') {
        if (this.fullScreenMode === true) {
          return {
            'background-color': this.headerColor,
            width: '100%'
          };
        } else {
          return {
            'background-color': this.headerColor,
            width: '80%'
          };
        }
      } else {
        return {
          'background-color': this.headerColor,
          width: '100%'
        };
      }
    },
    styleBorder() {
      return {
        border:
          this.headerColor === 'transparent'
            ? '1px solid #969bb5'
            : '1px solid white',
        padding: '5px 15px 5px 15px'
      };
    },
    linkButtonMobile() {
      return {
        color: '#fff',
        border: '1px solid ' + this.primaryColor + '',
        'background-color': this.primaryColor
      };
    },
    styleFooter() {
      return {
        'background-color': this.footerColor + '!important'
      };
    }
  },
  methods: {
    navBarSticky() {
      window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        header.classList.toggle('sticky', window.scrollY > 0);

        if (window.scrollY > 0) {
          this.stickyMode = true;
        } else {
          this.stickyMode = false;
        }
      });

      window.addEventListener('touchmove', () => {
        if (this.stickyMode === false) {
          const header = document.querySelector('header');
          header.classList.toggle('sticky');
          this.stickyMode = true;
        }
      });
    },
    toogleSidebar() {
      this.showMobile === true
        ? (this.showMobile = false)
        : (this.showMobile = true);
    },
    openLoginModal() {
      eventLogin.$emit('open-login-modal');
    },
    getHeader() {
      this.loading = true;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'builder',
        'listHeader'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.logo =
            this.$getUrlToContents() +
            'builder/header/' +
            response.data[0].logo +
            '';
          this.logoSticky =
            this.$getUrlToContents() +
            'builder/header/' +
            response.data[0].logo_sticky +
            '';
          this.logoSize = response.data[0].logo_size + '%';
          this.headerColor = response.data[0].color;
          this.loading = false;
          this.getLinks();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getFooter() {
      this.loading = true;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'builder',
        'listFooter'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.footerColor = response.data[0].color;
          this.copyright = response.data[0].copyright;
          this.loading = false;
          this.updateSocialMediaListArray();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    fullScreen() {
      if (this.fullScreenMode === false) {
        this.fullScreenMode = true;
      } else {
        this.fullScreenMode = false;
      }
      eventBus.$emit('full-screen');
    },
    getBody() {
      this.loading = true;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'section',
        'listing'
      );
      this.$request.post(urlToBeUsedInTheRequest).then(
        (response) => {
          this.sections = response.data;
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getLinks() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'link',
        'listing'
      );
      this.$request.post(urlToBeUsedInTheRequest).then(
        (response) => {
          this.links = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    updateSocialMediaListArray() {
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
    },
    getPrimaryColor() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );
      this.$request.post(urlToBeUsedInTheRequest).then(
        (response) => {
          this.primaryColor = response.data.color;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getSession() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'Mysessions',
        'activeSession'
      );
      this.$request.post(urlToBeUsedInTheRequest).then(
        (response) => {
          this.activeSession = response.data;
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
#floating-button {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  background: #09aec7;
  position: fixed;
  bottom: 30px;
  right: 30px;
  cursor: pointer;
  box-shadow: 0px 2px 5px #0e8496;
  padding: 10px;
}

.full {
  color: white;
  font-size: 15px;
  top: 0;
  display: block;
  bottom: 0;
  left: 0;
  right: 0;
  text-align: center;
  padding: 0;
  margin-top: 0;
  animation: plus-out 0.3s;
  transition: all 0.3s;
}

#container-floating {
  position: fixed;
  width: 70px;
  height: 70px;
  bottom: 30px;
  right: 30px;
  z-index: 50px;
}

#container-floating:hover {
  height: 400px;
  width: 90px;
  padding: 30px;
}

/* =============

    - Header
    - Layout
    - Sticky
    - Mobile
    - Button

============= */

/* =============
   Layout
============= */

.top-10 {
  margin-top: 10%;
}

/* =============
   Header
============= */
header {
  position: fixed;
  top: 0;
  width: 100%;
  height: 90px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transform: 0.4s;
  z-index: 2000;
  transition: 0.2s;
}

header a {
  flex: 0 0 20%;
  margin-left: 15%;
}

header ul {
  position: relative;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin: 0px !important;
  margin-right: 15% !important;
}

header ul li {
  position: relative;
  list-style: none;
}

header ul li a {
  position: relative;
  margin: 0 15px;
  font-weight: 500;
  transition: 0.5s;
  color: white;
  font-size: 1.3em;
  font-family: 'Poppins', sans-serif;
}

/* =============
sticky
============= */
header.sticky {
  position: fixed;
  box-shadow: 0px 0px 3px 0px #aca9a9;
  background-color: white !important;
  height: 75px;
  animation: smoothScroll 1.2s forwards;
}

header.sticky ul li a,
header.sticky ul li a span.link-button {
  color: #4a5682 !important;
}

header.sticky ul li a span.link-button {
  border: 2px solid #4a5682;
}

@keyframes smoothScroll {
  0% {
    transform: translateY(-40px);
  }
  100% {
    transform: translateY(0px);
  }
}

/* =============
Mobile
============= */

.ul-mobile {
  display: none;
}

.sidebar-mobile {
  position: fixed;
  overflow-y: auto;
  left: 0;
  background-color: #1c2138;
  width: 90%;
  height: 100vh;
  z-index: 3000 !important;
  animation: hideLeftBar 1s;
}

@keyframes hideLeftBar {
  0% {
    transform: translateX(-100px);
  }
  100% {
    transform: translateX(0px);
  }
}

.sidebar-mobile-close-button {
  width: 30px;
  height: 40px;
  margin: 10px 7px;
  display: none;
  float: right;
  color: #70798b;
  font-size: 26px;
  cursor: pointer;
  display: block;
}

.sidebar-mobile ul {
  width: 100%;
  float: left;
  padding: 0 !important;
  margin-top: 10%;
}

.sidebar-mobile ul li {
  list-style: none;
  border-top: solid 1px #2d3454;
  padding: 10px 30px;
}

.sidebar-mobile ul li a {
  position: relative;
  font-weight: 500;
  transition: 0.5s;
  color: white;
  font-size: 1.2em;
  font-family: 'Poppins', sans-serif;
}

.ul-landscape {
  width: 100%;
}

@media only screen and (max-width: 1024px) {
  .logo-nav {
    width: 80px !important;
  }
  .ul-landscape {
    display: none;
  }
  .ul-mobile {
    display: initial;
  }
  header {
    height: 90px;
  }
  header ul li a {
    font-size: 2em;
  }
}

/* =============
Button
============= */
.link-button {
  border: 1.2px solid white;
  border-radius: 5px;
  padding: 8px 18px 8px 18px;
}

.social-icon {
  margin: 0em 1em;
}
</style>
