<template>
  <div v-loading="loading">
    <div>
      <ul class="list-group">
        <draggable
          v-model="links"
          ghost-class="ghost"
          @end="reorderLinkPositions()"
        >
          <transition-group type="transition" name="flip-list">
            <li
              v-for="element in links"
              :key="element.id"
              class="list-group-item d-flex justify-content-between align-items-center"
            >
              <span class="text-eadtools">{{ element.title }}</span>
              <div class="action-icons">
                <i
                  @click.prevent="
                    openEditLinkModal(
                      element.id,
                      element.title,
                      element.url,
                      element.target
                    )
                  "
                  class="el-icon-edit text-primary links"
                ></i>
                <i
                  @click.prevent="deleteLink(element.id)"
                  class="el-icon-delete text-danger links"
                ></i>
                <i
                  class="el-icon-rank handle linkPosition"
                  :id="element.id"
                ></i>
              </div>
            </li>
          </transition-group>
        </draggable>
      </ul>
    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable';
import $ from 'jquery';

import { eventBus } from '@/components/site/App';
import { mapState } from 'vuex';

export default {
  components: {
    draggable
  },
  data: () => {
    return {
      links: [],
      loading: false
    };
  },
  mounted() {
    this.getLinks();
    eventBus.$on('link-list-update', () => {
      this.getLinks();
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    openEditLinkModal(id, title, url, target) {
      const data = {
        id: id,
        title: title,
        url: url,
        target: target
      };
      eventBus.$emit('edit-link', data);
    },
    deleteLink(id) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'link',
        'delete'
      );
      formData.set('linkId', id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getLinks();
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    reorderLinkPositions() {
      const ar = [];
      $('.linkPosition').each((index, element) => {
        const id = $(element).attr('id');
        ar.push({ id: id, index: index });
      });

      const formData = new FormData();
      $.each(ar, (index, value) => {
        formData.set('links[' + value.id + ']', value.index);
      });

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'link',
        'reorder'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getLinks();
          eventBus.$emit('link-list-update');
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getLinks() {
      this.loading = true;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'link',
        'listing'
      );
      this.$request.post(urlToBeUsedInTheRequest).then(
        (response) => {
          this.links = response.data;
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

.ghost {
  border-left: 6px solid rgb(0, 183, 255);
  border-radius: 5px;
  opacity: 0.5;
}

.handle {
  cursor: move;
}
</style>
