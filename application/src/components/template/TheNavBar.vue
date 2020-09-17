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
          <router-link to="/products" replace>
            <span>{{ lang['courses'] }}</span>
          </router-link>
        </li>

        <li v-for="element in links" :key="element.id">
          <a :href="element.url" :target="element.target">
            {{ element.title }}
          </a>
        </li>

        <!-- Login button -->
        <li class="pt-5" v-if="activeSession == false">
          <a
            class="link-button"
            href="javascript:void(0)"
            :style="linkButtonMobile"
            @click.prevent="openLoginModal()"
            >Login</a
          >
        </li>

        <li class="pt-5" v-else>
          <router-link to="/home">
            <span class="link-button" :style="linkButtonMobile">{{
              lang['go-to-platform']
            }}</span>
          </router-link>
        </li>
      </ul>
    </div>

    <header :style="styleHeader">
      <router-link to="/">
        <img class="logo-nav" :src="logo" :width="logoSize" />
      </router-link>

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
          <router-link to="/products">
            <span>{{ lang['courses'] }}</span>
          </router-link>
        </li>

        <!-- Links -->
        <li v-for="element in links" :key="element.id">
          <a :href="element.url" :target="element.target">
            {{ element.title }}
          </a>
        </li>

        <!-- Login button -->
        <li v-if="activeSession == false">
          <a
            class="link-button"
            href="javascript:void(0)"
            @click.prevent="openLoginModal()"
            >Login</a
          >
        </li>

        <li v-else>
          <router-link to="/home">
            <span class="link-button">{{ lang['go-to-platform'] }}</span>
          </router-link>
        </li>
      </ul>
    </header>
    <!-- End Navbar -->
    <login></login>
  </div>
</template>

<script>
/* eslint-disable */
import Login from '@/components/login/Login';
import { eventBus } from '@/components/site/App';
import { eventLogin } from '@/components/login/Login';
import { mapState } from 'vuex';

export default {
  props: ['full-screen-button'],
  components: {
    Login
  },
  data: () => {
    return {
      logo: '',
      logoSize: '',
      sections: null,
      loadingHeader: false,
      loadingSection: false,
      loadingFooter: false,
      footerColor: '',
      copyright: '',
      links: [],
      socialMedias: [],
      headerColor: '',
      activeSession: false,
      showMobile: false,
      primaryColor: '',
      navMobile: 'display:initial !important'
    };
  },
  mounted() {
    eventLogin.$on('new-login', () => {
      this.getSession();
    });

    this.getSession();
    this.getPrimaryColor();
    this.listHeader();
    this.navBarSticky();
  },
  computed: {
    styleHeader() {
      return {
        'background-color':
          this.headerColor === 'transparent'
            ? this.primaryColor
            : this.headerColor,
        width: '100%'
      };
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
    ...mapState(['lang'])
  },
  methods: {
    toogleSidebar() {
      this.showMobile === true
        ? (this.showMobile = false)
        : (this.showMobile = true);
    },
    enterPlatform() {
      window.location.href = 'home';
    },
    openLoginModal() {
      eventLogin.$emit('open-login-modal');
    },
    navBarSticky() {
      window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        header.classList.toggle('sticky', window.scrollY > 0);
      });
    },
    listHeader() {
      this.loadingHeader = true;
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
          this.logoSize = response.data[0].logo_size + '%';
          this.headerColor = response.data[0].color;
          this.loadingHeader = false;
          this.updateLinkListArray();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    changeMobileButtonClass() {
      if (this.navMobile === 'display:none !important;') {
        this.navMobile = 'display:initial !important;';
      } else {
        this.navMobile = 'display:none !important;';
      }
    },
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
          this.updateSocialMediaListArray();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    fullScreen() {
      eventBus.$emit('full-screen');
    },
    updateSectionListArray() {
      this.loadingSection = true;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'section',
        'listing'
      );
      this.$request.post(urlToBeUsedInTheRequest).then(
        (response) => {
          this.sections = response.data;
          this.loadingSection = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    updateLinkListArray() {
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
/* =============
    Navbar style

    - Header
    - Sticky
    - Mobile
    - Button

============= */

/* =============
Header
============= */
header {
  position: relative;
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
  height: 75px;
  padding: 0px 15%;
  background-color: white;
  animation: smoothScroll 1.2s forwards;
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
</style>
