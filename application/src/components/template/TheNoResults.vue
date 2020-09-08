<template>
  <div class="row mb-5">
    <div class="col-12 text-center">
      <img
        :style="'width:' + size"
        class="no-results-img"
        :src="'@/assets/img/general/ux/' + this.imageName"
        alt="No activities"
      />
      <h4 class="no-results-text">{{ lang['no-activities'] }}</h4>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  props: ['image-name', 'size'],
  mounted() {
    alert(this.imageName);
  },
  computed: {
    ...mapState(['lang', 'userRole'])
  }
};
</script>
