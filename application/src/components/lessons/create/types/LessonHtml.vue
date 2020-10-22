<template>
  <!--  Modal new lesson -->
  <div>
    <el-dialog
      :visible.sync="modalCreateHtml"
      :title="lang['create-new-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-html" @submit.prevent="create()">
        <div class="form-row">
          <!-- Module id -->
          <input type="number" class="hide" name="moduleId" :value="moduleId"/>
          <input type="text" class="hide" name="type_mylesson_id" value="7"/>
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-12 col-md-12">
            <!-- Html editor -->
            <input class="hide" name="path" id="path"/>
            <HtmlEditor @htmlCode="htmlCode=$event " @javascriptCode="jsCode=$event" @cssCode="cssCode=$event "/>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              class="sbr-primary"
              v-loading="loading"
              native-type="submit"
            >{{ lang['save-button'] }}
            </el-button
            >
          </div>
        </div>
      </form>
    </el-dialog>
  </div>
  <!-- End  modal new lesson -->
</template>

<script>
import {eventBus} from '@/components/newcourse/App';
import {mapState} from 'vuex';
import HtmlEditor from '@/components/viewcourse/HtmlEditor';
import UploadFile from '@/mixins/upload';


export default {
  props: ['module-id'],
  data() {
    return {
      loading: false,
      name: '',
      modalCreateHtml: false,
      htmlCode: '',
      jsCode: '',
      cssCode: ''
    };
  },
  components: {
    HtmlEditor
  },

  mounted() {
    eventBus.$on('new-html', () => {
      this.modalCreateHtml = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getSubDomainName() {
      return new Promise((resolve) => {
        const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
          'verify',
          'getSubDomainName'
        );
        this.$request.get(urlToBeUsedInTheRequest).then(
          (response) => {
            resolve(this.subDomainName = response.data);
          },
          () => {
            this.$errorMessage();
          }
        );
      });
    },
    async create() {
      this.loading = true;
      const up = new UploadFile();
      const myFolder = up.generateFileName();
      document.getElementById('path').value = myFolder;
      const subdomain = await this.getSubDomainName();
      await up.uploadTextFile(subdomain, 'html/' + myFolder, 'index.html', this.htmlCode);
      await up.uploadTextFile(subdomain, 'html/' + myFolder, 'script.js', this.jsCode);
      await up.uploadTextFile(subdomain, 'html/' + myFolder, 'style.css', this.cssCode);
      const form = document.getElementById('form-lesson-html');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'create'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.actionsToBePerformedAfterRegistration();
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );
      this.htmlCode = '';
      this.jsCode = '';
      this.cssCode = '';
      this.loading = false;
    },
    actionsToBePerformedAfterRegistration() {
      this.name = '';
      this.modalCreateHtml = false;
      eventBus.$emit('new-lesson');
    }
  }
}
</script>
