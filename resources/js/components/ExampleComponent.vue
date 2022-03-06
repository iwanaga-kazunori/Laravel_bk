<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                    {{ this.matches }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            axios.get('/api/matches')
                .then (function (response){
                    console.log(response)
                    this.matches = response.body
                })
                .catch (function (error){
                    console.log(error)
                })
            this.getMatches()
        },
        data() {
        return {
            matches: null
            }
        },
    
        methods: {
            getMatches () {
                
            }
        }
    }
</script>
