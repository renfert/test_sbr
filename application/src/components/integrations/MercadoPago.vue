<template>
  <el-col :sm="12" :xs="24">
    <br />
    <img
      style="width: 100px"
      class="m-b-10"
      src="@/assets/img/apps/mercadopago.png"
    />
    <br />
    <form id="form-mp" @submit.prevent="captureCurrency()">
      <div class="form-group">
        <el-input
          clearable
          class="m-b-10"
          :type="typeInput"
          v-model="accessToken"
          name="id"
          placeholder="ACCESS TOKEN"
        >
          <el-button
            @click.prevent="changeInputType()"
            slot="append"
            :icon="typeInput == 'password' ? 'mdi mdi-eye-off' : 'mdi mdi-eye'"
          ></el-button>
        </el-input>
        <el-button
          v-loading="loading"
          class="sbr-btn sbr-primary mt-3"
          native-type="submit"
          type="primary"
          >{{ lang['save-button'] }}</el-button
        >
        <br />

        <div class="mt-5">
          <p>{{ lang['how-get-access-token'] }}</p>
          <el-select
            v-model="code"
            name="country"
            :placeholder="lang['select-your-country']"
          >
            <!-- Argentina -->
            <a
              target="_blank"
              href="https://www.mercadopago.com/mla/account/credentials"
            >
              <el-option label="ar" value="ar">
                <span style="float: left">Argentina</span>
                <span style="float: right; color: #8492a6; font-size: 13px">
                  <img src="@/assets/img/general/flags/ar.png" alt="en" />
                </span>
              </el-option>
            </a>

            <!-- Uruguay -->
            <a
              target="_blank"
              href="https://www.mercadopago.com/mlu/account/credentials"
            >
              <el-option label="uy" value="uy">
                <span style="float: left">Uruguay</span>
                <span style="float: right; color: #8492a6; font-size: 13px">
                  <img src="@/assets/img/general/flags/uy.png" alt="uy" />
                </span>
              </el-option>
            </a>

            <a
              target="_blank"
              href="https://www.mercadopago.com/mco/account/credentials"
            >
              <!-- Colombia -->
              <el-option label="co" value="co">
                <span style="float: left">Colombia</span>
                <span style="float: right; color: #8492a6; font-size: 13px">
                  <img src="@/assets/img/general/flags/co.png" alt="co" />
                </span>
              </el-option>
            </a>

            <!-- México -->
            <a
              target="_blank"
              href="https://www.mercadopago.com/mlm/account/credentials"
            >
              <el-option label="mx" value="mx">
                <span style="float: left">México</span>
                <span style="float: right; color: #8492a6; font-size: 13px">
                  <img src="@/assets/img/general/flags/mx.png" alt="mx" />
                </span>
              </el-option>
            </a>

            <!-- Chile -->
            <a
              target="_blank"
              href="https://www.mercadopago.com/mlc/account/credentials"
            >
              <el-option label="cl" value="cl">
                <span style="float: left">Chile</span>
                <span style="float: right; color: #8492a6; font-size: 13px">
                  <img src="@/assets/img/general/flags/cl.png" alt="cl" />
                </span>
              </el-option>
            </a>

            <a
              target="_blank"
              href="https://www.mercadopago.com/mlb/account/credentials"
            >
              <el-option label="br" value="br">
                <span style="float: left">Brasil</span>
                <span style="float: right; color: #8492a6; font-size: 13px">
                  <img src="@/assets/img/general/flags/pt-br.png" alt="pt-br" />
                </span>
              </el-option>
            </a>

            <a
              target="_blank"
              href="https://www.mercadopago.com/mpe/account/credentials"
            >
              <el-option label="pe" value="pe">
                <span style="float: left">Peru</span>
                <span style="float: right; color: #8492a6; font-size: 13px">
                  <img src="@/assets/img/general/flags/pe.png" alt="pe" />
                </span>
              </el-option>
            </a>

            <a
              target="_blank"
              href="https://www.mercadopago.com/mlv/account/credentials"
            >
              <el-option label="ven" value="ven">
                <span style="float: left">Venezuela</span>
                <span style="float: right; color: #8492a6; font-size: 13px">
                  <img src="@/assets/img/general/flags/ven.png" alt="ven" />
                </span>
              </el-option>
            </a>
          </el-select>
        </div>
      </div>
    </form>

    <!-----------
    Currency set
    ------------->
    <el-dialog :visible.sync="modal" width="50%">
      <span slot="title">
        <div class="text-center">
          <img
            class="text-center"
            style="width: 15%"
            src="@/assets/img/apps/mercadopago.png"
            alt
          />
          <h3 class="fw-700">{{ lang['mercado-pago-success'] }}</h3>
        </div>
      </span>
      <div class="text-center">
        <h3>{{ lang['ready-for-sales'] }}</h3>
        <p>
          {{ lang['course-currency'] }}
          :
          <b>{{ currency }}</b>
        </p>
        <img style="width: 30%" src="@/assets/img/apps/mercadopago.gif" alt />
      </div>
    </el-dialog>
  </el-col>
</template>

<script>
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      code: '',
      loading: false,
      accessToken: '',
      typeInput: 'password',
      currency: '',
      modal: false
    };
  },
  mounted() {
    this.getMpAccessToken();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    changeInputType() {
      if (this.typeInput === 'password') {
        this.typeInput = 'text';
      } else {
        this.typeInput = 'password';
      }
    },
    getMpAccessToken() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'getIntegrations'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          response.data.mp_access_token === 'default'
            ? (this.accessToken = '')
            : (this.accessToken = response.data.mp_access_token);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    saveMpAccessToken() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'saveMpAccessToken'
      );
      formData.set('id', this.accessToken);
      this.$request.post(urlToBeUsedInTheRequest, formData);
    },
    saveCurrency(currency) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'editCurrency'
      );
      formData.set('currency', currency);
      this.$request.post(urlToBeUsedInTheRequest, formData);
    },
    captureCurrency() {
      this.loading = true;
      const mercadopago = require('mercadopago');

      mercadopago.configure({
        sandbox: false,
        access_token: this.accessToken
      });

      const preference = {
        items: [
          {
            title: 'Na',
            unit_price: 2000,
            quantity: 1
          }
        ]
      };

      mercadopago.preferences
        .create(preference)
        .catch((err) => {
          console.log(err);
          this.$message.error(this.lang['invalid-access-token']);
          this.loading = false;
        })
        .then((res) => {
          this.currency = res.response.items[0].currency_id;
          this.saveCurrency(res.response.items[0].currency_id);
          this.saveMpAccessToken();
          this.loading = false;
          this.modal = true;
        });
    }
  }
};
</script>

<style scoped>

@media only screen and (max-width: 450px) {
  .sbr-primary{
    width: 100% !important;
  }
}
</style>