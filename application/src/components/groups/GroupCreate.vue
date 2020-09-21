<template>
  <div class="card-box">
    <h4>{{ lang['create-group'] }}</h4>
    <el-form id="form-group" :inline="true">
      <el-form-item>
        <el-input
          clearable
          required
          name="name"
          :placeholder="lang['name']"
          v-model="groupName"
        ></el-input>
      </el-form-item>
      <el-form-item>
        <el-button
          @click.prevent="createGroup()"
          v-loading="loading"
          class="sbr-primary"
          native-type="submit"
          >{{ lang['save-button'] }}</el-button
        >
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { eventBus } from '@/components/groups/App';
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      groupName: '',
      loading: false
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    createGroup() {
      this.loading = true;
      const form = document.getElementById('form-group');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'create'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          if (response.data === false) {
            this.$groupAlreadyExistsMessage();
          } else {
            this.$successMessage();
            this.loading = false;
            form.reset();
            eventBus.$emit('new-group');
          }
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    groupAlreadyExistsMessage() {
      this.$notify({
        title: this.lang.error,
        message: this.lang['group-already-exists'],
        type: 'warning',
        duration: 3500
      });
    }
  }
};
</script>
