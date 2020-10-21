<template>
  <div ref="content" class="content-page">
    <el-row :gutter="40" class="publication_row m-t-40">
      <div class="publication_container">
        <div>
          <a @click.prevent="changeChannel()">
            <h4 style="color: white" class="fw-600">
              {{ lang['change-channel'] }}
              <i class="el-icon-chat-dot-round"></i>
            </h4>
          </a>
        </div>
      </div>
      <el-col
        :class="channel.type == null ? 'hide' : ''"
        :md="11"
        :sm="24"
        :xs="24"
      >
        <my-publication
          v-if="publicNetworkStatus != null"
          :public-network="publicNetworkStatus"
        ></my-publication>
      </el-col>

      <el-col :class="channel.type == null ? 'hide' : ''" :md="13" :xs="24">
        <div>
          <h4>
            {{ lang['connected-channel'] }} <i class="el-icon-arrow-right"></i>
            <b class="sbr-text-primary"> {{ channel.name }} </b>
            &nbsp;
            <img
              class="blob"
              v-if="channel.type == 'public'"
              style="width: 20px"
              src="@/assets/img/social/world.png"
            />
            <img
              class="blob"
              v-if="channel.type == 'group'"
              style="width: 20px"
              src="@/assets/img/general/ux/join_persons.png"
            />

            <img
              class="blob"
              v-if="channel.type == 'course'"
              style="width: 20px"
              src="@/assets/img/general/ux/view_course.png"
            />
          </h4>
        </div>
        <div>
          <post-list
            v-if="publicNetworkStatus != null"
            :public-network="publicNetworkStatus"
          ></post-list>
        </div>
      </el-col>
    </el-row>
    <div :class="channel.type != null ? 'hide' : ''" class="center m-t-40">
      <img
        src="@/assets/img/social/no_publications.svg"
        class="not-found-image"
      />
      <h3>Voce nao esta conectado a nenhum canal</h3>
      <el-button
        type="primary"
        class="sbr-primary"
        @click.prevent="changeChannel()"
      >
        {{ lang['change-channel'] }}
      </el-button>
    </div>
    <select-channel
      v-if="publicNetworkStatus != null"
      :public-network="publicNetworkStatus"
    ></select-channel>
    <edit-post></edit-post>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import { mapState } from 'vuex';
import PostList from '@/components/sabiorealm-social/feed/PostList';
import MyPublication from '@/components/sabiorealm-social/feed/MyPublication';
import SelectChannel from '@/components/sabiorealm-social/feed/SelectChannel';
import EditPost from '@/components/sabiorealm-social/feed/EditPost';

Vue.use(VueHead);

export const eventBus = new Vue();
export default {
  data: () => {
    return {
      publication: '',
      comment: [],
      publications: [],
      publicNetworkStatus: null,
      channel: {
        type: null,
        name: null
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
    this.getPublicNetworkStatus();
    this.channel.name = this.lang.public;
    // Connect to public channel
    eventBus.$on('connect-to-public-channel', () => {
      this.channel.name = this.lang.public;
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
    },
    getPublicNetworkStatus() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'socialNetwork',
        'getPublicNetworkStatus'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.publicNetworkStatus = response.data;
          if (response.data !== false) {
            this.channel.name = this.lang.public;
            this.channel.type = 'public';
          }
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
<style type="text/scss" scoped>
.publication_container {
  width: 100%;
  background-color: rgb(55, 58, 67);
  position: fixed;
  top: 0;
  z-index: 1;
  color: #fff;
  text-align: center;
  left: 0;
  display: flex;
  align-items: baseline;
  justify-content: center;
}

.publication_container h4 {
  font-size: 1rem;
  color: #fff;
  font-weight: 700;
  padding: 5px 0px 5px 230px;
}

.publication_row {
  display: flex;
}
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

@media only screen and (max-width: 600px) {
  .publication_row {
    display: inherit;
  }
}
</style>
