<template>
  <div class="m-t-40 m-l-20 m-r-20">
    <el-row :gutter="20" type="flex" class="row-bg" justify="space-around">
      <el-col :sm="8">
        <div class="card-box center">
          <div style="display: flex; justify-content: center">
            <div class="ins_info_thumb">
              <img
                src="http://www.nretnil.com/avatar/LawrenceEzekielAmos.png"
                class="img-fluid"
              />
            </div>
          </div>
          <div class="m-b-30">
            <h4>Robert</h4>
            <span>robert@gmail.com</span>
          </div>
          <el-collapse v-model="activeNames" @change="handleChange">
            <el-collapse-item title="Cursos" name="1">
              <div>
                Consistent with real life: in line with the process and logic of
                real life, and comply with languages and habits that the users
                are used to;
              </div>
              <div>
                Consistent within interface: all elements should be consistent,
                such as: design style, icons and texts, position of elements,
                etc.
              </div>
            </el-collapse-item>
            <el-collapse-item title="Programas" name="2">
              <div>
                Operation feedback: enable the users to clearly perceive their
                operations by style updates and interactive effects;
              </div>
              <div>
                Visual feedback: reflect current state by updating or
                rearranging elements of the page.
              </div>
            </el-collapse-item>
          </el-collapse>
        </div>
      </el-col>

      <el-col :sm="8">
        <div class="card-box center">
          <div style="display: flex; justify-content: center">
            <div class="ins_info_thumb">
              <img
                src="http://www.nretnil.com/avatar/LawrenceEzekielAmos.png"
                class="img-fluid"
              />
            </div>
          </div>
          <div class="m-b-30">
            <h4>Robert</h4>
            <span>robert@gmail.com</span>
          </div>
          <el-collapse v-model="activeNames" @change="handleChange">
            <el-collapse-item title="Cursos" name="1">
              <div>
                Consistent with real life: in line with the process and logic of
                real life, and comply with languages and habits that the users
                are used to;
              </div>
              <div>
                Consistent within interface: all elements should be consistent,
                such as: design style, icons and texts, position of elements,
                etc.
              </div>
            </el-collapse-item>
            <el-collapse-item title="Programas" name="2">
              <div>
                Operation feedback: enable the users to clearly perceive their
                operations by style updates and interactive effects;
              </div>
              <div>
                Visual feedback: reflect current state by updating or
                rearranging elements of the page.
              </div>
            </el-collapse-item>
          </el-collapse>
        </div>
      </el-col>

      <el-col :sm="8">
        <div class="card-box center">
          <div style="display: flex; justify-content: center">
            <div class="ins_info_thumb">
              <img
                src="http://www.nretnil.com/avatar/LawrenceEzekielAmos.png"
                class="img-fluid"
              />
            </div>
          </div>
          <div class="m-b-30">
            <h4>Robert</h4>
            <span>robert@gmail.com</span>
          </div>
          <el-collapse v-model="activeNames" @change="handleChange">
            <el-collapse-item title="Cursos" name="1">
              <div>
                Consistent with real life: in line with the process and logic of
                real life, and comply with languages and habits that the users
                are used to;
              </div>
              <div>
                Consistent within interface: all elements should be consistent,
                such as: design style, icons and texts, position of elements,
                etc.
              </div>
            </el-collapse-item>
            <el-collapse-item title="Programas" name="2">
              <div>
                Operation feedback: enable the users to clearly perceive their
                operations by style updates and interactive effects;
              </div>
              <div>
                Visual feedback: reflect current state by updating or
                rearranging elements of the page.
              </div>
            </el-collapse-item>
          </el-collapse>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import Vue from 'vue';

import { DataTables, DataTablesServer } from 'vue-data-tables';
import { mapState } from 'vuex';

Vue.use(DataTables);
Vue.use(DataTablesServer);

export default {
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
