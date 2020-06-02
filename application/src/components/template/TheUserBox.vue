<template>
  <!-- User box -->
  <div class="user-box">
    <a href="profile">
      <div class="user-img">
          <img :src="''+getCurrentDomainName()+'assets/uploads/avatar/' + imageUserProfile" alt="user-img"  class="rounded-circle img-thumbnail img-responsive">
      </div>
    </a>
    <h5><a href="profile">{{username}}</a> </h5>
    <ul class="list-inline">
      <li class="list-inline-item">
        <a @click.prevent="logoff" href="javascrit.void(0)" class="text-default">
          <i class="mdi mdi-power mdi-18px"></i>
        </a>
      </li>
    </ul>
  </div>
</template>



<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios)
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'


export default {
  mixins: [domains,alerts],
  data: () => {
    return {
      username: '',
      imageUserProfile: '',
    }
  },
  created(){
    this.getUserProfile();
  },
  methods:{
    getUserProfile(){
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserProfile");
      axios.get( urlToBeUsedInTheRequest).then(function (response) {
        this.username = response.data["name"];
        this.imageUserProfile = response.data["avatar"];
      }.bind(this));
    },
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.img-thumbnail{
  max-width: 60%;
}

.user-box {
    text-align: center;
    padding: 15px 0px 5px 0px;
}
</style>
