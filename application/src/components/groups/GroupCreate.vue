<template>
    <div class="col-12">
        <div class="card-box">
            <h4>{{lang["create-group"]}}</h4>
            <br>
            <form @submit.prevent="createGroup()" id="form-group">
                <div class="row">

                    <div class="col-xl-4 col-md-4">
                        <!-- Group name -->
                        <div class="form-group">
                            <el-input required name="name" :placeholder="lang['name']" v-model="groupName"></el-input>
                        </div>
                    </div>

                    <div  class="col-xl-4 col-md-4">
                        <!-- Save button -->
                        <div class="form-group">
                            <el-button 
                                v-loading="loadingButton" 
                                class="btn-sabiorealm" 
                                native-type="submit" 
                                type="primary
                                ">
                                {{lang["save-button"]}}
                            </el-button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios' 
import VueAxios from 'vue-axios'
import VueTheMask from 'vue-the-mask'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import {eventBus} from '@/pages/groups/App'
import {eventLang} from '@/components/helper/HelperLang'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'
Vue.use(ElementUI)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
export default {
    mixins: [domains,alerts],
    data: function() {
        return {
            groupName: '',
            lang: {},
            loadingButton: false
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){
            this.lang = response;
        }.bind(this));
    },
    methods: {
        createGroup: function(){
            this.loadingButton = true;
            var form = document.getElementById('form-group');
            var formData = new FormData(form);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "create")
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                /* Success callback */
                if(response.data == false){ 
                    this.groupAlreadyExistsMessage();
                }else{
                    this.successMessage();
                    this.actionsToBePerformedAfterRegistration();
                }
            }, 
                /* Error callback */
                function(){
                    this.errorMessage();
                }.bind(this)
            );
    },
    groupAlreadyExistsMessage(){
        this.$notify({
            title: this.lang['error'],
            message: this.lang["group-already-exists"],
            type: 'warning',
            duration: 3500
        });
    },
    actionsToBePerformedAfterRegistration(){
        this.loadingButton = false;
        this.groupName = ''; 
        eventBus.$emit('new-group'); 
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
  .ead-md{margin-left: 0.8em;}
</style>
