<template>
  <div>
    <div style="width: 100%" v-loading="loading" id="paypal-button"></div>
  </div>
</template>

<script>
import Vue from 'vue';
import { mapState } from 'vuex';
import LoadScript from 'vue-plugin-load-script';
Vue.use(LoadScript);
const md5 = require('md5');

export default {
  props: ['currency', 'price', 'course-id'],
  data: () => {
    return {
      paypalClientId: '',
      loading: false
    };
  },
  mounted() {
    this.getPaypalClientId();
  },
  computed: {
    ...mapState(['lang'])
  },
  watch: {
    paypalClientId() {
      this.createPaypalOrder();
    }
  },
  methods: {
    getPaypalClientId() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'getIntegrations'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.paypalClientId = response.data.paypal_client_id;
      });
    },
    savePreferenceId(preferenceId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'savePreferenceId'
      );
      formData.set('preferenceId', preferenceId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {},
        () => {
          this.$errorMessage();
        }
      );
    },

    createPaypalOrder() {
      Vue.loadScript(
        'https://www.paypal.com/sdk/js?currency=' +
          this.currency +
          '&client-id=' +
          this.paypalClientId +
          ''
      ).then(() => {
        /* eslint-disable */
        paypal
          .Buttons({
            commit: true,
            createOrder: (data, actions) => {
              this.loading = true;
              return actions.order.create({
                purchase_units: [
                  {
                    amount: {
                      value: parseInt(
                        this.price.split('.').join('').split(',').join('.')
                      )
                    }
                  }
                ]
              });
            },
            onApprove: (data, actions) => {
              return actions.order.capture().then((details) => {
                const transactionId = details.id;
                const transactionStatus = details.status;

                this.savePreferenceId(md5(transactionId));

                setTimeout(() => {
                  const formData = new FormData();
                  formData.set('transactionId', transactionId);
                  formData.set('transactionStatus', transactionStatus);
                  formData.set('courseId', this.courseId);
                  const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
                    'payment',
                    'processPaypal'
                  );

                  this.$request.post(urlToBeUsedInTheRequest, formData).then(
                    (response) => {
                      console.log(response);
                      if (response.data == true) {
                        this.$router.push(
                          '/purchase/success/' + this.courseId + ''
                        );
                      }
                    },
                    () => {
                      this.$errorMessage();
                    }
                  );
                }, 1000);
              });
            },
            style: {
              layout: 'vertical',
              color: 'gold',
              shape: 'rect',
              label: 'buynow'
            }
          })
          .render('#paypal-button');
      });
    }
  }
};
</script>
