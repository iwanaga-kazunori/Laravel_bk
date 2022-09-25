<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- {{ matches }} -->
                
            <div v-for="match in matches">
                {{ match }}
                
            </div>
        
        
        
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import Vuex from 'vuex'
import VModal from 'vue-js-modal'
import vueMoment from 'vue-moment'

Vue.use(Vuex)
Vue.use(VModal)
Vue.use(vueMoment)
    
export default {
    mounted() {
        console.log('mounted')
        this.$store.dispatch('getMatches')
    },
    computed: {
        matches: function(){
            return this.$store.state.matches
        },
    }
}
</script>
