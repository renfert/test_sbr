<template>
  <div>
    <div class="row mt-5">
      <div
        class="col-12 col-md-4 list-programs"
        v-for="element in programList"
        :key="element.id"
      >
        <!-- Card -->
        <div class="card">
          <!-- Card image -->
          <img
            v-if="element.expirationDays < 0 || element.releaseDays > 0"
            v-lazy="getUrlToContents() + 'program/' + element.photo + ''"
            style="height: 200px; cursor: not-allowed"
            class="card-img-top"
          />
          <router-link v-else :to="'/viewprogram/' + element.id">
            <!-- Card image -->
            <img
              v-lazy="getUrlToContents() + 'program/' + element.photo + ''"
              style="height: 200px"
              class="card-img-top"
            />
          </router-link>

          <!-- Card content -->
          <div class="card-body">
            <!-- Title -->
            <h4
              class="card-title"
              v-if="element.expirationDays < 0 || element.releaseDays > 0"
            >
              {{ element.title }}
            </h4>

            <h4 v-else>
              <router-link
                class="sbr-text-grey"
                :to="'/viewprogram/' + element.id"
                >{{ element.title }}</router-link
              >
            </h4>

            <el-progress
              v-if="
                parseInt((100 * element.finishedLessons) / element.lessons) > 0
              "
              :percentage="
                parseInt((100 * element.finishedLessons) / element.lessons)
              "
            ></el-progress>

            <el-progress v-else :percentage="0"></el-progress>

            <el-tag class="mt-2" v-if="element.expirationDays < 0" type="danger"
              >{{ lang['program-expired'] }}
              {{ element.expiration_date }}</el-tag
            >

            <el-tag class="mt-2" v-if="element.releaseDays > 0" type="primary"
              >{{ lang['program-avaiable-in'] }}
              {{ element.release_date }}</el-tag
            >

            <el-divider v-if="userRole != 3">
              <i class="el-icon-more-outline"></i>
            </el-divider>
            <el-row v-if="userRole != 3">
              <router-link :to="'/editprogram/' + element.id">
                <el-button
                  size="small"
                  class="sbr-primary mr-2"
                  type="primary"
                  icon="el-icon-edit"
                  circle
                ></el-button>
              </router-link>
              <template>
                <el-popconfirm
                  confirmButtonText="Ok"
                  cancelButtonText="No, Thanks"
                  placement="right"
                  :title="lang['question-delete-program'] + element.title + '?'"
                  @onConfirm="deleteProgram(element.id)"
                >
                  <el-button
                    class="sbr-danger"
                    slot="reference"
                    type="danger"
                    size="small"
                    icon="el-icon-delete"
                    circle
                  ></el-button>
                </el-popconfirm>
              </template>
            </el-row>
          </div>
        </div>
        <!-- Card -->
      </div>
    </div>
  </div>
  <!-- End col-12 -->
</template>

<script>
import Vue from 'vue';
import VueLazyload from 'vue-lazyload';
import { eventBus } from '@/components/programs/App';

import { mapState } from 'vuex';

Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: 'https://sbrfiles.s3.amazonaws.com/images/image-not-available.png',
  loading: 'https://sbrfiles.s3.amazonaws.com/gifs/loading7.gif',
  attempt: 1
});

export default {
  props: ['program-list'],
  data: () => {
    return {
      titles: [{ prop: 'title', label: 'Title' }],
      filters: [{ prop: 'title', value: '' }],
      tableProps: { defaultSort: { prop: 'title', order: 'descending' } },
      modal: false
    };
  },
  computed: {
    ...mapState(['lang', 'userRole'])
  },
  methods: {
    deleteProgram(id) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        'program',
        'delete'
      );
      formData.set('programId', id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          eventBus.$emit('program-deleted');
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
