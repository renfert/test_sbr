<template>
  <div class="card-box">
    <!----------------------
      Massive import button
    ------------------------>
    <div class="float-right">
      <el-button
        class="sbr-purple"
        v-if="plan == 'bussiness'"
        @click.prevent="modal = true"
        type="primary"
        size="small"
        >{{ lang['massive-import'] }}</el-button
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
    <br />
    <form
      @submit.prevent="createUser()"
      id="form-user"
      :inline="false"
      class="demo-form-inline"
    >
      <el-row>
        <!-- Username -->
        <el-col :md="8" class="mr-5 mb-3">
          <el-input
            required
            name="name"
            :placeholder="lang['name']"
            v-model="name"
          ></el-input>
        </el-col>

        <!-- Email -->
        <el-col :md="8" class="mr-5 mb-3">
          <el-input
            required
            type="email"
            name="email"
            :placeholder="lang['email']"
            v-model="email"
          ></el-input>
        </el-col>
      </el-row>

      <el-row>
        <!-- Password -->
        <el-col :md="8" class="mr-5 mb-3">
          <el-input
            required
            type="password"
            name="password"
            :placeholder="lang['password']"
            v-model="password"
          ></el-input>
        </el-col>

        <!-- Role -->
        <el-col :md="8" class="mr-5 mb-3">
          <el-select
            required
            name="role"
            v-model="role"
            :placeholder="lang['select-role']"
          >
            <el-option
              style="pointer-events: auto !important; z-index: 9999 !important"
              value="2"
              :label="lang['instructor']"
              >{{ lang['instructor'] }}</el-option
            >
            <el-option
              style="pointer-events: auto !important; z-index: 9999 !important"
              value="3"
              :label="lang['student']"
              >{{ lang['student'] }}</el-option
            >
          </el-select>
        </el-col>
      </el-row>

      <el-button
        v-loading="loadingButton"
        class="sbr-primary"
        native-type="submit"
        >{{ lang['save-button'] }}</el-button
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
        <div class="text-center">
          <a
            download
            href="https://cdn.eadtools.com/files/import_user.xlsx"
            class="sbr-btn sbr-purple mb-5"
            >{{ lang['download-template'] }}</a
          >
        </div>

        <div class="center">
          <h3 v-if="loadingMassiveImportButton" class="sbr-text-grey">
            {{ lang['please-wait'] }}
          </h3>
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
            <br />
            <el-button
              v-loading="loadingButton"
              class="sbr-primary"
              native-type="submit"
              type="primary"
              >{{ lang['save-button'] }}</el-button
            >
          </form>
        </div>
      </el-dialog>
    </div>
  </div>
</template>

<script>
import Upload from '@/components/helper/HelperUpload';

import { eventBus } from '@/components/users/App';
import { eventPlan } from '@/components/plans/UpgradePlan';
import { mapState } from 'vuex';

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
    ...mapState(['lang', 'plan'])
  },
  methods: {
    upgradePlanFeature() {
      eventPlan.$emit('upgrade-plan', 'feature');
    },
    createUser() {
      this.loadingButton = true;

      const form = document.getElementById('form-user');
      const formData = new FormData(form);
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
          headers: { 'Content-Type': 'multipart/form-data' }
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
