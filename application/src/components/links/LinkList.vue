<template>
  <div class="main" v-loading="loading">
    <lang></lang>
    <div>
      <ul class="list-group">
        <draggable v-model="links" ghost-class="ghost" @end="finishRepositioning">
          <transition-group type="transition" name="flip-list">
            <li
              v-for="element in links"
              :key="element.id"
              class="list-group-item d-flex justify-content-between align-items-center"
            >
              <span class="text-eadtools">{{element.title}}</span>
              <div class="action-icons">
                <i
                  @click.prevent="openEditLinkModal(element.id,element.title,element.url,element.target)"
                  class="el-icon-edit text-primary links"
                ></i>
                <i @click.prevent="deleteLink(element.id)" class="el-icon-delete text-danger links"></i>
                <i class="el-icon-rank handle linkPosition" :id="element.id"></i>
              </div>
            </li>
          </transition-group>
        </draggable>
      </ul>
    </div>
    <!-- End accordion -->
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
      links: null,
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
      "link-list-update",
      function() {
        this.updateLinkListArray();
      }.bind(this)
    );
    this.updateLinkListArray();
  },
  methods: {
    openEditLinkModal: function(id, title, url, target) {
      let data = {
        id: id,
        title: title,
        url: url,
        target: target
      };
      eventBus.$emit("edit-link", data);
    },
    deleteLink: function(id) {
      var formData = new FormData();
      formData.set("linkId", id);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("link", "delete");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.updateLinkListArray();
          this.successMessage();
          eventBus.$emit("link-list-update");
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
      $(".linkPosition").each(function(index) {
        var id = $(this).attr("id");
        ar.push({ id: id, index: index });
      });
      var formData = new FormData();
      $.each(ar, function(index, value) {
        formData.set("links[" + value.id + "]", value.index);
      });
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("link", "reorder");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
          eventBus.$emit("link-list-update");
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    updateLinkListArray: function() {
      this.loading = true;
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("link", "listing");
      axios.post(urlToBeUsedInTheRequest).then(
        response => {
          this.links = response.data;
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
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
  border-left: 6px solid rgb(0, 183, 255);
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
