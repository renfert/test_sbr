<template>
  <div class="card-box text-center">
    <!-- Profile edit -->
    <form id="form-profile" @submit.prevent="editProfile()">
      <!-- Person id -->
      <input type="number" v-model="userId" name="userId" class="hide" />
      <div class="form-group">
        <div class="image-upload" style="text-align:center;">
          <label for="file-input">
            <el-avatar style="cursor:pointer" :size="100">
              <img :src="getUrlToContents() + 'avatar/'+photo+''" />
            </el-avatar>
          </label>
          <input :value="avatar" name="avatar" type="text" />
          <input id="file-input" type="file" @change.prevent="uploadAvatar($event)" />
        </div>
      </div>
      <div class="form-group">
        <label>{{lang["name"]}}</label>
        <el-input name="name" v-model="name"></el-input>
      </div>

      <!-- Description -->
      <div class="form-group">
        <label>{{lang["description"]}}</label>
        <el-input type="textarea" name="description" v-model="description"></el-input>
      </div>

      <label>{{lang["change-password"]}}</label>
      <el-switch class="m-4" v-model="changePassword"></el-switch>

      <div v-if="changePassword">
        <!-- Password -->
        <div class="form-group">
          <label>{{lang["new-password"]}}</label>
          <el-input
            @focus="showConfirmPassword = true"
            type="password"
            name="password"
            v-model="password"
          ></el-input>
        </div>

        <!-- Confirm password -->
        <div v-if="showConfirmPassword" class="form-group">
          <label>{{lang["confirm-password"]}}</label>
          <el-input type="password" v-model="confirmPassword"></el-input>
        </div>
      </div>

      <div class="form-group">
        <el-button native-type="submit" class="sbr-primary">{{lang["save-button"]}}</el-button>
      </div>
    </form>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import HelperProgress from "@/components/helper/HelperProgress.vue";
import AWS from "aws-sdk/global";
import S3 from "aws-sdk/clients/s3";

import { eventBus } from "@/components/profile/App";
import { eventProgress } from "@/components/helper/HelperProgress";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  components: {
    HelperProgress
  },
  mixins: [domains, alerts],
  props: ["testimonial-id"],
  data: () => {
    return {
      name: "",
      photo: "",
      userId: "",
      avatar: "",
      description: "",
      password: "",
      confirmPassword: "",
      confirmPasswordShow: "",
      showConfirmPassword: false,
      changePassword: false,
      subDomainName: ""
    };
  },
  mounted() {
    this.getSubDomainName();
    this.getProfile();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    uploadAvatar: function(event) {
      this.upload(event);
      var input = event.target;
      if (input.files && input.files[0]) {
        this.render(input);
      }
    },
    render: function(input) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var div = input.parentElement;
        var img = div.getElementsByTagName("img")[0];
        img.src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    },
    upload: function(event) {
      var file = event.target.files[0];
      var fileName = file.name;
      var fileExt = fileName.split(".").pop();
      var newFileName = this.generateFileName(40) + "." + fileExt;
      eventProgress.$emit("new-progress");

      AWS.config.update({
        accessKeyId: "AKIA5AQZS5JMAWUELDG7",
        secretAccessKey: "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",
        region: "us-east-1"
      });

      var bucket = new S3({ params: { Bucket: "sabiorealm" } });
      var params = {
        Key: "" + this.subDomainName + "/uploads/avatar/" + newFileName + "",
        ContentType: file.type,
        Body: file
      };

      bucket
        .upload(params)
        .on("httpUploadProgress", function(evt) {
          var percentCompleted = Math.round(
            parseInt((evt.loaded * 100) / evt.total)
          );
          eventProgress.$emit("new-percent", percentCompleted);
        })
        .send(
          function() {
            this.avatar = newFileName;
            eventProgress.$emit("finish-progress");
          }.bind(this)
        );
    },
    editProfile: function() {
      if (this.password != this.confirmPassword) {
        this.$message({
          message: "The passwords are different",
          type: "warning"
        });
      } else {
        var form = document.getElementById("form-profile");
        var formData = new FormData(form);
        var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
          "user",
          "editProfile"
        );
        axios.post(urlToBeUsedInTheRequest, formData).then(
          () => {
            this.successMessage();
            eventBus.$emit("profile-edited");
          },
          function() {
            this.errorMessage();
          }.bind(this)
        );
      }
    },
    getProfile: function() {
      this.loading = true;
      var formData = new FormData();
      formData.set("testimonialId", this.testimonialId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.userId = response.data["id"];
          this.photo = response.data["avatar"];
          this.avatar = response.data["avatar"];
          this.name = response.data["name"];
          this.description = response.data["description"];
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    generateFileName: function(length) {
      var today = new Date();
      var time = today.getHours() + today.getMinutes() + today.getSeconds();

      var result = "";
      var characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      var charactersLength = characters.length;
      for (var i = 0; i < length; i++) {
        result += characters.charAt(
          Math.floor(Math.random() * charactersLength)
        );
      }
      return result + time;
    },
    getSubDomainName: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "verify",
        "getSubDomainName"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.subDomainName = response.data;
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  }
};
</script>
