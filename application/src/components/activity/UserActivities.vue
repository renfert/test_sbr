<template>
  <div v-loading="content">
    <div v-if="activities != null" class="row">
      <div class="col-12 col-md-12 mb-5">
        <div
          class="card-widget"
          style="
            overflow-y: scroll;
            height: 500px;
            border-radius: 10px 0px 0px 10px !important;
          "
        >
          <div class="activities-title text-center mb-5">
            <h3>{{ lang['last-activities'] }}</h3>
          </div>

          <!-- Activity -->
          <div
            v-for="element in activities"
            :key="element.id"
            class="activity-item mb-4"
          >
            <div class="row">
              <div class="col-12 col-md-2">
                <el-avatar
                  :size="70"
                  fit="contain"
                  :src="$getUrlToContents() + 'avatar/' + element.avatar + ''"
                />
              </div>
              <div class="col-10 text-left">
                <!-- Course created -->
                <div
                  v-if="element.type == 'course-created'"
                  class="activity-info"
                >
                  <h4>
                    <router-link :to="'/user/' + element.create_user">
                      <b class="sbr-text-primary">{{ element.name }}</b>
                    </router-link>
                    {{ lang['activity-course-created'] }}
                    <router-link
                      class="mr-1"
                      :to="'/viewcourse/' + element.mycourse_id"
                    >
                      <b class="sbr-text-primary">{{ element.title }}</b>
                    </router-link>
                    <i class="ti-blackboard text-success"></i>
                  </h4>
                  <span>{{ processDateTime(element.date) }}</span>
                </div>

                <!-- Course deleted -->
                <div
                  class="activity-info"
                  v-if="element.type == 'course-deleted'"
                >
                  <h4>
                    <router-link :to="'/user/' + element.create_user">
                      <b class="sbr-text-primary">{{ element.name }}</b>
                    </router-link>
                    {{ lang['activity-course-deleted'] }}
                    <b class="sbr-text-primary">{{ element.course_title }}</b>
                    <i class="ti-trash text-danger"></i>
                  </h4>
                  <span>{{ processDateTime(element.date) }}</span>
                </div>

                <!-- Course edited -->
                <div
                  class="activity-info"
                  v-if="element.type == 'course-edited'"
                >
                  <h4>
                    <router-link :to="'/user/' + element.create_user">
                      <b class="sbr-text-primary">{{ element.name }}</b>
                    </router-link>
                    {{ lang['activity-course-edited'] }}
                    <router-link
                      class="mr-1"
                      :to="'/viewcourse/' + element.mycourse_id"
                    >
                      <b class="sbr-text-primary">{{ element.title }}</b>
                    </router-link>
                    <i class="ti-pencil-alt text-warning"></i>
                  </h4>
                  <span>{{ processDateTime(element.date) }}</span>
                </div>

                <!-- Lesson finished -->
                <div
                  class="activity-info"
                  v-if="element.type == 'lesson-finished'"
                >
                  <h4>
                    <router-link :to="'/user/' + element.create_user">
                      <b class="sbr-text-primary">{{ element.name }}</b>
                    </router-link>
                    {{ lang['activity-finished-lesson'] }}
                    <b class="sbr-text-primary">{{ element.lessonTitle }}</b>
                    {{ lang['in-the-course'] }}
                    <router-link
                      class="mr-1"
                      :to="'/viewcourse/' + element.mycourse_id"
                    >
                      <b class="sbr-text-primary">{{ element.title }}</b>
                    </router-link>
                    <i class="ti-arrow-circle-down text-success"></i>
                  </h4>
                  <span>{{ processDateTime(element.date) }}</span>
                </div>

                <!-- Course finished -->
                <div
                  class="activity-info"
                  v-if="element.type == 'course-finished'"
                >
                  <h4>
                    <router-link :to="'/user/' + element.create_user">
                      <b class="sbr-text-primary">{{ element.name }}</b>
                    </router-link>
                    {{ lang['activity-course-finished'] }}
                    <router-link
                      class="mr-1"
                      :to="'/viewcourse/' + element.mycourse_id"
                    >
                      <b class="sbr-text-primary">{{ element.title }}</b>
                    </router-link>
                    <i class="ti-arrow-circle-down text-success"></i>
                  </h4>
                  <span>{{ processDateTime(element.date) }}</span>
                </div>

                <!-- Logout -->
                <div class="activity-info" v-if="element.type == 'logout'">
                  <h4>
                    <router-link :to="'/user/' + element.create_user">
                      <b class="sbr-text-primary">{{ element.name }}</b>
                    </router-link>
                    {{ lang['activity-logout'] }}
                    <i class="ti-shift-left text-danger"></i>
                  </h4>
                  <span>{{ processDateTime(element.date) }}</span>
                </div>

                <!-- Login -->
                <div class="activity-info" v-if="element.type == 'login'">
                  <h4>
                    <router-link :to="'/user/' + element.create_user">
                      <b class="sbr-text-primary">{{ element.name }}</b>
                    </router-link>
                    {{ lang['activity-login'] }}
                    <i class="ti-shift-right text-success"></i>
                  </h4>
                  <span>{{ processDateTime(element.date) }}</span>
                </div>

                <!-- Program created -->
                <div
                  class="activity-info"
                  v-if="element.type == 'program-created'"
                >
                  <h4>
                    <router-link :to="'/user/' + element.create_user">
                      <b class="sbr-text-primary">{{ element.name }}</b>
                    </router-link>
                    {{ lang['activity-program-created'] }}
                    <i class="ti-layers-alt text-success"></i>
                  </h4>
                  <span>{{ processDateTime(element.date) }}</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Activity -->
        </div>
      </div>
    </div>

    <div class="row mb-5" v-else>
      <div class="col-12 text-center">
        <img
          class="no-results-img"
          src="@/assets/img/general/ux/no_notification.png"
          alt="No activities"
        />
        <h4 class="no-results-text">{{ lang['no-activities'] }}</h4>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  props: ['user-id'],
  data: () => {
    return {
      content: false,
      activities: [],
      currentDate: ''
    };
  },
  computed: {
    ...mapState(['lang', 'company'])
  },
  created() {
    this.getCurrentDate();
    this.listActivities();
  },
  methods: {
    listActivities() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'activity',
        'listingUserActivities'
      );
      formData.set('userId', this.userId);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.activities = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getCurrentDate() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'getCurrentDate'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.currentDate = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    processDateTime(date) {
      const dt1 = new Date(this.currentDate);
      const dt2 = new Date(date);
      const diffTime = Math.abs(dt2 - dt1);
      const diffinMinutes = diffTime / (1000 * 60);
      const diffInHours = diffTime / (1000 * 60 * 60);

      const day = dt2.getDate();
      const month = dt2.getMonth() + 1;
      const year = dt2.getFullYear();

      if (diffinMinutes > 60) {
        if (diffInHours < 24) {
          return (
            this.lang['activity-about-time-hour'] +
            Math.round(diffInHours) +
            this.lang['activity-time-hour-ago']
          );
        } else {
          return day + '/' + month + '/' + year;
        }
      } else {
        return this.lang['activity-few-minutes-ago'];
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.user-avatar {
  width: 70px;
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

.activities-title h3 {
  color: #9e9c9c;
}

.activity-item {
  height: 70px;
  cursor: pointer;
  background-color: rgba(230, 230, 230, 0.4);
  padding: 0px 0px 30px 30px;
  border-radius: 20px;
}

.activity-item:hover {
  background-color: rgba(214, 211, 211, 0.4);
}
</style>
