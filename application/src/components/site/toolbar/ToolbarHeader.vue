<template>
  <div v-if="headerArray != null">
    <div v-for="element in headerArray" :key="element.id">
      <el-submenu index="1">
        <template slot="title">
          <i class="el-icon-menu"></i>
          <span>Header</span>
        </template>
        <form id="form-header">
          <el-menu-item-group title="Logo (150 x 50 px)">
            <el-menu-item index="1-0">
              <upload
                :src-name="element.logo"
                :src-img="
                  $getUrlToContents() + 'builder/header/' + element.logo + ''
                "
                do-upload="true"
                box-height="100"
                return-name="logoName"
                input-name="logo"
                bucket-key="uploads/builder/header"
                acceptable=".png,.jpg,.jpeg"
              ></upload>
            </el-menu-item>
          </el-menu-item-group>
          <el-menu-item-group title="Logo sticker (150 x 50 px)">
            <el-menu-item index="1-1">
              <upload
                :src-name="element.logo_sticky"
                :src-img="
                  $getUrlToContents() +
                  'builder/header/' +
                  element.logo_sticky +
                  ''
                "
                do-upload="true"
                box-height="100"
                return-name="logoStickyName"
                input-name="logoSticky"
                bucket-key="uploads/builder/header"
                acceptable=".png,.jpg,.jpeg"
              ></upload>
            </el-menu-item>
          </el-menu-item-group>
          <el-menu-item-group title="Logo size">
            <el-menu-item>
              <div class="block">
                <input
                  class="hide"
                  name="logoSize"
                  type="number"
                  v-model="logoSize"
                />
                <el-slider
                  @change="editHeader()"
                  v-model="logoSize"
                ></el-slider>
              </div>
            </el-menu-item>
          </el-menu-item-group>
          <el-menu-item-group :title="lang['color']">
            <el-menu-item>
              <input
                type="text"
                v-model="headerColor"
                name="color"
                class="hide"
              />
              <el-color-picker
                @change="changeHeaderColor()"
                v-model="headerColor"
              ></el-color-picker>
            </el-menu-item>
          </el-menu-item-group>
          <el-menu-item-group :title="lang['transparent-header']">
            <el-menu-item>
              <el-switch
                @change="applyTransparentHeader()"
                v-model="transparentHeader"
              ></el-switch>
            </el-menu-item>
          </el-menu-item-group>
        </form>
        <el-menu-item-group title="Links">
          <div class="list-block">
            <link-list></link-list>
            <br />
            <el-button
              size="small"
              class="sbr-primary"
              @click.prevent="openLinksModal()"
            >
              {{ lang['add-new-link'] }}
              <i class="el-icon-circle-plus-outline"></i>
            </el-button>
          </div>
        </el-menu-item-group>
      </el-submenu>
    </div>
  </div>
</template>

<script>
import Upload, { eventUpload } from '@/components/helper/HelperUpload';
import LinkList from '@/components/links/LinkList';
import { eventBus } from '@/components/site/App';
import { mapState } from 'vuex';

export default {
  components: {
    Upload,
    LinkList
  },
  data: () => {
    return {
      logoSize: 0,
      logo: '',
      headerArray: null,
      headerColor: '',
      transparentHeader: false
    };
  },
  mounted() {
    this.listHeader();

    eventUpload.$on('finish-upload', () => {
      if (this.$route.name === 'site') {
        this.editHeader();
      }
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    changeHeaderColor() {
      setTimeout(() => {
        this.editHeader();
      }, 100);
    },
    applyTransparentHeader() {
      if (this.transparentHeader === true) {
        this.headerColor = 'transparent';
        setTimeout(() => {
          this.editHeader();
        }, 200);
      } else {
        this.headerColor = '#87CEFA';
        setTimeout(() => {
          this.editHeader();
        }, 200);
      }
    },
    openLinksModal() {
      eventBus.$emit('open-link-modal');
    },
    listHeader() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'builder',
        'listHeader'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.headerArray = response.data;
          this.logoSize = parseInt(response.data[0].logo_size);
          this.headerColor = response.data[0].color;
          if (response.data[0].color === 'transparent') {
            this.transparentHeader = true;
          }
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    editHeader() {
      const form = document.getElementById('form-header');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'builder',
        'editHeader'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          eventBus.$emit('new-change-header');
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
