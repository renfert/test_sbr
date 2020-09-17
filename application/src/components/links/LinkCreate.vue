<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['new-link']"
      center
      width="40%"
      top="5vh"
    >
      <form id="form-link" @submit.prevent="createLink()">
        <div class="form-group">
          <label>{{ lang['name'] }}</label>
          <el-input name="title" v-model="link.title"></el-input>
        </div>
        <div class="form-group">
          <label>{{ lang['url'] }}</label>
          <el-input name="url" v-model="link.url"></el-input>
        </div>
        <div class="form-group">
          <label>{{ lang['target'] }}</label>
          <div>
            <el-select name="target" v-model="link.target" placeholder="Select">
              <el-option :label="lang['new-window']" value="_new"> </el-option>
              <el-option :label="lang['same-window']" value="_blank">
              </el-option>
            </el-select>
          </div>
        </div>
        <div class="form-group">
          <el-button class="sbr-primary" native-type="submit">{{
            lang['save-button']
          }}</el-button>
        </div>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import { eventBus } from '@/components/site/App';

import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      link: {
        title: '',
        url: '',
        target: ''
      },
      modal: false
    };
  },
  mounted() {
    eventBus.$on('open-link-modal', () => {
      this.modal = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    createLink() {
      const form = document.getElementById('form-link');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'link',
        'create'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          form.reset();
          this.modal = false;
          eventBus.$emit('link-list-update');
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
