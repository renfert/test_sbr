<template>
  <div class="left side-menu" :class="mobile">
    <!--- Sidemenu instructor role -->
    <el-menu
      v-if="roleId == 2"
      :collapse="collapse"
      style="width:230px"
      background-color="#373A43"
      text-color="#fff"
      active-text-color="#00C0FD"
      class="el-menu-vertical-demo"
    >
      <el-menu-item index="1">
        <i class="dripicons-home"></i>
        <a href="home" class="waves-effect">
          <span class="menuMain">{{ lang["home-nav"] }}</span>
        </a>
      </el-menu-item>

      <el-menu-item index="1">
        <i class="dripicons-graph-bar"></i>
        <a :href="getDomainNameToNavigation() + 'dashboard'" class="waves-effect">
          <span class="menuMain">{{ lang["dashboard-nav"] }}</span>
        </a>
      </el-menu-item>

      <el-menu-item index="2">
        <i class="dripicons-media-next"></i>
        <a :href="getDomainNameToNavigation() + 'courses'" class="waves-effect">
          <span class="menuMain">{{ lang["courses-nav"] }}</span>
        </a>
      </el-menu-item>

      <el-menu-item index="3" v-if="plan != 'starter'">
        <i class="dripicons-to-do"></i>
        <a :href="getDomainNameToNavigation() + 'programs'" class="waves-effect">
          <span class="menuMain">{{ lang["programs-nav"] }}</span>
        </a>
      </el-menu-item>

      <el-menu-item index="4" v-if="plan != 'starter'">
        <i class="dripicons-message"></i>
        <a :href="getDomainNameToNavigation() + 'corrections'" class="waves-effect">
          <span class="menuMain">{{ lang["corrections-nav"] }}</span>
        </a>
      </el-menu-item>

      <el-menu-item index="4">
        <i class="dripicons-list"></i>
        <a :href="getDomainNameToNavigation() + 'categories'" class="waves-effect">
          <span class="menuMain">{{ lang["categories-nav"] }}</span>
        </a>
      </el-menu-item>

      <!-- User information -->
      <el-menu-item index="17" class="menu-item-user">
        <el-row>
          <!-- Profile -->
          <a :href="getDomainNameToNavigation() + 'profile'" class="pr-4">
            <el-avatar :src="getUrlToContents() + 'avatar/' + userAvatar + ''"></el-avatar>
          </a>

          <!-- Notification -->
          <a href="#">
            <i class="mdi mdi-bell mdi-18px pr-3 mr-0"></i>
          </a>

          <!-- Calendar -->
          <a :href="getDomainNameToNavigation() + 'calendar'">
            <i class="mdi mdi-calendar mdi-18px pr-3 mr-0"></i>
          </a>

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
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import { mapState } from "vuex";
import { eventBus } from "@/components/profile/App";
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
  computed: {
    ...mapState(["lang"])
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
  methods: {
    getUserProfile() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.roleId = response.data["myrole_id"];
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
