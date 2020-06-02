<template>
    <div class="main"  v-loading="loading">
        <lang></lang>
        <div>
            <ul class="list-group">
                <draggable v-model="socialMedias" ghost-class="ghost"> 
                    <transition-group type="transition" name="flip-list">
                        <li v-for="element in socialMedias" :key="element.id" class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-eadtools">{{element.name}}</span>
                            <div class="action-icons">
                                <i @click.prevent="openEditSocialMediaModal(element.id,element.name,element.url)" class="el-icon-edit text-primary links"></i>
                                <i @click.prevent="deleteSocialMedia(element.id)" class="el-icon-delete text-danger links"></i>
                            </div>
                        </li>
                    </transition-group>
                </draggable>     
            </ul>      
        </div> <!-- End accordion -->

        <!--  Modal edit social media -->
        <div>
            <el-dialog  :visible.sync="modal" :title="lang['edit']" center width="40%" top="5vh">
                <form id="form-social" @submit.prevent="editSocialMedia()">
                    <input class="hide" type="number" name="socialMediaId" v-model="socialMediaId">
                    <div class="form-group">
                        <label>{{lang["social-media"]}}</label>
                        <div class="block">
                            <select class="form-select" name="socialMedia" v-model="name">
                                <option value="facebook">Facebook</option>
                                <option value="instagram">Instagram</option>
                                <option value="linkedin">Linkedin</option>
                                <option value="twitter">Twitter</option>
                                <option value="pinterest">Pinterest</option>
                                <option value="youtube">Youtube</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{lang["url"]}}</label>
                        <el-input  name="url" v-model="url"></el-input>
                        </div>
                        <div class="form-group">
                        <el-button native-type="submit"  type="primary"  size="medium">{{lang["save-button"]}}</el-button>
                    </div>
                </form>  
            </el-dialog>
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
import Lang from '@/components/helper/HelperLang.vue'
import draggable from 'vuedraggable'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import {eventLang} from '@/components/helper/HelperLang'
import {eventBus} from '@/pages/site/App'
import domains from '@/mixins/domains'
import alerts from '@/mixins/alerts'

locale.use(lang)
Vue.use(VueTheMask)
Vue.use(VueTheMask)
Vue.use(VueAxios, axios)
Vue.use(ElementUI)


export default {
    mixins: [domains,alerts],
    components: {
        draggable,
        Lang, 
    },
    data: () => {
        return {
            lang: {},
            socialMedias: null,
            socialMediaId: '',
            name: '',
            url : '',
            modal: false,
            loading: false
        }
    },
    mounted(){
        eventLang.$on('lang', function(response){  
            this.lang = response;
        }.bind(this));

        eventBus.$on('social-media-list-update', function(){
            this.updateSocialMediaListArray();
        }.bind(this));
        this.updateSocialMediaListArray();
    },
    methods: {
        editSocialMedia: function(){
            var form = document.getElementById('form-social')
            var formData = new FormData(form)
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("social", "edit");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                this.successMessage();
                this.actionsToBePerformedAfterEdit();
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
        openEditSocialMediaModal: function(id,name,url){
            this.socialMediaId = id;
            this.name = name;
            this.url = url;
            this.modal = true; 
        },
        deleteSocialMedia: function(id){
            var formData = new FormData();
            formData.set('socialMediaId', id);
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("social", "delete");
            axios.post(urlToBeUsedInTheRequest, formData).then(() => {
                eventBus.$emit("new-change-footer");
                this.updateSocialMediaListArray();  
                this.successMessage();
            }, 
                function(){
                    this.errorMessage();
                }.bind(this)
            );
        },
    
        updateSocialMediaListArray: function (){
            this.loading = true;
            var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("social", "listing");
            axios.post(urlToBeUsedInTheRequest).then((response) => {
                this.socialMedias = response.data;
                this.loading= false;
            },
                /* Error callback */
                function (){
                   this.errorMessage();
                }.bind(this)
            );
        },
        actionsToBePerformedAfterEdit(){
            eventBus.$emit("new-change-footer");
            this.updateSocialMediaListArray();
            this.modal = false; 
        }
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


</style>
