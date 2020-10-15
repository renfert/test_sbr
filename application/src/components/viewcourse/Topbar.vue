<template>
  <div class="nav-sticky">
    <nav
      class="navbar navbar-expand-lg navbar-expand navbar-dark special-color-dark text-nowrap flex-nowrap d-flex mobile-navbar"
    >
      <!-------------------
             Mobile topbar
      ----------------->
      <div class="collapse navbar-collapse" id="basicExampleNav">
        <ul class="navbar-nav mr-auto">
          <!-------------------
                      Back button
          ----------------->
          <li class="nav-item mr-2 ml-2 web-buttons">
            <router-link to="/courses">
              <el-button
                size="medium"
                class="sbr-primary"
                icon="el-icon-back"
                circle
              ></el-button>
            </router-link>
          </li>
          <li class="nav-item mr-2 ml-2 mobile-buttons">
            <router-link to="/courses">
              <el-button
                size="small"
                class="sbr-primary"
                icon="el-icon-back"
                circle
              ></el-button>
            </router-link>
          </li>
          <!-------------------
                      Certificate icon
          ----------------->
          <li class="nav-item" v-if="certificate != null">
            <a
              @click.prevent="printCertificate"
              v-if="progress == 100"
              class="nav-link course-title"
              href="javascript:void(0)"
            >
              <img
                class="cert"
                src="@/assets/img/general/ux/certificate.png"
                alt="certificate"
              />
            </a>

            <a
              v-else
              style="cursor: not-allowed"
              class="nav-link course-title"
              href="javascript:void(0)"
            >
              <el-tooltip
                class="item"
                effect="dark"
                :content="lang['certificate-unavailable']"
                placement="right"
              >
                <img
                  class="cert"
                  src="@/assets/img/general/ux/certificate.png"
                  alt="certificate"
                />
              </el-tooltip>
            </a>
          </li>
        </ul>

        <!-------------------
                 Prev and next buttons
        ----------------->
        <ul class="navbar-nav mx-auto web-buttons">
          <li class="nav-item" style="padding: 3%">
            <el-button
              class="sbr-btn sbr-primary mr-4"
              @click="prevLesson()"
              icon="el-icon-arrow-left"
              >Previous lesson
            </el-button>

            <el-button class="sbr-btn sbr-primary" @click="nextLesson()">
              Next lesson
              <i class="el-icon-arrow-right"></i>
            </el-button>
          </li>
        </ul>
        <li class="nav-item mobile-buttons">
          <el-button
            class="sbr-btn sbr-primary mr-1"
            @click="prevLesson()"
            icon="el-icon-arrow-left"
            size="small"
          >
          </el-button>
          <el-button
            size="small"
            class="sbr-btn sbr-primary"
            icon="el-icon-arrow-right"
            @click="nextLesson()"
          >
          </el-button>
        </li>

        <!-------------------
                  Course title
        ----------------->
        <ul class="navbar-nav mr-4">
          <li class="nav-item">
            <a class="nav-link course-title" href="#"></a>
          </li>
        </ul>
      </div>

      <!-------------------
             Progress bar
      ----------------->
      <div class="col-2 progress progress-viewcourse">
        <div
          class="progress-bar"
          role="progressbar"
          :style="style"
          :aria-valuenow="progress"
          aria-valuemin="0"
          aria-valuemax="100"
        ></div>
      </div>

      <!-------------------
             Print certificate
      ----------------->
      <certificate-print
        v-if="courseId != null && certificate != null"
        :course-id="courseId"
        :show="showCertificate"
      ></certificate-print>

      <!-------------------
              Review modal
      ----------------->
      <el-dialog
        :visible.sync="modalReview"
        center
        :title="lang['please-rate-my-course']"
        width="50%"
        top="5vh"
      >
        <div>
          <!-------------------
                      Review card
          ------------------>
          <div v-if="showThanksCard == false">
            <!-- Instructor information -->
            <div class="block text-center mb-3">
              <el-avatar
                :src="$getUrlToContents() + 'avatar/' + userCreatorAvatar + ''"
              ></el-avatar>
              <h4>
                <b>
                  <i>{{ userCreatorName }}</i>
                </b>
              </h4>
            </div>
            <!-- Rate -->
            <div class="block text-center mb-5">
              <h3>{{ lang['how-would-you-rate-this-course'] }}</h3>
              <el-rate v-model="rate"></el-rate>
            </div>
            <!-- Comment -->
            <div class="block mb-3">
              <h3 class="text-center">{{ lang['leave-a-comment'] }}</h3>
              <textarea
                v-model="comment"
                class="form-control"
                cols="30"
                rows="6"
              ></textarea>
            </div>
            <!-- Save button -->
            <div class="block text-center">
              <el-button
                @click.prevent="saveReview()"
                v-loading="loading"
                class="sbr-btn sbr-primary"
                >{{ lang['save-button'] }}
              </el-button>
            </div>
          </div>
          <!-------------------
                      End review card
          ------------------>

          <!-------------------
                      Thanks card
          ------------------>
          <div v-else>
            <!-- Instructor information -->
            <div class="block text-center mb-3">
              <el-avatar
                :src="$getUrlToContents() + 'avatar/' + userCreatorAvatar + ''"
              ></el-avatar>
              <h4>
                <b>
                  <i>{{ userCreatorName }}</i>
                </b>
              </h4>
            </div>

            <!-- Thanks message -->
            <div class="block text-center">
              <h3 class="sbr-text-primary">
                {{ lang['thanks-for-your-feedback'] }}
              </h3>
              <h2>
                <i class="far fa-grin-wink"></i>
              </h2>
            </div>
          </div>
          <!-------------------
                      End thanks card
          ------------------>
        </div>
      </el-dialog>
      <!-------------------
              End Review modal
      ----------------->
    </nav>
  </div>
