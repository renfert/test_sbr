<template>
  <div class="main" v-loading="loading">
    <div>
      <ul class="list-group">
        <draggable v-model="socialMedias" ghost-class="ghost">
          <transition-group type="transition" name="flip-list">
            <li
              v-for="element in socialMedias"
              :key="element.id"
              class="list-group-item d-flex justify-content-between align-items-center"
            >
              <span class="text-eadtools">{{ element.name }}</span>
              <div class="action-icons">
                <i
                  @click.prevent="
                    openEditSocialMediaModal(
                      element.id,
                      element.name,
                      element.url
                    )
                  "
                  class="el-icon-edit text-primary links"
                ></i>
                <i
                  @click.prevent="deleteSocialMedia(element.id)"
                  class="el-icon-delete text-danger links"
                ></i>
              </div>
            </li>
          </transition-group>
        </draggable>
      </ul>
    </div>
    <!-- End accordion -->
  </div>
</template>

<script>
import draggable from 'vuedraggable';

import { eventBus } from '@/components/site/App';
import { mapState } from 'vuex';

export default {
  components: {
    draggable
  },
  data: () => {
    return {
      socialMedias: null,
      loading: false
    };
  },
  mounted() {
    this.updateSocialMediaListArray();

    eventBus.$on('social-media-list-update', () => {
      this.updateSocialMediaListArray();
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    openEditSocialMediaModal(id, name, url) {
      const data = {
        id: id,
        name: name,
        url: url
      };
      eventBus.$emit('edit-social-media', data);
    },
    deleteSocialMedia(id) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'social',
        'delete'
      );
      formData.set('socialMediaId', id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          eventBus.$emit('new-change-footer');
          this.updateSocialMediaListArray();
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },

    updateSocialMediaListArray() {
      this.loading = true;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'social',
        'listing'
      );
      this.$request.post(urlToBeUsedInTheRequest).then(
        (response) => {
          this.socialMedias = response.data;
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
</style>
