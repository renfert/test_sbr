<template>
  <vc-calendar :attributes="attrs" is-inline is-expanded></vc-calendar>
</template>

<script>
import Vue from 'vue';
import VCalendar from 'v-calendar';

import { mapState } from 'vuex';

Vue.use(VCalendar, {
  componentPrefix: 'vc'
});

export default {
  data: () => {
    return {
      attrs: [
        {
          highlight: true,
          popover: {
            label: ''
          },
          dates: ''
        }
      ]
    };
  },
  mounted() {
    this.getUserEvents();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getUserEvents() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'calendar',
        'get'
      );

      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.attrs = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
