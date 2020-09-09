<template>
  <div class="card-box table-responsive" v-if="groupList != null">
    <facebook-loader
      v-if="content == false"
      :speed="2"
      width="700"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <div>
        <h4>{{ lang['list-group'] }}</h4>
        <div style="margin-bottom: 10px">
          <el-row>
            <el-col :md="6">
              <el-input
                v-model="table.filters[0].value"
                placeholder="Search"
              ></el-input>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="groupList"
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
              <!-- Edit group -->
              <el-button
                class="sbr-primary mr-1"
                @click="openModalToEditGroup(scope.row.id, scope.row.name)"
                size="small"
                icon="el-icon-edit"
                circle
              ></el-button>

              <!-- Delete group -->
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                placement="right"
                :title="lang['question-delete-group'] + scope.row.name + '?'"
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

      <div>
        <!------------------
        Group edit modal
      -------------------->
        <el-dialog
          :visible.sync="modal"
          :title="group.name"
          center
          width="40%"
          top="5vh"
        >
          <div class="form-group">
            <label>{{ lang['new-name'] }}</label>
            <el-input name="name" v-model="group.newName"></el-input>
          </div>
          <div class="form-group">
            <el-button
              class="sbr-primary"
              @click.prevent="editGroup(group.id, group.newName)"
              >{{ lang['save-button'] }}</el-button
            >
          </div>
        </el-dialog>

        <!------------------
        Group edit modal
      -------------------->
      </div>
    </div>
  </div>

  <div class="row mb-5 mt-5" v-else>
    <div class="col-12 text-center">
      <img
        class="no-results-img"
        src="@/assets/img/general/ux/no_persons.png"
        alt="No persons"
      />
      <h4 class="no-results-text">{{ lang['no-results-group-title'] }}</h4>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

import { FacebookLoader } from 'vue-content-loader';
import { eventBus } from '@/components/groups/App';
import { DataTables, DataTablesServer } from 'vue-data-tables';
import { mapState } from 'vuex';

Vue.use(DataTables);
Vue.use(DataTablesServer);

export default {
  components: {
    FacebookLoader
  },
  data() {
    return {
      table: {
        titles: [{ prop: 'name', label: 'Name' }],
        filters: [{ prop: 'name', value: '' }],
        props: { defaultSort: { prop: 'name', order: 'descending' } }
      },
      group: {
        id: '',
        name: '',
        newName: ''
      },
      groupList: [],
      modal: false,
      content: false
    };
  },
  created() {
    this.getGroups();
    eventBus.$on('new-group', () => {
      this.getGroups();
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    openModalToEditGroup(id, name) {
      this.group.name = name;
      this.group.id = id;
      this.modal = true;
    },
    editGroup(id, name) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'edit'
      );
      formData.set('name', name);
      formData.set('id', id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          if (response.data === false) {
            this.groupAlreadyExistsMessage();
          } else {
            this.$successMessage();
            this.modal = false;
            this.group.newName = '';
            this.getGroups();
          }
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    deleteGroup(id) {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'delete'
      );
      const formData = new FormData();
      formData.set('id', id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getGroups();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getGroups() {
      this.content = false;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.groupList = response.data;
          setTimeout(() => {
            this.content = true;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    groupAlreadyExistsMessage() {
      this.$notify({
        title: this.lang.error,
        message: this.lang['group-already-exists'],
        type: 'warning',
        duration: 3500
      });
    }
  }
};
</script>
