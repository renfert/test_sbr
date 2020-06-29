<template>
 <div>
    <div class="max-w-screen-x2 m-0 sm:m-0 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <div class="lg:w-1/2 xl:w-6/12 p-6 sm:p-12">
            <div>
                <a href="https://sabiorealm.com">
                <img
                    src="@/assets/img/logo.png"
                    class="w-32 mx-auto"
                />
                </a>
            </div>
            <div class="mt-12 flex flex-col items-center">

                <h1 class="text-2xl xl:text-3xl font-extrabold" style="color:#a0aec0 !important;">
                   Crie sua escola
                </h1>
                <div v-if="invalidName"  class="bg-red-100 border-t-4 border-red-400 rounded-b text-red-900 px-4 py-3 shadow-md" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                        <p class="font-bold">Esta escola já existe</p>
                        <p class="text-sm">Por favor escolha outro nome.</p>
                        </div>
                    </div>
                </div>
               
                <i v-if="secondStep" @click.prevent="back" class="fa fa-arrow-left mt-5" style="color:#a0aec0;cursor:pointer;"></i>

                <div class="w-full flex-1">
                    <div class="my-12 border-b text-center">
                        <div class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                        Preencha o formulário para continuar

                        </div>
                    </div>

                    <form id="form-trial" @submit.prevent="accessSecondStep">
                        <div class="first_step"  :class="firstStep == true? '':'hidden-step'">
                            <!-- Name and Phone-->
                            <div class="row">
                                <div class="col-6">
                                    <input
                                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white input-field"
                                        type="text"
                                        placeholder="Nome"
                                        required
                                        name="name"
                                        v-model="name"
                                    />
                                </div>

                                <div class="col-6">
                                    <input
                                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white input-field"
                                        type="text"
                                        placeholder="Telefone"
                                        required
                                        name="phone"
                                         v-model="phone"
                                    />
                                </div>
                            </div>

                            <!-- Login and password -->
                            <div class="row">
                                <div class="col-6">
                                    <input
                                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white input-field"
                                        type="email"
                                        placeholder="Email"
                                        required
                                        name="email"
                                         v-model="email"
                                    />
                                </div>

                                <div class="col-6">
                                    <div class="input-icons">
                                        <i @click="changeInputType" v-if="inputPassword == 'text'" class="fa fa-eye icon"></i>
                                        
                                        <i @click="changeInputType" v-else class="fa fa-eye-slash icon"></i>

                                        <input
                                            class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white input-field"
                                            :type="inputPassword"
                                            placeholder="Senha"
                                            name="password"
                                            required
                                             v-model="password"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <input
                                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white input-field"
                                        :class="invalidName == true ? 'border-red-400' : ''"
                                        type="text"
                                        placeholder="Nome da sua escola"
                                        name="subDomainName"
                                        required
                                        v-model="subDomainName"
                                    />
                                </div>
                                <div class="col-6">
                                    <div style="padding:13px;display:flex;justify-content: center;">
                                        <span style="color:#a0aec0;" class="text-sm font-medium">.sabiorealm.com</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mx-auto max-w-xs">
                            
                                <button
                                    class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
                                    :class="loadingBtn == true ? 'disable': ''"
                                >
                                    <span class="ml-3">
                                        Continuar
                                    </span>
                                </button>
                                <img  :class="loadingBtn == true? '' : 'hide'" class="loader-btn" src="@/assets/img/loader.gif" alt="">
                            </div>
                        </div>

                        <div class="second_step" v-if="secondStep">
                            <div class="row">
                                <div class="col-12">
                                    <span class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">Selecione uma etapa</span>
                                    <select
                                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white input-field"
                                        type="text"
                                        required
                                        name="step"
                                    >
                                        <option>Trabalho com curso e/ou capacitações de maneira presencial.</option>
                                        <option>Vou iniciar meu projeto de cursos e/ou capacitação online.</option>
                                        <option>Estou desenvolvendo meu projeto de cursos e/ou capacitação online.</option>
                                        <option>Já trabalho com cursos e/ou capacitações online.</option>
                                        <option>Ainda não trabalho com nenhum projeto de educação.</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <span class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">Selecione uma meta</span>
                                    <select
                                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white input-field"
                                        type="text"
                                        placeholder="Su nombre"
                                        required
                                        name="goal"
                                    >
                                        <option>Quero criar e vender cursos por internet.</option>
                                        <option>Quero realizar capacitações online para os colaboradores de minha empresa.</option>
                                        <option>Quero criar cursos para uma instituição educativa</option>
                                        <option>Quero realizar consultorias e/ou capacitações online para meus clientes.</option>
                                        <option>Quero expandir meu negócio através de Inbound Marketing.</option>
                                        <option>Não tenho nehum objetivo definido ainda.</option>
                                    </select>
                                </div>
                            </div>

                             <div class="mx-auto max-w-xs">
                            
                                <button
                                    class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
                                    :class="loadingBtn == true ? 'disable': ''"
                                    @click.prevent="createTrial"
                                >
                                    <span class="ml-3">
                                        Criar escola
                                    </span>
                                </button>
                                <img  :class="loadingBtn == true? '' : 'hide'" class="loader-btn" src="@/assets/img/loader.gif" alt="">
                                    
                                <p class="mt-6 text-xs text-gray-600 text-center">
                                    Li e aceito os
                                    <a href="#" class="border-b border-gray-500 border-dotted">
                                    Términos e condições de uso
                                    </a>
                                </p>
                            </div>

                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-indigo-100 text-center hidden lg:flex">
            <div
                v-if="mainImg == true"
                class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                style="background-image: url('https://sabiorealm.com/mailmarketing/home_trial.svg');"
            >       
            </div>

            <div
                v-if="errorImg == true"
                class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                style="background-image: url('https://sabiorealm.com/mailmarketing/error.svg');"
            >       
            <h1 class="text-2xl xl:text-1xl font-extrabold" style="color:#a0aec0 !important;text-align:center;">
                Algo saiu mal!
            </h1>
            <h3 class="font-extrabold" style="color:#a0aec0 !important;text-align:center;">
                Por favor entrar em contato com: 
                <a href="mailto:contact@sabiorealm.com">contact@sabiorealm.com</a>
                </h3>
            </div>

            <div v-if="loadingSvg == true" class="col-12" style="margin-top:10%;">
                <div class="text-content" style="padding:10px 50px 0px 50px">
                    <h1 class="text-2xl xl:text-1xl font-extrabold" style="color:#a0aec0 !important;text-align:center;">
                    Estamos criando sua escola, um momento ...
                    </h1>
                    <h3 class="font-extrabold" style="color:#a0aec0 !important;text-align:center;">
                        Enquanto issso a hade te vai fazer companhia
                    </h3>
                </div>
                <dog></dog>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Dog from '@/components/Dog'
