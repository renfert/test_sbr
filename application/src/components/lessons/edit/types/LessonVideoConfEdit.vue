<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['edit-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-videoconf-edit" @submit.prevent="edit()">
        <div class="form-row">
          <!-- Lesson id -->
          <input
            type="number"
            class="hide"
            name="lessonId"
            :value="videoconf.id"
          />
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input required v-model="videoconf.name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson description -->
            <label class="col-form-label">{{ lang['description'] }} *</label>
            <el-input
              type="textarea"
              name="description"
              rows="3"
              v-model="videoconf.description"
            ></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson date -->
            <label class="col-form-label">{{ lang['date'] }} *</label>
            <div class="block">
              <el-date-picker
                required
                v-model="videoconf.date"
                type="date"
                name="date"
                format="yyyy/MM/dd"
                value-format="yyyy-MM-dd"
                placeholder="Pick a day"
              ></el-date-picker>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson Schedule -->
            <label class="col-form-label">{{ lang['schedule'] }} *</label>
            <div class="block">
              <el-time-select
                required
                v-model="videoconf.schedule"
                name="time"
                :picker-options="{
                  start: '00:00',
                  end: '23:30'
                }"
                placeholder="Select time"
              ></el-time-select>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              v-loading="loading"
              native-type="submit"
              class="sbr-primary"
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
      videoconf: {
        id: '',
        name: '',
        url: '',
        date: '',
        description: '',
        schedule: ''
      },
      modal: false,
      loading: false
    };
  },
  mounted() {
    eventBus.$on('edit-lesson-5', (response) => {
      this.modal = true;
      this.videoconf.id = response[0].id;
      this.videoconf.name = response[0].title;
      this.videoconf.url = response[0].url;
      this.videoconf.date = response[0].date;
      this.videoconf.description = response[0].description;
      this.videoconf.schedule = response[0].time;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    edit() {
      this.loading = true;
      const form = document.getElementById('form-lesson-videoconf-edit');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          form.reset();
          this.$successMessage();
          eventBus.$emit('new-lesson');
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
