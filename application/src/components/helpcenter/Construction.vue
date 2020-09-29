<template>
  <div class="center construction">
    <!--
    <div>
      <el-row class="flex" :gutter="120">
        <el-col :sm="2" :xs="8">
          <img class="sabio" src="@/assets/gifs/sabio.gif" alt="" />
        </el-col>
        <el-col :sm="20" :xs="16">
          <div class="message-wrapper them">
            <div class="text-wrapper animated fadeIn">
              <div class="dots m-t-10">
                <span></span>
                <span></span>
                <span></span>
              </div>
            </div>
          </div>
        </el-col>
      </el-row>
    </div>
    <img
      class="not-found-image"
      src="@/assets/img/general/ux/construction.svg"
      alt=""
    />
    <h3 class="m-t-40 fw-700">{{ lang['under-construction-title'] }}</h3>
    <p>{{ lang['under-construction-subtitle'] }}</p>
    -->
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  computed: {
    ...mapState(['lang'])
  }
};
</script>

<style scoped>
.construction {
  padding: 0% 10%;
}
.dots span {
  width: 10px;
  height: 10px;
  margin: 0 5px;
  background-color: #9b9b90;
  border-radius: 50%;
  display: inline-block;
  animation-name: dots;
  animation-duration: 2s;
  animation-iteration-count: infinite;
  animation-timing-function: ease-in-out;
}

.dots span:nth-child(2) {
  background-color: #3f4240;
  animation-delay: 0.4s;
}

.dots span:nth-child(3) {
  background-color: #9b9b90;
  animation-delay: 0.8s;
}

@keyframes dots {
  50% {
    opacity: 0;
    transform: scale(0.7) translate(10px);
  }
}

.message-wrapper {
  position: relative;
  overflow: hidden;
  width: 100%;
  margin: 10.66667px 0;
  padding: 10.66667px 0;
  transition: all 0.2s ease-in-out 0s !important;
  cursor: pointer;
}

.message-wrapper:hover {
  transform: translateY(5px);
}

.message-wrapper.them .text-wrapper {
  background: white;
  float: left;
  color: #ffffff;
}

.message-wrapper .circle-wrapper {
  height: 42.66667px;
  width: 42.66667px;
  border-radius: 50%;
}

.message-wrapper .text-wrapper {
  padding: 10.66667px;
  min-height: 42.66667px;
  width: 30%;
  margin: 0 10.66667px;
  box-shadow: 5px 1px 12px 0px rgba(50, 50, 50, 0.3);
  border-radius: 10px;
  font-weight: 300;
  position: relative;
}

.message-wrapper.them .text-wrapper:before {
  border-width: 0px 20px 30px 0;
  border-color: transparent white transparent transparent;
  position: absolute;
  top: 0;
  left: -6px;
}

.message-wrapper .text-wrapper:before {
  content: '';
  width: 0;
  height: 0;
  border-style: solid;
}

.sabio {
  width: 150px;
  cursor: pointer;
}
</style>
