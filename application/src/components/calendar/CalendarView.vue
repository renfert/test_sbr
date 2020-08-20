<template>
  <vc-calendar :attributes="attrs" is-inline is-expanded></vc-calendar>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VCalendar from "v-calendar";

import { mapState } from "vuex";

Vue.use(VCalendar, {
  componentPrefix: "vc"
});

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      attrs: [
        {
          highlight: true,
          popover: {
            label: "You just hovered over today's date!"
          },
          dates: "2020-05-05"
        }
      ]
    };
  },
  mounted() {
    this.getUserEvents();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getUserEvents: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("calendar", "get");
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.attrs = response.data;
        },
        () => {
          // Failure callback
          this.errorMessage();
        }
      );
    }
  }
};
</script>