import md5 from 'md5'

Vue.use(VueAxios, axios)
export default {
    components: {
        Dog
    },
    data () {
        return {
            inputPassword: 'password',
            firstStep: true,
            secondStep: false,
            schoolCreated: false,
            loadingBtn: false,
            loadingSvg: false,
            mainImg: true,
            errorImg: false,
            name: '',
            email: '',
            password: '',
            phone: '',
            subDomainName: '',
            invalidName: false,
        }
    },
    methods: {
        changeInputType: function(){
            this.inputPassword == "password" ? this.inputPassword = "text" : this.inputPassword = "password";
        },
        accessSecondStep: function(){
            this.loadingBtn = true;
            var form = document.getElementById("form-trial");
            var formData = new FormData(form);
            axios.post("http://localhost/trial/trial/verifySubdomainAvaiable", formData).then((response) => {
                // success callback
                if(response.data == true){
                    this.secondStep = true;
                    this.firstStep = false;
                    this.invalidName = false;
                }else{
                    this.invalidName = true;
                }
                this.loadingBtn = false;
            });
        },
        createTrial: function(){
            var data = {
                "token" : this.createToken(10),
                "user_id": 1
            }

            const token = md5(JSON.stringify(data));
            this.loadingBtn = true;
            this.loadingSvg = true;
            this.mainImg = false;
            var form = document.getElementById("form-trial");
            var formData = new FormData(form);
            formData.set("token", token);
            axios.post("http://localhost/trial/trial/createTrial", formData).then((response) => {
                if(response.data != true){
                    this.loadingSvg = false;
                    this.errorImg = true;
                }else{ 
                    const subDomain = this.subDomainName;
                    setTimeout(function(){ 
                        this.loadingBtn = false;
                        window.location.href = "https://"+subDomain+".sabiorealm.com/"; 
                    }, 30000);
                }
            })
        },

        createToken: function(length){
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        },

        back: function(){
            this.firstStep = true;
            this.secondStep = false;
        }
    },
    watch: {
        subDomainName(newVal) {
            let re = /[^A-Z0-9]/gi;
            this.$set(this, 'subDomainName', newVal.replace(re, ''));
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}

.col-6 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
    padding:0px 10px 10px 10px;
}

.col-12 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
    padding:0px 10px 10px 10px;
}


.row{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}

.input-icons i { 
    position: absolute; 
} 
          
.input-icons { 
    width: 100%; 
    margin-bottom: 10px; 
} 
    
.icon { 
    padding: 12px; 
    color: #a0aec0; 
    min-width: 50px; 
    text-align: center; 
    cursor: pointer;
} 
    
.input-field { 
    width: 100%; 
    padding: 10px; 
    text-align: center; 
} 

.loader-btn{
    width:50px;
    position:relative;
    margin-top:-17%;
    margin-left:40%;
}

.disable{
    opacity: 0.2;
    cursor: initial;
}

.hide{
    visibility: hidden;
}

.hidden-step{
    display: none;
}
</style>
