<template>
  <div v-if="courseList != null">
    <div class="card-box m-b-40">
      <el-row>
        <el-col :sm="6">
          <img
            style="width: 250px; position: relative"
            src="@/assets/img/general/ux/create_course.svg"
            alt
          />
        </el-col>
        <el-col :sm="14" class="m-t-20">
          <h3>
            {{ lang['hello'] }}
            <b class="sbr-text-primary">{{ user.name }} !</b>
          </h3>
          <h4 style="line-height: 30px">{{ lang['new-course-message'] }}</h4>
          <router-link to="/newcourse">
            <el-button class="sbr-primary mt-4">{{
              lang['new-course-button']
            }}</el-button>
          </router-link>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
import { eventBus } from '@/components/courses/App';
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      courseList: [],
      numberTotalOfCoursesCreated: '',
      videoOverlay: false
    };
  },
  created() {
    this.getCourses();
  },
  computed: {
    ...mapState(['lang'])
  },
  mounted() {
    eventBus.$on('course-deleted', () => {
      this.getCourses();
    });
  },
  methods: {
    getCourses() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.courseList = response.data;
          if (response.data == null) {
            this.numberTotalOfCoursesCreated = 0;
          } else {
            this.numberTotalOfCoursesCreated = response.data.length;
          }
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
   Layout
============= */
.two-column-card {
  display: flex;
  flex-direction: row;
  flex: 1;
  flex-wrap: wrap;
  margin: 0 -8px;
  justify-content: space-around;
  align-items: baseline;
}

.two-column-card > * {
  margin: 0 8px;
}

.divider {
  width: 2px;
  margin: 6px 0;
  background: #ebe5e5;
  align-self: stretch;
}

.item-card {
  flex: 1;
  text-align: center;
}

.img-box {
  width: 70%;
}

.text-box {
  font-size: 17px;
}

.card-box {
  box-shadow: 0 1px 3px 0 #009bd877 !important;
  border-radius: 0 12px 12px 0 !important;
  border-left: 3px solid #009cd8;
  background-color: #009bd821;
}

/* =============
  Mobile
============= */

@media only screen and (max-width: 600px) {
  .divider {
    display: none;
  }

  .item-card {
    flex: initial;
    text-align: center;
  }

  .item-video-course {
    display: none;
  }
}
</style>
