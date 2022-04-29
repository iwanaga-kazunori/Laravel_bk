<template>
    <div>
        <h2>feed list</h2>
        <div>
            <div class="col-md-10 row">
                <div v-for="(feed, index) in this.$store.state.feeds" class="col-md-5 m-2 border rounded">
                    <div>{{ feed.title }}</div>
                    <div>{{ feed.link }}</div>
                    <div> {{ feed.date }}</div>
                    <div>{{ feed.category }}</div>
                    <div>{{ feed.description }}</div>
                    <div>
                        <button @click="show(index)" class="button">show</button>
                    </div>
                </div>
            </div>
            <modal name="hello-world" v-on:click="show" :draggable="true" :resizable="true">
                <div class="modal-header">
                    <h2>コメント投稿</h2>
                </div>
                <div class="modal-body">
                    <div class="" v-if="this.$store.state.selectFeedId !== null">
                        <div>{{ this.$store.state.feeds[this.$store.state.selectFeedId].title }}</div>
                        <div>
                            <textarea
                                row="5"
                                v-model="this.$store.state.postComment"
                            ></textarea>
                        </div>
                        <div>
                            <button v-on:click="sendPostComment">
                                投稿する
                            </button>
                        </div>
                    </div>

                </div>
                <button v-on:click="hide">
                    閉じる
                </button>
            </modal>

            <div>selectFeedId : {{ this.$store.state.selectFeedId }}</div>
            <div>feed : {{ this.$store.state.feeds[this.$store.state.selectFeedId] }}</div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import Vuex from 'vuex'
import VModal from 'vue-js-modal'
Vue.use(Vuex)
Vue.use(VModal)

export default {
    name: "FeedList",

    // メソッド一覧
    methods: {
        button4 () {
            this.$store.commit('getFeeds')
        },
        show (i) {
            console.log("show")
            console.log(i)

            this.$store.commit('selectFeedId', i)
            this.$modal.show('hello-world')
        },
        hide () {
            console.log("hide")
            this.$modal.hide('hello-world')
        },
        sendPostComment () {
            console.log('postComment')
            let params = {
                news_id: this.$store.state.selectFeedId,
                comment: this.$store.state.postComment
            }
            console.log(params)

            // axios.post()
        }
    },
    // 読み込み直後に起動するもの
    mounted () {
        this.button4()
    },
    computed: {
        postComment: {
            get () {
                return this.$store.getters.postComment
            },
            set (value) {
                // this.$store.dispatch('getPostComment', value)
            }
        }
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
.modal-header {
    border-bottom: 1px solid #ddd;
}

</style>
