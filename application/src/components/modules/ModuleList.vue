<template>
  <div class="main">
    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <div v-if="modules != null">
        <draggable v-model="modules" ghost-class="ghost" @end="finishRepositioning">
          <transition-group type="transition" name="flip-list">
            <div class="sortable" v-for="element in modules" :key="element.id">
              <li class="module" :id="element.id">
                <el-collapse accordion>
                  <el-badge
                    style="color:red;"
                    :value="element.totalLessons"
                    class="item"
                    type="primary"
                  >
                    <el-collapse-item>
                      <template slot="title">
                        <!-- Add lesson -->
                        <el-tooltip
                          class="item"
                          effect="dark"
                          :content="lang['add-new-lesson']"
                          placement="top-start"
                        >
                          <el-button
                            class="sbr-purple mr-1"
                            data-toggle="tooltip"
                            title="Another one here too"
                            @click.prevent="openLessonsModal(element.id)"
                            type="success"
                            size="small"
                            icon="el-icon-plus"
                            circle
                          ></el-button>
                        </el-tooltip>

                        <!-- Edit module -->
                        <el-tooltip
                          class="item"
                          effect="dark"
                          :content="lang['edit-module']"
                          placement="top-start"
                        >
                          <el-button
                            class="sbr-primary mr-1"
                            @click.prevent="openEditModuleModal(element.id,element.title,element.required_to_next, element.release_date)"
                            type="primary"
                            size="small"
                            icon="el-icon-edit"
                            circle
                          ></el-button>
                        </el-tooltip>

                        <!-- Delete module -->
                        <template>
                          <el-popconfirm
                            confirmButtonText="Ok"
                            cancelButtonText="No, Thanks"
                            placement="right"
                            :title="lang['question-delete-module'] +element.title  + '?'"
                            @onConfirm="deleteModule(element.id)"
                          >
                            <el-button
                              class="sbr-danger mr-1"
                              slot="reference"
                              type="danger"
                              size="small"
                              icon="el-icon-delete"
                              circle
                            ></el-button>
                          </el-popconfirm>
                        </template>
                        <!-- Move module -->
                        <el-tooltip
                          class="item"
                          effect="dark"
                          :content="lang['reposition-module']"
                          placement="top-start"
                        >
                          <el-button
                            class="handle sbr-neutral mr-1"
                            type="purple"
                            size="small"
                            icon="el-icon-rank"
                            circle
                          ></el-button>
                        </el-tooltip>
                        <el-divider direction="vertical"></el-divider>
                        <span class="moduleTitle">{{element.title}}</span>
                      </template>
                      <div>
                        <lesson-list :module-id="element.id"></lesson-list>
                      </div>
                    </el-collapse-item>
                  </el-badge>
                </el-collapse>
              </li>
            </div>
          </transition-group>
        </draggable>
      </div>
      <!-- End accordion -->

      <div class="box-no-results" v-else>
        <div class="row">
          <div class="col-1"></div>
          <div class="col-xl-6 col-md-6">
            <div class="text-no-results">
              <h4>{{lang["no-results-module-title"]}}</h4>
              <p>
                {{lang["no-results-module-subtitle"]}}
                <span
                  class="text-sabiorealm-secondary"
                >{{lang["no-results-module-subtitle-highlight"]}}</span>
              </p>
              <el-button
                class="sbr-btn sbr-primary mt-3"
                @click.prevent="openModuleModal()"
                type="primary"
                size="medium"
              >{{lang["new-module"]}}</el-button>
            </div>
          </div>
          <div class="col-xl-5 col-md-5">
            <img class="image-no-results" src="@/assets/img/general/ux/modules.png" alt="modules" />
          </div>
        </div>
      </div>
      <el-button
        v-if="modules != null"
        class="sbr-btn sbr-primary mt-5"
        @click.prevent="openModuleModal()"
        type="primary"
        size="medium"
      >{{lang["new-module"]}}</el-button>
    </div>

    <!--  Modal edit module -->
    <div>
      <el-dialog :visible.sync="modalEditModule" :title="moduleTitle" center top="5vh">
        <form id="form-module" @submit.prevent="editModule()">
          <div class="form-row">
            <!-- Module id -->
            <input type="number" class="hide" name="id" v-model="moduleId" />
            <div class="form-group col-xl-12 col-md-12">
              <!-- Module name -->
              <label class="col-form-label">{{lang["new-name"]}} *</label>
              <el-input required v-model="moduleTitle" name="title"></el-input>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-xl-6 col-md-6">
              <!-- Module release date -->
              <label class="col-form-label">{{lang["start-date"]}}</label>
              <br />
              <el-date-picker
                v-model="moduleReleaseDate"
                name="date"
                type="date"
                format="yyyy/MM/dd"
                value-format="yyyy-MM-dd"
                placeholder="Pick a day"
              ></el-date-picker>
            </div>
            <div class="form-group col-xl-6 col-md-6">
              <!-- Module requirement -->
              <label style="margin-bottom:4%;" class="col-form-label">{{lang["required-module"]}}</label>
              <br />
              <div class="input-group">
                <el-switch name="required" v-model="moduleRequired" active-color="#09dfff"></el-switch>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-xl-6 col-md-6">
              <el-button
                v-loading="loadingButton"
                class="sbr-btn sbr-primary"
                type="primary"
                @click.prevent="editModule()"
                size="medium"
              >{{lang["save-button"]}}</el-button>
            </div>
          </div>
        </form>
      </el-dialog>
    </div>
    <!-- End  modal new module -->

    <!--  Modal lessons -->
    <div>
      <el-dialog
        :visible.sync="modalChooseLessons"
        :title="lang['choose-your-content']"
        center
        top="5vh"
      >
        <div class="row">
          <!-- Video -->
          <div class="col-xl-3 col-md-3 lesson">
            <a @click.prevent="emitNewLessonEvent('new-video')">
              <img
                src="@/assets/img/class/video.png"
                class="img-thumbnail img-responsive lesson-img"
              />
              <br />
              <span>Video</span>
            </a>
          </div>
          <!-- Audio -->
          <div class="col-xl-3 col-md-3 lesson">
            <a @click.prevent="emitNewLessonEvent('new-audio')">
              <img
                src="@/assets/img/class/audio.png"
                class="lesson-img img-thumbnail img-responsive"
              />
              <br />
              <span>Audio</span>
            </a>
          </div>
          <!-- Pdf -->
          <div class="col-xl-3 col-md-3 lesson">
            <a @click.prevent="emitNewLessonEvent('new-pdf')">
              <img src="@/assets/img/class/pdf.png" class="lesson-img img-thumbnail img-responsive" />
              <br />
              <span>Pdf</span>
            </a>
          </div>
          <!-- Downloaded -->
          <div class="col-xl-3 col-md-3 lesson">
            <a @click.prevent="emitNewLessonEvent('new-downloadable')">
              <img
                src="@/assets/img/class/downloadable.png"
                class="lesson-img img-thumbnail img-responsive"
              />
              <br />
              <span>Downloadable</span>
            </a>
          </div>
        </div>
        <br />
        <hr />
        <br />
        <div class="row">
          <!-- HTML -->
          <div class="col-xl-3 col-md-3 lesson" v-if="plan == 'bussiness' || plan == 'trial'">
            <a @click.prevent="emitNewLessonEvent('new-html')">
              <img
                src="@/assets/img/class/html.png"
                class="lesson-img img-thumbnail img-responsive"
              />
              <br />
              <span>Html</span>
            </a>
          </div>

          <!-- HTML -->
          <div class="col-xl-3 col-md-3 lesson" v-else>
            <a @click.prevent="upgradePlan()">
              <img
                src="@/assets/img/general/ux/file_block.png"
                class="lesson-img img-thumbnail img-responsive"
              />
              <br />
              <span>Html</span>
            </a>
          </div>
          <!-- Webinar -->
          <div
            class="col-xl-3 col-md-3 lesson"
            v-if="plan != 'basic' && plan != 'trial' && plan != 'pro' "
          >
            <a @click.prevent="emitNewLessonEvent('new-webinar')">
              <img
                src="@/assets/img/class/webinar.png"
                class="lesson-img img-thumbnail img-responsive"
              />
              <br />
              <span>Webinar</span>
            </a>
          </div>

          <!-- Webinar -->
          <div class="col-xl-3 col-md-3 lesson" v-else>
            <a @click.prevent="upgradePlan()">
              <img
                src="@/assets/img/general/ux/file_block.png"
                class="lesson-img img-thumbnail img-responsive"
              />
              <br />
              <span>Webinar</span>
            </a>
          </div>

          <!-- Videoconf -->
          <div class="col-xl-3 col-md-3 lesson">
            <a @click.prevent="emitNewLessonEvent('new-videoconf')">
              <img
                src="@/assets/img/class/videoconf.png"
                class="lesson-img img-thumbnail img-responsive"
              />
              <br />
              <span>Videoconf</span>
            </a>
          </div>
          <!-- Exam -->
          <div class="col-xl-3 col-md-3 lesson" v-if="plan != 'basic' && plan != 'trial'">
            <a @click.prevent="emitNewLessonEvent('new-exam')">
              <img
                src="@/assets/img/class/exam.png"
                class="lesson-img img-thumbnail img-responsive"
              />
              <br />
              <span>Exam</span>
            </a>
          </div>

          <!-- Exam -->
          <div class="col-xl-3 col-md-3 lesson" v-else>
            <a @click.prevent="upgradePlan()">
              <img
                src="@/assets/img/general/ux/file_block.png"
                class="lesson-img img-thumbnail img-responsive"
              />
              <br />
              <span>Exam</span>
            </a>
          </div>
        </div>
      </el-dialog>
    </div>

    <!-- End  modal lesson -->
    <lesson-create :module-id="moduleId"></lesson-create>
    <lesson-video-edit></lesson-video-edit>
    <lesson-audio-edit></lesson-audio-edit>
    <lesson-pdf-edit></lesson-pdf-edit>
    <lesson-downloadable-edit></lesson-downloadable-edit>
    <lesson-html-edit></lesson-html-edit>
    <lesson-webinar-edit></lesson-webinar-edit>
    <lesson-video-conf-edit></lesson-video-conf-edit>
    <lesson-exam-edit></lesson-exam-edit>
    <question-create></question-create>
    <question-edit></question-edit>
    <answer-create></answer-create>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import LessonCreate from "@/components/lessons/LessonCreate";
