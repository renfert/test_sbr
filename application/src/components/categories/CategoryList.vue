<template>
   <div class="col-12">

        <div class="card-box"  v-if="loadingContent == true">
            <facebook-loader 
                :speed="2"
                width="700"
                height="200"
                primaryColor = "#f0f0f0"
                secondaryColor = "#d9d9d9"
            >
            </facebook-loader>
        </div>

        <div v-else>

            <!-- Category list -->
            <div class="card-box table-responsive" v-if="categoryList != null">
                <h4>{{lang["list-category"]}}</h4>
                <div style="margin-bottom: 10px">
                    <el-row>
                        <el-col :span="6">
                        <el-input v-model="filters[0].value" placeholder="Search"></el-input>
                        </el-col>
                    </el-row>
                </div>
                <data-tables  :pagination-props="{ background: true, pageSizes: [5] }"  :data="categoryList"  :filters="filters">
                    <el-table-column 
                        v-for="title in titles"  
                        sortable="custom" 
                        :prop="title.prop" 
                        :label="title.label" 
                        :key="title.label">
                    </el-table-column>
                    <el-table-column  label="Actions" align="center">
                        <template slot-scope="scope">
                            <!-- Edit category -->
                            <el-button 
                                class="btn-sabiorealm"
                                type="primary" 
                                @click="openModalToEditCategory(scope.row.id,scope.row.name)" 
                                size="medium" 
                                icon="el-icon-edit" 
                                circle>
                            </el-button>
                        
                            <!-- Delete category -->
                            <el-popconfirm  
                            confirmButtonText='Ok'
                            cancelButtonText='No, Thanks'
                            placement="right"
                            :title="lang['question-delete-category'] + scope.row.name  + '?'"
                            @onConfirm="deleteCategory(scope.row.id)"
                            >
                            <el-button  
                                class="btn-sabiorealm-danger"
                                slot="reference" 
                                type="danger"  
                                size="medium" 
                                icon="el-icon-delete" 
                                circle></el-button>
                            </el-popconfirm>
                        
                        </template>
                    </el-table-column>
                </data-tables>
            </div>  <!-- End category list -->

            <!-- No categories found content -->
            <div class="text-center mt-5" v-else>
                <h4>{{lang["no-categories-found"]}}</h4>
                <img class="image-no-results" src="@/assets/img/general/ux/not_found.png" alt="">
            </div>
            <!-- No categories found content end -->
        </div>
        
        <!-- Category edit modal -->
        <div>
            <el-dialog  :visible.sync="modal" :title="categoryName" center width="40%" top="5vh">
                <div class="form-group">
                    <label>{{lang["new-name"]}}</label>
                    <el-input  name="name" v-model="newCategoryName"></el-input>
                </div>
                <div class="form-group">
                    <el-button @click.prevent="editCategory(categoryId,newCategoryName)"  type="primary"  size="medium">{{lang["save-button"]}}</el-button>
                </div>
            </el-dialog>
        </div>
        <!-- End category edit modal -->
    </div><!-- End col-12 -->
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
import { DataTables, DataTablesServer } from 'vue-data-tables'
import {eventBus} from '@/pages/categories/App'
import {eventLang} from '@/components/helper/HelperLang'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import { FacebookLoader } from 'vue-content-loader';
locale.use(lang)
Vue.use(DataTables)
Vue.use(DataTablesServer)
Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    components: {
        FacebookLoader
    },
    mixins: [domains,alerts],
    data: function() {
        return {   
            titles : [{prop: "name",label: "Name"}],
            categoryList : [],
            filters: [{prop: 'name',value: ''}],
            tableProps: {defaultSort: {prop: 'name',order: 'descending'}},
            categoryId: '',
            categoryName: '',
            newCategoryName: '',
            loadingContent: false,
            lang: {},
            modal : false,
        }
    },
    created(){
        this.getCategories();
        eventBus.$on('new-category', function(){
            this.getCategories();
        }.bind(this));
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods:{
        openModalToEditCategory(id,name){
            this.categoryName = name;
            this.categoryId = id;
            this.modal = true;
        },
        editCategory(id,name){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("category", "edit");
            var formData = new FormData();
            formData.set('name', name);
            formData.set('id', id);
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                // success callback
                if(response.data == false){
                    this.categoryAlreadyExistsMessage();
                }else{
                    this.successMessage();
                    this.actionsToBePerformedAfterEdit();
                }
            }, function(){
                // Failure callback
                this.errorMessage();
            });
        },
        /* Delete a category function */
        deleteCategory(id){
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("category", "delete");
            var formData = new FormData();
            formData.set('id', id);
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                // success callback
                this.successMessage();
                this.getCategories(); 
            }, () => {
                // Failure callback
                this.errorMessage();
            });
        },
        getCategories(){
            this.loadingContent = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("category", "listing");
            axios.get(urlToBeUsedInTheRequest).then((response) => {
                // success callback
                this.categoryList = response.data; 
                setTimeout(function(){ 
                    this.loadingContent = false;
                }.bind(this), 1000);
            }, function(){
                // Failure callback
                this.errorMessage();
            });
        },
        categoryAlreadyExistsMessage(){
            this.$notify({
                title: this.lang['error'],
                message: this.lang["category-already-exists"],
                type: 'warning',
                duration: 3500
            });
        },
        actionsToBePerformedAfterEdit(){
            this.newCategoryName = ''; 
            this.getCategories();   
            this.modal = false; 
        }
    }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    .image-no-results{
        width:15%;
    }
    .box-no-results{
       background-color: #FCFCFC;
    }
    .text-no-results{
        margin-top:25%;
    }
</style>
