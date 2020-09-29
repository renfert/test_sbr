<template>
  <div ref="content" class="content-page" @touchmove="detectBottom($event)" @scroll="detectBottom($event)">
    <el-card shadow="always" style="background-color: #009cd8;color:white;text-align: center" class="h1">
      {{ group_name }}
    </el-card>
    <br>
    <el-row :gutter="8">
      <el-col :md="6" :sm="24" :xs="24">
        <UserStatus/>
        <br>
        <GroupFilter/>
        <br>
      </el-col>
      <el-col :md="18" :sm="24" :xs="24">

        <MyPublication to="group" :myid="this.$route.params.group_id"/>
        <br>
        <PostList type="group" :typeid= "this.$route.params.group_id"/>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import {mapState} from 'vuex';
import PostList from '@/components/sabiorealm-social/PostList';
import UserStatus from '@/components/sabiorealm-social/UserStatus';
import MyPublication from '@/components/sabiorealm-social/MyPublication';

import {eventBus} from '@/components/sabiorealm-social/App';
import GroupFilter from "@/components/sabiorealm-social/GroupFilter";
Vue.use(VueHead);

export default {
  data() {
    return {
      group_name: ''
    };
  },
  head: {
    title: {
      inner: 'Group '
    },
    meta: [
      {name: 'charset', content: 'utf-8'},
      {name: 'viewport', content: 'width=device-width, initial-scale=1.0'},
      {name: 'author', content: 'Sabiorealm'}
    ]
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  components: {GroupFilter, UserStatus, PostList, MyPublication},
  created() {
    window.addEventListener('scroll', () => {
      if (window.pageYOffset + window.innerHeight >= this.$el.clientHeight) {
        console.log('Actualizar!');
        eventBus.$emit('social-update-post');
      } else {
        console.log('sigue bajando');
      }
    });
    this.getGroupName();
  },
  mounted() {
    this.section_name = this.lang['group-default'];
  },
  methods: {
    getGroupName() {
      const form = new FormData();
      form.append('groupId', this.$route.params.group_id);
      this.$request.post(this.$getUrlToMakeRequest('group', 'get'), form).then((response) => {
        this.group_name = response.data.name;
      });
    },
    detectBottom(event) {
      console.log(event.touches[0]);
      if (window.pageYOffset + window.innerHeight >= this.$el.clientHeight) {
        console.log('Actualizar!');
        eventBus.$emit('social-update-post');
      } else {
        console.log();
        console.log('sigue bajando');
      }
    }

  }
};
</script>
<style type="text/scss">

.image {
  border-radius: 100%;
}

.link {
  color: #0c7cd5;
  font-size: medium;
}

.over:hover {
  transition: 1.2s;
  color: #009cd8;
  //font-size: large;
  cursor: pointer;
}
</style>
