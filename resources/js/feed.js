
require('./bootstrap');
require('vue-moment');

import Vue from'vue'
import Vuex from 'vuex'
import axios from 'axios'
import VueLoading from 'vue-loading-template'
import Slick from 'vue-slick';
Vue.use(Vuex)
Vue.use(VueLoading)
Vue.component('matches-component', require('./components/MatchesComponent.vue').default);
import FeedList from './components/FeedListComponent'
const store = new Vuex.Store({
    state: {
        feeds: [],
        selectFeedId: null,
        postComment: 'ポストコメント',
        comments: [],
        tcomments: [],  
        isSending: false,
        current_page:1,
        last_page: "",
        range: 5,
        front_dot: false,
        end_dot: false,
        loading: "",
        matches: [],
    },
    mutations: {
        getFeeds (state) {
            let token = document.head.querySelector('meta[name=api-token]')
            const url = '/api/feed?page=1' + '&api_token=' + token.content
            
            axios.get(url)
                .then(function (response) {
                    store.commit('setFeeds', response.data.data)
                    store.commit('setCurrentPage', response.data.current_page)
                    store.commit('setLastPage', response.data.last_page)
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        setFeeds (state, feeds) {
            state.feeds = feeds
        },
        setCurrentPage (state, current_page) {
            state.current_page = current_page
        },
        setLastPage (state, last_page) {
            state.last_page = last_page
        },
        setRange (state, range) {
            state.range = range
        },
        setFrontDot (state, front_dot) {
            state.front_dot = front_dot
        },
        setEndDot (state, end_dot) {
            state.end_dot = end_dot
        },
        selectFeedId (state, i) {
            state.selectFeedId = i
        },
        isSendingChange (state) {
            state.isSending = true
        },
        isSendingReset (state) {
            state.isSending = false
        },
        // loadingOn (state) {
        //     state.loading = true
        // },
        // loadingOff (state) {
        //     state.loading = false
        // },
        // 記事のコメントを一時取得する
        getPostComment () {
            return state.postComment
        },
        // 記事のコメントを一時的に保存する
        setPostComment (state, value) {
            state.postComment = value
        },
        setMatches : function(state,matches) {
            state.matches = matches
        },
    },
    actions: {
        getMatches (state){
            axios.get('api/matches')
            .then(function (response) {
                console.log(response.data)
                store.commit('setMatches',response.data)
            })
            .catch(function (error) {
                    console.log(error)
            })
        }
    },
});

const app = new Vue({
    el: '#app',
    components: { FeedList,Slick } ,
    store,
    
    data() {
        return {
          date: this.$moment().format(),
        };
      },
      data: {
        //メイン
        slickOptions: {
            slidesToShow: 1,
            arrows: true,
            centerMode: true,
            initialSlide: 1,
            centerPadding: '10%',
            asNavFor: '.slider-nav',
        },
        //サムネイル
        slickNavOptions: {
            slidesToShow: 5,
            asNavFor: '.slider-for',
            focusOnSelect: true,
        },
    },
})
