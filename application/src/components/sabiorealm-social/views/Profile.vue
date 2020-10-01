<template>
  <div ref="content" class="content-page">
    <el-row class="m-t-40" :gutter="40" style="display: flex">
      <div
        style="
          width: 100%;
          background-color: rgb(55, 58, 67);
          position: fixed;
          top: 0;
          z-index: 99999;
          color: #fff;
          text-align: center;
          left: 230px;
          display: flex;
          align-items: baseline;
          justify-content: center;
        "
      >
        <div>
          <h3 style="color: white; margin-right: 230px">
            Voce esta conectado ao canal <i class="el-icon-arrow-right"></i>
            <b class="sbr-text-primary"> General </b>
            &nbsp;
            <img
              class="test"
              style="width: 30px"
              src="@/assets/img/social/world.png"
            />
          </h3>
        </div>
        <div>
          <a href="#">
            <h3 style="color: white" class="fw-600">
              Mudar canal <i class="el-icon-chat-dot-round"></i>
            </h3>
          </a>
        </div>
      </div>
      <el-col :md="11" :sm="24" :xs="24">
        <my-publication></my-publication>
      </el-col>

      <el-col :md="13">
        <div>
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

.test {
  border-radius: 50%;
  margin: 10px;
  position: relative;
  box-shadow: 0 0 0 0 rgba(0, 0, 0, 1);
  transform: scale(1);
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% {
    transform: scale(0.95);
    box-shadow: 0 0 0 0 #009cd8;
  }

  70% {
    transform: scale(1);
    box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
  }

  100% {
    transform: scale(0.95);
    box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
  }
}
</style>
