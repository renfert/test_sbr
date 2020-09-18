<template>
  <div class="container-site top-13">
    <div class="center m-b-40">
      <h1>{{ header }}</h1>
      <h3>{{ subheader }}</h3>
    </div>
    <div>
      <persons-list
        v-for="element in testimonialArray"
        :key="element.id"
        :testimonial-id="element.id"
      ></persons-list>
    </div>
  </div>
</template>

<script>
import PersonsList from '@/components/persons/PersonsList';
import { mapState } from 'vuex';
import { eventBus } from '@/components/site/App';

export default {
  components: {
    PersonsList
  },
  props: ['section-id'],
  data: () => {
    return {
      header: '',
      subheader: '',
      testimonialArray: []
    };
  },
  mounted() {
    this.getTestimonial();
    eventBus.$on('new-testimonial-change', () => {
      this.getTestimonial();
    });
  },
  methods: {
    getTestimonial() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'site-elements/testimonial',
        'get'
      );
      const formData = new FormData();
      formData.set('sectionId', this.sectionId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.testimonialArray = response.data;
          this.header = response.data[0].header;
          this.subheader = response.data[0].subheader;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  },
  computed: {
    ...mapState(['lang']),
    styleButtonPlain() {
      return {
        'background-color': this.buttonColor,
        display: this.banner.title == null ? 'none' : 'initial',
        '--color-hover': this.buttonColorHover,
        'border-radius': this.buttonStyle === 'plain' ? '0px' : '30px'
      };
    },
    styleHeader() {
      return {
        'background-image': 'url(' + this.image + ')'
      };
    },
    styleBannerHeader() {
      return {
        color: this.headerColor
      };
    },
    styleBannerSubHeader() {
      return {
        color: this.subHeaderColor
      };
    }
  }
};
</script>

<style lang="scss" scoped>
/* =============
  == Products page style==

    - Layout
    - Fonts
    - Mobile

============= */

/* =============
   Layout
============= */

.top-13 {
  margin-top: 13%;
}

/* =============
   Fonts
============= */
h1,
h2,
h3,
h4,
h5,
h6 {
  color: #2d3954;
  font-family: 'Poppins', sans-serif;
  word-break: break-word !important;
}

h1 {
  line-height: 34px;
  font-size: 28px;
}

h2 {
  line-height: 28px;
  font-size: 22px;
}

h3 {
  line-height: 24px;
  font-size: 18px;
}

h4 {
  line-height: 24px;
  font-size: 18px;
}

a {
  color: #4a5682;
  text-decoration: none;
  background-color: transparent;
  -webkit-text-decoration-skip: objects;
}

/* =============
   Mobile
============= */

@media only screen and (max-width: 1024px) {
  h1 {
    line-height: 24px;
    font-size: 22px;
  }

  h2 {
    line-height: 22px;
    font-size: 18px;
  }

  h3 {
    line-height: 16px;
    font-size: 14px;
  }

  h4 {
    line-height: 14px;
    font-size: 12px;
  }

  .link-button[data-v-059bd9ee] {
    font-weight: 500;
    -webkit-transition: 0.5s;
    transition: 0.5s;
    color: white;
    font-size: 1em;
    font-family: 'Poppins', sans-serif;
    border-radius: 5px;
    padding: 8px 18px 8px 18px;
  }
}
</style>
