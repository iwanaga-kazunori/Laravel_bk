/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');
import Vue from 'vue';

import axios from 'axios';

import VModal from 'vue-js-modal';
Vue.use(VModal);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('matches-component', require('./components/MatchesComponent.vue').default);
// Vue.component('hooper-component', require('./components/HooperComponent.vue').default);
// Vue.component('modal-component', require('./components/ModalComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data() {
        return {
            // matches: null
        }
    },
    mounted () {
        // this.getMatches()
    },
    methods: {
        getMatches () {
            axios.get('/api/matches')
            .then (function (response){
                console.log(response)
                this.matches = response.body
            })
            .catch (function (error){
                console.log(error)
            })
        },

    },
  //       el: '#app',
  //     methods: {
  //       show : function() {
  //         this.$modal.show('hello-world');
  //       },
  //       hide : function () {
  //         this.$modal.hide('hello-world');
  //       },
  // },


//     el: '#app2',
// 　　data: {
// 　　　　modalVisible: false, // モーダル
// 　　　　modalBgVisible: false //モーダル背景色（薄黒）
// 　　},
// 　　methods: {
// 　　　　showModal: function(){
// 　　　　　　this.modalVisible = true
// 　　　　　　this.modalBgVisible = true
//     },
//     closeModal: function(){
//       this.modalVisible = false
//       this.modalBgVisible = false
//     },
//     cancelEvent: function(){
//      event.stopPropagation()
//     }
//   },


});
