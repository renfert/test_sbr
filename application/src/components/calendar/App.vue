<template>
  <div class="content-page">
    <calendar-view></calendar-view>
  </div>
</template>

<script>
import CalendarView from "@/components/calendar/CalendarView";
import Vue from "vue";
import VueHead from "vue-head";

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    CalendarView
  },
  head: {
    title: {
      inner: "Calendar"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "description", content: "Learn and technology" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>

