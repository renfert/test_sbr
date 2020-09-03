<template>
  <div>
    <div v-for="element in footerArray" :key="element.id">
      <el-submenu index="3">
        <template slot="title">
          <i class="el-icon-menu"></i>
          <span>Footer</span>
        </template>
        <form id="form-footer">
          <el-menu-item-group :title="lang['copyright']">
            <el-menu-item>
              <el-input
                name="copyright"
                @change="editFooter()"
                v-model="copyright"
              ></el-input>
            </el-menu-item>
          </el-menu-item-group>
          <el-menu-item-group :title="lang['primary-color']">
            <el-menu-item>
              <input type="text" v-model="color" name="color" class="hide" />
              <el-color-picker
                @change="changeColor()"
                v-model="color"
              ></el-color-picker>
            </el-menu-item>
          </el-menu-item-group>
        </form>
        <el-menu-item-group :title="lang['social-medias']">
          <div class="list-block">
            <social-media-list></social-media-list>
            <br />
            <el-button
              class="sbr-btn sbr-primary"
              @click.prevent="openSocialModal()"
            >
              {{ lang['add-new-social'] }}
              <i class="el-icon-circle-plus-outline"></i>
            </el-button>
          </div>
        </el-menu-item-group>
      </el-submenu>
    </div>
  </div>
</template>

<script>
import SocialMediaList from '@/components/social/SocialMediaList';

import { eventBus } from '@/components/site/App';
import { mapState } from 'vuex';

export default {
  components: {
    SocialMediaList
  },
  data: () => {
    return {
      footerArray: [],
      color: '',
      copyright: false
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  mounted() {
    this.listFooter();
  },
  methods: {
    changeColor() {
      setTimeout(() => {
        this.editFooter();
      }, 100);
    },

    openSocialModal() {
      eventBus.$emit('open-social-modal');
    },
    listFooter() {
      const urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        'builder',
        'listFooter'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.footerArray = response.data;
          this.color = response.data[0].color;
          this.copyright = response.data[0].copyright;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    editFooter() {
      const form = document.getElementById('form-footer');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        'builder',
        'editFooter'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          eventBus.$emit('new-change-footer');
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
[class*=' el-icon-'],
[class^='el-icon-'] {
  line-height: 0 !important;
}

.el-menu-item {
  height: auto !important;
}

.el-submenu {
  list-style: none;
  margin: 0;
  padding-left: 0;
  border-bottom: 1px solid #ccc !important;
}

.el-submenu span {
  font-size: 1.2em !important;
  font-family: 'Montserrat', sans-serif;
  color: #53536e !important;
}
</style>
