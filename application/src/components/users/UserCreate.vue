<template>
  <div class="card-box">
    <!----------------------
      Massive import button
    ------------------------>
    <div class="float-right">
      <el-button
        class="sbr-purple"
        v-if="company.plan == 'bussiness'"
        @click.prevent="modal = true"
      >
        <i class="el-icon-upload2"></i> {{ lang['massive-import'] }}
      </el-button
      >

      <el-button
        @click.prevent="upgradePlanFeature()"
        v-else
        class="sbr-purple"
        type="primary"
        size="small"
      >
        <i class="el-icon-lock"></i>
        {{ lang['massive-import'] }}
      </el-button>
    </div>

    <!----------------------
     Create user form
    ------------------------>
    <h4>{{ lang['create-user'] }}</h4>
    <br/>
    <form
      @submit.prevent="createUser()"
      id="form-user"
      :inline="false"
      class="demo-form-inline"
    >
      <el-row class="m-b-10" :gutter="20">
        <!-- Username -->
        <el-col :md="8" class="m-b-10">
          <el-input
            clearable
            required
            name="name"
            :placeholder="lang['name']"
            v-model="name"
          ></el-input>
        </el-col>

        <!-- Email -->
        <el-col :md="8" class="m-b-10">
          <el-input
            clearable
            required
            type="email"
            name="email"
            :placeholder="lang['email']"
            v-model="email"
          ></el-input>
        </el-col>
      </el-row>

      <el-row class="m-b-20" :gutter="20">
        <!-- Password -->
        <el-col :md="8" class="m-b-10">
          <el-input
            clearable
            required
            type="password"
            name="password"
            :placeholder="lang['password']"
            v-model="password"
          ></el-input>
        </el-col>

        <!-- Role -->
        <el-col :md="8" class="m-b-10">
          <el-select
            required
            name="role"
            v-model="role"
            :placeholder="lang['select-role']"
          >
            <el-option value="2" :label="lang['instructor']">
              <span style="float: left">{{ lang['instructor'] }}</span>
              <span style="float: right">
                <img
                  style="width: 50px"
                  src="@/assets/img/general/ux/instructor.svg"
                  alt="en"
                />
              </span>
            </el-option>

            <el-option value="3" :label="lang['student']">
              <span style="float: left">{{ lang['student'] }}</span>
              <span style="float: right">
                <img
                  style="width: 50px"
                  src="@/assets/img/general/ux/graduation_cap.svg"
                  alt="en"
                />
              </span>
            </el-option>
          </el-select>
        </el-col>
      </el-row>

      <el-button
        v-loading="loadingButton"
        class="sbr-primary"
        native-type="submit"
      >{{ lang['save-button'] }}
      </el-button
      >
    </form>

    <!----------------------
      Massive import modal
    ------------------------>
    <div>
      <el-dialog
        :visible.sync="modal"
        :title="lang['massive-import']"
        center
        width="40%"
        top="5vh"
      >
        <div class="center m-b-20">
          <b>
            <a
              download
              href="https://cdn.eadtools.com/files/import_user.xlsx"
              class="sbr-text-primary"
            >
              <i class="el-icon-download"></i>
              {{ lang['download-template'] }}</a
            >
          </b>
        </div>

        <div class="center">
          <div v-if="loadingMassiveImportButton">
            <h3 class="sbr-text-grey">
              {{ lang['please-wait'] }}
            </h3>
            <img
              src="https://sbrfiles.s3.amazonaws.com/gifs/loader4.gif"
              style="width: 25%"
              alt
            />
          </div>
          <form
            v-loading="loadingMassiveImportButton"
            id="form-massive"
            @submit.prevent="massivelyCreateUsers"
          >
            <upload
              input-name="file"
              acceptable=".xlsx"
              box-height="200"
            ></upload>
            <br/>
            <el-form-item >
              <el-button
                style="width: 100%"
                v-loading="loadingButton"
                class="sbr-primary"
                native-type="submit"
                type="primary"
              >{{ lang['save-button'] }}
              </el-button>
            </el-form-item>

          </form>
        </div>
      </el-dialog>
    </div>
  </div>
</template>

<script>
import Upload from '@/components/helper/HelperUpload';

import {eventBus} from '@/components/users/App';
import {eventPlan} from '@/components/plans/UpgradePlan';
import {mapState} from 'vuex';

export default {
  data: () => {
    return {
      modal: false,
      name: '',
      email: '',
      role: '',
      password: '',
      loadingButton: false,
      loadingMassiveImportButton: false
    };
  },
  components: {
    Upload
  },
  computed: {
    ...mapState(['lang', 'company'])
  },
  methods: {
    upgradePlanFeature() {
      eventPlan.$emit('upgrade-plan', 'feature');
    },
    createUser() {
      this.loadingButton = true;

      const formData = new FormData();
      formData.set('name', this.name);
      formData.set('email', this.email);
      formData.set('password', this.password);
      formData.set('role', this.role);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'create'
      );

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          if (response.data === 'upgrade-plan') {
            eventPlan.$emit('upgrade-plan', 'users');
          } else {
            if (response.data === false) {
              this.$userAlreadyExists();
            } else {
              this.$successMessage();
              eventBus.$emit('new-user');
              document.getElementById('form-user').reset();
            }
          }
          this.loadingButton = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    massivelyCreateUsers() {
      this.loadingMassiveImportButton = true;
      const form = document.getElementById('form-massive');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'massivelyCreateUsers'
      );

      this.$request
        .post(urlToBeUsedInTheRequest, formData, {
          headers: {'Content-Type': 'multipart/form-data'}
        })
        .then(
          () => {
            this.loadingMassiveImportButton = false;
            this.$successMessage();
            this.modal = false;
            eventBus.$emit('new-user');
            document.getElementById('form-massive').reset();
          },
          () => {
            this.$errorMessage();
          }
        );
    }
  }
};
</script>
<style scoped>

@media (max-width: 768px) {
  .el-form--inline .el-form-item__content {
    width: 100%;
  }
}
</style>