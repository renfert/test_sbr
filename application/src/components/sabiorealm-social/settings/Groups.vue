<template>
  <div class="m-t-40 m-l-40">
    <facebook-loader
      v-if="content == false"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <div v-if="groupsBelongingToSocial != null">
        <div>
          <el-row :gutter="40">
            <el-col :sm="6" :xs="18">
              <el-input
                v-model="table.filters[0].value"
                placeholder="Search"
              ></el-input>
            </el-col>
            <el-col :span="2">
              <el-button
                @click.prevent="addGroup"
                class="sbr-purple"
                icon="el-icon-plus"
                circle
              ></el-button>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="groupsBelongingToSocial"
          :filters="table.filters"
        >
          <el-table-column
            v-for="title in table.titles"
            sortable="custom"
            :prop="title.prop"
            :label="title.label"
            :key="title.label"
          ></el-table-column>

          <el-table-column label="Actions" align="center">
            <template slot-scope="scope">
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                :title="lang['remove-group-question'] + scope.row.name + '?'"
                @onConfirm="removeGroupFromSocial(scope.row.id)"
              >
                <i
                  slot="reference"
                  class="el-icon-delete table-icon table-icon-danger"
                ></i>
              </el-popconfirm>
            </template>
          </el-table-column>
        </data-tables>
      </div>

      <el-row v-else class="center m-t-40 m-b-40">
        <el-col :md="24">
          <img
            class="not-found-image m-b-20"
            src="@/assets/img/general/ux/no_courses.svg"
          />
          <br />
          <el-button class="sbr-primary" @click="addGroup()"
            >{{ lang['add-group'] }}
          </el-button>
        </el-col>
      </el-row>
    </div>

    <!--------------------
      Add new group modal
    ---------------------->
    <el-dialog
      :visible.sync="modal"
      :title="lang['join-groups']"
      center
      top="5vh"
    >
      <facebook-loader
        v-if="contentModal == false"
        :speed="2"
        width="700"
        height="200"
        primaryColor="#f0f0f0"
        secondaryColor="#d9d9d9"
      ></facebook-loader>

      <div v-else class="center">
        <div v-if="groupsNotBelongingToSocial != null">
          <template>
            <el-transfer
              filterable
              :titles="['Groups', 'Social']"
              v-model="groups"
              :data="groupsNotBelongingToSocial"
            ></el-transfer>
          </template>
          <br />
          <el-button
            v-loading="loading"
            class="sbr-primary"
            @click="saveGroups()"
            >{{ lang['save-button'] }}
          </el-button>
        </div>
        <el-row v-else class="center">
          <el-col>
            <img
              class="not-found-image"
              src="@/assets/img/general/ux/no_courses.svg"
            />
            <h4>{{ lang['all-groups-already-added'] }}</h4>
          </el-col>
        </el-row>
      </div>
    </el-dialog>
    <!--------------------
      End add new course modal
    ---------------------->
  </div>
</template>

<script>
import Vue from 'vue';

import { FacebookLoader } from 'vue-content-loader';
import { DataTables, DataTablesServer } from 'vue-data-tables';
import { mapState } from 'vuex';

Vue.use(DataTables);
Vue.use(DataTablesServer);

export default {
  components: {
    FacebookLoader
  },
  data: () => {
    return {
      table: {
        titles: [{ prop: 'name', label: 'Name' }],
        filters: [{ prop: 'title', value: '' }],
        props: { defaultSort: { prop: 'title', order: 'descending' } }
      },
      groupsBelongingToSocial: [],
      groupsNotBelongingToSocial: [],
      groups: [],
      loading: false,
      modal: false,
      contentModal: false,
      content: false
    };
  },
  created() {
    this.getGroupsThatBelongToSocial();
    this.getGroupsThatNotBelongToSocial();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    removeGroupFromSocial(groupId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'socialNetwork',
        'removeGroupFromSocial'
      );
      formData.set('groupId', groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getGroupsThatBelongToSocial();
          this.getGroupsThatNotBelongToSocial();
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    saveGroups() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'SocialNetwork',
        'saveGroupsIntoSocial'
      );
      formData.set('groups', this.groups);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.loading = false;
          this.modal = false;
          this.getGroupsThatBelongToSocial();
          this.getGroupsThatNotBelongToSocial();
          this.courses = [];
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    addGroup() {
      this.modal = true;
    },
    getGroupsThatBelongToSocial() {
      this.content = false;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'SocialNetwork',
        'getGroupsInsideSocial'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.groupsBelongingToSocial = response.data;
          setTimeout(() => {
            this.content = true;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getGroupsThatNotBelongToSocial() {
      this.contentModal = false;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'SocialNetwork',
        'getGroupsOutsideSocial'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.groupsNotBelongingToSocial = response.data;
          setTimeout(() => {
            this.contentModal = true;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
<style scoped>
.el-transfer-panel {
  margin: 5px;
  width: 255px;
}

@media only screen and (max-width: 1315px) {
  .el-transfer__buttons {
    display: flow-root;
  }

  .el-transfer-panel {
    width: 100%;
    margin: 5px;
  }
}
</style>
