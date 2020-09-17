<template>
  <!--  Modal edit social media -->
  <div>
    <el-dialog
      :visible.sync="modal"
      :title="lang['edit']"
      center
      width="40%"
      top="5vh"
    >
      <form id="form-social" @submit.prevent="editSocialMedia()">
        <input
          class="hide"
          type="number"
          name="socialMediaId"
          v-model="socialMediaId"
        />
        <div class="form-group">
          <label>{{ lang['social-media'] }}</label>
          <div class="block">
            <el-select name="socialMedia" v-model="name" placeholder="Select">
              <el-option label="Facebook" value="facebook"> </el-option>
              <el-option label="Instagram" value="instagram"> </el-option>
              <el-option label="Linkedin" value="linkedin"> </el-option>
              <el-option label="Twitter" value="twitter"> </el-option>
              <el-option label="Pinterest" value="pinterest"> </el-option>
              <el-option label="Youtube" value="youtube"> </el-option>
            </el-select>
          </div>
        </div>
        <div class="form-group">
          <label>{{ lang['url'] }}</label>
          <el-input name="url" v-model="url"></el-input>
        </div>
        <div class="form-group">
          <el-button native-type="submit" class="sbr-btn sbr-primary">{{
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
      socialMediaId: '',
      name: '',
      url: '',
      modal: false,
      loading: false
    };
  },
  mounted() {
    eventBus.$on('edit-social-media', (data) => {
      this.socialMediaId = data.id;
      this.name = data.name;
      this.url = data.url;

      this.modal = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    editSocialMedia() {
      const form = document.getElementById('form-social');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'social',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.actionsToBePerformedAfterEdit();
        },
        () => {
          this.$errorMessage();
        }
      );
    },

    actionsToBePerformedAfterEdit() {
      eventBus.$emit('new-change-footer');
      this.modal = false;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.action-icons {
  float: right;
  margin-left: 0%;
}

.links {
  cursor: pointer;
}

.custom-control-label {
  padding-top: 4px !important;
}

#accordion > .card {
  margin-bottom: 2%;
}

.btn-link {
  padding: 0px !important;
  font-size: 13px;
  font-family: 'Poppins', sans-serif;
  font-weight: 600;
}

.btn.link:hover {
  text-decoration: none !important;
}

.card-header {
  padding: 10px !important;
}

.btn-eadtools-rounded {
  border-radius: 50%;
  cursor: pointer;
  display: inline-block;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
  position: relative;
  height: 40px;
  width: 40px;
  background-color: #d696ef;
  z-index: 2;
  border: none;
  color: white;
  margin: 0 0.2rem;
}

.sortable-drag {
  opacity: 0;
}

.flip-list-move {
  transition: transform 0.5s;
}

.ghost {
  border-left: 6px solid rgb(0, 183, 255);
  border-radius: 5px;
  opacity: 0.5;
}

.card {
  margin-bottom: 15px;
}

.handle {
  cursor: move;
}

li {
  list-style-type: none;
}
</style>
