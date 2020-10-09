<template>
  <div class="center">
    <h3 class="m-b-40">Agora, de onde gostaria de extrair este relatorio?</h3>
    <el-row :gutter="20">
      <!-- Specific group -->
      <el-col :xs="24" :md="8">
        <div class="card-box">
          <h4>Grupo</h4>
          <img
            class="report_type_image m-b-20"
            src="@/assets/img/general/ux/group.svg"
          />
          <el-select
            @change="emitGroupEvent()"
            :disabled="checkGroupDisableOption"
            v-model="groupId"
            filterable
            clearable
            placeholder="Select a group"
          >
            <el-option
              v-for="group in groups"
              :key="group.id"
              :label="group.name"
              :value="group.id"
            >
            </el-option>
          </el-select>
        </div>
      </el-col>
      <!-- End specific group -->

      <!-- Specific student -->
      <el-col :xs="24" :md="8">
        <div class="card-box">
          <h4>Estudante</h4>
          <img
            class="report_type_image m-b-20"
            src="@/assets/img/general/ux/user.svg"
          />
          <el-select
            @change="emitStudentEvent()"
            :disabled="checkStudentDisableOption"
            v-model="studentId"
            filterable
            clearable
            placeholder="Select a student"
          >
            <el-option
              v-for="student in students"
              :key="student.id"
              :label="student.name"
              :value="student.myuser_id"
            >
            </el-option>
          </el-select>
        </div>
      </el-col>
      <!-- End specific student -->

      <!-- Specific course -->
      <el-col :xs="24" :md="8">
        <div class="card-box">
          <h4>Curso</h4>
          <img
            class="report_type_image m-b-20"
            src="@/assets/img/general/ux/video_file.svg"
          />
          <el-select
            @change="emitCourseEvent()"
            :disabled="checkCourseDisableOption"
            v-model="courseId"
            filterable
            clearable
            placeholder="Select a course"
          >
            <el-option
              v-for="course in courses"
              :key="course.id"
              :label="course.title"
              :value="course.id"
            >
            </el-option>
          </el-select>
        </div>
      </el-col>
      <!-- End Specific course -->
    </el-row>
  </div>
</template>

<script>
import { eventBus } from '@/components/reports/App';

export default {
  data: () => {
    return {
      courseId: null,
      studentId: null,
      groupId: '',
      courses: [],
      groups: [],
      students: []
    };
  },
  mounted() {
    this.getCourses();
    this.getGroups();
    this.getStudents();
  },
  computed: {
    checkGroupDisableOption() {
      let result = null;
      if (parseInt(this.courseId) > 0 || parseInt(this.studentId) > 0) {
        result = true;
      } else {
        result = false;
      }
      return result;
    },
    checkCourseDisableOption() {
      let result = null;
      if (parseInt(this.groupId) > 0 || parseInt(this.studentId) > 0) {
        result = true;
      } else {
        result = false;
      }
      return result;
    },
    checkStudentDisableOption() {
      let result = null;
      if (parseInt(this.courseId) > 0 || parseInt(this.groupId) > 0) {
        result = true;
      } else {
        result = false;
      }
      return result;
    }
  },
  methods: {
    emitGroupEvent() {
      eventBus.$emit('select-group-report', this.groupId);
    },
    emitStudentEvent() {
      eventBus.$emit('select-student-report', this.studentId);
    },
    emitCourseEvent() {
      eventBus.$emit('select-course-report', this.courseId);
    },
    getCourses() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.courses = response.data;
      });
    },

    getGroups() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.groups = response.data;
      });
    },
    getStudents() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getStudents'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.students = response.data;
      });
    }
  }
};
</script>

<style scoped>
.card-box {
  cursor: pointer !important;
}
.report_type_image {
  width: 100%;
  height: 70px;
}
.el-row {
  padding: 0% 5%;
}
</style>
