<template>
  <div class="main" v-loading="loading">
    <lang></lang>
    <div>
      <ul class="list-group">
        <draggable v-model="sections" ghost-class="ghost" @end="finishRepositioning">
          <transition-group type="transition" name="flip-list">
            <li
              v-for="element in sections"
              :key="element.id"
              class="list-group-item d-flex justify-content-between align-items-center sortable"
            >
              <!-- Banner -->
              <span class="text-sabiorealm" v-if="element.banner_id != 1">Banner</span>
              <!-- Product list -->
              <span class="text-sabiorealm" v-if="element.product_list_id != 1">Product list</span>
              <!-- Testimonial list -->
              <span class="text-sabiorealm" v-if="element.testimonial_id != 1">Testimonial</span>
              <!-- Text and media list -->
              <span class="text-sabiorealm" v-if="element.text_and_media_id != 1">Text and media</span>

              <div class="action-icons">
                <!-- Edit banner -->
                <i
                  v-if="element.banner_id != 1"
                  @click.prevent="openEditSectionModal(element.id,'banner')"
                  class="el-icon-edit text-sabiorealm links"
                ></i>

                <!-- Edit product list -->
                <i
                  v-if="element.product_list_id != 1"
                  @click.prevent="openEditSectionModal(element.id,'product-list')"
                  class="el-icon-edit text-sabiorealm links"
                ></i>

                <!-- Edit testimonial -->
                <i
                  v-if="element.testimonial_id != 1"
                  @click.prevent="openEditSectionModal(element.id,'testimonial')"
                  class="el-icon-edit text-sabiorealm links"
                ></i>

                <!-- Edit text and media list -->
                <i
                  v-if="element.text_and_media_id != 1"
                  @click.prevent="openEditSectionModal(element.id,'text-and-media')"
                  class="el-icon-edit text-sabiorealm links"
                ></i>

                <!-- Delete section -->
                <el-popconfirm
                  confirmButtonText="Ok"
                  cancelButtonText="No, Thanks"
                  placement="right"
                  :title="lang['question-delete-section']"
                  @onConfirm="deleteSection(element.id)"
                >
                  <i slot="reference" class="el-icon-delete text-danger links"></i>
                </el-popconfirm>
                <i class="el-icon-rank handle sectionPosition" :id="element.id"></i>
              </div>
            </li>
          </transition-group>
        </draggable>
      </ul>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueTheMask from "vue-the-mask";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import Lang from "@/components/helper/HelperLang.vue";
import draggable from "vuedraggable";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import { eventLang } from "@/components/helper/HelperLang";
import { eventBus } from "@/components/site/App";
import $ from "jquery";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

locale.use(lang);
Vue.use(VueTheMask);
Vue.use(VueTheMask);
Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  components: {
    draggable,
    Lang
  },
  data: () => {
    return {
      lang: {},
      sections: null,
      modal: false,
      loading: false
    };
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );

    eventBus.$on(
      "new-section",
      function() {
        this.updateSectionListArray();
      }.bind(this)
    );
    this.updateSectionListArray();
  },
  methods: {
    openEditSectionModal: function(sectionId, sectionType) {
      eventBus.$emit("edit-" + sectionType + "", sectionId);
    },
    deleteSection: function(id) {
      var formData = new FormData();
      formData.set("sectionId", id);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "section",
        "delete"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.actionsToBePerformedAfterDelete();
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    finishRepositioning: function() {
      this.reorderLinkPositions();
    },
    reorderLinkPositions: function() {
      var ar = [];
      $(".sectionPosition").each(function(index) {
        var id = $(this).attr("id");
        ar.push({ id: id, index: index });
      });
      var formData = new FormData();
      $.each(ar, function(index, value) {
        formData.set("sections[" + value.id + "]", value.index);
      });
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "section",
        "reorder"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
          this.updateSectionListArray();
          eventBus.$emit("new-change-body");
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    updateSectionListArray: function() {
      this.loading = true;
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "section",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest).then(
        response => {
          this.sections = response.data;
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    actionsToBePerformedAfterDelete() {
      this.successMessage();
      this.updateSectionListArray();
      eventBus.$emit("new-section");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.action-icons {
  float: right;
  margin-left: 0%;
}

.links {
  cursor: pointer;
}

.custom-control-label {
  padding-top: 4px !important;
}

#accordion > .card {
  margin-bottom: 2%;
}

.btn-link {
  padding: 0px !important;
  font-size: 13px;
  font-family: "Poppins", sans-serif;
  font-weight: 600;
}

.btn.link:hover {
  text-decoration: none !important;
}

.card-header {
  padding: 10px !important;
}

.btn-eadtools-rounded {
  border-radius: 50%;
  cursor: pointer;
  display: inline-block;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
  position: relative;
  height: 40px;
  width: 40px;
  background-color: #d696ef;
  z-index: 2;
  border: none;
  color: white;
  margin: 0 0.2rem;
}

.sortable-drag {
  opacity: 0;
}

.flip-list-move {
  transition: transform 0.5s;
}

.ghost {
  border-left: 6px solid #009cd8;
  border-radius: 5px;
  opacity: 0.5;
}

.card {
  margin-bottom: 15px;
}

.handle {
  cursor: move;
}

li {
  list-style-type: none;
}
</style>
