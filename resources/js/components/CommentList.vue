<template>
    <div>
        <h2>コメント一覧</h2>
        <div v-if="comments.length === 0">
            コメントがありませんでした。
        </div>
        <div v-else v-for="(comment, index) in comments" class="row">
            <div class="col-md-8">
                {{ comment.comment }}
            </div>
            <div class="col-md-4">
                {{ comment.created_at }}
            </div>

        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
Vue.use(Vuex)
export default {
    name: "CommentList",
    created () {
        this.getComments()
    },
    methods: {
        // 該当ニュースのコメントを取得する
        getComments: function () {
            let feedId = this.$store.state.selectFeedId
            let url = '/api/comments/' + feedId

            axios({method: 'get',  url: url})
                .then(response => {
                    this.$store.state.comments[feedId] = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        }
    },
    computed: {
        comments: {
            get () {
                let feedId = this.$store.state.selectFeedId
                return this.$store.state.comments[feedId]
            }
        }
    }
}
</script>

<style scoped>

</style>
