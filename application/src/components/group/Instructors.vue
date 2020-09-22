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
      <div v-if="instructorsBelongingToTheGroup != null">
        <div>
          <el-row :gutter="40">
            <el-col :sm="6" :xs="18">
              <el-input
                v-model="table.filters[0].value"
                placeholder="Search"
              ></el-input>
            </el-col>
            <el-col :sm="2">
              <el-button
                @click.prevent="addInstructor"
                class="sbr-purple"
                icon="el-icon-plus"
                circle
              ></el-button>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="instructorsBelongingToTheGroup"
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
                :title="
                  lang['remove-instructor-question'] + scope.row.name + '?'
                "
                @onConfirm="removeInstructorFromGroup(scope.row.id)"
              >
                <el-button
                  class="sbr-danger"
                  size="small"
                  slot="reference"
                  icon="el-icon-delete"
                  circle
                ></el-button>
              </el-popconfirm>
            </template>
          </el-table-column>
        </data-tables>
      </div>

      <el-row class="center m-t-40 m-b-40" v-else>
        <el-col :sm="24">
          <img
            class="not-found-image"
            src="@/assets/img/general/ux/instructor.svg"
          />
          <h4 class="sbr-text-grey">
            {{ lang['no-results-instructors-in-group'] }}
          </h4>
          <el-button class="sbr-primary" @click="addInstructor()">{{
            lang['add-instructor']
          }}</el-button>
        </el-col>
      </el-row>
    </div>

    <!-------------------------
      Add new instructor modal
    --------------------------->
    <el-dialog
      :visible.sync="modal"
      :title="lang['join-instructors']"
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

      <div v-else>
        <div class="center" v-if="instructorsNotBelongingToTheGroup != null">
          <template>
            <el-transfer
              filterable
              :titles="['Instructors', 'Group']"
              v-model="instructors"
              :data="instructorsNotBelongingToTheGroup"
            ></el-transfer>
          </template>
          <br />
          <el-button
            v-loading="loading"
            class="sbr-primary"
            @click="saveInstructors()"
            type="primary"
            size="medium"
            >{{ lang['save-button'] }}</el-button
          >
        </div>

        <el-row v-else class="center">
          <el-col :sm="24">
            <img
              class="not-found-image"
              src="@/assets/img/general/ux/instructor.svg"
            />
            <h4 class="sbr-text-grey">
              {{ lang['all-instructors-already-added'] }}
            </h4>
          </el-col>
        </el-row>
      </div>
    </el-dialog>
    <!-------------------------
    End add new instructor modal
    --------------------------->
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
  props: ['group-id'],
  data: () => {
    return {
      table: {
        titles: [{ prop: 'name', label: 'Name' }],
        filters: [{ prop: 'name', value: '' }],
        props: { defaultSort: { prop: 'name', order: 'descending' } }
      },
      instructorsBelongingToTheGroup: [],
      instructorsNotBelongingToTheGroup: [],
      instructors: [],
      loading: false,
      content: false,
      contentModal: false,
      modal: false
    };
  },
  created() {
    this.getInstructorsThatBelongToGroup();
    this.getInstructorThatNotBelongToGroup();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    removeInstructorFromGroup(instructorId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'removeUserFromGroup'
      );
      formData.set('userId', instructorId);
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getInstructorsThatBelongToGroup();
          this.getInstructorThatNotBelongToGroup();
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    saveInstructors() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'saveUsersIntoGroup'
      );
      formData.set('groupId', this.groupId);
      formData.set('users', this.instructors);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.loading = false;
          this.modal = false;
          this.getInstructorsThatBelongToGroup();
          this.getInstructorThatNotBelongToGroup();
          this.instructors = [];
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    addInstructor() {
      this.modal = true;
    },
    getInstructorsThatBelongToGroup() {
      this.content = false;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'getInstructorsInsideGroup'
      );
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.instructorsBelongingToTheGroup = response.data;
          setTimeout(() => {
            this.content = true;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getInstructorThatNotBelongToGroup() {
      this.contentModal = false;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'getInstructorsOutsideGroup'
      );
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.instructorsNotBelongingToTheGroup = response.data;
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
