<template>
    <div>
        <div>
            <h2 style="text-align:center;font-size:1.4em;padding-bottom:20px;">新着情報</h2>
            <!-- <Loading v-show="loading"></Loading> -->
            <!-- {{ matches }} -->
            
            <!-- <div>
                {{ this.$store.state.current_page }}<br>
                {{ this.$store.state.last_page }}<br>
                {{ this.$store.state.range }}<br>
                {{  this.$store.state.front_dot }}<br>
                {{  this.$store.state.end_dot }}</div><br> -->
            <div  class="container-lg d-flex justify-content-around flex-wrap">
                <div v-for="(feed, index) in feeds" class="col-md-3 feed" @click="ModalShow(index)"
                style="background-color: rgba(0,0,0,0.4);margin: 30px 10px 10px 10px;padding: 15px;border-radius:3px;box-shadow: -3px 3px 5px rgba(221, 0, 0, 0.7), 3px -3px 5px rgba(255, 207, 0, 0.7)">
                    <h3 style="font-size:1.1em;line-height: 150%;height:4.0em">{{ feed.title }}</h3>
                    <!-- <p>NEWSID:{{ feed.news_id }}</p> -->
                    <div style="width: 100%;overflow: hidden;">
                        <div style="width:100%;"><img :src="feed.img_path" width="100%"></div>
                        <div style="width:100%;">
                            <p>{{ feed.date }}</p>
                            <!-- <p style="font-size:0.9em;">{{ feed.description }}。。。続きを読む</p> -->
                            <p>{{ feed.team }}</p>
                            <div v-if="feed.teammaster" style="width:50px;"><img :src="'/'+feed.teammaster.path"></div>
                        </div>
                    </div>
                </div>
            </div>
            <modal 
                name="feed" 
                v-on:click="ModalShow"
                :draggable="true"
                height="80%">
                <div class="modal-header" v-if="this.$store.state.selectFeedId !== null">
                    
                    <h3>{{ feeds[this.$store.state.selectFeedId].title }}</h3>
                    <p>{{ feeds[this.$store.state.selectFeedId].date }}</p>
                    <p>{{ feeds[this.$store.state.selectFeedId].team }}</p>
                </div>
                <div class="modal-body">
                    <div class="" v-if="this.$store.state.selectFeedId !== null">
                        <div ref="news_id" class="news_id">{{ feeds[this.$store.state.selectFeedId].news_id }}</div>
                        <div v-html="feeds[this.$store.state.selectFeedId].content"></div>
                        <h3>コメント一覧</h3>
                        <hr>
                        <div v-if="feeds[this.$store.state.selectFeedId].comments.length">
                            <table>
                                <tr><th>日付</th><th>名前</th><th>コメント</th></tr>
                                <tr v-for="comment in feeds[this.$store.state.selectFeedId].comments">
                                    <td>{{ comment.user.created_at | moment("YYYY/MM/DD") }}　</td>
                                    <td>{{ comment.user.name }}　</td>
                                    <td>{{ comment.comment }}</td>
                                </tr>
                            </table>
                            <hr>
                        </div>
                        <div v-else>
                            コメントがありません。
                        </div>
                        <div v-if="isSending == false">
                            <div>
                                <textarea
                                    v-model="commentForm"
                                    ></textarea>  
                            </div>
                            <div>
                                <button v-on:click="SendPostComment">
                                    投稿する
                                </button>
                            </div>
                        </div>
                        <div v-else>投稿中(しばらくお待ちください)</div>
                        <hr>
                    </div>
                </div>
                <button v-on:click="ModalHide">
                    閉じる
                </button>
            </modal>
            <div style="text-align: center;margin-top: 30px;">
            <ul class="pagination" style="justify-content: center;">
                <li class="inactive" 
                    :class="(this.$store.state.current_page == 1) ? 'disabled' : ''"
                    @click="changePage(currentPage-1)"
                >&laquo;</li>
                <li v-for="page in frontPageRange" :key="page" @click="changePage(page)" :class="(isCurrent(page)) ? 'active' : 'inactive'">{{ page }}</li>
                <li v-show="this.$store.state.front_dot" class="inactive disabled">...</li>
                <li v-for="page in middlePageRange" :key="page" @click="changePage(page)" :class="(isCurrent(page)) ? 'active' : 'inactive'">{{ page }}</li>
                <li v-show="this.$store.state.end_dot" class="inactive disabled">...</li>
                <li v-for="page in endPageRange" :key="page" @click="changePage(page)" :class="(isCurrent(page)) ? 'active' : 'inactive'">{{ page }}</li>
                <li class="inactive"
                    :class="(this.$store.state.current_page >= this.$store.state.last_page) ? 'disabled' : ''"
                    @click="changePage(currentPage + 1)"
                >&raquo;</li>
            </ul>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import Vuex from 'vuex'
