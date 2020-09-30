<template>
  <div ref="content" class="content-page">
    <el-row :gutter="40">
      <el-col :md="11" :sm="24" :xs="24">
        <my-publication></my-publication>
      </el-col>

      <el-col :md="13">
        <div>
          <h3 class="center">
            <i class="el-icon-chat-dot-square sbr-text-primary"></i> Feed
            <i class="el-icon-arrow-right"></i> Public
            <img
              style="width: 18px"
              src="@/assets/img/social/world.png"
              alt=""
            />
          </h3>
          <el-button
            style="padding: 0px; font-size: 0.8rem"
            class="sbr-text-primary"
            type="text"
          >
            &nbsp;
            <a
              >Exibir em
              <i class="fas fa-angle-right" style="font-size: 12px"></i>
              Public
            </a>
          </el-button>
          <hr />
          <post-list type="all"></post-list>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import { mapState } from 'vuex';
import PostList from '@/components/sabiorealm-social/PostList';
import MyPublication from '@/components/sabiorealm-social/MyPublication';

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
  components: { MyPublication, PostList },
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
