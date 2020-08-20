<template>
  <div>
    <exam-correction></exam-correction>
    <!----------------- 
      Corrections list 
    ------------------->
    <div class="card-box table-responsive" v-if="correctionsList != null">
      <h4>
        {{lang["list-corrections"]}}
        <el-popover placement="right" trigger="hover">
          <div>
            <p>{{lang["correction-status-information"]}}</p>
            <hr />
            <a href="#" class="text-warning">
              {{lang["pending"]}}
              <i class="el-icon-refresh-right"></i>
            </a>
            : {{lang["pending-information"]}}
            <br />
            <a href="#" class="text-success">
              {{lang["done"]}}
              <i class="el-icon-circle-check"></i>
            </a>
            : {{lang["done-information"]}}
          </div>
          <i slot="reference" class="el-icon-warning-outline text-primary"></i>
        </el-popover>
      </h4>
      <div style="margin-bottom: 10px">
        <el-row>
          <el-col :span="6">
            <el-input v-model="filters[0].value" placeholder="Search"></el-input>
          </el-col>
        </el-row>
      </div>
      <data-tables
        :pagination-props="{ background: true, pageSizes: [5] }"
        :data="correctionsList"
        :filters="filters"
      >
        <el-table-column
          v-for="title in titles"
          sortable="custom"
          :prop="title.prop"
          :label="title.label"
          :key="title.label"
        ></el-table-column>
        <el-table-column label="Actions" align="center">
          <template slot-scope="scope">
            <el-button
              @click="openCorrection(scope.row.id,scope.row.studentId)"
              class="sbr-primary"
              icon="el-icon-edit"
              circle
            ></el-button>
          </template>
        </el-table-column>
        <el-table-column prop="status" label="Status" align="center" sortable>
          <template slot-scope="scope">
            <a href="#" class="text-warning" v-if="scope.row.questionsToEvaluate != 0">
              {{lang["pending"]}}
              <i class="el-icon-refresh-right"></i>
            </a>

            <a href="#" class="text-success" v-else>
              {{lang["done"]}}
              <i class="el-icon-circle-check"></i>
            </a>
          </template>
        </el-table-column>
      </data-tables>
    </div>
    <!-- End correction list -->

    <div class="row mb-5 mt-5" v-else>
      <div class="col-12 text-center">
        <img class="no-results-img" src="@/assets/img/general/ux/no_exams.png" alt="No persons" />
        <h4 class="no-results-text">{{lang["no-results-corrections-title"]}}</h4>
      </div>
    </div>
  </div>
  <!-- End col-12 -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import ElementUI from "element-ui";
import ExamCorrection from "@/components/viewcourse/correction/ExamCorrection";

import { eventCorrection } from "@/components/viewcourse/correction/ExamCorrection";
import { DataTables, DataTablesServer } from "vue-data-tables";
import { mapState } from "vuex";

Vue.use(DataTables);
Vue.use(DataTablesServer);
Vue.use(ElementUI);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  components: {
    ExamCorrection
  },
  data: function() {
    return {
      titles: [
        { prop: "student", label: "Student" },
        { prop: "course", label: "Course" },
        { prop: "exam", label: "Exam" }
      ],
      correctionsList: [],
      filters: [
        { prop: "student", value: "" },
        { prop: "course", value: "" },
        { prop: "exam", value: "" },
        { prop: "status", value: "" }
      ],
      tableProps: { defaultSort: { prop: "status", order: "descending" } }
    };
  },
  created() {
    this.getCorrections();
  },
  mounted() {
    eventCorrection.$on(
      "finish-correction",
      function() {
        this.getCorrections();
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getCorrections() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "corrections",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.correctionsList = response.data;
        },
        function() {
          // Failure callback
          this.errorMessage();
        }.bind(this)
      );
    },
    openCorrection: function(examId, studentId) {
      var data = {
        examId: examId,
        studentId: studentId
      };
      eventCorrection.$emit("open-exam-correction", data);
    }
  }
};
</script>
