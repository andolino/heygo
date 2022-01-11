<template>
  <div>
    <div class="row mb-2">
      <div class="col-lg-12 mb-3 inp-right-a-post">
        <div class="bg-light rounded-lg w-100 p-3" @click="showModalPost()">Create Your Post</div>
        <i class="fas fa-paper-plane cursor"></i>
      </div>
      <div class="col-lg-12 float-left mb-1">
        <button type="button" class="btn rounded-3 btn-md btn-default rounded-pill font-14">All</button>
        <button type="button" class="btn rounded-3 btn-md btn-default rounded-pill font-14">Students</button>
        <button type="button" class="btn rounded-3 btn-md btn-default rounded-pill font-14">Teachers</button>
      </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modalWriteAPost" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title text-center w-100 ml-5" id="exampleModalLabel"><strong>Create Your Post!</strong></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <ul class="nav nav-tabs border-0 justify-content-center font-12" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link border-0 active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Post a Question</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link border-0" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Post a Lesson Plan</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <form>
                  <div class="form-group mt-3">
                    <textarea :class="{ errbox: isActive }"  v-model="post_msg" class="form-control font-14" rows="6" id="message-post" placeholder="Create you question"></textarea>
                  </div>
                  <span  :class="{ alert: isActive, 'alert-danger': isActive }"> {{ validationfail}}</span>
                </form>
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <!-- <div class="m-auto">
                  <p class="text-center">
                    <a href="" class="text-warning font-12">Post a Question</a> &nbsp; <a href="" class="text-dark font-12">Post a Lesson Plan</a>
                  </p>
                </div> -->
                <vue-dropzone 
                  ref="myVueDropzone" 
                  id="dropzone" 
                  :options="dropzoneOptions"
                  @vdropzone-complete="afterUploadComplete"
                  @vdropzone-sending-multiple="sendTeacherFeeds"></vue-dropzone>
                <form>
                  <div class="form-group mt-3">
                    <textarea :class="{ errbox: isActive }" v-model="post_msg" class="form-control font-14" rows="6" id="message-post" placeholder="Create you post"></textarea>
                  </div>
                  <span :class="{ alert: isActive, 'alert-danger': isActive }"> {{ validationfail}}</span>
                </form>
              </div>
            </div>


            
          </div>
          <div class="modal-footer">
            <div class="row mr-auto text-light post-feed-icon">
              <div class="col-lg-1 mr-2"><a href="" class="text-light"><i class="fas fa-paperclip"></i></a></div>
              <div class="col-lg-1"><a href="" class="text-light"><i class="fas fa-camera"></i></a></div>
            </div>
            <button type="button" @click="postTeacherFeed" class="btn btn-default mb-3 font-14">Post</button>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-3 cursor" v-for="pfd in postedFeedsData" :key="pfd.id">
      <div class="card rounded-11px">
        <div class="card-body mt-1" @click="goToProfile(pfd.id)">
          <div class="row">
            <div class="col-lg-2 text-center mt-3 pr-1">
              <img :src="asset + 'images/ellipse-1.png'" alt="">
            </div>
            <div class="col-lg-10">
              <div class="cicle-active"></div>
              <div class="row">
                <div class="col-lg-7">
                  <span class="ml-3 font-14"> 
                   {{ pfd.lastname.toUpperCase() }}, {{ pfd.firstname.toUpperCase() }}</span>
                </div>
                <div class="col-lg-5">
                  <span class="ml-3 font-14" style="float: right;">
                    {{ moment(new Date(pfd.created_at)).format('LLL') }}
                  </span>
                </div>
              </div>
              <hr>
              <!-- <span class="ml-3">
                43 Reviews 
                <i class="fas fa-heart" style="color: rgb(217, 22, 132);"></i></span> -->
              <div class="row">
                <div class="col-lg-9">
                  {{ pfd.feed_body }}
                </div>
              </div>
              <div class="row">
                <div class="col-lg-7">
                  <!-- {{ displayAttachments(pfd.attmnts) }} -->
                  <!-- <div class="row">
                    <div class="col-lg-4" v-for="(item, index) in dataAttachments" :key="index">
                      <a :href="baseurl + '/uploads/teachers-feeds/' + item" class="font-12 text-black-50"  download>Attachment {{ index + 1 }}</a>
                    </div>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <div class="card-footer">
          <div class="row cont-count-feeds">
            <div class="col-lg-4 text-center font-weight-normal pr-1 count-feeds-like">
              <span class="font-12 cursor" :class="{ 'text-primary' : pfd.is_like }" data-loc="like-question" :data-id="pfd.id" v-on:click="likeCmnt"><i class="fas fa-thumbs-up"></i> Like</span>
            </div>
            <!-- <div class="col-lg-4 text-center font-weight-normal pr-1 count-feeds-comment">
              <span class="font-12 cursor"><i class="far fa-check-circle"></i> This helpfull me</span>
            </div> -->
            <div class="col-lg-4 offset-lg-4 text-center font-weight-normal pr-1 count-feeds-dislikes">
              <span class="font-12 cursor text-secondary" v-on:click="showComments(pfd.id)"><i class="fas fa-comment"></i> Show Answers</span>
            </div>
          </div>
          <hr>

          <div class="d-none" :id="'comments'+pfd.id">
            <div class="row"  v-for="cmnts in comments[pfd.id]" :key="cmnts.id">
              <div class="col-lg-1 pr-0">
                <img :src="asset + 'images/ellipse.png'" alt="" width="100%">
              </div>
              <div class="col-lg-8">
                <div class="rounded-cmnt-content font-12">
                  <div class="row mb-1">
                    <div class="col-lg-8 font-weight-bold text-secondary">{{ $helpers.capFirstLetter(cmnts.lastname) }}, {{ $helpers.capFirstLetter(cmnts.firstname) }}</div>
                    <div class="col-lg-4">
                      <div class="time-cmnt font-12 text-right">{{ moment(new Date(cmnts.created_at)).fromNow() }}</div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="msg-cmnt font-12">
                        {{ cmnts.comments }}
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="row mt-3">
                        <div class="col-lg-2 font-weight-normal pr-1 count-feeds-like">
                          <span class="font-12 cursor" :class="{ 'text-primary' : cmnts.is_like }" data-loc="like-comments" :data-id="cmnts.id" v-on:click="likeCmnt"><i class="fas fa-thumbs-up"></i> Like</span>
                        </div>
                        <div class="col-lg-4 font-weight-normal pr-1 count-feeds-comment">
                          <span class="font-12 cursor" :class="{ 'text-primary' : cmnts.usefull_like }" data-loc="usefull-comments" :data-id="cmnts.id" v-on:click="likeCmnt"><i class="far fa-check-circle"></i> This helpfull me</span>
                        </div>
                        <div class="col-lg-4 font-weight-normal pr-1 count-feeds-dislikes">
                          <span class="font-12 cursor"><i class="fas fa-comment"></i> Show Comments</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="rounded-sub-cmnt-content font-12" v-for="sb_cmnts in sub_comments[cmnts.id]" :key="sb_cmnts.id">
                  <div class="row">
                    <div class="col-lg-7 font-weight-bold text-secondary">{{ $helpers.capFirstLetter(sb_cmnts.lastname) }}, {{ $helpers.capFirstLetter(sb_cmnts.firstname) }}</div>
                    <div class="col-lg-5"><div class="time-cmnt font-12 text-right">{{ moment(new Date(sb_cmnts.created_at)).fromNow() }}</div></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      {{ sb_cmnts.comments }}
                    </div>
                  </div>
                </div>

                <div class="sub-comment-inpt">
                  <div class="row">
                    <div class="col-lg-12"></div>
                    <div class="col-lg-1 pr-0 offset-lg-2 pl-1 text-right">
                      <img :src="asset + 'images/ellipse.png'" alt="">
                    </div>
                    <div class="col-lg-8 text-right pr-0 count-feeds-like mb-3">
                      <input type="text" class="form-control form-control-sm rounded-pill font-12" data-loc="comment-comments-sub" :data-id="cmnts.id" v-on:keyup.enter="onEnterCmnts">
                    </div>
                    <div class="col-lg-1 text-left pr-1 pl-0 count-feeds-comment">
                      <a href="#" class="text-black-50"><img :src="baseurl+'/public/images/arrow-left-ico.png'" 
                                                              style="position: relative;
                                                                      right: 24px;
                                                                      top: 1px;" alt="" width="14"></a>
                    </div>
                  </div>
                </div>

              </div>
              

            </div>

            
          </div>


          <div class="row">
            <div class="col-lg-1 pl-1 text-right">
              <img :src="asset + 'images/ellipse.png'" alt="">
            </div>
            <div class="col-lg-10 text-right pl-1 pr-1 count-feeds-like">
              <input type="text" class="form-control form-control-lg rounded-pill font-12" data-loc="comment-comments" :data-id="pfd.id" v-on:keyup.enter="onEnterCmnts">
            </div>
            <div class="col-lg-1 text-left pr-1 count-feeds-comment">
              <a href="#" class="text-black-50"><img :src="baseurl+'/public/images/arrow-left-ico.png'" 
                                                      style="position: relative;
                                                      right: 56px;
                                                      font-size: 12px;
                                                      top: 5px;" alt="" width="18"></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    

  </div>
