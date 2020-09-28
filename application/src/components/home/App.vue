<template>
  <div class="content-page">
    <admin v-if="user.role == 1"></admin>
    <instructor v-if="user.role == 2"></instructor>
    <student v-if="user.role == 3"></student>

<!--    <Social/>-->
  </div>
</template>

<script>
import Admin from '@/components/home/roles/Admin';
import Instructor from '@/components/home/roles/Instructor';
import Student from '@/components/home/roles/Student';
import Social from '@/components/sabiorealm-social/App';
import { mapState } from 'vuex';

export default {
  components: {
    Admin,
    Instructor,
    Student,
    Social
  },
  computed: {
    ...mapState(['user'])
  }
};
</script>
