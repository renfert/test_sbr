<template>
  <div class="card-box table-responsive" v-if="groupList != null">
    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <div>
        <h4>{{lang["list-group"]}}</h4>
        <div style="margin-bottom: 10px">
          <el-row>
            <el-col :md="6">
              <el-input v-model="filters[0].value" placeholder="Search"></el-input>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="groupList"
          :filters="filters"
        >
          <el-table-column
            v-for="title in titles"
            sortable="custom"
            :prop="title.prop"
            :label="title.label"
            :key="title.label"
          ></el-table-column>
          <el-table-column label="Actions" align="center">
            <template slot-scope="scope">
              <!-- Edit group -->
              <el-button
                class="sbr-primary mr-1"
                @click="openModalToEditGroup(scope.row.id,scope.row.name)"
                size="small"
                icon="el-icon-edit"
                circle
              ></el-button>

              <!-- Delete group -->
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                placement="right"
                :title="lang['question-delete-group'] + scope.row.name  + '?'"
                @onConfirm="deleteGroup(scope.row.id)"
              >
                <el-button
                  size="small"
                  class="sbr-danger mr-1"
                  slot="reference"
                  icon="el-icon-delete"
                  circle
                ></el-button>
              </el-popconfirm>
              <!-- Manage group -->
              <router-link :to="'/group/' + scope.row.id">
                <el-button
                  class="sbr-secondary"
                  type="success"
                  size="small"
                  icon="el-icon-magic-stick"
                  circle
                ></el-button>
              </router-link>
            </template>
          </el-table-column>
        </data-tables>
      </div>

      <!-- Group edit modal -->
      <div>
        <el-dialog :visible.sync="modal" :title="groupName" center width="40%" top="5vh">
          <div class="form-group">
            <label>{{lang["new-name"]}}</label>
            <el-input name="name" v-model="newGroupName"></el-input>
          </div>
          <div class="form-group">
            <el-button
              class="sbr-primary"
              @click.prevent="editGroup(groupId,newGroupName)"
            >{{lang["save-button"]}}</el-button>
          </div>
        </el-dialog>
      </div>
    </div>
  </div>

  <div class="row mb-5 mt-5" v-else>
    <div class="col-12 text-center">
      <img class="no-results-img" src="@/assets/img/general/ux/no_persons.png" alt="No persons" />
      <h4 class="no-results-text">{{lang["no-results-group-title"]}}</h4>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { FacebookLoader } from "vue-content-loader";
import { eventBus } from "@/components/groups/App";
import { DataTables, DataTablesServer } from "vue-data-tables";
import { mapState } from "vuex";

Vue.use(DataTables);
Vue.use(DataTablesServer);
Vue.use(ElementUI);
Vue.use(VueAxios, axios);

export default {
  components: {
    FacebookLoader
  },
  mixins: [domains, alerts],
  data: function() {
    return {
      titles: [{ prop: "name", label: "Name" }],
      groupList: [],
      filters: [{ prop: "name", value: "" }],
      tableProps: { defaultSort: { prop: "name", order: "descending" } },
      groupId: "",
      groupName: "",
      newGroupName: "",
      modal: false,
      loadingContent: false
    };
  },
  created() {
    this.listingGroup();
    eventBus.$on(
      "new-group",
      function() {
        this.listingGroup();
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    openModalToEditGroup(id, name) {
      this.groupName = name;
      this.groupId = id;
      this.modal = true;
    },
    editGroup(id, name) {
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest("group", "edit");
      var formData = new FormData();
      formData.set("name", name);
      formData.set("id", id);
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          // success callback
          if (response.data == false) {
            this.groupAlreadyExistsMessage();
          } else {
            this.successMessage();
            this.actionsToBePerformedAfterEdit();
          }
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    deleteGroup(id) {
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "group",
        "delete"
      );
      var formData = new FormData();
      formData.set("id", id);
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          // success callback
          this.successMessage();
          this.listingGroup();
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    listingGroup() {
      this.loadingContent = true;
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "group",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          this.groupList = response.data;
          setTimeout(
            function() {
              this.loadingContent = false;
            }.bind(this),
            1000
          );
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    groupAlreadyExistsMessage() {
      this.$notify({
        title: this.lang["error"],
        message: this.lang["group-already-exists"],
        type: "warning",
        duration: 3500
      });
    },
    actionsToBePerformedAfterEdit() {
      this.modal = false;
      this.newGroupName = "";
      this.listingGroup();
    }
  }
};
</script>
