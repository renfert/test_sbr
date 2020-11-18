<template>
  <div class="content-page">
    <div class="card-box">
      <div class="row">
        <div class="col-6" style="padding: 5%">
          <!-- User registration form -->
          <form v-if="firstStep">
            <span>{{ lang['name'] }}</span>
            <el-input v-model="username"></el-input>
            <br /><br />
            <span>{{ lang['email'] }}</span>
            <el-input v-model="email"></el-input>
            <br /><br />
            <span>{{ lang['password'] }}</span>
            <el-input
              :type="seePassword == true ? 'text' : 'password'"
              v-model="password"
            >
              <el-button
                v-if="seePassword == false"
                slot="append"
                @click="seePassword = true"
                icon="fas fa-eye-slash"
              ></el-button>

              <el-button
                v-else
                @click="seePassword = false"
                slot="append"
                icon="fas fa-eye"
              ></el-button>
            </el-input>
            <br /><br />
            <el-button @click="updateUser()" class="sbr-primary">{{
              lang['create-user']
            }}</el-button>
          </form>
        </div>
        <div class="col-6 colored-side">
          <!-- First step text -->
          <div class="text" v-if="firstStep">
            <h3>{{ lang['user-account'] }}</h3>
            <hr />
            <h4>
              {{ lang['registration-message'] }}
            </h4>
          </div>
          <robot></robot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import Robot from '@/components/registration/Robot';
export default {
  components: {
    Robot
  },
  data: () => {
    return {
      username: '',
      email: '',
      password: '',
      firstStep: true,
      seePassword: false
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    updateUser() {
      const formData = new FormData();
      formData.set('name', this.username);
      formData.set('email', this.email);
      formData.set('password', this.password);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'User',
        'updateAdminUser'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.firstStep = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<style scoped lang="scss">
.colored-side {
  background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
  background-size: 400% 400%;
  animation: gradient 15s ease infinite;
}

@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}

.text {
  padding: 10% 10% 0% 10%;
  margin-bottom: 20%;
}

.text hr {
  background-color: white;
}

.text h3,
h4 {
  color: white !important;
  text-align: center;
}

.text h3 {
  font-weight: 700;
  font-size: 2em;
}

.text h4 {
  letter-spacing: 1px;
  font-weight: 700;
}

.card-box {
  padding: 0px !important;
}
</style>
