<template>
  <el-submenu index="2">
    <template slot="title">
      <i class="el-icon-menu"></i>
      <span>Body</span>
    </template>
    <el-menu-item-group title="Sections">
      <div class="list-block">
        <!---------------
          Section list
        ---------------->
        <div class="row align-items-center">
          <section-list></section-list>
        </div>

        <!---------------
          Create new section
        ---------------->
        <div class="align-items-center">
          <div class="mt-3">
            <div class="row">
              <div>
                <el-select
                  v-model="section"
                  :placeholder="lang['select-an-element']"
                >
                  <el-option :label="lang['banner']" value="Banner">{{
                    lang['banner']
                  }}</el-option>
                  <el-option
                    :label="lang['product-list']"
                    value="ProductList"
                    >{{ lang['product-list'] }}</el-option
                  >
                  <el-option :label="lang['testimonial']" value="Testimonial">{{
                    lang['testimonial']
                  }}</el-option>
                  <el-option
                    :label="lang['text-and-media']"
                    value="TextAndMedia"
                    >{{ lang['text-and-media'] }}</el-option
                  >
                </el-select>
              </div>
              <div>
                <el-button
                  v-loading="loading"
                  native-type="submit"
                  @click.prevent="createSection()"
                  size="medium"
                  icon="el-icon-circle-plus-outline"
                ></el-button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </el-menu-item-group>
  </el-submenu>
</template>

<script>
import SectionList from '@/components/site/section/SectionList';

import { eventBus } from '@/components/site/App';
import { mapState } from 'vuex';

export default {
  components: {
    SectionList
  },
  data: () => {
    return {
      section: 'Banner',
      loading: false
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    createSection() {
      this.loading = true;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'site-elements/' + this.section + '',
        'create'
      );
      this.$request.post(urlToBeUsedInTheRequest).then(
        () => {
          this.$successMessage();
          this.loading = false;
          eventBus.$emit('new-section');
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
.el-submenu span {
  font-size: 1.2em !important;
  font-family: 'Montserrat', sans-serif;
  color: #53536e !important;
}
</style>
