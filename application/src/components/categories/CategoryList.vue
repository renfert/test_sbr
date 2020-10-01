<template>
  <div>
    <div class="card-box" v-if="content == false">
      <facebook-loader
        :speed="2"
        width="700"
        height="200"
        primaryColor="#f0f0f0"
        secondaryColor="#d9d9d9"
      ></facebook-loader>
    </div>

    <div v-else>
      <div class="card-box table-responsive" v-if="categoryList != null">
        <h4>{{ lang['list-category'] }}</h4>
        <div style="margin-bottom: 10px">
          <el-row>
            <el-col :xs="24" :lg="6">
              <el-input
                v-model="filters[0].value"
                placeholder="Search"
              ></el-input>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="categoryList"
          :filters="filters"
        >
          <el-table-column
            v-for="title in titles"
            sortable="custom"
            :prop="title.prop"
            :label="title.label"
            :key="title.label"
          ></el-table-column>
          <el-table-column :label="lang['actions']" align="center">
            <template slot-scope="scope">
              <el-tooltip
                class="item"
                effect="dark"
                :content="lang['edit-category']"
                placement="top"
              >
                <i
                  @click="openModalToEditCategory(scope.row.id, scope.row.name)"
                  class="el-icon-edit-outline table-icon table-icon-primary m-r-20"
                ></i>
              </el-tooltip>

              <el-tooltip
                class="item"
                effect="dark"
                :content="lang['delete-category']"
                placement="top"
              >
                <el-popconfirm
                  confirmButtonText="Ok"
                  cancelButtonText="No, Thanks"
                  placement="right"
                  :title="
                    lang['question-delete-category'] + scope.row.name + '?'
                  "
                  @onConfirm="deleteCategory(scope.row.id)"
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

      <div class="center m-t-40" v-else>
        <img
          class="not-found-image"
          src="@/assets/img/general/ux/no_categories.svg"
        />
        <h4 class="sbr-text-grey">{{ lang['no-categories-found'] }}</h4>
      </div>
    </div>

    <!--------------------
      Category edit modal
    --------------------->
    <div>
      <el-dialog
        :visible.sync="modal"
        :title="categoryName"
        center
        width="40%"
        top="5vh"
      >
        <el-row :gutter="20">
          <el-col :sm="12">
            <el-input
              :placeholder="lang['new-name']"
              clearable
              name="name"
              v-model="newCategoryName"
            ></el-input>
          </el-col>
          <el-col :sm="12">
            <el-button
              @click.prevent="editCategory(categoryId)"
              class="sbr-primary"
              >{{ lang['save-button'] }}</el-button
            >
          </el-col>
        </el-row>
      </el-dialog>
    </div>
    <!--------------------
      End category edit modal
    --------------------->
  </div>
</template>

<script>
import Vue from 'vue';
import { FacebookLoader } from 'vue-content-loader';
import { DataTables, DataTablesServer } from 'vue-data-tables';
import { eventBus } from '@/components/categories/App';
import { mapState } from 'vuex';

Vue.use(DataTables);
Vue.use(DataTablesServer);

export default {
  components: {
    FacebookLoader
  },
  data: () => {
    return {
      titles: [{ prop: 'name', label: 'Name' }],
      filters: [{ prop: 'name', value: '' }],
      tableProps: { defaultSort: { prop: 'name', order: 'descending' } },

      categoryList: null,
      categoryId: '',
      categoryName: '',
      newCategoryName: '',

      content: false,
      modal: false
    };
  },
  created() {
    this.titles[0].label = this.lang.name;

    this.getCategories();

    eventBus.$on('new-category', () => {
      this.getCategories();
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    openModalToEditCategory(id, name) {
      this.categoryName = name;
      this.categoryId = id;
      this.modal = true;
    },
    editCategory(id) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'category',
        'edit'
      );
      formData.set('name', this.newCategoryName);
      formData.set('id', id);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          if (response.data === false) {
            this.categoryAlreadyExistsMessage();
          } else {
            this.$successMessage();
            this.getCategories();
            this.newCategoryName = '';
            this.modal = false;
          }
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    deleteCategory(id) {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'category',
        'delete'
      );
      const formData = new FormData();
      formData.set('id', id);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getCategories();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getCategories() {
      this.content = false;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'category',
        'listing'
      );

      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.categoryList = response.data;
          this.content = true;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    categoryAlreadyExistsMessage() {
      this.$notify({
        title: this.lang.error,
        message: this.lang['category-already-exists'],
        type: 'warning',
        duration: 3500
      });
    }
  }
};
</script>
