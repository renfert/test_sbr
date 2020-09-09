<template>
  <div v-loading="loading">
    <el-carousel :interval="4000" type="card" height="350px">
      <el-carousel-item v-for="element in persons" :key="element.id">
        <div class="testimonial-persons">
          <el-avatar :size="80">
            <img
              :src="$getUrlToContents() + 'testimonial/' + element.photo + ''"
            />
          </el-avatar>
          <h3>{{ element.name }}</h3>
          <h4>{{ element.occupation }}</h4>
          <hr style="width: 50%" />
          <p>"{{ element.comment }}"</p>
        </div>
      </el-carousel-item>
    </el-carousel>
  </div>
</template>

<script>
import { eventBus } from '@/components/site/App.vue';
import { mapState } from 'vuex';

export default {
  props: ['testimonial-id'],
  data: () => {
    return {
      persons: [],
      loading: false
    };
  },
  mounted() {
    eventBus.$on('edit-person', () => {
      this.getPersons();
    });

    this.getPersons();
    this.getPrimaryColor();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getPrimaryColor() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          const style = document.createElement('style');
          style.type = 'text/css';
          style.innerHTML =
            '.el-carousel__arrow{background-color:' +
            response.data.color +
            ' !important;}';
          document.getElementsByTagName('head')[0].appendChild(style);
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
.testimonial-persons {
  text-align: center;
  padding: 10%;
}

.testimonial-persons h3 {
  font-size: 15px;
  line-height: 1;
}

.testimonial-persons h4 {
  font-size: 11px;
}

.el-carousel__item:nth-child(2n) {
  background-color: white;
  border-radius: 15px;
}

.el-carousel__item:nth-child(2n + 1) {
  background-color: white;
  border-radius: 15px;
}

.el-carousel__item.is-active.el-carousel__item--card.is-in-stage {
  box-shadow: 10px 10px 33px -10px #aca9a9;
  border-radius: 15px;
}
</style>
