<template>
  <div class="col-12">
    <div class="card-sabiorealm text-center">
      <h3>{{ lang['purchase-in-process'] }}</h3>

      <p>{{ lang['doubts'] }} {{ email }}</p>
    </div>

    <div class="app-background-accent"></div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  data: () => {
    return {
      courseTitle: '',
      courseImage: '',
      email: ''
    };
  },

  mounted() {
    this.getCompanyInformation();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getCompanyInformation() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'company',
        'getCompanyInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.email = response.data.email;
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
.course-title {
  color: #9e9c9c;
}

.item-name h3 {
  color: #9e9c9c;
  font-size: 1.2em;
}

.card-sabiorealm {
  width: 50%;
  animation: fadeIn 0.5s ease-in;
  background-color: white;
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 10px, rgba(0, 0, 0, 0.23) 0px 3px 10px;
  padding: 20px;
  transform: translateX(-50%) translateY(-50%);
  z-index: 10;
  position: absolute;
  left: 50%;
  margin-top: 18%;
}

@media only screen and (max-width: 600px) {
  .card-sabiorealm {
    width: 80%;
    animation: fadeIn 0.5s ease-in;
    background-color: white;
    border-radius: 10px;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 10px,
      rgba(0, 0, 0, 0.23) 0px 3px 10px;
    padding: 20px;
    transform: translateX(-50%) translateY(-50%);
    z-index: 10;
    position: absolute;
    left: 50%;
    margin-top: 70%;
  }
}
</style>
