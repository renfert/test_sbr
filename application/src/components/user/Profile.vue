<template>
  <div>
    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <!--------------
        Banner profile
      --------------->
      <el-row>
        <div class="card-box m-t-40">
          <el-row>
            <el-col :sm="2" :md="2">
              <el-avatar
                class="profile-avatar"
                :size="120"
                fit="contain"
                :src="$getUrlToContents() + 'avatar/' + userAvatar + ''"
              ></el-avatar>
            </el-col>
            <el-col>
              <el-row class="text-left">
                <el-col
                  class="m-r-40"
                  :sm="12"
                  :xs="24"
                  style="border-right: 2px solid #009cd8"
                >
                  <h2 class="sbr-text-grey">Information</h2>
                  <br />
                  <h4>
                    <span class="m-r-5">NAME : </span>
                    <span>{{ userName }}</span>
                  </h4>
                  <h4 v-if="role == 2">
                    <span class="m-r-5">ROLE : </span>
                    <span>{{ lang['instructor'] }}</span>
                  </h4>
                  <h4 v-else class="text-sabiorealm">
                    <span class="m-r-5">ROLE : </span>
                    <span>{{ lang['student'] }}</span>
                  </h4>
                  <h4>
                    <span class="m-r-5">EMAIL : </span>
                    <span>{{ userEmail }}</span>
                  </h4>
                </el-col>
                <!--
                <el-col :sm="12">
                  <h2 class="sbr-text-white">Data</h2>
                  <br />
                  <h4><i class="el-icon-notebook-1"></i> Courses: 14</h4>
                  <h4><i class="el-icon-document"></i> Programs: 14</h4>
                  <h4><i class="el-icon-user"></i> Groups: 14</h4>
                </el-col>
                !-->
              </el-row>
            </el-col>
          </el-row>
        </div>
      </el-row>

      <!--------------
       Profile charts
      --------------->
      <div class="profile-charts mt-5">
        <el-row :gutter="20" class="m-b-40">
          <!--------------
          Exams
          --------------->
          <el-col :sm="24" :xs="24">
            <div class="card-widget" style="overflow-y: scroll; height: 250px">
              <div v-if="exams != null">
                <h3 class="exams-title">{{ lang['exams'] }}</h3>

                <div class="exams-list-header">
                  <div class="row">
                    <div class="col-4">
                      <h4>Exam</h4>
                    </div>
                    <div class="col-4">
                      <h4>Score</h4>
                    </div>
                    <div class="col-4">
                      <h4>Course</h4>
                    </div>
                  </div>
                </div>

                <div class="exams-list-body">
                  <div
                    class="row exam-item"
                    v-for="element in exams"
                    :key="element.id"
                  >
                    <div class="col-4">
                      <h4>
                        <i
                          v-if="
                            parseInt(element.score) > parseInt(element.approval)
                          "
                          class="ti-pin-alt text-sabiorealm"
                        ></i>

                        <i v-else class="ti-pin-alt text-danger"></i>
                        {{ element.exam }}
                      </h4>
                    </div>
                    <div class="col-4">
                      <h4>{{ element.score }}</h4>
                    </div>
                    <div class="col-4">
                      <h4>{{ element.course }}</h4>
                    </div>
                  </div>
                </div>
              </div>

              <!--------------
              Exams not found
              --------------->
              <el-row v-else>
                <div class="text-center">
                  <img
                    class="not-found-image"
                    src="@/assets/img/general/ux/data_not_found.svg"
                  />
                  <br />
                  <h4 class="sbr-text-grey">{{ lang['no-results-exam'] }}</h4>
                </div>
              </el-row>
            </div>
          </el-col>
        </el-row>
      </div>
    </div>
  </div>
  <!-- End col-auto -->
</template>

<script>
import Vue from 'vue';
import VueGoogleCharts from 'vue-google-charts';

import { FacebookLoader } from 'vue-content-loader';
import { DataTables, DataTablesServer } from 'vue-data-tables';
import { mapState } from 'vuex';

Vue.use(DataTables);
Vue.use(DataTablesServer);
Vue.use(VueGoogleCharts);

export default {
  components: {
    FacebookLoader
  },
  props: ['user-id'],
  data: () => {
    return {
      userName: '',
      userEmail: '',
      userAvatar: '',
      role: '',
      exams: [],
      coursesData: [],
      coursesChartOptions: {
        title: 'Courses',
        colors: ['#00A9B4', '#29277F', '#6959CD']
      },
      loadingContent: false
    };
  },
  mounted() {
    this.getUser();
    this.getUserExams();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getUser() {
      this.loadingContent = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest('user', 'get');
      formData.set('userId', this.userId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.userName = response.data.name;
          this.userEmail = response.data.email;
          this.userAvatar = response.data.avatar;
          this.role = response.data.myrole_id;
          setTimeout(() => {
            this.loadingContent = false;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getUserExams() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getUserExams'
      );
      formData.set('userId', this.userId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.exams = response.data;
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
.img-container {
  width: 100%;
  height: 200px;
  overflow: hidden;
  margin: 0px !important;
  margin-top: -15px !important;
}

.profile-row {
  background-color: rgba(27, 87, 84, 0.192);
}

.profile-avatar {
  margin-top: -8%;
  right: 0 !important;
  position: absolute;
}

.profile-info {
  margin-left: 35%;
  text-align: left;
}

.profile-info h2,
span,
h4 {
  line-height: 15px;
}

.img-profile-container {
  color: white;
  position: absolute;
  width: 400px;
  margin-top: 12%;
}

.chart {
  width: 100%;
  height: 100%;
  max-height: 100%;
}

.card-widget {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  background-color: white;
  border-radius: 10px;
  padding: 30px;
}

.card-widget:hover {
  box-shadow: 0 0px 7px rgba(70, 67, 67, 0.25), 0 5px 5px rgba(70, 67, 67, 0.25);
}

::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
  background-color: #f5f5f5;
}

::-webkit-scrollbar {
  width: 2px;
  background-color: #f5f5f5;
}

::-webkit-scrollbar-thumb {
  background-color: #0ae;
  background-image: -webkit-gradient(
    linear,
    0 0,
    0 100%,
    color-stop(0.5, rgba(255, 255, 255, 0.2)),
    color-stop(0.5, transparent),
    to(transparent)
  );
}

.card-box {
  box-shadow: 0 0px 4px 0 #009bd877 !important;
  border-radius: 0 12px 12px 0 !important;
  border-left: 3px solid #009cd8;
  padding: 50px !important;
}

.el-avatar {
  border: 2px solid #009cd8 !important;
  transition: all 0.2s ease-in-out 0s !important;
  cursor: pointer !important;
}

.el-avatar:hover {
  transform: translateX(5px) !important;
  box-shadow: 0 5px 20px 0 #009bd877 !important;
}

.el-tabs--border-card > .el-tabs__content {
  padding: 0px !important;
}

.exams-title {
  color: #9e9c9c;
}

.exams-list-header {
  background-color: rgba(230, 230, 230, 0.4);
  border-radius: 10px;
  margin-bottom: 5%;
}

.exam-item {
  cursor: pointer;
  border-bottom: 1px solid rgba(230, 230, 230, 0.4);
  padding: 5px;
}

.exam-item:hover {
  background-color: rgba(230, 230, 230, 0.4);
}

@media only screen and (max-width: 768px) {
  .img-profile-container {
    color: white;
    position: absolute;
    width: 400px;
    max-width: 92%;
    margin-top: 8%;
  }

  .profile-avatar {
    margin-top: initial;
    right: initial;
    position: initial;
  }
}
</style>
