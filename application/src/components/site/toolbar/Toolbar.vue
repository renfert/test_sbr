<template>
  <div>
    <el-container>
      <el-aside class="fixed-aside">
        <el-menu class="el-menu-vertical-demo">
          <div class="back mt-5">
            <router-link to="/home">
              <i class="el-icon-back"></i>
              {{ lang['back'] }}
            </router-link>
          </div>
          <toolbar-general></toolbar-general>
          <toolbar-header></toolbar-header>
          <toolbar-body></toolbar-body>
          <toolbar-footer></toolbar-footer>
        </el-menu>
      </el-aside>
    </el-container>
    <edit-banner></edit-banner>
    <edit-testimonial></edit-testimonial>
    <edit-product-list></edit-product-list>
    <edit-text-and-media></edit-text-and-media>
    <link-create></link-create>
    <link-edit></link-edit>
    <social-media-create></social-media-create>
    <social-media-edit></social-media-edit>
  </div>
</template>

<script>
import ToolbarHeader from '@/components/site/toolbar/ToolbarHeader';
import ToolbarBody from '@/components/site/toolbar/ToolbarBody';
import ToolbarFooter from '@/components/site/toolbar/ToolbarFooter';
import ToolbarGeneral from '@/components/site/toolbar/ToolbarGeneral';
import EditBanner from '@/components/site/section/elements/edit/Banner';
import EditTestimonial from '@/components/site/section/elements/edit/Testimonial';
import EditProductList from '@/components/site/section/elements/edit/ProductList';
import EditTextAndMedia from '@/components/site/section/elements/edit/TextAndMedia';
import LinkCreate from '@/components/links/LinkCreate';
import LinkEdit from '@/components/links/LinkEdit';
import SocialMediaCreate from '@/components/social/SocialMediaCreate';
import SocialMediaEdit from '@/components/social/SocialMediaEdit';

import { mapState } from 'vuex';

export default {
  components: {
    ToolbarHeader,
    ToolbarBody,
    ToolbarFooter,
    ToolbarGeneral,
    EditBanner,
    EditTestimonial,
    EditProductList,
    EditTextAndMedia,
    LinkCreate,
    LinkEdit,
    SocialMediaCreate,
    SocialMediaEdit
  },
  computed: {
    ...mapState(['lang'])
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.fixed-aside {
  width: 350px !important;
  position: fixed;
  z-index: 2001;
  top: 0;
  bottom: 0;
  background: #fff;
  border-right: 1px solid #dbd3d3;
}

.fixed-aside ul {
  padding: 0;
  margin: 0;
  position: absolute;
  top: 0;
  left: 0;
  background: white;
  width: 280px;
}

.el-menu {
  width: 350px !important;
}

.el-menu-item {
  height: auto !important;
}

.el-menu-item-group {
  padding-top: 10%;
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
  color: #53536e;
}

.el-submenu span.back {
  color: white;
  font-weight: 700;
}

.el-menu-item:focus,
.el-menu-item:hover {
  background-color: white !important;
}

.back {
  text-align: center;
  height: 50px;
  font-size: 1rem;
  text-transform: uppercase;
  font-weight: 700;
}

@media only screen and (max-width: 600px) {
  .el-aside {
    position: fixed !important;
  }
}
</style>
