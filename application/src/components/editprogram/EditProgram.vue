<template>
  <div>
    <h4>
      {{ lang['edit-program'] }}
    </h4>
    <br />
    <form @submit.prevent="edit()" id="form-program" v-loading="loading">
      <input name="programId" class="hide" type="text" v-model="program.id" />
      <el-tabs tab-position="top">
        <!--------------------
        Basic information tab
        ----------------------->
        <el-tab-pane label="Basic information">
          <div class="row gap5">
            <div class="col-10">
              <div class="form-group">
                <label>{{ lang['name'] }}</label>
                <el-input
                  required
                  name="title"
                  :placeholder="lang['name']"
                  v-model="program.title"
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
                <textarea
                  class="hide"
                  v-model="program.description"
                  name="description"
                ></textarea>
                <label class="col-form-label">{{ lang['description'] }}</label>
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
                  <draggable ghost-class="ghost" @end="repositioning()">
                    <transition-group type="transition" name="flip-list">
                      <li
                        v-for="element in coursesProgram"
                        :key="element.id"
                        class="list-group-item d-flex justify-content-between align-items-center sortable"
                      >
                        <div>
                          <i
                            style="cursor: pointer !important"
                            class="remove-course el-icon-delete sbr-text-danger mr-5"
                          ></i>
                          <input
                            class="courses-position hide"
                            :value="element.id"
                            :name="
                              'courses[' + parseInt(element.position) + ']'
                            "
                          />
                          {{ element.title }}
                        </div>
                      </li>

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
          <div class="row gap5">
            <div class="col-md-6 col-12">
              <upload
                v-if="program.image != ''"
                :src-img="program.image"
                :src-name="program.imageName"
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
      <el-button native-type="submit" class="sbr-primary">{{
        lang['save-button']
      }}</el-button>
    </form>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import Vue from 'vue';
import draggable from 'vuedraggable';
import HelperProgress from '@/components/helper/HelperProgress.vue';
import wysiwyg from 'vue-wysiwyg';
import Upload from '@/components/helper/HelperUpload';
import $ from 'jquery';

import { mapState } from 'vuex';

Vue.use(wysiwyg, {
  hideModules: {
    image: true,
    code: true,
    table: true,
    hyperlink: true
  }
});

export default {
  data: () => {
    return {
      program: {
        id: '',
        title: '',
        description: '',
        image: '',
        imageName: '',
        releaseDate: '',
        expirationDate: ''
      },
      course: '',
      coursesList: [],
      coursesProgram: [],
      selectedCourses: [],

      cont: 0,

      loading: false
    };
  },
  components: {
    Upload,
    draggable,
    HelperProgress
  },
  created() {
    this.programId = this.$route.params.id;
  },
  mounted() {
    this.getProgram();
    this.getCourses();
    this.getProgramCourses();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
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
    getProgram() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'program',
        'get'
      );
      formData.set('programId', this.programId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.program.title = response.data[0].title;
          this.program.description = response.data[0].description;
          this.program.imageName = response.data[0].photo;
          this.program.image =
            this.$getUrlToContents() + 'program/' + response.data[0].photo + '';

          this.program.expirationDate = response.data[0].expiration_date;
          this.program.releaseDate = response.data[0].release_date;
        },
        () => {
          this.$errorMessage();
        }
      );
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
    edit() {
      const form = document.getElementById('form-program');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'program',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getProgramCourses() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'program',
        'getProgramCourses'
      );
      formData.set('programId', this.programId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          response.data.forEach((element) => {
            this.cont = parseInt(element.position) + 1;
          });
          this.coursesProgram = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
