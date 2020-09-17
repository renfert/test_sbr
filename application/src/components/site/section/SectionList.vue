<template>
  <div>
    <ul class="list-group">
      <draggable
        v-model="sections"
        ghost-class="ghost"
        @end="reorderSectionPositions()"
      >
        <transition-group type="transition" name="flip-list">
          <li
            v-for="element in sections"
            :key="element.id"
            class="list-group-item sortable"
          >
            <!-- Banner -->
            <span class="sbr-text-primary" v-if="element.banner_id != 1"
              >Banner</span
            >
            <!-- Product list -->
            <span class="sbr-text-primary" v-if="element.product_list_id != 1"
              >Product list</span
            >
            <!-- Testimonial list -->
            <span class="sbr-text-primary" v-if="element.testimonial_id != 1"
              >Testimonial</span
            >
            <!-- Text and media list -->
            <span class="sbr-text-primary" v-if="element.text_and_media_id != 1"
              >Text and media</span
            >

            <div class="action-icons">
              <!-- Edit banner -->
              <i
                v-if="element.banner_id != 1"
                @click.prevent="openEditSectionModal(element.id, 'banner')"
                class="el-icon-edit sbr-text-primary links"
              ></i>

              <!-- Edit product list -->
              <i
                v-if="element.product_list_id != 1"
                @click.prevent="
                  openEditSectionModal(element.id, 'product-list')
                "
                class="el-icon-edit sbr-text-primary links"
              ></i>

              <!-- Edit testimonial -->
              <i
                v-if="element.testimonial_id != 1"
                @click.prevent="openEditSectionModal(element.id, 'testimonial')"
                class="el-icon-edit sbr-text-primary links"
              ></i>

              <!-- Edit text and media list -->
              <i
                v-if="element.text_and_media_id != 1"
                @click.prevent="
                  openEditSectionModal(element.id, 'text-and-media')
                "
                class="el-icon-edit sbr-text-primary links"
              ></i>

              <!-- Delete section -->
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                placement="right"
                :title="lang['question-delete-section']"
                @onConfirm="deleteSection(element.id)"
              >
                <i
                  slot="reference"
                  class="el-icon-delete text-danger links"
                ></i>
              </el-popconfirm>
              <i
                class="el-icon-rank handle sectionPosition"
                :id="element.id"
              ></i>
            </div>
          </li>
        </transition-group>
      </draggable>
    </ul>
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
      sections: null,
      modal: false
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  created() {
    this.getSections();

    eventBus.$on('new-section', () => {
      this.getSections();
    });
  },
  methods: {
    openEditSectionModal(sectionId, sectionType) {
      eventBus.$emit('edit-' + sectionType + '', sectionId);
    },
    deleteSection(id) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'section',
        'delete'
      );
      formData.set('sectionId', id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getSections();
          eventBus.$emit('delete-section');
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    reorderSectionPositions() {
      const ar = [];

      $('.sectionPosition').each((index, element) => {
        const id = $(element).attr('id');
        ar.push({ id: id, index: index });
      });

      const formData = new FormData();
      $.each(ar, (index, value) => {
        formData.set('sections[' + value.id + ']', value.index);
      });

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'section',
        'reorder'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getSections();
          eventBus.$emit('reorder-section');
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getSections() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'section',
        'listing'
      );
      this.$request.post(urlToBeUsedInTheRequest).then(
        (response) => {
          this.sections = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
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

.card-header {
  padding: 10px !important;
}

.sortable-drag {
  opacity: 0;
}

.flip-list-move {
  transition: transform 0.5s;
}

.ghost {
  border-left: 6px solid #009cd8;
  border-radius: 5px;
  opacity: 0.5;
}

.handle {
  cursor: move;
}
</style>
