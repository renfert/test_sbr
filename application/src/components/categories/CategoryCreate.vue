<template>
  <div class="card-box table-responsive">
    <h4>{{ lang["create-category"] }}</h4>
    <el-form id="form-category" :inline="true">
      <el-form-item>
        <el-input required name="name" :placeholder="lang['name']" v-model="categoryName"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button
          @click.prevent="createCategory()"
          v-loading="loadingButton"
          class="sbr-primary"
          native-type="submit"
          type="primary"
        >{{ lang["save-button"] }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import { eventBus } from "@/components/categories/App";
import { mapState } from "vuex";

Vue.use(ElementUI);
Vue.use(VueAxios, axios);
export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      categoryName: "",
      loadingButton: false
    };
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    createCategory: function() {
      this.loadingButton = true;
      var form = document.getElementById("form-category");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "category",
        "create"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          /* Success callback */
          this.loadingButton = false;
          if (response.data == false) {
            this.categoryAlreadyExistsMessage();
          } else {
            this.successMessage();
            this.actionsToBePerformedAfterRegistration();
          }
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    categoryAlreadyExistsMessage() {
      this.$notify({
        title: this.lang["error"],
        message: this.lang["category-already-exists"],
        type: "warning",
        duration: 3500
      });
    },
    actionsToBePerformedAfterRegistration() {
      this.categoryName = ""; // Clear a category name input
      eventBus.$emit("new-category"); // Emit a event to list component update the table of categories.
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
