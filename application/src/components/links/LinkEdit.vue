<template>
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['edit-link']"
      center
      width="40%"
      top="5vh"
    >
      <form id="form-link" @submit.prevent="editLink()">
        <div class="form-group">
          <label>{{ lang['name'] }}</label>
          <el-input name="title" v-model="link.title"></el-input>
          <input type="text" name="linkId" v-model="link.id" class="hide" />
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
          <el-button native-type="submit" class="sbr-primary">{{
            lang['save-button']
          }}</el-button>
        </div>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import { eventBus } from '@/components/site/App';

export default {
  data: () => {
    return {
      link: {
        id: '',
        title: '',
        url: '',
        target: ''
      },
      modal: false,
      loading: false
    };
  },
  mounted() {
    eventBus.$on('edit-link', (data) => {
      this.link.id = data.id;
      this.link.title = data.title;
      this.link.url = data.url;
      this.link.target = data.target;
      this.modal = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    editLink() {
      const form = document.getElementById('form-link');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest('link', 'edit');
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          eventBus.$emit('link-list-update');
          this.modal = false;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