import VModal from 'vue-js-modal'
import CommentList from './CommentList'
import vueMoment from 'vue-moment'
import { VueLoading } from 'vue-loading-template'
import Loading from './Loading'

Vue.use(Vuex)
Vue.use(VModal)
Vue.use(vueMoment)

export default {
    name: "FeedList",
    data() {
        return {
            loading: "true",
        }
    },
    // メソッド一覧
    methods: {
        button4 () {
            
            this.$store.commit('getFeeds')
            
        },
        async getFeeds (store, page) {
            // this.loadingOn()
            let token = document.head.querySelector('meta[name=api-token]')
            const url = '/api/feed?page=' + page + '&api_token=' + token.content
                        
            await axios.get(url)
                .then(function (response) {
                    store.commit('setFeeds', response.data.data)
                    store.commit('setCurrentPage', response.data.current_page)
                    store.commit('setLastPage', response.data.last_page)
                })
                .catch(function (error) {
                    console.log(error)
                })
            // this.loadingOff()
        },
        ModalShow (i) {
            this.$store.commit('selectFeedId', i)
            this.$modal.show('feed')
        },
        ModalHide () {
            this.$modal.hide('feed')            
        },
        calRange(start, end) {
            const range = [];
            for (let i = start; i <= end; i++) {
                range.push(i)
            }
            return range
        },
        async changePage(page) {
            this.loading = true;
            console.log(page)
            console.log(typeof page)
            if (page > 0 && page <= this.$store.state.last_page) {
                this.$store.state.current_page = page
                
                await this.getFeeds(this.$store, page)
                
            }
            
        },
        isCurrent(page) {
            return page === this.$store.state.current_page
        },
        UpdateState () {
            this.$store.commit('getFeeds')
        },
        isSendingChange () {
            this.$store.commit('isSendingChange')
        },
        isSendingReset () {
            this.$store.commit('isSendingReset')
        },
        // loadingOn () {
        //     this.$store.commit('loadingOn')
        // },
        // loadingOff () {
        //     this.$store.commit('loadingOff')
        // },
        async SendPostComment () {
            this.isSendingChange()
            let url = '/api/feed'
            //userのidを取得
            let user_id = document.head.querySelector('meta[name=user_id]')
            console.log(user_id.content)
            //userのnews_idを取得
            var news_id = this.$refs.news_id
            console.log(news_id.innerHTML)
            
            let params = {
                feed_id: this.$store.state.selectFeedId,
                comment: this.$store.state.postComment,
                user_id: user_id.content,
                news_id: news_id.innerHTML
            }
            
            // Ajaxでデータを投げる
            await axios.put(url, params)
                .then(function (response) {
                    // this.ModalHide()
                    console.log(response)                    
                })
                .catch(function (error) {
                    console.log(error)
                })
            this.UpdateState()
            alert('アップロードが完了しました！');
            this.ModalHide()
            this.isSendingReset()
        },
        
    },
    // 読み込み直後に起動するもの
    async mounted () {
        console.log('mounted')
        // this.loadingOn()
        await this.button4()
        this.$store.dispatch('getMatches')
                
    },
    updated() {
        console.log('=====');
        this.loading = false;
    },
    async created () {
        console.log('created')
        // this.loadingOn()
        // await this.button4()
        // this.loadingOff()
    },
    computed: {
        feeds: function(){
  		        return this.$store.state.feeds
  	    },
        selectFeedId: function(){
  		        return this.$store.state.selectFeedId
  	    },
          matches: function(){
                return this.$store.state.matches
            },
        isSending: function(){
  		        return this.$store.state.isSending
  	    },
        currentPage: function() {
                return this.$store.state.current_page
        },
        commentForm: {
            get () {
                return this.$store.getters.postComment
            },
            set (value) {
                this.$store.commit('setPostComment', value)
            }
        },
        // isSending: {
        //     get () {
        //         return this.$store.getters.isSending
        //     },
        //     set () {
        //         this.$store.commit('isSending',)
        //     }
        // }
        sizeCheck: function() {
            if (this.$store.state.last_page <= this.$store.state.range + 4) {
                return false
            }
            return true
        },
        frontPageRange: function() {
            if (!this.sizeCheck) {
                this.front_dot = false;
                this.end_dot = false;
                return this.calRange(1, this.$store.state.last_page);
            }
            return this.calRange(1, 2)
        },
        middlePageRange() {
            if (!this.sizeCheck) return []
                let start = ""
                let end = ""
            if (this.$store.state.current_page <= this.$store.state.range) {
                start = 3
                end = this.$store.state.range + 2
                this.$store.state.front_dot = false
                this.$store.state.end_dot = true
                this.$store.commit('setFrontDot', false)
                this.$store.commit('setEndDot', true)                
            } else if (this.$store.state.current_page > this.$store.state.last_page - this.$store.state.range) {
                start = this.$store.state.last_page - this.$store.state.range - 1
                end = this.$store.state.last_page - 2
                this.$store.state.front_dot = true
                this.$store.state.end_dot = false
            } else {
                start = this.$store.state.current_page - Math.floor(this.$store.state.range / 2)
                end = this.$store.state.current_page + Math.floor(this.$store.state.range / 2)
                this.$store.state.front_dot = true
                this.$store.state.end_dot = true
            }
            return this.calRange(start, end)
        },
        endPageRange() {
            if (!this.sizeCheck) return []
                return this.calRange(this.$store.state.last_page - 1, this.$store.state.last_page)
        },
        
    },
   
    components: {
        CommentList,
        VueLoading,
        Loading,
    }
}
</script>

<style scoped>
.modal-header, .modal-body {
    color: #333;
    display: block;
}
.modal-header h3{
    font-size: 1.3em;
}
.modal-header, .modal-body {
    padding: 20px;
}
.modal-body .news_id {
    display: none;
}
.modal-body h3{
    text-align: center;
    font-size: 1.3em;
}
.modal-body > textarea {
    width: 400px;
    color: #ff0000;
}
.modal-header {
    border-bottom: 3px solid #c21500;
    border-image: linear-gradient(90deg, rgba(0,0,0,1) 0%, rgba(221,0,0,1) 50%, rgba(255,207,0,1) 100%);
    border-image-slice: 1;
}
img {
    width:100%;
}
.pagination {
        display: flex;
        list-style-type: none;
    }
    .pagination li {
        border: 1px solid #ddd;
        padding: 6px 12px;
        text-align: center;
    }
    .active {
        background-color: #3377ab;
        color:white;
    }
    .inactive{
        color: #fff;
    }
    .pagination li + li {
        border-left: none;
    }
    .disabled {
  cursor: not-allowed;
}
td {
    white-space: pre-line;
}
p {
    margin: 0px;
}
</style>
