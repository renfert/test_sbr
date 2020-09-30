<template>
  <div ref="content" class="content-page">
    <el-row :gutter="8">
      <el-col :md="6" :sm="24" :xs="24">
        <UserStatus />
        <br />
        <GroupFilter />
        <br />
      </el-col>
      <el-col :md="18" :sm="24" :xs="24">
        <MyPublication />
        <br />
        <PostList type="all" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import { mapState } from 'vuex';
import PostList from '@/components/sabiorealm-social/PostList';
import UserStatus from '@/components/sabiorealm-social/UserStatus';
import MyPublication from '@/components/sabiorealm-social/MyPublication';
import GroupFilter from '@/components/sabiorealm-social/GroupFilter';

Vue.use(VueHead);

export const eventBus = new Vue();
export default {
  data: () => {
    return {
      publication: '',
      comment: [],
      publications: [],
      activeName: 'first'
    };
  },
  head: {
    title: {
      inner: 'Social'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  components: { GroupFilter, MyPublication, UserStatus, PostList },
  created() {
    window.addEventListener('scroll', () => {
      if (window.pageYOffset + window.innerHeight >= this.$el.clientHeight) {
        console.log('Actualizar!');
        eventBus.$emit('social-update-post');
      } else {
        console.log('sigue bajando');
      }
    });
  },
  methods: {
    detectBottom(event) {
      console.log(event.touches[0]);
      if (window.pageYOffset + window.innerHeight >= this.$el.clientHeight) {
        console.log('Actualizar!');
        eventBus.$emit('social-update-post');
      } else {
        console.log();
        console.log('sigue bajando');
      }
    },
    handleClick(tab, event) {
      console.log(this.activeName);
      console.log(tab, event);
    }
  }
};
</script>
<style type="text/scss">
.link {
  color: #0c7cd5;
  font-size: medium;
}
.over:hover {
  transition: 1.2s;
  color: #009cd8;
  cursor: pointer;
}
</style>
