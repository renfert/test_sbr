<template>
  <div>
    <nav-bar></nav-bar>
    <banner
      :title="courseTitle"
      :category="category"
      :lessons="totalLessons"
      :modules="totalModules"
      :color="color"
      :reviews="reviews"
      :total-reviews="totalReviews"
      :total-rate="totalRate"
    ></banner>
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8">
            <thumb
              :instructor-photo="instructorPhoto"
              :instructor-name="instructorName"
              :reviews="reviews"
              :title="courseTitle"
              :photo="photo"
              :category="category"
              :modules-total="totalModules"
              :lessons-total="totalLessons"
              :total-reviews="totalReviews"
              :total-rate="totalRate"
            ></thumb>
            <tabs
              :description="description"
              :modules="modules"
              :color="color"
              :instructor-name="instructorName"
              :instructor-photo="instructorPhoto"
              :instructor-description="instructorDescription"
              :total-reviews="totalReviews"
              :total-rate="totalRate"
              :course-id="courseId"
              :reviews="reviews"
            ></tabs>
          </div>

          <div class="col-lg-4 col-md-4">
            <price
              :course-title="courseTitle"
              :course-id="courseId"
              :color="color"
              :price="price"
              :description="description"
              :preview="preview"
              :payment-platform="coursePaymentPlatform"
              :currency="courseCurrency"
            ></price>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- End of wrapper -->
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import NavBar from '@/components/template/TheNavBar';
import Banner from '@/components/product/Banner';
import Thumb from '@/components/product/Thumb';
import Tabs from '@/components/product/Tabs';
import Price from '@/components/product/Price';

Vue.use(VueHead);

export default {
  data: () => {
    return {
      courseId: '',
      courseTitle: '',

      coursePaymentPlatform: '',
      courseCurrency: '',
      mpCurrency: '',

      totalModules: '',
      totalLessons: '',

      modules: [],

      instructorName: '',
      instructorPhoto: '',
      instructorDescription: '',

      totalReviews: '',
      totalRate: '',

      category: '',
      description: '',
      photo: '',
      preview: '',
      reviews: '',
      color: '',
      price: ''
    };
  },
  components: {
    Banner,
    Thumb,
    Tabs,
    Price,
    NavBar
  },
  mounted() {
    this.getMpCurrency();
    const title = this.$route.params.title;
    this.courseTitle = title.split('-').join(' ');
    this.getColor();
    this.createMetaTags();
  },
  head: {
    title: {
      inner: 'Product'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  methods: {
    getMpCurrency() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.mpCurrency = response.data.currency;
        this.getCourse();
      });
    },
    getCourse() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'getCourseByTitle'
      );
      formData.set('courseTitle', this.courseTitle);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.courseId = response.data.id;
          this.courseTitle = response.data.title;
          this.category = response.data.category;
          this.description = response.data.description;
          this.photo = response.data.photo;
          this.preview = response.data.preview;
          this.price = response.data.price;
          this.reviews = response.data.reviews;
          this.coursePaymentPlatform = response.data.payment_platform;
          this.totalModules = response.data.totalModules;
          this.totalLessons = response.data.totalLessons;
          this.instructorName = response.data.instructorName;
          this.instructorPhoto = response.data.instructorAvatar;
          this.instructorDescription = response.data.instructorDescription;
          this.totalReviews = response.data.totalReviews;
          this.totalRate = response.data.totalRate;
          if (response.data.payment_platform === 'mercadopago') {
            this.courseCurrency = this.mpCurrency;
          } else {
            this.courseCurrency = response.data.currency;
          }
          this.getModules(response.data.id);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getModules(courseId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'module',
        'listing'
      );
      formData.set('courseId', courseId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.modules = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getColor() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.color = response.data.color;
      });
    },
    createMetaTags() {
      /* Title og metatag */
      const title = document.createElement('meta');
      title.setAttribute('property', 'og:title');
      title.content = this.title;
      document.getElementsByTagName('head')[0].appendChild(title);

      /* Description og metatag */
      const description = document.createElement('meta');
      description.setAttribute('property', 'og:description');
      description.content = this.description;
      document.getElementsByTagName('head')[0].appendChild(description);

      /* Image og metatag */
      const image = document.createElement('meta');
      image.setAttribute('property', 'og:image');
      image.content = this.$getUrlToContents() + 'course/' + this.photo + '';
      document.getElementsByTagName('head')[0].appendChild(image);

      /* Url og metatag */
      const url = document.createElement('meta');
      url.setAttribute('property', 'og:url');
      url.content = this.$getCurrentDomainName() + 'product' + this.courseId;
      document.getElementsByTagName('head')[0].appendChild(url);
    }
  }
};
</script>

<style scoped>
body {
  background-color: #f4f8fa;
}

html {
  background-color: #f4f8fa;
}

section {
  padding: 80px 0;
  position: relative;
}

.main ol {
  padding-left: 70px;
}

.main h1.course-title {
  padding: 30px 0px 10px 70px;
}

.course-card {
  margin: 0px 80px 30px 70px;
}
</style>
