<template>
  <div>
    <div v-if="content == true">
      <h4 class="fw-700">{{ lang['create-program'] }}</h4>
      <br />
      <form @submit.prevent="createProgram()" id="form-program">
        <el-tabs tab-position="top">
          <!--------------------
            Basic information tab
          ----------------------->
          <el-tab-pane label="Basic information">
            <div class="row mt-5">
              <div class="col-10">
                <div class="form-group">
                  <label>{{ lang['name'] }}</label>
                  <el-input
                    required
                    name="title"
                    :placeholder="lang['name']"
                    v-model="program.name"
                  ></el-input>
                </div>
                <div class="form-group">
                  <label>{{ lang['start-date'] }}</label>
                  <br />
                  <el-date-picker
                    name="release_date"
                    v-model="program.releaseDate"
                    type="date"
                    format="yyyy/MM/dd"
                    value-format="yyyy-MM-dd"
                    placeholder="Pick a day"
                  ></el-date-picker>
                </div>
                <div class="form-group">
                  <label>{{ lang['end-date'] }}</label>
                  <br />
                  <el-date-picker
                    name="expiration_date"
                    v-model="program.expirationDate"
                    type="date"
                    format="yyyy/MM/dd"
                    value-format="yyyy-MM-dd"
                    placeholder="Pick a day"
                  ></el-date-picker>
                </div>
                <div class="form-group">
                  <!-- Program description -->
                  <textarea
                    class="hide"
                    v-model="program.description"
                    name="description"
                  ></textarea>
                  <label class="col-form-label">
                    {{ lang['description'] }}
                  </label>
                  <wysiwyg v-model="program.description" />
                </div>
              </div>
            </div>
          </el-tab-pane>
          <!--------------------
          Courses tab
          ----------------------->
          <el-tab-pane label="Courses">
            <div class="mt-5">
              <div>
                <el-form :inline="true" class="demo-form-inline">
                  <el-form-item>
                    <el-select v-model="course" placeholder="Course">
                      <el-option
                        v-for="element in coursesList"
                        :key="element.key"
                        :label="element.label"
                        :value="element.key"
                      ></el-option>
                    </el-select>
                  </el-form-item>
                  <el-form-item>
                    <el-button
                      class="sbr-purple"
                      @click.prevent="addCourse()"
                      type="primary"
                      >{{ lang['add-course'] }}</el-button
                    >
                  </el-form-item>
                </el-form>
                <div class="mb-5">
                  <ul class="list-group">
                    <draggable ghost-class="ghost" @end="repositioning">
                      <transition-group type="transition" name="flip-list">
                        <li
                          class="list-group-item d-flex justify-content-between align-items-center sortable"
                          v-for="element in selectedCourses"
                          :key="element.id"
                        >
                          <div v-html="element.text"></div>
                        </li>
                      </transition-group>
                    </draggable>
                  </ul>
                </div>
              </div>
            </div>
          </el-tab-pane>
          <!--------------------
          Image tab
          ----------------------->
          <el-tab-pane label="Image">
            <div class="row mt-5">
              <div class="col-md-6 col-12">
                <upload
                  do-upload="true"
                  box-height="200"
                  return-name="photo"
                  input-name="file"
                  bucket-key="uploads/program"
                  acceptable=".png,.jpg,.jpeg"
                ></upload>
              </div>
            </div>
          </el-tab-pane>
        </el-tabs>
        <br />
        <el-button native-type="submit" class="sbr-primary">
          {{ lang['save-button'] }}
        </el-button>
      </form>
    </div>
    <helper-progress></helper-progress>
    <program-created
      :class="programId == '' ? 'hide' : ''"
      :program-name="programName"
      :program-id="programId"
    ></program-created>
  </div>
</template>

<script>
import Vue from 'vue';
import draggable from 'vuedraggable';
import ProgramCreated from '@/components/newprogram/ProgramCreated';
import HelperProgress from '@/components/helper/HelperProgress.vue';
import wysiwyg from 'vue-wysiwyg';
import Upload from '@/components/helper/HelperUpload';
import $ from 'jquery';
import { mapState } from 'vuex';

Vue.use(wysiwyg, {
  hideModules: { image: true, code: true, table: true, hyperlink: true }
});

export default {
  data: () => {
    return {
      program: {
        id: '',
        name: '',
        description: '',
        releaseDate: '',
        expirationDate: ''
      },
      course: '',
      coursesList: [],
      selectedCourses: [],

      modal: false,
      content: true,

      cont: 0
    };
  },
  components: {
    Upload,
    draggable,
    ProgramCreated,
    HelperProgress
  },
  mounted() {
    this.removeCourse();
    this.getCourses();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    removeCourse() {
      $(document).ready(() => {
        $(document).on('click', '.remove-course', () => {
          const el = $(this).parent().parent();
          el.remove();
        });
      });
    },
    repositioning() {
      $('.courses-position').each((index) => {
        $(this).attr('name', 'courses[' + index + ']');
      });
    },
    addCourse() {
      const course = this.coursesList.find(
        (element) => element.key === this.course
      );

      const obj = {
        id: this.course,
        text:
          "<i style='cursor:pointer !important;' class='remove-course el-icon-delete sbr-text-danger mr-5'></i><input class='courses-position hide' name='courses[" +
          this.cont +
          "]' value='" +
          this.course +
          "'>" +
          course.label +
          ''
      };
      this.cont++;
      this.selectedCourses.push(obj);
    },
    getCourses() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'program',
        'getCourses'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.coursesList = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    createProgram() {
      const form = document.getElementById('form-program');
      const urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        'program',
        'create'
      );
      const formData = new FormData(form);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.program.id = response.data;
          this.content = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
li {
  cursor: grab;
}

.sortable-drag {
  opacity: 0;
}

.flip-list-move {
  transition: transform 0.5s;
}

.ghost {
  border-left: 6px solid rgb(0, 183, 255);
  border-radius: 5px;
  opacity: 0.5;
}
</style>
