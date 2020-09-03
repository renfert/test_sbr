<template>
  <div class="creation-content">
    <div>
      <div class="img-container">
        <div class="text-container">
          <h4>{{ lang['program-created-successfully'] }}</h4>
          <h1>{{ programName }}</h1>
        </div>
        <img src="@/assets/img/general/ux/course_completed.png" />
      </div>
    </div>

    <div class="row mt-3 ml-5 mr-5 row-actions">
      <div class="col-12 col-md-4">
        <router-link :to="'/viewprogram/' + programId">
          <div class="card-box card-action">
            <h4 class="fw-700">{{ lang['view-program'] }}</h4>
            <img src="@/assets/img/general/ux/view_course.png" alt />
          </div>
        </router-link>
      </div>

      <div class="col-12 col-md-4">
        <a href="javascript:void(0)" @click.prevent="modal = true">
          <div class="card-box card-action">
            <h4 class="fw-700">{{ lang['join-persons'] }}</h4>
            <img src="@/assets/img/general/ux/join_persons.png" alt />
          </div>
        </a>
      </div>

      <div class="col-12 col-md-4">
        <a href="javascript:void(0)" @click.prevent="reloadPage()">
          <div class="card-box card-action">
            <h4 class="fw-700">{{ lang['create-new-program'] }}</h4>
            <img src="@/assets/img/general/ux/create_new_course.png" alt />
          </div>
        </a>
      </div>
    </div>

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
        <el-button class="sbr-primary" @click="enrollUsers()" type="primary">{{
          lang['save-button']
        }}</el-button>
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
              alt
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

export default {
  data: () => {
    return {
      loading: false,
      modal: false,
      usersList: [],
      users: []
    };
  },
  props: ['program-id', 'program-name'],
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    enrollUsers() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'program',
        'enrollUsersIntoProgram'
      );
      formData.set('programId', this.programId);
      formData.set('users', this.users);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.loading = false;
          this.modal = false;
          this.getPersonsOutsideTheProgram(this.programId);
          this.users = [];
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getPersonsOutsideTheProgram() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'program',
        'getPersonsOutsideTheProgram'
      );
      formData.set('programId', this.programId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.usersList = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    reloadPage() {
      location.reload();
    }
  },
  watch: {
    programId() {
      this.getPersonsOutsideTheProgram();
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

.creation-content {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
}

.row-actions {
  padding-left: 230px;
}

.card-action {
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: grey !important;
}

.card-action:hover {
  -webkit-box-shadow: 0px 0px 5px 0px #00a9b4;
  box-shadow: 0px 0px 5px 0px #00a9b4;
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
    color: white;
    position: absolute;
    width: 100%;
    margin-top: 25%;
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
