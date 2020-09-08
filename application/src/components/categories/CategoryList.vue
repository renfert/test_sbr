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
          <el-table-column label="Actions" align="center">
            <template slot-scope="scope">
              <el-button
                size="small"
                class="sbr-primary"
                @click="openModalToEditCategory(scope.row.id, scope.row.name)"
                icon="el-icon-edit"
                circle
              ></el-button>

              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                placement="right"
                :title="lang['question-delete-category'] + scope.row.name + '?'"
                @onConfirm="deleteCategory(scope.row.id)"
              >
                <el-button
                  size="small"
                  class="sbr-danger ml-1"
                  slot="reference"
                  icon="el-icon-delete"
                  circle
                ></el-button>
              </el-popconfirm>
            </template>
          </el-table-column>
        </data-tables>
      </div>

      <div class="text-center mt-5" v-else>
        <h4>{{ lang['no-categories-found'] }}</h4>
        <img
          class="image-no-results"
          src="@/assets/img/general/ux/not_found.png"
        />
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
        <div class="form-group">
          <label>{{ lang['new-name'] }}</label>
          <el-input name="name" v-model="newCategoryName"></el-input>
        </div>
        <div class="form-group">
          <el-button
            @click.prevent="editCategory(categoryId)"
            class="sbr-primary"
            >{{ lang['save-button'] }}</el-button
          >
        </div>
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
