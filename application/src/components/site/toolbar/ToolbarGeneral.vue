<template>
  <div>
    <div>
      <el-submenu index="0">
        <template slot="title">
          <i class="el-icon-menu"></i>
          <span>General</span>
        </template>
        <form id="form-general">
          <el-menu-item-group class="mb-5" :title="lang['color']">
            <el-menu-item>
              <input type="text" v-model="color" name="color" class="hide" />
              <el-color-picker
                @change="changeHeaderColor()"
                v-model="color"
              ></el-color-picker>
            </el-menu-item>
          </el-menu-item-group>
        </form>
      </el-submenu>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      color: ''
    };
  },
  mounted() {
    this.getColor();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    changeHeaderColor() {
      setTimeout(() => {
        this.editColor();
      }, 100);
    },
    getColor() {
      const urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.color = response.data.color;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    editColor() {
      const form = document.getElementById('form-general');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        'settings',
        'editPrimaryColor'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {},
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
