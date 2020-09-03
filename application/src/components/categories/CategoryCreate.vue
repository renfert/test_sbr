<template>
  <div class="card-box table-responsive">
    <h4>{{ lang['create-category'] }}</h4>
    <el-form id="form-category" :inline="true">
      <el-form-item>
        <el-input
          required
          name="name"
          :placeholder="lang['name']"
          v-model="categoryName"
        ></el-input>
      </el-form-item>
      <el-form-item>
        <el-button
          @click.prevent="createCategory()"
          v-loading="loading"
          class="sbr-primary"
          native-type="submit"
          type="primary"
          >{{ lang['save-button'] }}</el-button
        >
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { eventBus } from '@/components/categories/App';
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      categoryName: '',
      loading: false
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    createCategory() {
      this.loading = true;

      const form = document.getElementById('form-category');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'category',
        'create'
      );

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.loading = false;
          if (response.data === false) {
            this.categoryAlreadyExistsMessage();
          } else {
            this.$successMessage();
            form.reset();
            eventBus.$emit('new-category');
          }
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    categoryAlreadyExistsMessage() {
      this.$notify({
        title: this.lang.error,
        message: this.lang['category-already-exists'],
        type: 'warning',
        duration: 3500
      });
    }
  }
};
</script>
