<template>
  <vc-calendar
    v-if="locale != null"
    :locale="locale"
    :attributes="attrs"
    is-inline
    is-expanded
  ></vc-calendar>
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
      ],
      locale: null
    };
  },
  mounted() {
    this.getUserEvents();
    this.getSettingsInformation();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getSettingsInformation() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );

      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.locale = response.data.lang;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
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
