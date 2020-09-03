<template>
  <div class="content-page">
    <div v-if="userRole != 3">
      <program-create
        :program-list="programList"
        :total-programs="numberTotalOfProgramsCreated"
      ></program-create>
    </div>

    <div>
      <program-list :program-list="programList"></program-list>
    </div>
  </div>
</template>

<script>
import ProgramCreate from '@/components/programs/ProgramCreate.vue';
import ProgramList from '@/components/programs/ProgramList.vue';
import Vue from 'vue';
import VueHead from 'vue-head';
import { mapState } from 'vuex';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  data: () => {
    return {
      programList: null,
      numberTotalOfProgramsCreated: ''
    };
  },
  computed: {
    ...mapState(['userRole'])
  },
  mounted() {
    this.getPrograms();
    eventBus.$on('program-deleted', () => {
      this.getPrograms();
    });
  },
  methods: {
    getPrograms() {
      const urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        'program',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.programList = response.data;
          this.numberTotalOfProgramsCreated = response.data.length;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  },
  head: {
    title: {
      inner: 'Programs'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  components: {
    ProgramCreate,
    ProgramList
  }
};
</script>

<style scoped></style>
