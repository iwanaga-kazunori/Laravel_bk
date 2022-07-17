<template>
    <div>
        <div>
            <div class="col-md-10 row">
                <div v-for="(feed, index) in feeds" class="col-md-5 m-2 border rounded feed" @click="ModalShow(index)">
                    <h3>{{ feed.title }}</h3>
                    <p>NEWSID:{{ feed.news_id }}</p>
                    <div><img :src="feed.img_path"></div>
                    <div>{{ feed.description }}&hellip;</div>
                    <div>{{ feed.date }}</div>
                    <div>{{ feed.team }}</div>                   
                </div>
            </div>
            <modal 
                name="hello-world" 
                v-on:click="ModalShow"
                :draggable="true"
                
                
                height="80%">
                <div class="modal-header" v-if="this.$store.state.selectFeedId !== null">
                    <h3>{{ feeds[this.$store.state.selectFeedId].title }}</h3>
                </div>
                <div class="modal-body">
                    <div class="" v-if="this.$store.state.selectFeedId !== null">
                        <div ref="news_id">{{ feeds[this.$store.state.selectFeedId].news_id }}</div>
                        <div v-html="feeds[this.$store.state.selectFeedId].content"></div>
                        <comment-list></comment-list>
                        
                        <div v-if="arrayAttribute != null">
                            <div>
                                <textarea
                                    v-model="commentForm"
                                ></textarea>
                                
                            </div>
                            <div>
                                <button v-on:click="SendPostComment">
                                    <sapn v-if="isSending">
                                        投稿中(しばらくお待ちください)
                                    </sapn>
                                    <span v-else>
                                        投稿する
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div v-else>
                            <p>ログインしていません</p>
                        </div>
                        <hr>
                        
                    </div>

                </div>
                <button v-on:click="ModalHide">
                    閉じる
                </button>
            </modal>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import Vuex from 'vuex'
import VModal from 'vue-js-modal'
import CommentList from './CommentList'
Vue.use(Vuex)
Vue.use(VModal)

export default {
    name: "FeedList",
    // メソッド一覧
    methods: {
        button4 () {
            this.$store.commit('getFeeds')
        },
        ModalShow (i) {
            this.$store.commit('selectFeedId', i)
            this.$modal.show('hello-world')
        },
        ModalHide () {
            this.$modal.hide('hello-world')            
        },
        async SendPostComment () {
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
            this.ModalHide()
        },
    },
    // 読み込み直後に起動するもの
    mounted () {
        this.button4()
        // this.getComments()
        
    },
    computed: {
        feeds: function(){
  		        return this.$store.state.feeds
  	    },
        selectFeedId: function(){
  		        return this.$store.state.selectFeedId
  	    },
        commentForm: {
            get () {
                return this.$store.getters.postComment
            },
            set (value) {
                this.$store.commit('setPostComment', value)
            }
        },
        isSending: {
            get () {
                return this.$store.getters.isSending
            },
            set () {
                this.$store.commit('isSending',)
            }
        }
    },
    props: {
            arrayAttribute: Array,
        },
    components: {
        CommentList
    }
}
</script>

<style scoped>

div.week {
    border: 1px solid #f00;
}

.modal-header, .modal-body {
    color: #333;
}
.modal-header, modal-body {
    padding: 5px 25px;
}
.modal-body > textarea {
    width: 400px;
    color: #ff0000;
}
.modal-header {
    border-bottom: 1px solid #ddd;
}
img {
    width:100%;
}
</style>
