<template>
  <div v-loading="loading">
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
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import draggable from "vuedraggable";
import $ from "jquery";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/site/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  components: {
    draggable
  },
  data: () => {
    return {
      links: null,
      loading: false
    };
  },
  mounted() {
    eventBus.$on(
      "link-list-update",
      function() {
        this.updateLinkListArray();
      }.bind(this)
    );
    this.updateLinkListArray();
  },
  computed: {
    ...mapState(["lang"])
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

.ghost {
  border-left: 6px solid rgb(0, 183, 255);
  border-radius: 5px;
  opacity: 0.5;
}

.handle {
  cursor: move;
}
</style>
