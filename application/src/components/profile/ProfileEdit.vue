<template>
    <div class="col-6 p-3"  v-loading="loading">
        <lang></lang> 
        <div class="card-box text-center">
            <!-- Profile edit -->
            <form id="form-profile" @submit.prevent="editProfile()">
                <!-- Person id -->
                <input type="number" v-model="userId" name="userId" class="hide">
                <div class="form-group">
                    <div class="image-upload" style="text-align:center;">
                        <label for="file-input">
                            <el-avatar style="cursor:pointer" :size="100">
                                <img :src="''+getCurrentDomainName()+'assets/uploads/avatar/' + photo" />
                            </el-avatar>
                        </label>
                        <input :value="avatar" name="avatar" type="text">
                        <input id="file-input" type="file"  @change.prevent="uploadAvatar($event)"/>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{lang["name"]}}</label>
                    <el-input  name="name" v-model="name"></el-input>
                </div>
            
                <!-- Description -->
                <div class="form-group">
                    <label>{{lang["description"]}}</label>
                    <el-input type="textarea" name="description" v-model="description"></el-input>
                </div>
                
                <label>{{lang["change-password"]}}</label>
                <el-switch class="m-4" v-model="changePassword"></el-switch>

                <div v-if="changePassword">
                    <!-- Password -->
                    <div class="form-group">
                        <label>{{lang["new-password"]}}</label>
                        <el-input @focus="showConfirmPassword = true" type="password" name="password" v-model="password"></el-input>
                    </div>
                    

                    <!-- Confirm password -->
                    <div v-if="showConfirmPassword" class="form-group">
                        <label>{{lang["confirm-password"]}}</label>
                        <el-input type="password" v-model="confirmPassword" ></el-input>
                    </div>
                </div>

               
                <div class="form-group">
                    <el-button native-type="submit"  type="primary"  size="medium">{{lang["save-button"]}}</el-button>
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
import Lang from '@/components/helper/HelperLang.vue'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/profile/App'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'

locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    components: {
        Lang,
    },
    mixins: [domains,alerts],
    props:["testimonial-id"],
    data: () => {
        return {
            lang: {},
            loading: false,
            name: '',
            photo: '',
            userId: '',
            avatar: '',
            description: '',
            password: '',
            confirmPassword: '',
            confirmPasswordShow: '',
            showConfirmPassword: false,
            changePassword: false
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        this.getProfile();

    },
    methods: {
        uploadAvatar: function(event){
            this.upload(event);
            var input = event.target; 
            if(input.files && input.files[0]){ 
                this.render(input)
            }
        },
        render: function(input){
            var reader = new FileReader();
            reader.onload = function (e) {
                var div = input.parentElement; 
                var img = div.getElementsByTagName('img')[0];
                img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        },
        upload: function(event){
            var data = new FormData()
            data.append('file', event.target.files[0])
            data.append('type', "profile-avatar")
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("upload", "upload_file");
            axios.post(urlToBeUsedInTheRequest,data).then((response) => {
                this.avatar = response.data;
                event.target.value = null
            }, () => {
                /* Error callback */
                this.errorMessage();
            })
        },
        editProfile: function(){
            if(this.password != this.confirmPassword){
                this.$message({
                    message: 'The passwords are different',
                    type: 'warning'
                });
            }else{
                var form = document.getElementById('form-profile')
                var formData = new FormData(form)
                var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "editProfile");
                axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                    this.successMessage();
                    eventBus.$emit("profile-edited");
                }, 
                    function(){
                        this.errorMessage();
                    }.bind(this)
                );
            }
        },
        getProfile: function (){
            this.loading = true;
            var formData = new FormData();
            formData.set("testimonialId",this.testimonialId);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "getUserProfile");
            axios.post(urlToBeUsedInTheRequest, formData).then((response) => {
                this.userId = response.data["id"];
                this.photo = response.data["avatar"];
                this.avatar = response.data["avatar"];
                this.name = response.data["name"];
                this.description = response.data["description"];
                this.loading = false;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

.action-icons{
    float:right;
    margin-left:0%;
}

.links{
    cursor: pointer;
}

.custom-control-label {
    padding-top: 4px !important;
}

#accordion > .card{
    margin-bottom:2%;
}

.btn-link{
    padding: 0px !important;
    font-size:13px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
}


.btn.link:hover{
    text-decoration: none !important;
}

.card-header{
    padding:10px !important;
}

.btn-eadtools-rounded{
    border-radius: 50%;
    cursor: pointer;
    display: inline-block;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
    position: relative;
    height: 40px;
    width: 40px;
    background-color: #D696EF;
    z-index: 2;
    border:none;
    color:white;
    margin: 0 0.2rem;
}


.sortable-drag{
    opacity: 0;
}

.flip-list-move{
    transition: transform 0.5s;
}

.ghost{
    border-left:6px solid rgb(0, 183, 255);
    border-radius:5px;
    opacity: .5;
}


.card{
    margin-bottom: 15px;
}



.handle{
    cursor:move;
}


li{
    list-style-type: none;
}

.lesson{
    text-align:center;
    text-transform: uppercase;
    font-size:10px;
}

.lesson span{
    font-family: 'Poppins', sans-serif;
    margin-top:3em;
    font-size:1em;
}

</style>
