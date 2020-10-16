<template>
  <div>
    <el-dialog
      :visible.sync="login.modal"
      :title="lang['go-to-platform']"
      center
      top="5vh"
    >
      <form
        @submit.prevent="doLogin()"
        id="form-login"
        v-loading="login.loading"
        class="form-login text-center border border-light p-5"
      >
        <el-alert
          @close="login.wrongPasswordOrUserMessage = false"
          :title="lang['wrong-password']"
          type="error"
          v-if="login.wrongPasswordOrUserMessage == true"
          show-icon
        ></el-alert>
        <br />
        <!-- Email -->
        <input
          v-model="email"
          type="email"
          name="email"
          class="form-control mb-4"
          placeholder="E-mail"
        />
        <!-- Password -->
        <input
          v-model="password"
          type="password"
          name="password"
          class="form-control mb-4"
          :placeholder="lang['password']"
        />

        <div class="d-flex justify-content-around">
          <div>
            <!-- Forgot password -->
            <a
              href="javascript:void(0)"
              :style="primaryColor"
              @click="
                recover.modal = true;
                login.modal = false;
              "
              >{{ lang['recover-password'] }}</a
            >
          </div>
        </div>

        <!-- Sign in button -->
        <button :style="primaryColorBg" class="btn account-btn" type="submit">
          {{ lang['go-to-platform'] }}
        </button>
      </form>
    </el-dialog>

    <!----------------
    Recover password
    ------------------>
    <el-dialog
      :visible.sync="recover.modal"
      :title="lang['recover-password']"
      center
      width="40%"
      top="5vh"
    >
      <form
        v-loading="recover.loading"
        id="form-recover"
        @submit.prevent="recoverPassword()"
        action="recover"
      >
        <el-input
          v-model="recover.email"
          required
          placeholder="Email"
          name="email"
        ></el-input>
        <button :style="primaryColorBg" class="btn account-btn">Recover</button>
        <div style="margin: auto; text-align: center">
          <b>{{ message }}</b>
        </div>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import router from '@/router';
import Vue from 'vue';
import { mapState } from 'vuex';

export const eventLogin = new Vue();

export default {
  data: () => {
    return {
      recover: {
        modal: false,
        email: '',
        loading: false
      },
      login: {
        modal: false,
        loading: false,
        wrongPasswordOrUserMessage: false
      },
      email: '',
      password: '',
      color: '',
      message: ''
    };
  },
  mounted() {
    this.getColor();
    eventLogin.$on('open-login-modal', () => {
      this.login.modal = true;
    });
  },
  methods: {
    doLogin() {
      this.login.loading = true;
      const form = document.getElementById('form-login');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'Login',
        'doLogin'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.email = '';
          this.password = '';
          this.login.loading = false;

          if (response.data === true) {
            router.push('/home');
          } else {
            this.login.wrongPasswordOrUserMessage = true;
          }
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getColor() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.color = response.data.color;
      });
    },
    recoverPassword() {
      this.recover.loading = true;
      const form = document.getElementById('form-recover');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'Login',
        'recoverPassword'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.recover.loading = false;
          if (response.data === false) {
            this.message = 'User not found, please verify. ';
          } else {
            this.message = 'Password has been modified, verify your email.';
          }
        },
        () => {
          this.$errorMessage();
        }
      );
      // this.recover.loading = false;
    }
  },
  computed: {
    primaryColorBg() {
      return {
        'background-color': this.color
      };
    },
    primaryColor() {
      return {
        color: this.color
      };
    },
    ...mapState(['lang'])
  }
};
</script>

<style lang="scss" scoped>
.btn {
  display: inline-block;
  font-weight: 400;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  border: 1px solid transparent;
  padding: 12px 25px;
  font-size: 1rem;
  line-height: 1.25;
  transition: all 0.15s ease-in-out;
  border: 2px solid transparent;
  cursor: pointer;
}

.account-btn {
  width: 60%;
  margin: 1.5rem auto 0;
  display: flex;
  height: 44px;
  font-weight: 600;
  border-radius: 50px;
  color: #fff !important;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem !important;
}

.custom-control-label {
  padding-top: 4px !important;
}
</style>
