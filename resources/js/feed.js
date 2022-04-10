
import Vue from'vue'
import axios from 'axios'

Vue.component('feed-list', require('./components/FeedList.vue').default)

const app = new Vue({
    el: '#app',
    data () {
        return {
            feeds: [],
            weeks: [
                {ja:'日', en:'Sun'},
                {ja:'月', en:'Mon'},
                {ja:'火', en:'Tue'},
                {ja:'水', en:'Wed'},
                {ja:'木', en:'Thu'},
                {ja:'金', en:'Fri'},
                {ja:'土', en:'Sat'}
            ],
        }
    },
    mounted () {
        // console.log('feed.js mounted')
        // this.getFeeds()
    },
    computed: {

    },
    methods: {
        testMethod () {
            console.log('=====test.method======')
        },
        getFeeds () {
            let url = '/api/feed'

            console.log(url)
            axios.get(url)
                .then (function (response) {
                    // console.log(response)
                    this.feeds = response.data
                })
                .catch (function (error) {
                    console.log(error)
                })
        }
    }
})
