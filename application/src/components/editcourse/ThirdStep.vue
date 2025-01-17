<template>
  <div :class="displayContentThirdStep == false ? 'hide' : 'main'">
    <el-row class="center m-t-40 m-b-40">
      <img class="w-30" src="@/assets/img/general/ux/test.svg" />
    </el-row>
    <div class="row row-actions">
      <div class="col-12 col-md-3">
        <router-link :to="'/viewcourse/' + courseId">
          <div class="card-box card-action">
            <h5 class="fw-700">{{ lang['view-course'] }}</h5>
            <img src="@/assets/img/general/ux/view_course.png" alt />
          </div>
        </router-link>
      </div>

      <div class="col-12 col-md-3">
        <a href="javascript:void(0)" @click.prevent="modal = true">
          <div class="card-box card-action">
            <h5 class="fw-700">{{ lang['join-persons'] }}</h5>
            <img src="@/assets/img/general/ux/join_persons.png" alt />
          </div>
        </a>
      </div>

      <div class="col-12 col-md-3">
        <a href="javascript:void(0)" @click.prevent="reloadPage()">
          <div class="card-box card-action">
            <h5 class="fw-700">{{ lang['create-new-course'] }}</h5>
            <img src="@/assets/img/general/ux/create_new_course.png" alt />
          </div>
        </a>
      </div>

      <div class="col-12 col-md-3">
        <a href="javascript:void(0)" @click.prevent="share = true">
          <div class="card-box card-action">
            <h5 class="fw-700">{{ lang['share'] }}</h5>
            <img src="@/assets/img/general/ux/share.png" alt />
          </div>
        </a>
      </div>
    </div>

    <!---------
            Share
    ---------->
    <el-dialog :visible.sync="share" :title="lang['share']" center top="5vh">
      <el-input id="shareLink" placeholder="Please input" v-model="linkToShare">
        <el-button
          @click.prevent="copyToClipboard()"
          slot="append"
          icon="el-icon-copy-document"
        ></el-button>
      </el-input>
    </el-dialog>

    <!-- Join users -->
    <el-dialog
      :visible.sync="modal"
      :title="lang['join-persons']"
      center
      top="5vh"
    >
      <div v-if="usersList != null" v-loading="loading">
        <template>
          <el-transfer
            filterable
            :titles="['Persons', 'Course']"
            v-model="users"
            :data="usersList"
          ></el-transfer>
        </template>
        <br />
        <el-button
          class="sbr-primary"
          @click="enrollUsers()"
          type="primary"
          size="medium"
          >{{ lang['save-button'] }}</el-button
        >
      </div>

      <!-- No persons found content -->
      <div class="card-box box-no-results" v-else>
        <div class="row">
          <div class="col-1"></div>
          <div class="col-5">
            <div class="text-no-results">
              <h5>{{ lang['all-students-already-added'] }}</h5>
            </div>
          </div>
          <div class="col-6">
            <img
              class="image-no-results"
              src="@/assets/img/general/ux/no_persons.png"
            />
          </div>
        </div>
      </div>
      <!-- No users found content end -->
    </el-dialog>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import { eventBus } from '@/components/newcourse/App';

export default {
  data: () => {
    return {
      courseId: '',
      courseName: '',
      displayContentThirdStep: false,
      modal: false,
      usersList: [],
      users: [],
      loading: false,
      share: false,
      linkToShare: ''
    };
  },
  created() {
    this.courseId = this.$route.params.id;
    this.getUsersNotEnrolledIntoCourse(this.courseId);
  },
  computed: {
    ...mapState(['lang', 'company'])
  },
  mounted() {
    /* Access first step */
    eventBus.$on('access-first-step', () => {
      this.displayContentThirdStep = false;
    });

    /* Access second step */
    eventBus.$on('access-second-step', () => {
      this.displayContentThirdStep = false;
    });

    /* Access third step */
    eventBus.$on('access-third-step', () => {
      this.displayContentThirdStep = true;
      this.getCourse();
    });
  },
  methods: {
    formatTitleParameter(title) {
      const newTitle = title.split(' ').join('-');
      return newTitle.toLowerCase();
    },
    copyToClipboard() {
      const copyText = document.getElementById('shareLink');
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand('copy');
      this.$message('Copied');
    },
    getUsersNotEnrolledIntoCourse(courseId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'getPersonsOutsideTheCourse'
      );
      formData.set('courseId', courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.usersList = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    enrollUsers() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'enrollUsersIntoCourse'
      );
      formData.set('courseId', this.courseId);
      formData.set('users', this.users);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.users = [];
          this.loading = false;
          this.modal = false;
          this.getUsersNotEnrolledIntoCourse(this.courseId);
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getCourse() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'get'
      );
      formData.set('courseId', this.courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.courseName = response.data.title;
          this.courseImage = response.data.photo;
          this.linkToShare =
            this.$getCurrentDomainName() +
            'product/' +
            this.formatTitleParameter(response.data.title);
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<style lang="scss" scoped>
/* =============
    - Layout
    - Font
    - Mobile
============= */

/* =============
   Layout
============= */

.card-action {
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: grey !important;
}

.card-action:hover {
  -webkit-box-shadow: 0px 0px 5px 0px #009cd8;
  box-shadow: 0px 0px 5px 0px #009cd8;
}

.card-action img {
  width: 50px;
}

.course-name {
  text-transform: uppercase;
  letter-spacing: 1px;
}

.img-container {
  width: 100%;
  height: 380px;
  overflow: hidden;
  margin: 0px !important;
}

.img-container img {
  width: inherit !important;
}

.text-container {
  color: white;
  position: absolute;
  width: 100%;
  margin-top: 10%;
  padding-left: 230px;
  text-align: center;
}

/* =============
   Font
============= */

.text-container h4 {
  text-transform: uppercase;
  font-family: 'Poppins', sans-serif;
  letter-spacing: 1px;
  color: white;
}

.text-container h1 {
  text-transform: uppercase;
  color: white;
}

/* =============
   Mobile
============= */

@media only screen and (max-width: 600px) {
  .text-container {
    color: #ffffff;
    position: absolute;
    width: 100%;
    margin-top: 15%;
    padding-left: 0px;
    text-align: center;
  }
  .text-container h4 {
    font-size: 0.8em;
    text-transform: uppercase;
    font-family: 'Poppins', sans-serif;
    letter-spacing: 1px;
    color: white;
  }

  .text-container h1 {
    font-size: 1.5em;
    font-weight: 600;
    text-transform: uppercase;
    color: white;
  }
  .row-actions {
    padding-left: 0px;
  }
  .img-container {
    height: 280px;
  }
}
</style>
