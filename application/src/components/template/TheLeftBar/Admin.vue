<template>
  <div
    class="left side-menu"
    :class="mobile"
    @touchstart="touchMoveStart($event)"
    @touchmove="touchMoveEnd($event)"
    v-click-outside="hideMenu"
  >
    <!--- Sidemenu administrator role -->
    <el-menu
      :collapse="collapse"
      background-color="#373A43"
      text-color="#fff"
      :style="
        collapse == true
          ? 'border-right:0px !important;background-color'
          : 'width:230px;'
      "
      default-active="2"
      active-text-color="#00C0FD"
      class="el-menu-vertical-demo"
    >
      <!-- Logo -->
      <el-menu-item index="1" class="logo">
        <el-row>
          <!-- Profile -->
          <router-link to="/">
            <img :src="$getUrlToContents() + 'settings/' + logo + ''" />
          </router-link>
        </el-row>
      </el-menu-item>

      <router-link to="/home">
        <el-menu-item index="2" @click="hideNavLeft">
          <i class="dripicons-home"></i>

          <span class="menuMain">{{ lang['home-nav'] }}</span>
        </el-menu-item>
      </router-link>

      <router-link to="/dashboard">
        <el-menu-item index="3" @click="hideNavLeft">
          <i class="dripicons-graph-bar"></i>
          <span class="menuMain">{{ lang['dashboard-nav'] }}</span>
        </el-menu-item>
      </router-link>

      <el-submenu index="4">
        <template slot="title">
          <i class="dripicons-graduation"></i>
          <a href="javascript:void(0)" class="waves-effect">
            <span class="menuMain">{{ lang['courses-nav'] }}</span>
          </a>
        </template>

        <router-link to="/courses">
          <el-menu-item index="5" @click="hideNavLeft">
            <i class="dripicons-media-next"></i>
            <span class="menuMain">{{ lang['my-courses-nav'] }}</span>
          </el-menu-item>
        </router-link>

        <router-link to="/corrections">
          <el-menu-item
            index="25"
            v-if="plan != 'free' && plan != 'basic'"
            @click="hideNavLeft"
          >
            <i class="dripicons-message"></i>
            <span class="menuMain">{{ lang['corrections-nav'] }}</span>
          </el-menu-item>
        </router-link>

        <router-link to="/categories">
          <el-menu-item index="6" @click="hideNavLeft">
            <i class="dripicons-list"></i>
            <span class="menuMain">{{ lang['categories-nav'] }}</span>
          </el-menu-item>
        </router-link>

        <router-link to="/programs">
          <el-menu-item
            v-if="plan != 'free' && plan != 'basic'"
            index="7"
            @click="hideNavLeft"
          >
            <i class="dripicons-to-do"></i>
            <span class="menuMain">{{ lang['programs-nav'] }}</span>
          </el-menu-item>
        </router-link>
      </el-submenu>

      <el-submenu index="8">
        <template slot="title">
          <i class="dripicons-user"></i>
          <a href="javascript:void(0)" class="waves-effect">
            <span class="menuMain">{{ lang['persons-nav'] }}</span>
          </a>
        </template>

        <router-link to="/users">
          <el-menu-item index="9" @click="hideNavLeft">
            <i class="dripicons-user-id"></i>
            <span class="menuMain">{{ lang['users-nav'] }}</span>
          </el-menu-item>
        </router-link>

        <router-link to="/groups">
          <el-menu-item
            v-if="plan != 'free' && plan != 'basic'"
            index="10"
            @click="hideNavLeft"
          >
            <i class="dripicons-user-group"></i>
            <span class="menuMain">{{ lang['groups-nav'] }}</span>
          </el-menu-item>
        </router-link>

        <router-link to="/leads">
          <el-menu-item index="11" @click="hideNavLeft">
            <i class="dripicons-experiment"></i>
            <span class="menuMain">{{ lang['leads-nav'] }}</span>
          </el-menu-item>
        </router-link>
      </el-submenu>

      <router-link to="/site">
        <el-menu-item index="12" @click="hideNavLeft">
          <i class="dripicons-browser"></i>
          <span class="menuMain">{{ lang['site-nav'] }}</span>
        </el-menu-item>
      </router-link>

      <el-submenu v-if="plan != 'free' && plan != 'basic'" index="39">
        <template slot="title">
          <i class="dripicons-broadcast"></i>
          <a href="javascript:void(0)" class="waves-effect">
            <span class="menuMain">Social</span>
          </a>
        </template>

        <router-link to="/social">
          <el-menu-item index="36" @click="hideNavLeft">
            <i class="dripicons-feed"></i>
            <span class="menuMain">Feed</span>
          </el-menu-item>
        </router-link>

        <router-link to="/social/settings">
          <el-menu-item index="15" @click="hideNavLeft">
            <i class="dripicons-message"></i>
            <span class="menuMain">{{ lang['networks'] }}</span>
          </el-menu-item>
        </router-link>
      </el-submenu>

      <el-submenu index="13">
        <template slot="title">
          <i class="dripicons-gear"></i>
          <a href="javascript:void(0)" class="waves-effect">
            <span class="menuMain">{{ lang['settings-nav'] }}</span>
          </a>
        </template>

        <router-link to="/settings">
          <el-menu-item index="14" @click="hideNavLeft">
            <i class="dripicons-web"></i>
            <span class="menuMain">{{ lang['general-settings-nav'] }}</span>
          </el-menu-item>
        </router-link>

        <router-link to="/integrations">
          <el-menu-item index="15" @click="hideNavLeft">
            <i class="dripicons-cart"></i>
            <span class="menuMain">{{ lang['integrations-nav'] }}</span>
          </el-menu-item>
        </router-link>
      </el-submenu>

      <el-submenu index="16">
        <template slot="title">
          <i class="dripicons-information"></i>
          <a href="javascript:void(0)" class="waves-effect">
            <span class="menuMain">Sabiorealm</span>
          </a>
        </template>

        <router-link to="/plans">
          <el-menu-item index="17" @click="hideNavLeft">
            <i class="dripicons-rocket"></i>
            <span class="menuMain">{{ lang['plans-nav'] }}</span>
          </el-menu-item>
        </router-link>

        <router-link to="/helpcenter">
          <el-menu-item index="18" @click="hideNavLeft">
            <i class="dripicons-question"></i>
            <span class="menuMain">{{ lang['help-center-nav'] }}</span>
          </el-menu-item>
        </router-link>
      </el-submenu>

      <!-- User information -->
      <el-menu-item index="20" class="menu-item-user" v-if="collapse != true">
        <el-row>
          <!-- Profile -->
          <router-link to="/profile" class="pr-4">
            <el-avatar
              :src="$getUrlToContents() + 'avatar/' + userAvatar + ''"
            ></el-avatar>
          </router-link>

          <!-- Notification -->
          <a href="#">
            <i class="mdi mdi-bell mdi-18px pr-3 mr-0"></i>
          </a>

          <!-- Calendar -->
          <router-link to="calendar">
            <i class="mdi mdi-calendar mdi-18px pr-3 mr-0"></i>
          </router-link>

          <!-- Lofoff -->
          <a href="javascript:void(0)" @click="confirmLogout">
            <i class="mdi mdi-power-settings mdi-18px ml-0 pl-0"></i>
          </a>
        </el-row>
      </el-menu-item>
    </el-menu>
    <!--- End sidemenu administrator role -->
  </div>
  <!--- End main div -->
