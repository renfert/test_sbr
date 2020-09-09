<template>
  <div class="left side-menu" :class="mobile">
    <!--- Sidemenu student role -->
    <el-menu
      style="width: 230px"
      :collapse="collapse"
      background-color="#373A43"
      text-color="#fff"
      active-text-color="#00C0FD"
      class="el-menu-vertical-demo"
    >
      <!-- Logo -->
      <el-menu-item index="0" class="logo">
        <el-row>
          <!-- Profile -->
          <router-link to="/">
            <img :src="$getUrlToContents() + 'settings/' + logo + ''" />
          </router-link>
        </el-row>
      </el-menu-item>

      <el-menu-item index="1">
        <i class="dripicons-home" />
        <router-link to="/home">
          <span class="menuMain">{{ lang['home-nav'] }}</span>
        </router-link>
      </el-menu-item>

      <el-menu-item index="2">
        <i class="dripicons-graph-bar" />
        <router-link to="/dashboard">
          <span class="menuMain">{{ lang['dashboard-nav'] }}</span>
        </router-link>
      </el-menu-item>

      <el-menu-item index="3">
        <i class="dripicons-media-next" />
        <router-link to="/courses">
          <span class="menuMain">{{ lang['courses-nav'] }}</span>
        </router-link>
      </el-menu-item>

      <el-menu-item v-if="plan != 'starter'" index="4">
        <i class="dripicons-to-do" />
        <router-link to="/programs">
          <span class="menuMain">{{ lang['programs-nav'] }}</span>
        </router-link>
      </el-menu-item>

      <el-menu-item v-if="plan != 'starter'" index="5">
        <i class="dripicons-copy" />
        <router-link to="/records">
          <span class="menuMain">{{ lang['school-records'] }}</span>
        </router-link>
      </el-menu-item>

      <el-menu-item v-if="plan != 'starter'" index="6">
        <i class="dripicons-star" />
        <router-link to="/certificates">
          <span class="menuMain">{{ lang['certificates-nav'] }}</span>
        </router-link>
      </el-menu-item>

      <!-- User information -->
      <el-menu-item index="7" class="menu-item-user">
        <el-row>
          <!-- Profile -->
          <router-link class="pr-4" to="/profile">
            <el-avatar
              :src="$getUrlToContents() + 'avatar/' + userAvatar + ''"
            />
          </router-link>

          <!-- Notification -->
          <a href="#">
            <i class="mdi mdi-bell mdi-18px pr-3 mr-0" />
          </a>

          <!-- Calendar -->
          <router-link to="/calendar">
            <i class="mdi mdi-calendar mdi-18px pr-3 mr-0" />
          </router-link>
          <!-- Lofoff -->
          <a href="javascript:void(0)" @click="confirmLogout">
            <i class="mdi mdi-power-settings mdi-18px ml-0 pl-0" />
          </a>
        </el-row>
      </el-menu-item>
    </el-menu>
  </div>
  <!--- End main div -->
</template>

<script>
import { mapState } from 'vuex';
import { eventTemplate } from '@/components/template/TheTopBar';

export default {
  props: ['collapse', 'logo', 'user-name', 'user-avatar', 'user-id', 'plan'],
  data: () => {
    return {
      mobile: 'retracted'
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  mounted() {
    eventTemplate.$on('change-leftbar-class', () => {
      this.mobile === 'retracted'
        ? (this.mobile = 'opened')
        : (this.mobile = 'retracted');
    });
  },
  methods: {
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
        window.location.href = this.$getDomainNameToNavigation();
      });
    }
  }
};
</script>

<style lang="scss" scoped>
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

.side-menu {
  overflow: overlay !important;
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
</style>
