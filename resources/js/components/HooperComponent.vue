<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Hooper Component</div>

                    <div class="card-body">
                        hooper
                        <div id="app">
                          
  <hooper group="group1" :itemsToShow="6" :initialSlide="2" :centerMode="true">
  <slide>
    slide 1
  </slide>
  <slide>
    slide 2
  </slide>
  <slide>
    slide 3
  </slide>
  <slide>
    slide 4
  </slide>
  <slide>
    slide 5
  </slide>
  <slide>
    slide 6
  </slide>

  <hooper-navigation slot="hooper-addons"></hooper-navigation>
  <hooper-pagination slot="hooper-addons"></hooper-pagination>
</hooper>
  <hooper group="group1" :initialSlide="2">
  <slide>
    slide 1
  </slide>
  <slide>
    slide 2
  </slide>
  <slide>
    slide 3
  </slide>
  <slide>
    slide 4
  </slide>
  <slide>
    slide 5
  </slide>
  <slide>
    slide 6
  </slide>
</hooper>


</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Hooper, Slide } from 'hooper';
    import 'hooper/dist/hooper.css';
 
    export default {
        name: 'App',
        components: {
        Hooper,
        Slide
        }
        // mounted() {
        //     console.log('Component mounted.')
        // }
    }
</script>