</template>

<script>
import $ from 'jquery';
import CertificatePrint, {
  eventCertificate
} from '@/components/certificates/CertificatePrint';
import { mapState } from 'vuex';
import { eventBus } from '@/components/viewcourse/App';

export default {
  components: {
    CertificatePrint
  },
  data: () => {
    return {
      title: null,
      reviews: null,
      progress: '',
      certificate: null,
      companyName: '',
      courseId: null,
      showCertificate: false,
      userCreatorName: '',
      userCreatorEmail: '',
      userCreatorAvatar: '',
      rate: 5,
      comment: '',
      loading: false,

      courseHasAlreadyBeenEvaluated: false,

      showThanksCard: false,
      modalReview: false
    };
  },
  created() {
    this.courseId = this.$route.params.id;
    this.checkIfCourseHasAlreadyBeenEvaluated(this.courseId);
  },
  mounted() {
    this.getCourseCreator();

    eventBus.$on('update-progress-bar', () => {
      this.getCourseProgress(this.courseId);
    });
  },
  methods: {
    saveReview() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'reviews',
        'saveReview'
      );
      formData.set('courseId', this.courseId);
      formData.set('comment', this.comment);
      formData.set('rate', this.rate);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.loading = false;
          this.showThanksCard = true;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    openReviewModal(progress) {
      if (
        parseInt(progress) > 98 &&
        this.courseHasAlreadyBeenEvaluated === false &&
        this.reviews != null
      ) {
        this.modalReview = true;
      }
    },
    getCourseCreator() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'getCourseCreator'
      );
      formData.set('courseId', this.courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.userCreatorEmail = response.data.email;
          this.userCreatorName = response.data.name;
          this.userCreatorAvatar = response.data.avatar;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    changeLeftBarClass() {
      eventBus.$emit('change-leftbar-class');
    },
    printCertificate() {
      eventCertificate.$emit('print-certificate');
    },
    nextLesson() {
      const currentLesson = $('.list_lesson.lesson_active');
      console.log(currentLesson);
      const nextLesson = currentLesson.next('li.list_lesson');
      nextLesson.click();
    },
    prevLesson() {
      const currentLesson = $('.list_lesson.lesson_active');
      const prevLesson = currentLesson.prev('li.list_lesson');

      /* verify if the next lesson belongs to another module */
      if (prevLesson.length === 1) {
        prevLesson.click();
      } else {
        const currentModule = currentLesson.closest('.el-submenu');
        const prevModule = currentModule.prev('li.el-submenu');

        /* Open menu */
        const prevModuleId = prevModule.attr('id');
        eventBus.$emit('open-menu', prevModuleId);

        const prevModuleFirstLesson = prevModule
          .children('.el-menu')
          .children()
          .children()
          .first();
        prevModuleFirstLesson.click();
      }
    },
    getCourseProgress(courseId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'progress'
      );
      formData.set('courseId', courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then((response) => {
        this.progress = response.data;
        this.openReviewModal(response.data);
      });
    },
    getCourse() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'get'
      );
      formData.set('courseId', this.courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then((response) => {
        this.title = response.data.title;
        this.courseId = response.data.id;
        this.certificate = response.data.certificate;
        this.reviews = response.data.reviews;
        this.getCourseProgress(response.data.id);
      });
    },
    checkIfCourseHasAlreadyBeenEvaluated(courseId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'verifyIfCourseHasAlreadyBeenEvaluated'
      );
      formData.set('courseId', courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.courseHasAlreadyBeenEvaluated = response.data;
          this.getCourse();
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  },
  computed: {
    ...mapState(['lang']),
    style() {
      return {
        width: this.progress + '%'
      };
    }
  }
};
</script>

<style lang="scss" scoped>
.el-submenu {
  border-bottom: 1px solid rgb(67, 74, 80);
}

.course-title {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.1vw;
}

.el-submenu__title * {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.1vw;
  border: 0;
  font-weight: normal;
  line-height: 1;
  list-style: none;
  margin: 0;
  padding: 0;
  position: relative;
  text-decoration: none;
}

.progress {
  margin-bottom: 0px !important;
}

.progress-bar {
  background-color: #009cd8 !important;
}

.col-2 {
  padding: 0px !important;
}

.cert {
  width: 30px;
}
@media only screen and (max-width: 768px) {
  .progress-bar {
    background-color: #009cd8 !important;
    float: right;
    right: 0;
  }
  .progress-viewcourse {
    right: 0;
    margin-right: 40px;
  }
  .web-buttons {
    display: none;
  }
  .mobile-buttons {
    display: initial;
  }
}

@media only screen and (min-width: 768px) {
  .mobile-buttons {
    display: none;
  }
}
</style>
