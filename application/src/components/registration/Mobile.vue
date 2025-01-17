<template>
  <div class="row">
    <div class="col-md-6 col-12">
      <!-- User registration form -->
      <form @submit.prevent="updateUser()" v-if="firstStep">
        <span>{{ lang['name'] }}</span>
        <el-input required v-model="username"></el-input>
        <br /><br />
        <span>{{ lang['email'] }}</span>
        <el-input required v-model="email"></el-input>
        <br /><br />
        <span>{{ lang['password'] }}</span>
        <el-input
          required
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
        <el-button
          v-loading="loading"
          native-type="submit"
          class="sbr-primary"
          >{{ lang['create-user'] }}</el-button
        >
      </form>

      <!-- Form aditional information -->
      <form @submit.prevent="updateCompanyInformation()" v-else>
        <span>Seleccione un paso</span>
        <el-select required name="step" v-model="step" placeholder="Select">
          <el-option
            label="Trabajo con curso y / o formación en persona."
            value="Trabajo con curso y / o formación en persona."
          >
          </el-option>
          <el-option
            label="Empezaré mis cursos online y / o proyecto formativo."
            value="Empezaré mis cursos online y / o proyecto formativo."
          >
          </el-option>
          <el-option
            label="Estoy desarrollando mis cursos online y / o proyecto formativo."
            value="Estoy desarrollando mis cursos online y / o proyecto formativo."
          >
          </el-option>
          <el-option
            label="Ya trabajo con cursos y / o formaciones online."
            value="Ya trabajo con cursos y / o formaciones online."
          >
          </el-option>
          <el-option
            label="Todavía no trabajo con ningún proyecto educativo."
            value="Todavía no trabajo con ningún proyecto educativo."
          >
          </el-option>
        </el-select>
        <br /><br />
        <span>Seleccione una meta</span>
        <el-select required name="goal" v-model="goal" placeholder="Select">
          <el-option
            label="Quiero crear y vender cursos a través de Internet."
            value="Quiero crear y vender cursos a través de Internet."
          >
          </el-option>
          <el-option
            label="Quiero impartir formación online a los empleados de mi empresa."
            value="Quiero impartir formación online a los empleados de mi empresa."
          >
          </el-option>
          <el-option
            label="Quiero crear cursos para una institución educativa."
            value="Quiero crear cursos para una institución educativa."
          >
          </el-option>
          <el-option
            label="Quiero realizar consultoría y / o formación online para mis clientes."
            value="Quiero realizar consultoría y / o formación online para mis clientes."
          >
          </el-option>
          <el-option
            label="Quiero expandir mi negocio a través del Inbound Marketing."
            value="Quiero expandir mi negocio a través del Inbound Marketing."
          >
          </el-option>
          <el-option
            label="Todavía no tengo un objetivo definido."
            value="Todavía no tengo un objetivo definido."
          >
          </el-option>
        </el-select>
        <br /><br />
        <span>{{ lang['phone'] }}</span>
        <el-input required name="phone" v-model="phone" type="text"></el-input>
        <br /><br />
        <el-button
          v-loading="loading"
          native-type="submit"
          class="sbr-primary"
          >{{ lang['save-button'] }}</el-button
        >
      </form>
    </div>
    <div class="col-md-6 col-12">
      <!-- First step text -->
      <div class="text" v-if="firstStep">
        <h3>{{ lang['user-account'] }}</h3>
        <hr />
        <h4>
          {{ lang['registration-message'] }}
        </h4>
      </div>
      <!-- Second step text -->
      <div class="text" v-else>
        <h3>Informaciones adicionales</h3>
        <h4>
          ¡Estamos casi alli! Ahora necesitamos más información para mejorar tu
          experiencia dentro de la plataforma
        </h4>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  data: () => {
    return {
      username: '',
      email: '',
      password: '',
      firstStep: true,
      seePassword: false,
      step: 'Trabajo con curso y / o formación en persona.',
      goal: 'Quiero crear y vender cursos a través de Internet.',
      phone: '',
      loading: false
    };
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  mounted() {
    this.getCompanyInformation();

    const body = document.body;
    body.classList.add('modal_bg');

    if (this.user.name !== 'default') {
      this.firstStep = false;
    }
  },
  beforeDestroy() {
    const body = document.body;
    body.classList.remove('modal_bg');
  },
  methods: {
    updateUser() {
      this.loading = true;
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
          this.loading = false;
          this.firstStep = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    updateCompanyInformation() {
      this.loading = true;
      const formData = new FormData();
      formData.set('step', this.step);
      formData.set('goal', this.goal);
      formData.set('phone', this.phone);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'Company',
        'updateCompanyInformation'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$router.push('/home').catch(() => {});
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getCompanyInformation() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'Company',
        'getCompanyInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          if (response.data.step_project !== 'default') {
            this.$router.push('/home').catch(() => {});
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

<style scoped lang="scss"></style>
