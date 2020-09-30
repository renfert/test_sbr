<template>
  <div style="">
    <el-card class="box-card">
      <div slot="header" class="clearfix">My social relationships</div>
      <el-row>
        <b>{{ lang['groups'] }}</b>
      </el-row>
      <el-select
        v-model="group_options"
        filterable
        placeholder="Select"
        @change="handleClickGroup()"
      >
        <el-option
          v-for="item in group_elements"
          :key="item.id"
          :label="item.name"
          :value="item.id"
        >
        </el-option>
      </el-select>

      <br />
      <br />
      <el-row>
        <b>{{ lang['courses'] }}</b>
      </el-row>
      <el-select
        v-model="course_options"
        filterable
        placeholder="Select"
        @change="handleClickCourse()"
      >
        <el-option
          v-for="item in course_elements"
          :key="item.id"
          :label="item.title"
          :value="item.id"
          @change="handleClickCourse(item.id)"
        >
        </el-option>
      </el-select>
    </el-card>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  head: {
    title: {
      inner: 'Courses'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  data() {
    return {
      users: [],
      group_elements: [],
      course_elements: [],
      group_options: '',
      course_options: ''
    };
  },
  methods: {
    getGroups() {
      this.$request
        .post(this.$getUrlToMakeRequest('group', 'listing'))
        .then((response) => {
          this.group_elements = response.data;
        });
    },
    getCourses() {
      this.$request
        .post(this.$getUrlToMakeRequest('course', 'listing'))
        .then((response) => {
          this.course_elements = response.data;
        });
    },
    handleClickGroup() {
      this.$router.push({
        name: 'groups-social',
        params: {
          group_id: this.group_options
        }
      });
    },
    handleClickCourse() {
      this.$router.push({
        name: 'courses-social',
        params: {
          course_id: this.course_options
        }
      });
    }
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  mounted() {
    this.getGroups();
    this.getCourses();
  }
};
</script>

<style scoped>
.box-card {
  border-radius: 30px;
  padding: 4%;
}
</style>
