<template>
  <div>
    <facebook-loader
      v-if="content == false"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <div v-if="programsBelongingToTheGroup != null">
        <div>
          <el-row>
            <el-col :sm="6" :xs="18">
              <el-input
                v-model="table.filters[0].value"
                placeholder="Search"
              ></el-input>
            </el-col>
            <el-col :span="2">
              <el-button
                @click.prevent="addProgram"
                class="sbr-purple"
                icon="el-icon-plus"
                circle
              ></el-button>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="programsBelongingToTheGroup"
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
              <!-- Remove program -->
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                :title="lang['remove-program-question'] + scope.row.title + '?'"
                @onConfirm="removeProgramFromGroup(scope.row.id)"
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
            src="@/assets/img/general/ux/no_programs.svg"
          />
          <h4 class="sbr-text-grey">
            {{ lang['no-results-instructors-in-group'] }}
          </h4>
          <el-button class="sbr-primary" @click="addProgram()">{{
            lang['add-program']
          }}</el-button>
        </el-col>
      </el-row>
    </div>

    <!-----------------------
      Add new program modal
    ------------------------->
    <el-dialog
      :visible.sync="modal"
      :title="lang['join-programs']"
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
        <div v-if="programsNotBelongingToTheGroup != null">
          <template>
            <el-transfer
              filterable
              :titles="['Programs', 'Group']"
              v-model="programs"
              :data="programsNotBelongingToTheGroup"
            ></el-transfer>
          </template>
          <br />
          <el-button
            v-loading="loadingButton"
            class="sbr-primary"
            @click="savePrograms()"
            >{{ lang['save-button'] }}</el-button
          >
        </div>

        <el-row v-else class="center">
          <el-col :sm="24">
            <img
              class="not-found-image"
              src="@/assets/img/general/ux/no_programs.svg"
            />
            <h4 class="sbr-text-grey">
              {{ lang['all-programs-already-added'] }}
            </h4>
          </el-col>
        </el-row>
      </div>
    </el-dialog>
    <!-----------------------
      End add new program modal
    ------------------------->
  </div>
</template>

<script>
import Vue from 'vue';

import { DataTables, DataTablesServer } from 'vue-data-tables';
import { FacebookLoader } from 'vue-content-loader';
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
        titles: [{ prop: 'title', label: 'Title' }],
        filters: [{ prop: 'title', value: '' }],
        props: { defaultSort: { prop: 'title', order: 'descending' } }
      },
      programsBelongingToTheGroup: [],
      programsNotBelongingToTheGroup: [],
      loading: false,
      content: false,
      contentModal: false,
      modal: false,
      programs: []
    };
  },
  created() {
    this.getProgramsThatBelongToGroup();
    this.getProgramsThatNotBelongToGroup();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    removeProgramFromGroup(programId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'removeProgramFromGroup'
      );
      formData.set('groupId', this.groupId);
      formData.set('programId', programId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getProgramsThatBelongToGroup();
          this.getProgramsThatNotBelongToGroup();
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    savePrograms() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'saveProgramsIntoGroup'
      );
      formData.set('programs', this.programs);
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.loading = false;
          this.modal = false;
          this.getProgramsThatBelongToGroup();
          this.getProgramsThatNotBelongToGroup();
          this.programs = [];
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    addProgram() {
      this.modal = true;
    },
    getProgramsThatBelongToGroup() {
      this.content = false;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'getProgramsInsideGroup'
      );
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.programsBelongingToTheGroup = response.data;
          setTimeout(() => {
            this.content = true;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getProgramsThatNotBelongToGroup() {
      this.contentModal = false;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'getProgramsOutsideGroup'
      );
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.programsNotBelongingToTheGroup = response.data;
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
