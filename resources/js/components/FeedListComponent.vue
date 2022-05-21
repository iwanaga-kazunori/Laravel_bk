<template>
    <div>
        <h2>feed list</h2>
        <div>
            <div class="col-md-10 row">
                <div v-for="(feed, index) in this.$store.state.feeds" class="col-md-5 m-2 border rounded">
                    <div>{{ feed.title }}</div>
                    <div>{{ feed.link }}</div>
                    <div>{{ feed.date }}</div>
                    <div>{{ feed.category }}</div>
                    <div>{{ feed.description }}</div>
                    <div>
                        <button @click="ModalShow(index)" class="button">show</button>
                    </div>
                </div>
            </div>
            <modal name="hello-world" v-on:click="ModalShow" :draggable="true" :resizable="true">
                <div class="modal-header">
                    <h2>コメント投稿</h2>
                </div>
                <div class="modal-body">
                    <div class="" v-if="this.$store.state.selectFeedId !== null">
                        <div>{{ this.$store.state.feeds[this.$store.state.selectFeedId].title }}</div>
                        <div>
                            <textarea
                                v-model="commentForm"
                                ></textarea>
                        </div>
                        <comment-list></comment-list>
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
        SendPostComment () {
            let url = '/api/feed'
            let params = {
                feed_id: this.$store.state.selectFeedId,
                comment: this.$store.state.postComment
            }

            // Ajaxでデータを投げる
            axios.put(url, params)
                .then(function (response) {
                    this.ModalHide()
                    console.log(response)
                })
                .catch(function (error) {
                    console.log(error)
                })

        },
    },
    // 読み込み直後に起動するもの
    mounted () {
        this.button4()
        this.getComments()
    },
    computed: {
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

</style>