import LessonList from "@/components/lessons/LessonList";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import draggable from "vuedraggable";
import $ from "jquery";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import LessonVideoEdit from "@/components/lessons/edit/types/LessonVideoEdit";
import LessonAudioEdit from "@/components/lessons/edit/types/LessonAudioEdit";
import LessonPdfEdit from "@/components/lessons/edit/types/LessonPdfEdit";
import LessonDownloadableEdit from "@/components/lessons/edit/types/LessonDownloadableEdit";
import LessonHtmlEdit from "@/components/lessons/edit/types/LessonHtmlEdit";
import LessonWebinarEdit from "@/components/lessons/edit/types/LessonWebinarEdit";
import LessonVideoConfEdit from "@/components/lessons/edit/types/LessonVideoConfEdit";
import LessonExamEdit from "@/components/lessons/edit/types/LessonExamEdit";
import QuestionCreate from "@/components/questions/QuestionCreate";
import QuestionEdit from "@/components/questions/QuestionEdit";
import AnswerCreate from "@/components/answers/AnswerCreate";

import { eventBus } from "@/components/newcourse/App";
import { mapState } from "vuex";
import { eventPlan } from "@/components/plans/UpgradePlan";
import { FacebookLoader } from "vue-content-loader";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  components: {
    draggable,
    LessonCreate,
    LessonList,
    LessonVideoEdit,
    LessonAudioEdit,
    LessonPdfEdit,
    LessonDownloadableEdit,
    LessonHtmlEdit,
    LessonWebinarEdit,
    LessonVideoConfEdit,
    LessonExamEdit,
    QuestionCreate,
    QuestionEdit,
    AnswerCreate,
    FacebookLoader
  },
  data: function() {
    return {
      modules: null,
      modalEditModule: false,
      moduleId: "",
      moduleTitle: "",
      moduleReleaseDate: "",
      moduleRequired: false,
      modalChooseLessons: false,
      loadingContent: false,
      loadingButton: false,
      plan: ""
    };
  },
  props: ["course"],

  mounted() {
    this.getCompanyInformation();

    eventBus.$on(
      "new-module",
      function() {
        this.getModules(this.course);
      }.bind(this)
    );

    eventBus.$on(
      "response-access-second-step",
      function(response) {
        if (response == true) {
          this.getModules();
        }
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    myCustomPreviousStepCallback(currentStep) {
      alert(currentStep);
    },
    myCustomNextStepCallback(currentStep) {
      if (currentStep == 3) {
        eventBus.$emit("access-second-step");
      }
    },
    upgradePlan: function() {
      eventPlan.$emit("upgrade-plan", "feature");
    },

    getCompanyInformation() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "company",
        "getCompanyInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.plan = response.data["plan"];
        }.bind(this)
      );
    },

    openModuleModal: function() {
      eventBus.$emit("open-module-modal");
    },

    finishRepositioning: function() {
      this.reorderModulePositions();
    },

    emitNewLessonEvent: function(type) {
      eventBus.$emit("create-lesson", type);
      this.modalChooseLessons = false;
    },

    openLessonsModal: function(id) {
      this.modalChooseLessons = true;
      this.moduleId = id;
      this.loadingLessons = false;
    },

    editModule: function() {
      this.loadingButton = true;
      var form = document.getElementById("form-module");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("module", "edit");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.actionsToBePerformedAfterEdit();
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },

    openEditModuleModal: function(id, title, required, date) {
      this.moduleId = id;
      this.moduleTitle = title;

      if (required == "on") {
        this.moduleRequired = true;
      } else {
        this.moduleRequired = false;
      }

      if (date == null || date == "" || date == "0000-00-00") {
        this.moduleReleaseDate = "";
      } else {
        this.moduleReleaseDate = date;
      }

      this.modalEditModule = true;
    },

    deleteModule: function(id) {
      var formData = new FormData();
      formData.set("id", id);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "module",
        "delete"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getModules(this.course);
          this.successMessage();
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },

    reorderModulePositions: function() {
      var ar = [];
      $(".module").each(function(index) {
        var id = $(this).attr("id");
        ar.push({ id: id, index: index });
      });
      var formData = new FormData();
      $.each(ar, function(index, value) {
        formData.set("module[" + value.id + "]", value.index);
      });
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "module",
        "reorder"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          /* Success callback */
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getModules: function() {
      this.loadingContent = true;
      var formData = new FormData();
      formData.set("courseId", this.course);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "module",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.modules = response.data;
          setTimeout(
            function() {
              this.loadingContent = false;
            }.bind(this),
            1000
          );
        },
        /* Error callback */

        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    actionsToBePerformedAfterEdit() {
      this.getModules(this.course);
      this.modalEditModule = false;
      this.loadingButton = false;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.moduleTitle {
  font-family: "Poppins", sans-serif;
  font-weight: 400;
  font-size: 16px;
  margin-left: 20px;
}

.el-button + .el-button {
  margin-left: 0px !important;
}

.el-badge {
  width: 100% !important;
}

#accordion > .card {
  margin-bottom: 2%;
}

.btn-link {
  padding: 0px !important;
  font-size: 13px;
  font-family: "Poppins", sans-serif;
  font-weight: 600;
}

.btn.link:hover {
  text-decoration: none !important;
}

.card-header {
  padding: 10px !important;
}

.btn-eadtools-rounded {
  border-radius: 50%;
  cursor: pointer;
  display: inline-block;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
  position: relative;
  height: 40px;
  width: 40px;
  background-color: #d696ef;
  z-index: 2;
  border: none;
  color: white;
  margin: 0 0.2rem;
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

.card {
  margin-bottom: 15px;
}

.handle {
  cursor: move !important;
}

li {
  list-style-type: none;
}

.lesson {
  text-align: center;
  text-transform: uppercase;
  font-size: 10px;
}

.lesson span {
  font-family: "Poppins", sans-serif;
  margin-top: 3em;
  font-size: 1em;
}

.lesson-img {
  width: 60%;
}

.box-no-results {
  background-color: white;
}

.image-no-results {
  width: 85%;
}

.text-no-results {
  margin-top: 10%;
}
</style>
