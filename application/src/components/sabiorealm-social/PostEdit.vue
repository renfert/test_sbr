<template>

</template>

<script>
import {mapState} from "vuex";

export default {
  props: ['editDialog'],
  computed: {
    myedit: {
      get() {
        return this.editDialog;
      },
      set(value) {
        this.$emit('editDialog', value);
      }
    },
    ...mapState(['lang', 'user'])

  }
};
</script>