</template>

<script>
import moment from 'moment';
import vue2Dropzone from 'vue2-dropzone';
import axios from 'axios';
export default {
  name: 'TeacherFeeds',
  components: {
    vueDropzone: vue2Dropzone
  },
  // props: [ 'base_url' ],
  props: {
    feeds_id: ''
  },
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
      user_type: document.querySelector('meta[name="user-type"]').getAttribute('content'),
      dropzoneOptions: {
        url: document.querySelector('meta[name="base-url"]').getAttribute('content') + '/api/post-teacher-feeds', // 'https://httpbin.org/post',
        thumbnailWidth: 150,
        maxFilesize: 2,
        parallelUploads: 3,
        maxFiles: 10,
        uploadMultiple: true,
        addRemoveLinks: true,
        autoProcessQueue: false,
        thumbnailWidth: "100",
        thumbnailHeight: "100"
      },
      post_msg: '',
      postedFeedsData: '',
      comments: {
        type: Array,
        default: []
      },
      sub_comments: {
        type: Array,
        default: []
      },
      moment: moment,
      dataAttachments: {
        type: Array,
        default: [],
      },
      isActive : false,
      validationfail : ''
    }
  },

  methods: {
   

    showModalPost(){
      $('#modalWriteAPost').modal('show')
    },
    searchTeacher(){
      alert('oowa');
    },
    displayTeacherFeeds(){
      axios.post(process.env.MIX_BASE_URL+'/display-teacher-feeds', { 'teachers_id' : this.user_id, 'feeds_id' : this.feeds_id }).then((res) => {
          this.postedFeedsData = res.data.question;
          this.comments = res.data.comments;
          this.sub_comments = res.data.sub_comments;
        }).catch((error) => {
          console.log(error);
      });
    },
    afterUploadComplete: async function(response){
      if (response.status =="success") {
        
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Posted successfully',
          showConfirmButton: false,
          timer: 2000
        }).then((result) => {
          /* Read more about handling dismissals below */
          if (result.dismiss === Swal.DismissReason.timer) {
            window.location.reload();
          }
        });
      } else {
        Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: 'Upload failure',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    sendTeacherFeeds: async function (files, xhr, formData){
      formData.append('feed_body', this.post_msg);
      formData.append('teacher_id', this.user_id);
    },
    postTeacherFeed: async function(){
      if (typeof this.$refs.myVueDropzone.processQueue() === 'undefined') {
        axios.post(process.env.MIX_BASE_URL+'/api/post-teacher-feeds', 
            { 'feed_body': this.post_msg, 'teacher_id': this.user_id 
        }).then((res) => {

          if(res.data.validationfail){
            this.validationfail = res.data.validationfail;
           
            this.isActive = true;
            return false;
          }else{
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: res.data.message,
              showConfirmButton: false,
              timer: 2000
            }).then((result) => {
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
                // window.location.reload();
              }
            });
          }
          
        

          
        }).catch((error) => {
            console.log(error);
        });
      } else {
        this.$refs.myVueDropzone.processQueue();
      }
    },
    likeCmnt(e){
      // console.log();
      e.target.classList.toggle('text-primary');
      var type = e.target.getAttribute('data-loc');
      var feeds_id = e.target.getAttribute('data-id');
      axios.post(process.env.MIX_BASE_URL+'/api/post-likes', 
          { 'type' : type, 
            'feeds_id' : feeds_id, 
            'user_id' : this.user_id, 
            'is_students' : (this.user_type == 'teachers' ? 0 : 1),
            'is_like' : (e.target.classList.contains('text-primary') ? 1 : 0)
      }).then((res) => {
        
      }).catch((error) => {
          console.log(error);
      });
    },
    showComments(id){
      var el = document.getElementById('comments'+id);
      if (el.classList.contains("d-none")) {
        el.classList.remove('d-none');
      } else {
        el.classList.add('d-none');
      }
    },
    displayAttachments(f){
      if (typeof f !== 'object') {
        var arr = f.split('==');
        this.dataAttachments = arr; 
      }
    },
    onEnterCmnts(e){
      var cmnt = e.target.value;
      var feeds_id = e.target.getAttribute('data-id');
      var type = e.target.getAttribute('data-loc');
      axios.post(process.env.MIX_BASE_URL+'/api/post-comments', 
        { 
          'type' : type,
          'user_id' : this.user_id, 
          'comments' : cmnt,
          'feeds_id' : feeds_id,
          'is_students' : (this.user_type == 'teachers' ? 0 : 1),
      }).then((res) => {
        this.displayTeacherFeeds();
        e.target.value = '';
      }).catch((error) => {
          console.log(error);
      });
    },
    goToProfile(feeds_id){
      window.location.href = process.env.MIX_BASE_URL+'/profile-feeds/'+this.user_id+'/'+feeds_id;
    }
  },
  mounted() {
    this.displayTeacherFeeds();
  }
}
</script>

<style>
.modal-header {
    border-bottom: 0px !important;
    text-align: center;
}
.modal-footer {
    border-top: 0px !important;
}
.rounded-cmnt-content {
    padding: 15px;
    background: #f7f2e9;
    margin-bottom: 15px;
    border-left: 3px solid #fcb017;
    box-shadow: 2px 2px 0px 0px #eee;
}
.rounded-sub-cmnt-content {
    background: #f0f0f0;
    padding: 15px;
    float: right;
    width: 88%;
    margin-bottom: 13px;
    border-radius: 18px;
    box-shadow: 1px 1px 1px 0px #ddd;
}
.sub-comment-inpt {
    float: right;
    width: 88%;
    margin-bottom: 15px;
    border-radius: 18px;
    width: 89%;
}
.errbox{
  border: 2px solid red !important;
}
</style>