</template>

<script>
import router from '@/router';
import { eventTemplate } from '@/components/template/TheTopBar';
import { mapState } from 'vuex';

export default {
  props: ['collapse', 'logo', 'user-name', 'user-avatar', 'user-id', 'plan'],
  data: () => {
    return {
      mobile: 'retracted',
      prevMouseX: 0,
      swipedLeft: false
    };
  },
  mounted() {
    eventTemplate.$on('change-leftbar-class', () => {
      this.mobile === 'retracted'
        ? (this.mobile = 'opened')
        : (this.mobile = 'retracted');
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    hideMenu() {
      this.mobile = 'retracted';
    },
    confirmLogout() {
      this.$confirm(this.lang['wanna-leave'], {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning'
      }).then(() => {
        this.logout();
      });
    },
    logout() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'logout',
        'doLogout'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(() => {
        router.push('/');
      });
    },
    touchMoveStart(event) {
      this.swipedLeft = false;
      this.prevMouseX = event.touches[0].clientX;
    },
    touchMoveEnd(event) {
      if (
        this.prevMouseX > event.touches[0].clientX + 50 &&
        this.swipedLeft === false
      ) {
        eventTemplate.$emit('change-leftbar-class');
        this.swipedLeft = true;
      }
      this.prevMouseX = 0;
    },
    hideNavLeft() {
      eventTemplate.$emit('change-leftbar-class');
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.el-menu-item.logo,
.el-submenu__title.logo {
  line-height: none;
}

.logo {
  margin: 0 0 2rem 0;
}

.logo img {
  margin-left: 15%;
  padding: 0px;
  width: 120px;
  max-height: 100%;
  position: relative;
}

.el-menu-item i {
  margin-right: 15%;
}

.el-submenu i {
  margin-right: 15%;
}

.el-submenu i,
a {
  color: white;
  font-family: 'Montserrat', sans-serif;
}

.el-submenu a:hover {
  color: #00c0fd;
}

.el-menu-item i,
a {
  color: white;
  font-family: 'Montserrat', sans-serif;
}

.el-menu-item a:hover {
  color: #00c0fd;
}

.el-menu-item:hover {
  background-color: #2a2d35 !important;
}

.menu-item-user {
  background-color: #2a2d35 !important;
  padding-left: 20px;
  position: fixed;
  z-index: 9999;
  left: 0px;
  bottom: 0px;
  width: 230px;
  color: white;
  text-align: center;
  background-color: rgb(55, 58, 67);
}

@media only screen and (max-width: 768px) {
  .menu-item-user {
    position: absolute;
  }
}

.side-menu {
  overflow: overlay !important;
  height: 100%;
}
</style>
