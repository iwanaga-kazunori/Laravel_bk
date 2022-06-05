
require('./bootstrap');

import Vue from'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

import FeedList from './components/FeedListComponent'

const store = new Vuex.Store({
    state: {
        // message: 'Hello World',
        // weeks: [],
        feeds: [],
        selectFeedId: null,
        postComment: 'ポストコメント',
        comments: [],
        tcomments: [],
        
    },
    mutations: {
        // setWeek () {
        //     this.state.weeks = [
        //         {ja:'日', en:'Sun'},
        //         {ja:'月', en:'Mon'},
        //         {ja:'火', en:'Tue'},
        //         {ja:'水', en:'Wed'},
        //         {ja:'木', en:'Thu'},
        //         {ja:'金', en:'Fri'},
        //         {ja:'土', en:'Sat'}
        //     ]
        // },
        getFeeds (state) {
            const url = '/api/feed'
            axios.get(url)
                .then(function (response) {
                    store.commit('setFeeds', response.data)
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        setFeeds (state, feeds) {
            state.feeds = feeds
        },
        selectFeedId (state, i) {
            state.selectFeedId = i
        },
        // 記事のコメントを一時取得する
        getPostComment () {
            return state.postComment
        },
        // 記事のコメントを一時的に保存する
        setPostComment (state, value) {
            state.postComment = value
        },
        addComment (state, { content }) {
            state.tcomments.push({
                content,
            })
        },
    },
});

const app = new Vue({
    el: '#app',
    components: { FeedList } ,
    store,
    
})
