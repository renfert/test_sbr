<template>
  <div>
    <div class="card-box m-t-30" v-if="programList != null">
      <program-list-view
        :program-list="programList"
        v-if="programVisualization == 'list'"
      ></program-list-view>
      <program-table-view v-else></program-table-view>
    </div>

    <el-row class="center m-t-40" v-else>
      <el-col :sm="24">
        <img
          class="not-found-image"
          src="@/assets/img/general/ux/no_programs.svg"
          alt="No programs"
        />
        <h4 class="sbr-text-grey">{{ lang['no-programs-found'] }}</h4>
        <router-link to="/newprogram">
          <el-button class="sbr-primary mt-3">
            {{ lang['new-program-button'] }}
          </el-button>
        </router-link>
      </el-col>
    </el-row>
  </div>
  <!-- End col-12 -->
</template>

<script>
import ProgramListView from '@/components/programs/views/ProgramListView';
import ProgramTableView from '@/components/programs/views/ProgramTableView';

import { mapState } from 'vuex';

export default {
  components: {
    ProgramListView,
    ProgramTableView
  },
  props: ['program-list'],
  data: () => {
    return {
      programVisualization: 'list'
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    changeProgramVisualization() {
      this.programVisualization === 'list'
        ? (this.programVisualization = 'table')
        : (this.programVisualization = 'list');
    }
  }
};
</script>
