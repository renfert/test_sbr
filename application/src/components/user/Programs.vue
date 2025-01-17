<template>
  <div class="m-t-40 m-l-40">
    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else class="m-b-40">
      <!-- Programs list content -->
      <div class="program-content" v-if="enrolledPrograms != null">
        <div>
          <el-row>
            <el-col :md="6" :xs="18">
              <el-input
                v-model="filters[0].value"
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
          :data="enrolledPrograms"
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
              <!-- Remove program -->
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                :title="lang['remove-program-question'] + scope.row.title + '?'"
                @onConfirm="removeProgramFromUser(scope.row.id)"
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
      <!-- Programs list content -->

      <!--------------
      Programs not found
      --------------->
      <el-row v-else>
        <div class="text-center m-t-40">
          <img
            class="not-found-image"
            src="@/assets/img/general/ux/no_programs.svg"
          />
          <br />
          <h4 class="sbr-text-grey">
            {{ lang['no-results-programs-in-user'] }}
          </h4>
          <el-button class="sbr-purple" @click="addProgram()">{{
            lang['add-program']
          }}</el-button>
        </div>
      </el-row>
    </div>

    <!-- Add new program dialog -->
    <el-dialog
      :visible.sync="modal"
      :title="lang['join-programs']"
      center
      top="5vh"
    >
      <facebook-loader
        v-if="loadingContentModal == true"
        :speed="2"
        width="700"
        height="200"
        primaryColor="#f0f0f0"
        secondaryColor="#d9d9d9"
      ></facebook-loader>

      <div v-else>
        <div class="center" v-if="notEnrolledPrograms != null">
          <template>
            <el-transfer
              filterable
              :titles="['Courses', 'User']"
              v-model="programs"
              :data="notEnrolledPrograms"
            ></el-transfer>
          </template>
          <br />
          <el-button
            class="sbr-primary"
            v-loading="loadingButton"
            @click="enrollUserIntoPrograms()"
            >{{ lang['save-button'] }}</el-button
          >
        </div>

        <!--------------
      No programs
      --------------->
        <el-row v-else>
          <div class="center">
            <img
              class="not-found-image m-b-10"
              src="@/assets/img/general/ux/no_programs.svg"
            />
            <h4 class="sbr-text-grey">
              {{ lang['all-programs-already-added'] }}
            </h4>
          </div>
        </el-row>
      </div>
    </el-dialog>
  </div>
  <!-- End col-auto -->
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
  props: ['user-id'],
  data: () => {
    return {
      titles: [{ prop: 'title', label: 'Title' }],
      enrolledPrograms: [],
      notEnrolledPrograms: [],
      filters: [{ prop: 'title', value: '' }],
      tableProps: { defaultSort: { prop: 'title', order: 'descending' } },
      modal: false,
      programs: [],
      loadingButton: false,
      loadingContent: false,
      loadingContentModal: false
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  created() {
    this.getEnrolledPrograms();
    this.getNotEnrolledPrograms();
  },
  methods: {
    removeProgramFromUser(programId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'removeProgramFromUser'
      );
      formData.set('programId', programId);
      formData.set('userId', this.userId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getEnrolledPrograms();
          this.getNotEnrolledPrograms();
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },

    addProgram() {
      this.modal = true;
    },
    enrollUserIntoPrograms() {
      this.loadingButton = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'enrollUserIntoPrograms'
      );
      formData.set('userId', this.userId);
      formData.set('programs', this.programs);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.loadingButton = false;
          this.$successMessage();
          this.modal = false;
          this.getEnrolledPrograms();
          this.getNotEnrolledPrograms();
          this.programs = [];
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getEnrolledPrograms() {
      this.loadingContent = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getEnrolledPrograms'
      );
      formData.set('userId', this.userId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.enrolledPrograms = response.data;
          setTimeout(() => {
            this.loadingContent = false;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getNotEnrolledPrograms() {
      this.loadingContentModal = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getNotEnrolledPrograms'
      );
      formData.set('userId', this.userId);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.notEnrolledPrograms = response.data;
          setTimeout(() => {
            this.loadingContentModal = false;
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
