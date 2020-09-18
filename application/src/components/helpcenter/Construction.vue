<template>
  <div class="m-t-10 center construction">
    <img
      class="no-results-img"
      src="@/assets/img/general/ux/no_persons.png"
      alt="No courses"
    />
    <h3 class="m-t-40 fw-700">{{ lang['under-construction-title'] }}</h3>
    <p>{{ lang['under-construction-subtitle'] }}</p>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  computed: {
    ...mapState(['lang'])
  }
};
</script>

<style scoped>
.construction {
  padding: 0% 10%;
}
</style>
