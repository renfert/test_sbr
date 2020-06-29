<template>
    <div id="loading"></div>
</template>

<script>
import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI)
export default {
    mounted(){
        this.onReady(function() {
            this.setVisible('#loading', false);
        }.bind(this));
    },
    methods: {
        onReady: function(callback){
            var intervalId = window.setInterval(function() {
                if (document.getElementsByTagName('body')[0] !== undefined) {
                window.clearInterval(intervalId);
                callback.call(this);
                }
            }, 1000);
        },
        setVisible: function(selector, visible){
            document.querySelector(selector).style.display = visible ? 'block' : 'none';
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.page{ display: none; padding: 0 0.5em; }
.page h1 { font-size: 2em; line-height: 1em; margin-top: 1.1em; font-weight: bold; }
.page p  { font-size: 1.5em; line-height: 1.275em; margin-top: 0.15em; }

#loading {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 100;
    width: 100vw;
    height: 100vh;
    background-color: white;
    background-image: url("https://sbrfiles.s3.amazonaws.com/gifs/loader.gif");
    background-repeat: no-repeat;
    background-position: center;
}
</style>
