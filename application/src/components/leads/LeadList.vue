<template>
  <div class="card-box" v-if="leadList != null">
    <facebook-loader
      v-if="content == false"
      :speed="2"
      width="700"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <el-row>
        <el-col :sm="6" :xs="16" class="mr-3">
          <el-input
            v-model="table.filters[0].value"
            placeholder="Search"
          ></el-input>
        </el-col>
        <el-col v-if="leadList != null" :span="6">
          <export-excel :data="leadList" name="leads.xls">
            <el-tooltip
              class="item"
              effect="dark"
              :content="lang['export']"
              placement="top"
            >
              <el-button
                class="sbr-purple"
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
      :data="leadList"
      :filters="table.filters"
    >
      <el-table-column
        v-for="title in table.titles"
        sortable="custom"
        :prop="title.prop"
        :label="title.label"
        :key="title.label"
      ></el-table-column>
    </data-tables>
  </div>

  <div class="m-t-40 center" v-else>
    <img
      class="not-found-image"
      src="@/assets/img/general/ux/leads.svg"
      alt="No leads"
    />
    <h4 class="sbr-text-grey">{{ lang['no-leads-found'] }}</h4>
  </div>
</template>

<script>
import Vue from 'vue';
import excel from 'vue-excel-export';

import { DataTables } from 'vue-data-tables';
import { FacebookLoader } from 'vue-content-loader';
import { mapState } from 'vuex';

Vue.use(excel);
Vue.use(DataTables);

export default {
  components: {
    FacebookLoader
  },
  data: () => {
    return {
      table: {
        titles: [
          { prop: 'name', label: 'Name' },
          { prop: 'email', label: 'Email' },
          { prop: 'creation_date', label: 'Date' }
        ],
        filters: [{ prop: 'name', value: '' }],
        props: { defaultSort: { prop: 'name', order: 'descending' } }
      },
      leadList: [],
      modal: false,
      content: false
    };
  },
  mounted() {
    this.table.titles[0].label = this.lang.name;
    this.table.titles[1].label = this.lang.email;
    this.table.titles[2].label = this.lang.date;

    this.getLeads();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getLeads() {
      this.content = false;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lead',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.leadList = response.data;
          setTimeout(() => {
            this.content = true;
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
