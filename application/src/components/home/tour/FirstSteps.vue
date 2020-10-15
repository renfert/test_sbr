<template>
  <div class="block">
    <!--------------
            Introduction
    --------------->
    <div class="row text-center">
      <div class="col-12">
        <img
          class="waiter"
          src="@/assets/img/general/ux/gifs/waiter-rev1.gif"
          alt
        />
        <h2 class="sbr-text-grey text-center">
          {{ lang['welcome-to-sabiorealm'] }}
          <b>{{ user.name }}</b>
        </h2>
        <h3>{{ lang['welcome-message-pt1'] }}</h3>
        <h4 class="sbr-text-grey">{{ lang['welcome-message-pt2'] }}</h4>
      </div>
    </div>
    <!--------------
            End  Introduction
    --------------->

    <!--------------
            Steps
    --------------->
    <div class="block text-center mb-5 mt-5">
      <div class="row text-center">
        <div class="col-md-4 col-12 mb-5">
          <router-link to="/users" class="mb-3 sbr-text-primary">
            <img
              class="img-step"
              v-if="userStep != null"
              src="@/assets/img/general/ux/tour/check.png"
            />
            <img
              class="img-step"
              v-else
              src="@/assets/img/general/ux/tour/1.png"
            />
            <div>
              <h4>
                {{
                  lang['create-user']
                }}
              </h4>
            </div>

          </router-link>
        </div>
        <div class="col-md-4 col-12 mb-5">
          <router-link to="/newcourse" class="mb-3 sbr-text-primary">
            <img
              class="img-step"
              v-if="courseStep != null"
              src="@/assets/img/general/ux/tour/check.png"
            />
            <img
              class="img-step"
              v-else
              src="@/assets/img/general/ux/tour/2.png"
            />
            <div>
              <h4>
                {{
                  lang['new-course-button']
                }}
              </h4>
            </div>
          </router-link>
        </div>

        <div class="col-md-4 col-12 mb-5">
          <router-link to="/settings" class="mb-3 sbr-text-primary">
          <img
            class="img-step"
            v-if="settingsStep != null"
            src="@/assets/img/general/ux/tour/check.png"
          />
          <img
            class="img-step"
            v-else
            src="@/assets/img/general/ux/tour/3.png"
          />
          <div>
            <h4>
             {{
                  lang['change-settings']
                }}

            </h4>
          </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapState} from 'vuex';

export default {
  data: () => {
    return {
      userStep: null,
      courseStep: null,
      customizeStep: null,
      settingsStep: null
    };
  },
  mounted() {
    this.getStepsStatus();
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  methods: {
    getStepsStatus() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'stepsStatus'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.userStep = response.data[0].status;
        this.courseStep = response.data[1].status;
        this.customizeStep = response.data[2].status;
        this.settingsStep = response.data[3].status;
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.waiter {
  width: 18%;
}

@media only screen and (max-width: 600px) {
  .waiter {
    width: 60%;
    margin-top: 0%;
  }
}

.img-step {
  width: 25%;
}
</style>
