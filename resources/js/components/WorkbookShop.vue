<template>
  <div>
    <div class="card rounded-0 bg-transparent border-0">
      <div class="card-body pb-5">
         <div>
            <b-carousel
              id="carousel-1"
              v-model="slide"
              :interval="4000"
              controls
              background="#ababab"
              img-width="1024"
              img-height="480"
              style="text-shadow: 1px 1px 2px #333;"
              @sliding-start="onSlideStart"
              @sliding-end="onSlideEnd"
              
            >
              <!-- Slides with img slot -->
              <!-- Note the classes .d-block and .img-fluid to prevent browser default image alignment -->
              <b-carousel-slide>
                <template #img >
                  <img
                    class="d-block img-fluid w-100"
                    width="1024"
                    height="480"
                    src="https://picsum.photos/1024/480/?image=55"
                    alt="image slot"
                    @click="showBooksThumb = !showBooksThumb"
                  >
                </template>
              </b-carousel-slide>
             
            </b-carousel>
            <p class="mt-4">
              Slide #: {{ slide }}<br>
              Sliding: {{ sliding }}
            </p>
          </div>

          <transition name="fade">
            <div class="lightbox-container" v-if="showBooksThumb">
              <a href="javascript:void(0);" v-on:click="showBooksThumb = false"><i class="fas fa-times"></i></a>
              <img :src="asset + 'images/apay.jpg'" alt="" class="lightbox-img">
            </div>
          </transition>

      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
    },
    name: 'WorkbookShop',
    data(){
      return{
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
        asset: document.querySelector('meta[name="url-asset"]').getAttribute('content'),
        slide: 0,
        sliding: null,
        showBooksThumb: false
      }
    },
    methods: {
      onSlideStart(slide) {
        this.sliding = true
      },
      onSlideEnd(slide) {
        this.sliding = false
      },
      showAlert(){
        alert('oowa');
      }

      
    },
    mounted() {
      
    }
  }
</script>

<style>
#carousel-1 .carousel-item img {
  display: block;
  object-fit: cover;
  height: 30vh;
  margin: auto;
  width: 74% !important;
}
#carousel-1 {
  background: none !important;
}
#carousel-1 .carousel-item {
  background: none !important;
}
#carousel-1 .carousel-inner{
  background: none !important;
}
#carousel-1 .carousel-control-prev-icon {
  background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%234f4e4e' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
}
#carousel-1 .carousel-control-next-icon {
  background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%234f4e4e' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
}
.lightbox-container {
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 9;
  right: 0%;
  padding-top: 10%;
  background: rgba(0, 0, 0, 0.63);
  height: 100%;
}
.lightbox-img{
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.lightbox-container a {
  position: relative;
  margin: auto;
  display: block;
  width: 50%;
  text-align: right;
  color: #f0f0f0;
  font-size: 46px !important;
}
</style>