<template>
  <div>
    <el-dialog
      :visible.sync="modalEditHtml"
      :title="lang['edit-lesson']"
      center
      top="5vh"
    >
      <form id="form-lesson-html-edit" @submit.prevent="edit()">
        <div class="form-row">
          <input type="number" class="hide" name="lessonId" :value="lessonId"/>
          <div class="form-group col-xl-12 col-md-12">
            <!-- Lesson name -->
            <label class="col-form-label">{{ lang['name'] }} *</label>
            <el-input required v-model="name" name="title"></el-input>
          </div>
        </div>
        <img src="https://sbrfiles.s3.amazonaws.com/gifs/loader.gif" alt="loader" style="display: block; margin:auto; "
             v-if="loading">
        <HtmlEditor :html-code="html" @htmlCode="html=$event" :javascriptCode="javascript"
                    @javascriptCode="javascript=$event" :cssCode="css" @cssCode="css=$event" v-else/>
        <br>
        <div class="form-row">
          <div class="form-group col-xl-6 col-md-6">
            <el-button
              v-loading="loading"
              native-type="submit"
              class="sbr-primary"
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
import {eventProgress} from '@/components/helper/HelperProgress';
import {eventBus} from '@/components/newcourse/App';
import {mapState} from 'vuex';
import HtmlEditor from '@/components/viewcourse/HtmlEditor';
import UploadFile from '@/mixins/upload';

export default {
  components: {HtmlEditor},
  data: () => {
    return {
      name: '',
      htmlName: '',
      previewImg: '',
      realName: '',
      icon: 'fas fa-cloud-upload-alt',
      message: 'Upload a file',
      modalEditHtml: false,
      loading: false,
      lessonId: '',
      html: '',
      javascript: '',
      css: ''
    };
  },
  mounted() {
    eventBus.$on('edit-lesson-7', (response) => {
      this.modalEditHtml = true;
      this.lessonId = response[0].id;
      this.name = response[0].title;
      this.realName = response[0].real_name;
      this.htmlName = response[0].path;
      this.message = response[0].real_name;
      this.icon = 'far fa-thumbs-up text-default';
      this.loadHtmlContent();
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
    async loadHtmlContent() {
      this.loading = true;
      const fileRoute = this.$getUrlToContents() + 'html/' + this.htmlName + '/';
      /* Get Html Content -> index.html */
      this.$request.get(fileRoute + 'index.html').then((response)=>{
        this.html = response.data;
        console.log(response);
      });
      /* Get Javascript Content -> script.js */
      const response1 = await this.$request.get(fileRoute + 'script.js');
      this.javascript = response1.data;
      /* Get Css Content -> style.css */
      const response2 = await this.$request.get(fileRoute + 'style.css');
      this.css = response2.data;
      this.loading = false;
    },
    async edit() {
      this.loading = true;
      const form = document.getElementById('form-lesson-html-edit');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'lesson',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.actionsToBePerformedAfterEdit();
          this.loading = false;
        },
        () => {
          this.$errorMessage();
        }
      );

      const subdomain = await this.getSubDomainName();
      const up = new UploadFile();
      up.uploadTextFile(subdomain, 'html/' + this.htmlName, 'index.html', this.html);
      up.uploadTextFile(subdomain, 'html/' + this.htmlName, 'script.js', this.javascript);
      up.uploadTextFile(subdomain, 'html/' + this.htmlName, 'style.css', this.css);
    },
    actionsToBePerformedAfterEdit() {
      this.name = '';
      this.htmlName = '';
      this.modalEditHtml = false;
      eventBus.$emit('new-lesson');
    }
  }
};
</script>
