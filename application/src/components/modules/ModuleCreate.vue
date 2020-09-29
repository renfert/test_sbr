<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['create-new-module']"
      center
      top="5vh"
    >
      <form
        id="form-create-module"
        @submit.prevent="createModule()"
        v-loading="loading"
      >
        <div class="form-row">
          <!-- Course id -->
          <input
            type="number"
            class="hide"
            name="courseId"
            v-model="courseId"
          />

          <div class="form-group col-xl-12 col-md-12 m-b-40">
            <!-- Module name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input required v-model="myModule.name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row hide">
          <div class="form-group col-xl-6 col-md-6">
            <!-- Module release date -->
            <label class="col-form-label">{{ lang['start-date'] }} *</label>
            <br />
            <el-date-picker
              v-model="myModule.releaseDate"
              name="date"
              type="date"
              format="yyyy/MM/dd"
              value-format="yyyy-MM-dd"
              placeholder="Pick a day"
            ></el-date-picker>
          </div>
          <div class="form-group col-xl-6 col-md-6">
            <!-- Module requirement -->
            <label style="margin-bottom: 4%" class="col-form-label">{{
              lang['required-module']
            }}</label>
            <br />
            <div class="input-group">
              <el-switch
                name="required"
                v-model="myModule.required"
                active-color="#09dfff"
              ></el-switch>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              class="sbr-primary"
              native-type="submit"
              type="primary"
              size="medium"
              >{{ lang['save-button'] }}</el-button
            >
          </div>
        </div>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import { eventBus } from '@/components/newcourse/App';
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      myModule: {
        name: '',
        releaseDate: '',
        required: false
      },
      modal: false,
      loading: false
    };
  },
  props: ['course-id'],
  mounted() {
    eventBus.$on('open-module-modal', () => {
      this.modal = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    createModule() {
      this.loading = true;
      const form = document.getElementById('form-create-module');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'module',
        'create'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          eventBus.$emit('new-module');
          this.$successMessage();
          form.reset();
          this.modal = false;
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
