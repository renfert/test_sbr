<template>
  <div v-loading="loading">
    <div>
      <ul class="list-group">
        <draggable
          v-model="persons"
          ghost-class="ghost"
          @end="reorderPersonsPositions()"
        >
          <transition-group type="transition" name="flip-list">
            <li
              v-for="element in persons"
              :key="element.id"
              class="list-group-item d-flex justify-content-between align-items-center sortable"
            >
              {{ element.name }}
              <div class="action-icons">
                <!-- Edit person -->
                <el-button
                  @click.prevent="
                    openEditPersonModal(
                      element.id,
                      element.name,
                      element.occupation,
                      element.comment,
                      element.photo
                    )
                  "
                  class="sbr-primary"
                  size="mini"
                  icon="el-icon-edit"
                  circle
                ></el-button>
                <!-- Delete person -->
                <el-button
                  @click.prevent="deletePerson(element.id)"
                  slot="reference"
                  class="sbr-danger"
                  size="mini"
                  icon="el-icon-delete"
                  circle
                ></el-button>
                <!-- Change position -->
                <el-button
                  icon="el-icon-rank"
                  size="mini"
                  class="handle positionPerson sbr-neutral"
                  :id="element.id"
                  circle
                ></el-button>
              </div>
            </li>
          </transition-group>
        </draggable>
      </ul>
    </div>

    <!-- Person edit -->
    <el-dialog
      :visible.sync="modal"
      append-to-body
      :title="lang['person']"
      center
      width="40%"
      top="5vh"
    >
      <form id="form-person" @submit.prevent="editPerson()">
        <!-- Person id -->
        <input type="number" v-model="person.id" name="personId" class="hide" />
        <div class="form-group">
          <div class="image-upload" style="text-align: center">
            <label for="file-input">
              <el-avatar style="cursor: pointer" :size="100">
                <img
                  :src="
                    $getUrlToContents() + 'testimonial/' + person.avatar + ''
                  "
                />
              </el-avatar>
            </label>
            <input :value="person.avatar" name="avatar" type="text" />
            <input
              id="file-input"
              type="file"
              @change.prevent="uploadAvatar($event)"
            />
          </div>
        </div>
        <div class="form-group">
          <label>{{ lang['name'] }}</label>
          <el-input name="name" v-model="person.name"></el-input>
        </div>
        <div class="form-group">
          <label>{{ lang['occupation'] }}</label>
          <el-input name="occupation" v-model="person.occupation"></el-input>
        </div>
        <div class="form-group">
          <label>{{ lang['comment'] }}</label>
          <el-input
            type="textarea"
            name="comment"
            v-model="person.comment"
          ></el-input>
        </div>
        <div class="form-group">
          <el-button native-type="submit" class="sbr-primary">{{
            lang['save-button']
          }}</el-button>
        </div>
      </form>
    </el-dialog>
    <helper-progress></helper-progress>
  </div>
</template>

<script>
import draggable from 'vuedraggable';
import $ from 'jquery';
import HelperProgress from '@/components/helper/HelperProgress.vue';
import AWS from 'aws-sdk/global';
import S3 from 'aws-sdk/clients/s3';

import { eventProgress } from '@/components/helper/HelperProgress';
import { eventBus } from '@/components/site/App';
import { mapState } from 'vuex';

export default {
  components: {
    draggable,
    HelperProgress
  },
  props: ['testimonial-id'],
  data: () => {
    return {
      person: {
        id: '',
        name: '',
        occupation: '',
        comment: '',
        avatar: ''
      },
      modal: false,
      persons: [],
      loading: false,
      subDomainName: ''
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  mounted() {
    this.getPersons();
    this.getSubDomainName();

    eventBus.$on('edit-person', () => {
      this.getPersons();
    });
  },
  methods: {
    uploadAvatar(event) {
      this.upload(event);
      const input = event.target;
      if (input.files && input.files[0]) {
        this.render(input);
      }
    },
    render(input) {
      const reader = new FileReader();
      reader.onload = (e) => {
        const div = input.parentElement;
        const img = div.getElementsByTagName('img')[0];
        img.src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    },
    upload(event) {
      const file = event.target.files[0];
      const fileName = file.name;
      const fileExt = fileName.split('.').pop();
      const newFileName = this.generateFileName(40) + '.' + fileExt;
      eventProgress.$emit('new-progress');

      AWS.config.update({
        accessKeyId: 'AKIA5AQZS5JMAWUELDG7',
        secretAccessKey: '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',
        region: 'us-east-1'
      });

      const bucket = new S3({ params: { Bucket: 'sabiorealm' } });
      const params = {
        Key:
          '' + this.subDomainName + '/uploads/testimonial/' + newFileName + '',
        ContentType: file.type,
        Body: file
      };

      bucket
        .upload(params)
        .on('httpUploadProgress', (evt) => {
          const percentCompleted = Math.round(
            parseInt((evt.loaded * 100) / evt.total)
          );
          eventProgress.$emit('new-percent', percentCompleted);
        })
        .send(() => {
          this.person.avatar = newFileName;
          eventProgress.$emit('finish-progress');
        });
    },
    deletePerson(id) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'persons',
        'delete'
      );
      formData.set('personId', id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getPersons();
          this.$successMessage();
          eventBus.$emit('edit-person');
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    generateFileName(length) {
      const today = new Date();
      const time = today.getHours() + today.getMinutes() + today.getSeconds();

      let result = '';
      const characters =
        'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      const charactersLength = characters.length;
      for (let i = 0; i < length; i++) {
        result += characters.charAt(
          Math.floor(Math.random() * charactersLength)
        );
      }
      return result + time;
    },
    getSubDomainName() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'getSubDomainName'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.subDomainName = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    openEditPersonModal(id, name, occupation, comment, photo) {
      this.person.id = id;
      this.person.name = name;
      this.person.occupation = occupation;
      this.person.comment = comment;
      this.person.avatar = photo;
      this.modal = true;
    },
    editPerson() {
      const form = document.getElementById('form-person');
      const formData = new FormData(form);
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'persons',
        'edit'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getPersons();
          this.modal = false;
          eventBus.$emit('edit-person');
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    reorderPersonsPositions() {
      const ar = [];
      $('.positionPerson').each((index, element) => {
        const id = $(element).attr('id');
        ar.push({ id: id, index: index });
      });

      const formData = new FormData();
      $.each(ar, (index, value) => {
        formData.set('persons[' + value.id + ']', value.index);
      });

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'persons',
        'reorder'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getPersons();
          eventBus.$emit('edit-person');
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getPersons() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'persons',
        'listing'
      );
      formData.set('testimonialId', this.testimonialId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.persons = response.data;
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

.lesson {
  text-align: center;
  text-transform: uppercase;
  font-size: 10px;
}

.lesson span {
  font-family: 'Poppins', sans-serif;
  margin-top: 3em;
  font-size: 1em;
}
</style>
