<template>
  <div>
    <!--------
    Template base
    ---------->
    <TheHamburger />
    <top-bar
      v-if="
        loaded == true &&
        currentRoute != null &&
        currentRoute != 'marketplace' &&
        currentRoute != 'products' &&
        currentRoute != 'product' &&
        currentRoute != 'viewcourse' &&
        currentRoute != 'invalidsession' &&
        currentRoute != 'purchase' &&
        currentRoute != 'site' &&
        currentRoute != '404' &&
        currentRoute != 'auth'
      "
    ></top-bar>
    <div
      v-if="
        loaded == true &&
        currentRoute != null &&
        currentRoute != 'marketplace' &&
        currentRoute != 'products' &&
        currentRoute != 'product' &&
        currentRoute != 'viewcourse' &&
        currentRoute != 'invalidsession' &&
        currentRoute != 'purchase' &&
        currentRoute != 'site' &&
        currentRoute != '404' &&
        currentRoute != 'auth'
      "
    >
      <admin-left-bar
        :user-name="userName"
        :user-avatar="userAvatar"
        :user-id="userId"
        :plan="plan"
        :logo="logo"
        v-if="userRoleId == 1"
      ></admin-left-bar>
      <instructor-left-bar
        :user-name="userName"
        :user-avatar="userAvatar"
        :user-id="userId"
        :logo="logo"
        :plan="plan"
        v-if="userRoleId == 2"
      ></instructor-left-bar>
      <student-left-bar
        :user-name="userName"
        :user-avatar="userAvatar"
        :user-id="userId"
        :plan="plan"
        :logo="logo"
        v-if="userRoleId == 3"
      ></student-left-bar>
    </div>

    <transition name="fade" mode="out-in">
      <router-view v-if="loaded == true"></router-view>
      <div v-else id="loading"></div>
    </transition>
    <upgrade-plan></upgrade-plan>
    <the-trial-expired></the-trial-expired>
  </div>
</template>

<script>
import UpgradePlan from '@/components/plans/UpgradePlan';
import TheTrialExpired from '@/components/template/TheTrialExpired';
import AdminLeftBar from '@/components/template/TheLeftBar/Admin';
import InstructorLeftBar from '@/components/template/TheLeftBar/Instructor';
import StudentLeftBar from '@/components/template/TheLeftBar/Student';
/* eslint-disable */
import TopBar, { eventTemplate } from '@/components/template/TheTopBar';
import headerTags from '@/mixins/headerTags';
import integrations from '@/mixins/integrations';
import TheHamburger, {
  eventHamburger
} from './components/template/TheHamburger';

import { mapMutations } from 'vuex';

export default {
  mixins: [headerTags, integrations],
  data: () => {
    return {
      userRoleId: null,
      currentRoute: null,
      logo: '',
      userName: '',
      userAvatar: '',
      userId: '',
      plan: '',
      loaded: false
    };
  },
  components: {
    UpgradePlan,
    TheTrialExpired,
    AdminLeftBar,
    InstructorLeftBar,
    StudentLeftBar,
    TopBar,
    TheHamburger
  },
  watch: {
    $route() {
      this.currentRoute = this.$route.name;
      this.getCompanyInformation();
      this.getUserProfile();
      if (
        this.$route.name !== 'marketplace' &&
        this.$route.name !== 'invalidsession' &&
        this.$route.name !== 'products' &&
        this.$route.name !== 'product' &&
        this.$route.name !== '404' &&
        this.$route.name !== 'auth'
      ) {
        this.$verifySession();
      }
    }
  },
  created() {
    this.getLanguage();
    this.loadIntegrations();
    this.createFavicon();
  },
  mounted() {
    eventHamburger.$emit('showHamburger');
  },
  methods: {
    ...mapMutations(['setLang', 'setUser', 'setCompany']),
    getLanguage() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.logo = response.data.logo;
        const lang = require('../language/' +
          response.data.lang +
          '/lang.json');
        this.setLang(lang);
        this.getCompanyInformation();
      });
    },
    getCompanyInformation() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'company',
        'getCompanyInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.plan = response.data.plan;
        const companyObj = {
          plan: response.data.plan,
          country: response.data.country,
          name: response.data.name,
          subdomain: response.data.subdomain,
          expiration: response.data.expiration
        };
        this.setCompany(companyObj);
        this.getUserProfile();
      });
    },
    getUserProfile() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getUserProfile'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.userName = response.data.name;
        this.userAvatar = response.data.avatar;
        this.userId = response.data.id;
        this.userRoleId = response.data.myrole_id;
        const userObj = {
          name: response.data.name,
          email: response.data.email,
          id: response.data.id,
          role: response.data.myrole_id,
          avatar: response.data.avatar
        };
        this.setUser(userObj);
        if (this.userName == 'default') {
          this.$router.push('/registration').catch(() => {});
        }
        setTimeout(() => {
          this.loaded = true;
        }, 2000);
      });
    }
  }
};
</script>

<style>
#sbrmain {
  display: none;
}

.loaded {
  display: initial !important;
}

.hide {
  display: none !important;
}

#loading {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 100;
  width: 100vw;
  height: 100vh;
  background-color: white;
  background-image: url('https://sbrfiles.s3.amazonaws.com/gifs/loader.gif');
  background-repeat: no-repeat;
  background-position: center;
}

.fade-enter {
  opacity: 0;
}

.fade-enter-active {
  transition: all 0.4s ease;
}

.fade-leave-active {
  transition: opacity 0.4s ease;
  opacity: 0;
}
</style>
