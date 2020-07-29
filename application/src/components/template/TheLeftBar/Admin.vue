<template>
  <div class="left side-menu" :class="mobile">
    <!--- Sidemenu administrator role -->
    <el-menu
      :collapse="collapse"
      background-color="#373A43"
      text-color="#fff"
      :style="
        collapse == true ? 'border-right:0px !important;' : 'width:230px;'
      "
      default-active="2"
      active-text-color="#00C0FD"
      class="el-menu-vertical-demo"
    >
      <el-menu-item index="1">
        <i class="dripicons-home"></i>
        <router-link to="home">
          <span class="menuMain">{{ lang["home-nav"] }}</span>
        </router-link>
      </el-menu-item>

      <el-menu-item index="1">
        <i class="dripicons-graph-bar"></i>
        <router-link to="dashboard">
          <span class="menuMain">{{ lang["dashboard-nav"] }}</span>
        </router-link>
      </el-menu-item>

      <el-submenu index="2">
        <template slot="title">
          <i class="dripicons-graduation"></i>
          <a href="javascript:void(0)" class="waves-effect">
            <span class="menuMain">{{ lang["courses-nav"] }}</span>
          </a>
        </template>

        <el-menu-item index="3">
          <i class="dripicons-media-next"></i>
          <router-link to="courses">
            <span class="menuMain">{{ lang["my-courses-nav"] }}</span>
          </router-link>
        </el-menu-item>

        <el-menu-item index="4">
          <i class="dripicons-list"></i>
          <router-link to="categories">
            <span class="menuMain">{{ lang["categories-nav"] }}</span>
          </router-link>
        </el-menu-item>

        <el-menu-item index="5">
          <i class="dripicons-to-do"></i>
          <a href="programs" class="waves-effect">
            <span class="menuMain">{{ lang["programs-nav"] }}</span>
          </a>
        </el-menu-item>
      </el-submenu>

      <el-submenu index="7">
        <template slot="title">
          <i class="dripicons-user"></i>
          <a href="javascript:void(0)" class="waves-effect">
            <span class="menuMain">{{ lang["persons-nav"] }}</span>
          </a>
        </template>

        <el-menu-item index="8">
          <i class="dripicons-user-id"></i>
          <a href="users" class="waves-effect">
            <span class="menuMain">{{ lang["users-nav"] }}</span>
          </a>
        </el-menu-item>

        <el-menu-item index="9">
          <i class="dripicons-user-group"></i>
          <a href="groups" class="waves-effect">
            <span class="menuMain">{{ lang["groups-nav"] }}</span>
          </a>
        </el-menu-item>

        <el-menu-item index="10">
          <i class="dripicons-experiment"></i>
          <a href="leads" class="waves-effect">
            <span class="menuMain">{{ lang["leads-nav"] }}</span>
          </a>
        </el-menu-item>
      </el-submenu>

      <el-menu-item index="11">
        <i class="dripicons-browser"></i>
        <a href="site" class="waves-effect">
          <span class="menuMain">{{ lang["site-nav"] }}</span>
        </a>
      </el-menu-item>

      <el-submenu index="12">
        <template slot="title">
          <i class="dripicons-gear"></i>
          <a href="javascript:void(0)" class="waves-effect">
            <span class="menuMain">{{ lang["settings-nav"] }}</span>
          </a>
        </template>

        <el-menu-item index="13">
          <i class="dripicons-web"></i>
          <a href="settings" class="waves-effect">
            <span class="menuMain">{{ lang["general-settings-nav"] }}</span>
          </a>
        </el-menu-item>

        <el-menu-item index="14">
          <i class="dripicons-cart"></i>
          <a href="integrations" class="waves-effect">
            <span class="menuMain">{{ lang["integrations-nav"] }}</span>
          </a>
        </el-menu-item>
      </el-submenu>

      <el-submenu index="16">
        <template slot="title">
          <i class="dripicons-information"></i>
          <a href="javascript:void(0)" class="waves-effect">
            <span class="menuMain">Sabiorealm</span>
          </a>
        </template>

        <el-menu-item index="17">
          <i class="dripicons-rocket"></i>
          <a href="plans" class="waves-effect">
            <span class="menuMain">{{ lang["plans-nav"] }}</span>
          </a>
        </el-menu-item>

        <el-menu-item index="18">
          <i class="dripicons-question"></i>
          <a href="helpcenter" class="waves-effect">
            <span class="menuMain">{{ lang["help-center-nav"] }}</span>
          </a>
        </el-menu-item>
      </el-submenu>

      <!-- User information -->
      <el-menu-item index="17" class="menu-item-user" v-if="collapse != true">
        <el-row>
          <!-- Profile -->
          <a href="profile" class="pr-4 mb-2">
            <el-avatar :src="getUrlToContents() + 'avatar/' + userAvatar + ''"></el-avatar>
          </a>

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
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import { mapState } from "vuex";
import { eventBus } from "@/pages/profile/App";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
export const eventTemplate = new Vue();

Vue.use(VueAxios, axios);
export default {
  mixins: [domains, alerts],
  props: ["collapse"],
  data: () => {
    return {
      userName: "",
      userAvatar: "",
      plan: "",
      mobile: "retracted"
    };
  },
  created: function() {
    this.getCompanyInformation();
    this.getUserProfile();
  },
  mounted() {
    eventBus.$on(
      "profile-edited",
      function() {
        this.getUserProfile();
      }.bind(this)
    );

    eventTemplate.$on(
      "change-leftbar-class",
      function() {
        this.mobile == "retracted"
          ? (this.mobile = "opened")
          : (this.mobile = "retracted");
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getUserProfile() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.userName = response.data["name"];
          this.userAvatar = response.data["avatar"];
        }.bind(this)
      );
    },
    getCompanyInformation() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "company",
        "getCompanyInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.plan = response.data["plan"];
        }.bind(this)
      );
    },
    confirmLogout: function() {
      this.$confirm(this.lang["wanna-leave"], {
        confirmButtonText: "OK",
        cancelButtonText: "Cancel",
        type: "warning"
      }).then(() => {
        this.logout();
      });
    },
    logout: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "logout",
        "doLogout"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function() {
          window.location.href = this.getDomainNameToNavigation();
        }.bind(this)
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.el-menu {
  border-right: solid 0px #e6e6e6 !important;
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
  font-family: "Montserrat", sans-serif;
}

.el-submenu a:hover {
  color: #00c0fd;
}

.el-menu-item i,
a {
  color: white;
  font-family: "Montserrat", sans-serif;
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
</style>
