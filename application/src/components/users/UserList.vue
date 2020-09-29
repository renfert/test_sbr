<template>
  <div class="card-box table-responsive" v-if="userList != null">
    <facebook-loader
      v-if="content == true"
      :speed="2"
      width="700"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <div>
        <h4>{{ lang['list-users'] }}</h4>
        <div style="margin-bottom: 10px">
          <el-row :gutter="20">
            <el-col :sm="8" :xs="16">
              <el-input
                v-model="filters[0].value"
                placeholder="Search"
              ></el-input>
            </el-col>
            <el-col v-if="userList != null" :span="6">
              <export-excel :data="userList" name="users.xls">
                <el-tooltip
                  class="item"
                  effect="dark"
                  :content="lang['export']"
                  placement="top"
                >
                  <el-button
                    class="sbr-purple ml-3"
                    type="primary"
                    icon="el-icon-download"
                    circle
                  ></el-button>
                </el-tooltip>
              </export-excel>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="userList"
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
              <!-- Manage user -->
              <el-tooltip
                class="item"
                effect="dark"
                :content="lang['manage-user']"
                placement="top"
              >
                <router-link class="m-r-20" :to="'/user/' + scope.row.id">
                  <i class="el-icon-set-up table-icon table-icon-purple"></i>
                </router-link>
              </el-tooltip>

              <!-- Delete User -->
              <el-tooltip
                class="item"
                effect="dark"
                :content="lang['delete-user']"
                placement="top"
              >
                <el-popconfirm
                  confirmButtonText="Ok"
                  cancelButtonText="No, Thanks"
                  placement="right"
                  :title="lang['question-delete-user'] + scope.row.name + '?'"
                  @onConfirm="deleteUser(scope.row.id)"
                >
                  <i
                    slot="reference"
                    class="el-icon-delete table-icon table-icon-danger"
                  ></i>
                </el-popconfirm>
              </el-tooltip>
            </template>
          </el-table-column>
        </data-tables>
      </div>
    </div>
  </div>
  <!-- End User list -->

  <div class="center m-t-40" v-else>
    <img class="not-found-image" src="@/assets/img/general/ux/no_users.svg" />
    <h4 class="sbr-text-grey">{{ lang['no-results-user-title'] }}</h4>
  </div>
</template>

<script>
import Vue from 'vue';
import excel from 'vue-excel-export';

import { FacebookLoader } from 'vue-content-loader';
import { DataTables, DataTablesServer } from 'vue-data-tables';
import { eventBus } from '@/components/users/App';
import { mapState } from 'vuex';

Vue.use(excel);
Vue.use(DataTables);
Vue.use(DataTablesServer);

export default {
  components: {
    FacebookLoader
  },
  data: () => {
    return {
      titles: [
        { prop: 'name', label: 'Name' },
        { prop: 'role', label: 'Role' }
      ],
      userList: [],
      filters: [{ prop: 'name', value: '' }],
      tableProps: { defaultSort: { prop: 'name', order: 'descending' } },
      content: false
    };
  },
  created() {
    this.getUsers();

    eventBus.$on('new-user', () => {
      this.getUsers();
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    deleteUser(id) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'delete'
      );
      formData.set('id', id);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getUsers();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getUsers() {
      this.content = true;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'listing'
      );

      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.userList = response.data;
          this.content = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
