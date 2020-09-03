<template>
  <div class="row mb-5">
    <div class="col-12 text-center">
      <img
        class="no-results-img"
        src="@/assets/img/general/ux/no_notification.png"
        alt="No activities"
      />
      <h4 class="no-results-text">{{ lang['no-activities'] }}</h4>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  data: () => {
    return {};
  },
  computed: {
    ...mapState(['lang', 'userRole'])
  }
};
</script>
