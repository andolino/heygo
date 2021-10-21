<template>
  <div>
    <div class="card rounded-0 bg-transparent border-0">
      <div class="card-body pb-5">

        <div class="col-lg-12 text-center pb-5 pt-5" v-if="teachersData.display_status == 0">
          <img :src="this.defaultImg" ref="prof_display" class="rounded-circle" alt="" >
        </div>
        <div class="col-lg-12 text-center" @click="toggleModal" v-else>
          <video ref="videoRef" src="" id="video-container" width="250" height="190" @mouseover="playVidsEvt(true)" @mouseleave="playVidsEvt(false)"></video>
        </div>

        <div>
          <b-modal static class="p-0" v-model="showVideoModal" id="video-container-mod" ref="my-modal" hide-footer>
            <video ref="videoRefMod" src="" width="100%" height="100%" controls></video>
          </b-modal>
        </div>

        <div class="col-lg-12 text-justify">
          <ul id="ti_ul" class="mb-1">
            <li class="pl-0" style="font-size:20px;">
                <i class="fa fa-circle text-success font-12" style="position:relative;bottom:3px;" aria-hidden="true"></i> 
                {{ this.$helpers.capFirstLetter(teachersData.lastname) }}, {{ this.$helpers.capFirstLetter(teachersData.firstname) }} </li>
            <li style="line-height:2"><i class="fas fa-map-marker-alt text-warning p-2"></i> <img :src="asset + 'images/flag-1.png'" width="20"></li>
          </ul>
          <ul id="ti_ul" class="font-14">
            <li class="pl-0"><i class="fas fa-star text-warning" aria-hidden="true"></i> 4.5 </li>
            <li>43 Reviews</li>
            <li><i class="fa fa-circle text-success font-12" aria-hidden="true"></i> Certified Tutor</li>
            <li></li>
          </ul>
          <ul id="ti_ul" class="font-12 mb-1">
            <li class="pl-0">45 active students</li>
            <li>2,820 Lesson</li>
          </ul>
          <ul id="ti_ul" class="font-12">
            <li class="pl-0"><strong>Speaks:</strong></li>
            <li>English, Japanese, Korean</li>
          </ul>
          <ul id="ti_ul" class="font-14 mb-1">
            <li class="pl-0"><strong>{{ teachersData.rate_per_hr | toCurrency }}</strong> JPY/hour</li>
            <li></li>
          </ul>
          <!-- <span class="mb-0" style="font-size: 23px;text-align:center"><div class="cicle-active"></div> James Cameron </span>
          <span class="ml-3"><i class="fas fa-map-marker-alt text-warning p-2"></i><img :src="asset + 'images/flag-1.png'" width="20"></span>
          <span class="ml-3"><i class="fas fa-star text-warning p-2"></i><strong>4.5</strong></span>
          <span class="ml-3">43 Reviews <i class="fas fa-heart" style="color: rgb(217, 22, 132);"></i></span> -->
          <hr>
          <div class="row">
            <div class="col-lg-12">
              <label for="" class="font-14"><strong>Earned Badges:</strong></label>
            </div>
            <div class="col-lg-4 text-center">
              <img :src="asset + 'images/badge.png'" width="60">
            </div>
            <div class="col-lg-4 text-center">
              <img :src="asset + 'images/badge.png'" width="60">
            </div>
            <div class="col-lg-4 text-center">
              <img :src="asset + 'images/badge.png'" width="60">
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <button type="button" 
                        class="btn btn-default float-left btn-dashboard mb-3 font-12 pl-3 pr-3"  
                        data-apptype="confirm">Book A Lesson</button>
              <button type="button" 
                        class="btn btn-default float-right btn-dashboard mb-3 font-12"  
                        data-apptype="confirm">See Profile</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      teachersId: Number
    },
    name: 'TeacherInformation',
    data(){
      return{
        form: new Form({
          email: '',
          password: '',
        }),
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
        asset: document.querySelector('meta[name="url-asset"]').getAttribute('content'),
        teachersData: '',
        defaultImg: '',
        hover: false,
        showVideoModal: false,
        teacherVideo: ''
      }
    },
    methods: {
      fetTeachersData(){
        axios.get(process.env.MIX_BASE_URL+'/api/get-teacher-information/'+this.teachersId).then((res) => {
						this.teachersData = res.data;
            this.defaultImg = this.baseurl + '/public/images/profile/teachers/thumb/' + res.data.picture;
            if (typeof this.$refs.videoRef !== 'undefined') {
              this.$refs.videoRef.src = this.baseurl + '/public/videos/teachers/' + res.data.video;
            } 
            if (typeof this.$refs.videoRefMod !== 'undefined'){
              this.$refs.videoRefMod.src = this.baseurl + '/public/videos/teachers/' + res.data.video;
            }
          }).catch((error) => {
						console.log(error);
        });
      },
      playVidsEvt(b){
        if (b == true) {
          this.$refs.videoRef.play();
        } else {
          this.$refs.videoRef.src = this.baseurl + '/public/videos/teachers/' + this.teachersData.video;
          this.teacherVideo = this.baseurl + '/public/videos/teachers/' + this.teachersData.video;
        }
        // console.log(b);
      },
      toggleModal(){
        this.showVideoModal = true;
        this.$refs.videoRefMod.src = this.baseurl + '/public/videos/teachers/' + this.teachersData.video;
      
      }
    },
    mounted() {
      this.fetTeachersData();
    }
  }
</script>

<style>
ul#ti_ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
}

#ti_ul li {
  float: left;
  padding-left:11px;
}
#ti_ul li a {
  display: block;
  color: white;
  text-align: center;
  padding: 16px;
  text-decoration: none;
}
#video-container-mod .modal-body{
  padding: 0 !important;
}
</style>