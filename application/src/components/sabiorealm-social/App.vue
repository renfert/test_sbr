<template>
  <div ref="content" class="content-page">
    <el-row class="m-t-40" :gutter="40" style="display: flex">
      <div
        style="
          width: 100%;
          background-color: rgb(55, 58, 67);
          position: fixed;
          top: 0;
          z-index: 1000;
          color: #fff;
          text-align: center;
          left: 230px;
          display: flex;
          align-items: baseline;
          justify-content: center;
        "
      >
        <div>
          <h3
            style="
              color: white;
              margin-right: 230px;
              display: flex;
              align-items: center;
            "
          >
            Voce esta conectado ao canal <i class="el-icon-arrow-right"></i>
            <b class="sbr-text-primary"> {{ channel.name }} </b>
            &nbsp;
            <img
              class="blob"
              v-if="channel.type == 'public'"
              style="width: 30px"
              src="@/assets/img/social/world.png"
            />
            <img
              class="blob"
              v-if="channel.type == 'group'"
              style="width: 30px"
              src="@/assets/img/general/ux/join_persons.png"
            />

            <img
              class="blob"
              v-if="channel.type == 'course'"
              style="width: 30px"
              src="@/assets/img/general/ux/view_course.png"
            />
          </h3>
        </div>
        <div>
          <a @click.prevent="changeChannel()">
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
          <post-list></post-list>
        </div>
      </el-col>
    </el-row>
    <select-channel></select-channel>
    <edit-post></edit-post>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import { mapState } from 'vuex';
import PostList from '@/components/sabiorealm-social/PostList';
import MyPublication from '@/components/sabiorealm-social/MyPublication';
import SelectChannel from '@/components/sabiorealm-social/SelectChannel';
import EditPost from '@/components/sabiorealm-social/EditPost';

Vue.use(VueHead);

export const eventBus = new Vue();
export default {
  data: () => {
    return {
      publication: '',
      comment: [],
      publications: [],
      activeName: 'first',
      channel: {
        type: 'public',
        name: 'Public'
      }
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
  components: { MyPublication, PostList, SelectChannel, EditPost },
  created() {
    // Connect to public channel
    eventBus.$on('connect-to-public-channel', () => {
      this.channel.name = 'public';
      this.channel.type = 'public';
    });

    // Connect to group channel
    eventBus.$on('connect-to-group-channel', (response) => {
      this.channel.name = response.name;
      this.channel.type = response.type;
    });

    // Connect to course channel
    eventBus.$on('connect-to-course-channel', (response) => {
      this.channel.name = response.name;
      this.channel.type = response.type;
    });
  },
  methods: {
    changeChannel() {
      eventBus.$emit('open-channel-modal');
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

.blob {
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
