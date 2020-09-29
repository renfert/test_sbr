<template>
  <div class="left side-menu" :class="mobile">
    <!--- Sidemenu instructor role -->
    <el-menu
      :collapse="collapse"
      style="width: 230px"
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

      <router-link to="/home">
        <el-menu-item index="1">
          <i class="dripicons-home"></i>
          <span class="menuMain">{{ lang['home-nav'] }}</span>
        </el-menu-item>
      </router-link>

      <router-link to="/dashboard">
        <el-menu-item index="2">
          <i class="dripicons-graph-bar"></i>
          <span class="menuMain">{{ lang['dashboard-nav'] }}</span>
        </el-menu-item>
      </router-link>

      <router-link to="/courses">
        <el-menu-item index="3">
          <i class="dripicons-media-next"></i>
          <span class="menuMain">{{ lang['courses-nav'] }}</span>
        </el-menu-item>
      </router-link>

      <router-link to="/groups">
        <el-menu-item index="10">
          <i class="dripicons-user-group"></i>
          <span class="menuMain">{{ lang['groups-nav'] }}</span>
        </el-menu-item>
      </router-link>

      <router-link to="/programs">
        <el-menu-item index="4" v-if="plan != 'starter'">
          <i class="dripicons-to-do"></i>
          <span class="menuMain">{{ lang['programs-nav'] }}</span>
        </el-menu-item>
      </router-link>

      <router-link to="/corrections">
        <el-menu-item index="5" v-if="plan != 'starter'">
          <i class="dripicons-message"></i>
          <span class="menuMain">{{ lang['corrections-nav'] }}</span>
        </el-menu-item>
      </router-link>

      <router-link to="/categories">
        <el-menu-item index="6">
          <i class="dripicons-list"></i>
          <span class="menuMain">{{ lang['categories-nav'] }}</span>
        </el-menu-item>
      </router-link>

      <!-- User information -->
      <el-menu-item index="7" class="menu-item-user">
        <el-row>
          <!-- Profile -->
          <router-link class="pr-4" to="/profile">
            <el-avatar
              :src="$getUrlToContents() + 'avatar/' + userAvatar + ''"
            ></el-avatar>
          </router-link>

          <!-- Notification -->
          <a href="#">
            <i class="mdi mdi-bell mdi-18px pr-3 mr-0"></i>
          </a>

          <!-- Calendar -->
          <router-link to="/calendar">
            <i class="mdi mdi-calendar mdi-18px pr-3 mr-0"></i>
          </router-link>
          <!-- Lofoff -->
          <a href="javascript:void(0)" @click="confirmLogout">
            <i class="mdi mdi-power-settings mdi-18px ml-0 pl-0"></i>
          </a>
        </el-row>
      </el-menu-item>
    </el-menu>
  </div>
  <!--- End main div -->
</template>

<script>
import router from '@/router';
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
        router.push('/marketplace');
      });
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
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

@media only screen and (max-width: 600px) {
  .menu-item-user {
    position: absolute;
  }
}

.side-menu {
  overflow: overlay !important;
}
</style>
