<template>
  <el-dialog :visible.sync="modal" :title="lang['your-certificate']" center width="60%" top="5vh">
    <div v-loading="loading">
      <div class="text-center mb-3">
        <div class="text-center">
          <img src="@/assets/img/general/ux/certificate.png" class="mb-3" />
          <br />
          <el-button
            @click.prevent="printCertificate()"
            class="sbr-primary"
          >{{lang["print-certificate"]}}</el-button>
        </div>
      </div>
    </div>
    <vue-html2pdf
      :show-layout="false"
      :preview-modal="true"
      :paginate-elements-by-height="1400"
      filename="certificate"
      :pdf-quality="2"
      pdf-format="a4"
      pdf-orientation="landscape"
      pdf-content-width="800px"
      ref="html2Pdf"
      @progress="onProgress($event)"
    >
      <section v-if="template == 'classic'" slot="pdf-content">
        <div>
          <div class="classic-template">
            <h2>{{companyName}}</h2>
            <h3>{{lang['certificate-of-completition']}}</h3>
            <h5>{{lang['granted-to']}}</h5>
            <h1>{{userName}}</h1>
            <p>{{lang['certify-completition']}}</p>
            <h3>{{course}}</h3>
            <hr />
            <div class="row">
              <div class="col-6">
                <h4>#{{number}}</h4>
              </div>
              <div class="col-6">
                <h4>{{date}}</h4>
              </div>
            </div>
          </div>
        </div>
        <img src="@/assets/img/general/certificate/classic_template.png" alt />
      </section>

      <section v-if="template == 'tech'" slot="pdf-content">
        <div>
          <div class="tech-template">
            <h2>{{companyName}}</h2>
            <h3>{{lang['certificate-of-completition']}}</h3>
            <h5>{{lang['granted-to']}}</h5>
            <h1>{{userName}}</h1>
            <p>{{lang['certify-completition']}}</p>
            <h3>{{course}}</h3>
            <hr />
            <div class="row">
              <div class="col-6">
                <h4>#{{number}}</h4>
              </div>
              <div class="col-6">
                <h4>{{date}}</h4>
              </div>
            </div>
          </div>
        </div>
        <img src="@/assets/img/general/certificate/tech_template.png" alt />
      </section>

      <section v-if="template == 'artistic'" slot="pdf-content">
        <div>
          <div class="artistic-template">
            <h2>{{companyName}}</h2>
            <h3>{{lang['certificate-of-completition']}}</h3>
            <h5>{{lang['granted-to']}}</h5>
            <h1>{{userName}}</h1>
            <p>{{lang['certify-completition']}}</p>
            <h3>{{courseName}}</h3>
            <hr />
            <div class="row">
              <div class="col-6">
                <h4>#{{number}}</h4>
              </div>
              <div class="col-6">
                <h4>{{date}}</h4>
              </div>
            </div>
          </div>
        </div>
        <img src="@/assets/img/general/certificate/artistic_template.png" alt />
      </section>
    </vue-html2pdf>
  </el-dialog>
</template>

<script>
import Vue from "vue";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VueHtml2pdf from "vue-html2pdf";

export const eventCertificate = new Vue();

import { mapState } from "vuex";

export default {
  mixins: [domains, alerts],
  props: ["course-id"],
  components: {
    VueHtml2pdf
  },
  data: function() {
    return {
      modal: false,
      courseName: "",
      date: "",
      template: null,
      number: "",
      companyName: "",
      userName: "",
      loading: false
    };
  },
  mounted() {
    eventCertificate.$on("print-certificate", () => {
      this.getCompanyInformation();
      this.getUserProfile();
      this.getCertificate();
      this.modal = true;
    });
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    printCertificate() {
      this.loading = true;
      this.$refs.html2Pdf.generatePdf();
    },
    onProgress(event) {
      if (event == 100) {
        this.loading = false;
      }
    },
    getUserProfile() {
      let urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      this.$request.get(urlToBeUsedInTheRequest).then(response => {
        this.userName = response.data["name"];
      });
    },
    getCompanyInformation() {
      let urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "company",
        "getCompanyInformation"
      );
      this.$request.get(urlToBeUsedInTheRequest).then(response => {
        this.companyName = response.data["name"];
      });
    },
    getCertificate() {
      let formData = new FormData();
      let urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "certificate",
        "get"
      );
      formData.set("courseId", this.courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(response => {
        this.course = response.data[0]["course"];
        this.date = response.data[0]["date"];
        this.template = response.data[0]["certificate"];
        this.number = response.data[0]["number"];
      });
    }
  }
};
</script>
