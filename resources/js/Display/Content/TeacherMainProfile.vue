<template>
  <div>
    <h3>Profile Summary</h3>
    <div class="card rounded-0 bg-transparent border-0">
      <div class="card-body pb-5 row">

        <!-- <div class="col-lg-12 text-center pb-5 pt-5" v-if="teachersData.display_status == 0">
          <img :src="this.defaultImg" ref="prof_display" class="rounded-circle" alt="" >
        </div> -->
        <!-- <div class="col-lg-12 text-center" @click="toggleModal" v-else>
          <video ref="videoRef" src="" id="video-container" width="250" height="190" @mouseover="playVidsEvt(true)" @mouseleave="playVidsEvt(false)"></video>
        </div> -->

        <div>
          <b-modal static class="p-0" v-model="showVideoModal" id="video-container-mod" ref="my-modal" hide-footer>
            <video ref="videoRefMod" src="" width="100%" height="100%" controls></video>
          </b-modal>
        </div>

        <div class="col-lg-12 text-justify">
          <div class="row">
            <div class="col-lg-2">
              <!-- <div class="clearfix">
                <img :src="this.defaultImg" ref="prof_display" width="100%" class="rounded-circle" alt="" >
              </div> -->
              <div class="img-card">
                <!-- <h5 class="text-left font-14">Profile Pic</h5> -->
                <div class="img-container mb-3">
                  <img :src="this.defaultImg" ref="prof_display" class="rounded-circle" alt="">
                  <input type="file" class="d-none" ref="uploadImg" @change="selectFileUploadImg">
                  <div class="overlay">
                    <a href="javascript:void(0);" @click="$refs.uploadImg.click()" class="icon" title="User Profile">
                      <i class="fa fa-upload"></i>
                    </a>
                  </div>
                </div>
              </div>

            </div>
            <div class="col-lg-9">
              <ul class="todo-list">
                  <li v-for="todo in todos" :key="todo.id">
                      <input
                          v-if="todo.edit"
                          v-model="todo.title"
                          @blur="todo.edit = false; $emit('update')"
                          @keyup.enter="todo.edit=false; $emit('update')"
                          v-focus
                      >
                      <div v-else>
                          <label @click="todo.edit = true;"> {{todo.title}} </label>
                      </div>
                  </li>
              </ul>
              
              <!-- <ul id="ti_ul" class="mb-1">
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
              </ul> -->
              <TeacherProfileSettings />
            </div>


            <!-- <div class="col-lg-4" v-if="teachersId != user_id">
              <div class="row">
                <div class="col-lg-8">
                  <button type="button" 
                          class="btn btn-default float-left btn-dashboard mb-3 font-12 pl-3 pr-3"  
                          data-apptype="confirm">SCHEDULE A LESSON</button>
                </div>
                <div class="col-lg-4 text-center mb-3 card">
                  <label for="" class="price-txt"><span class="font-14">5,000</span> <br> <span class="font-10">per day</span></label>
                </div>
                <div class="col-lg-8">
                  <button type="button" 
                          class="btn btn-warning float-left btn-dashboard mb-3 font-12 pl-3 pr-3"  
                          data-apptype="confirm">SCHEDULE A TRIAL</button>
                </div>
                <div class="col-lg-4 text-center mb-3 card">
                  <label for="" class="price-txt"><span class="font-14">200</span> <br> <span class="font-10">30 mins</span></label>
                </div>
              </div>
            </div> -->

          </div>
          <hr>
          <div class="row">
            <div class="col-lg-12">
              <label for="" class="font-14"><strong>Badges:</strong></label>
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
          <hr>
          <div class="row">
            <div class="col-lg-12">
              <label for="" class="font-14"><strong>About Me:</strong></label>
              <p class="font-14">{{ $helpers.exactLimitText(teachersData.objective_text, textLimit) }} ... <a href="#" v-on:click="showMore">{{ showMoreTxt }}</a></p>
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-lg-12">
              <h5 for=""><strong>Schedules:</strong></h5>
            </div>
            <div class="col-lg-12 font-12">
              <Fullcalendar ref="calendar" :options="calendarOptions"/>
            </div>
          </div> -->
          <hr>
          <!-- <div class="row">
            <div class="col-lg-12">
            
            </div>
          </div> -->
            
        </div>
        <div class="col-lg-6">
          <!-- <TeacherProfileSettings/> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import TeacherSchedule from '../../components/TeacherSchedule.vue';
  import TeacherProfileSettings from '../../Display/Content/TeacherProfileSettings.vue';
  import Fullcalendar from "@fullcalendar/vue";
  import dayGridPlugin from "@fullcalendar/daygrid";
  import interactionPlugin from "@fullcalendar/interaction";
  import timeGridPlugin from "@fullcalendar/timegrid";
  import * as api from '../api.js';
  export default {
    props: {
      teachersId: String
    },
    components: {
      TeacherSchedule,
      Fullcalendar,
      TeacherProfileSettings
    },
    name: 'TeacherMainProfile',
    data(){
      return{
        form: new Form({
          email: '',
          password: '',
        }),
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
        asset: document.querySelector('meta[name="url-asset"]').getAttribute('content'),
        user_id: document.querySelector('meta[name="user-id"]').getAttribute('content'),
        defaultImg: document.querySelector('meta[name="url-asset"]').getAttribute('content') + 'images/ellipse-4.png',
        teachersData: '',
        defaultImg: '',
        hover: false,
        showVideoModal: false,
        teacherVideo: '',
        showMoreTxt: 'show more',
        showMoreBool: true,
        textLimit: 400,
        calendarOptions: {
          plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin ],
          initialView: 'timeGridWeek',
          navLinks: true, // can click day/week names to navigate views
          // editable: true,
          selectable: true,
          nowIndicator: true,
          dayMaxEvents: true, // allow "more" link when too many events
          expandRows: true,
          contentHeight: '1000px',
          events: [
            {
              time_start: this.time_start
            }
          ],
          // eventColor: '#fff',
          eventContent: function (arg, createElement){
            let ht = '';
                ht+='<div class="card" style="height:100%;">';
                  ht+='<div class="card-body pt-2 pr-3 pl-3 pb-3 bg-success">';
                    ht+='<h6 class="card-title font-12">'+arg.timeText+'</h6>';
                  ht+='</div>';
              ht+='</div>';
            arg.backgroundColor = 'rgba(0, 0, 0, 0)';
            arg.borderColor = 'rgba(0, 0, 0, 0)';
            arg.textColor = '#000';
            return { html: ht } 
          }
        },
        form_profile: [
          { 
            id: 1, 
            title: 'one value', 
            edit: false },
          { id: 2, title: 'one value', edit: false },
          { id: 3, title: 'otro titulo', edit: false }
        ],
        editedTodo: null,
        message: 'Hello Vue.js!',
        dataImage: {
          photo: null,
          description: ''
        },
      }
    },
    methods: {
      editTodo: function (todo) {
        this.editedTodo = todo
      },
      directives: {
        focus: {
          inserted (el) {
            el.focus()
          }
        }
      },
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
      },
      
      showMore(){
        if (this.showMoreBool == true) {
          this.showMoreTxt = 'show less';
          this.showMoreBool = false;
          this.textLimit = 100000;
        } else {
          this.showMoreTxt = 'show more';
          this.showMoreBool = true;
          this.textLimit = 400;
        }
      },
      getTeachersAvailability(res){
        if (typeof res !== 'undefined') {
          this.calendarOptions.events = res.data[0];
        }
      },
      selectFileUploadImg(event){
        this.dataImage.photo = event.target.files[0];
        const data = new FormData();
        data.append('photo', this.dataImage.photo);
        const json = JSON.stringify({
            description: 'teachers',
            type: 'picture',
            teachers_id: this.user_id,
        });
        data.append('data', json);
        axios.post(process.env.MIX_BASE_URL+"/api/upload-img", data).then((res) => {
          this.defaultImg = this.baseurl + '/public/images/profile/teachers/thumb/' + res.data.imagename;
        });
      },
    },
    mounted() {
      api.getTeachersSched({ 'teachers_id' : this.teachersId }, this.getTeachersAvailability);
      this.fetTeachersData();
      this.getTeachersAvailability();
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

.price-txt{
  line-height: 1em;
  vertical-align: middle;
  margin: auto;
}

</style>