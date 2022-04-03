<template>
  <div>
    <div class="card rounded-0 bg-transparent border-0">
      <div class="card-body pb-5">
        <h1>Teacher Workbooks</h1>
        <!-- <div class="col-lg-12 text-center pb-5 pt-5" v-if="teachersData.display_status == 0">
          <img :src="this.defaultImg" ref="prof_display" class="rounded-circle" alt="" >
        </div> -->
        <!-- <div class="col-lg-12 text-center" @click="toggleModal" v-else>
          <video ref="videoRef" src="" id="video-container" width="250" height="190" @mouseover="playVidsEvt(true)" @mouseleave="playVidsEvt(false)"></video>
        </div> -->


      </div>
    </div>
  </div>
</template>

<script>
  import * as api from '../api.js';
  export default {
    props: {
    },
    components: {
    },
    name: 'TeacherWorkbooks',
    data(){
      return{
        
      }
    },
    methods: {
    
    },
    mounted() {
    }
  }
</script>

<style>

</style>