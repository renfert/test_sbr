<template>
  <el-submenu index="2">
    <template slot="title">
      <i class="el-icon-menu sbr-text-primary"></i>
      <span>Body</span>
    </template>
    <el-menu-item-group :title="lang['sections']">
      <div class="m-l-40 m-r-40">
        <!---------------
          Section list
        ---------------->
        <el-row>
          <section-list></section-list>
        </el-row>

        <!---------------
          Create new section
        ---------------->
        <div>
          <div class="m-t-40 m-b-40">
            <el-row>
              <el-col :span="12">
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
              </el-col>

              <el-button
                v-loading="loading"
                native-type="submit"
                @click.prevent="createSection()"
                size="medium"
                icon="el-icon-circle-plus-outline"
              ></el-button>
            </el-row>
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
