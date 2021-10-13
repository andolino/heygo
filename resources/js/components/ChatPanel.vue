<template>
  <div>
    <div class="w-100 justify-content-center align-items-center">
      <div class="row w-100 pl-2">
          <div class="cont-account-settings col-lg-12 m-auto custom-shadow p-0 background-none">
            <div class="head-upcoming-lesson bg-dark mb-0 pb-2 pt-3 pl-3">
                <h5 class="font-weight-regular">Start Your Conversation </h5>
            </div>
            <div class="row">
              <div class="col-lg-5 pr-0">
                <TeacherInformation :teachersId="teachersId" v-if="usertype == 'students'"/>
                <StudentInformation :studentsId="studentsId" v-else/>
              </div>
              <div class="col-lg-7 text-center pl-0">
                <div class="card rounded-0" style="border-bottom-right-radius: 10px !important;">
                  <div class="card-body chat-panel-dv">
                    
                    <!-- custom-scrollbar-css mCustomScrollbar data-mcs-theme="minimal-dark"-->
                    <div class="msg-convo h-89 pt-3 p-2" id="chat_scroller">
                      <div>
                        <div v-for="(msg, idx) in messages" :key="idx">
                          <div class="row msg-convo-right mb-2" v-if="msg.usertype == 'students' && msg.is_teacher == 0">
                            <div class="col-lg-8 offset-lg-2 pr-0">
                              <div class="msg-txt">
                                <h6 for="" class="font-12"><strong>{{ $helpers.capFirstLetter(msg.username) }} <span class="float-right">{{ msg.time }}</span></strong></h6>
                                {{ msg.msg }}
                              </div>
                            </div>
                            <div class="col-lg-2 pt-3 pr-3 pl-0">
                              <img :src="asset + 'images/ellipse-4.png'" width="40">
                            </div>
                          </div>
                          <div class="row msg-convo-right mb-2" v-else-if="msg.usertype == 'teachers' && msg.is_teacher == 1">
                            <div class="col-lg-8 offset-lg-2 pr-0">
                              <div class="msg-txt">
                                <h6 for="" class="font-12"><strong>{{ $helpers.capFirstLetter(msg.username) }} <span class="float-right">{{ msg.time }}</span></strong></h6>
                                {{ msg.msg }}
                              </div>
                            </div>
                            <div class="col-lg-2 pt-3 pr-3 pl-0">
                              <img :src="asset + 'images/ellipse-4.png'" width="40">
                            </div>
                          </div>
                          <div class="row msg-convo-left mb-2" v-else>
                            <div class="col-lg-2 pt-3 pl-3 pr-0">
                              <img :src="asset + 'images/ellipse-4.png'" width="40">
                            </div>
                            <div class="col-lg-8 pl-0">
                              <div class="msg-txt">
                                <h6 for="" class="font-12"><strong>{{ $helpers.capFirstLetter(msg.username) }} <span class="float-right">{{ msg.time }}</span></strong></h6>
                                {{ msg.msg }}
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- <div class="row msg-convo-right mb-2">
                          <div class="col-lg-8 offset-lg-2 pr-0">
                            <div class="msg-txt">
                              Lorem ipsum dolor, sit amet consectetolestiae! Porro asperiores rati
                              one voluptatem id aspernatur officia, non itaque, ut ipsum vero neque.
                              Lorem ipsum dolor, sit amet consectetolestiae! Porro asperiores rati
                              one voluptatem id aspernatur officia, non itaque, ut ipsum vero neque.
                            </div>
                          </div>
                          <div class="col-lg-2 pt-3 pr-3 pl-0">
                            <img :src="asset + 'images/ellipse-4.png'" width="40">
                          </div>
                        </div> -->
                      </div>
                    </div>
                    <div class="msg-input">
                      <form @submit.prevent="sendMessageStudents">
                        <textarea id="msg" 
                          name="password" v-model="message"
                          placeholder="Type Message Here" class="form-control input-custom font-14 mb-3"></textarea>
                          <img :src="asset + 'images/arrow-left-ico.png'" @click="sendMsg" class="ico-sent curso-pointer" width="20">
                          <b-button ref="submitSendMsg" class="d-none" type="submit">Submit</b-button>
                      </form>
                    </div>

                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

  </div>
</template>

<script>

import TeacherInformation from './TeacherInformation';
import StudentInformation from './StudentInformation';
// import {ref} from 'vue';
import Pusher from 'pusher-js';
import axios from 'axios';
import moment from 'moment';

export default {
  props: {
    teachersId: Number,
    studentsId: Number,
  },
  components: {
    TeacherInformation,
    StudentInformation,
  },
  name: 'ChatPanel',
  data(){
    return{
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
      asset: document.querySelector('meta[name="url-asset"]').getAttribute('content'),
      messages: [],
      message: '',
      usertype: document.querySelector('meta[name="user-type"]').getAttribute('content'),
      username: document.querySelector('meta[name="user-name"]').getAttribute('content'),
      user_id: document.querySelector('meta[name="user-id"]').getAttribute('content'),
    }
  },
  methods: {
    sendMsg(){
      this.$refs.submitSendMsg.click();
    },
    sendMessageStudents() {
      axios.post(process.env.MIX_BASE_URL+'/messages-'+this.usertype, {
        username: this.username,
        message: this.message,
        usertype: this.usertype,
        user_id : this.usertype == 'students' ? this.teachersId : this.studentsId,
        client_id: this.user_id,
        is_teacher: this.usertype == 'students' ? 0 : 1
      }).then((res)=>{
        this.scrollToEnd();
      }).catch((err)=>console.log(err));
      this.message = '';
    },
    fetchMessages(){
      axios.post(process.env.MIX_BASE_URL+'/get-conversation-'+this.usertype, { 
        usertype: this.usertype, 
        user_id: this.usertype == 'students' ? this.teachersId : this.studentsId 
      }).then((res)=>{
        this.messages = res.data[0];
        // console.log(res.data[0]);
      }).catch((err)=>console.log(err));
    },
    scrollToEnd() {    	
      var container = this.$el.querySelector("#chat_scroller");
      container.scrollTop = container.scrollHeight - container.clientHeight;
    }
  },
  mounted() {
    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var pusher = new Pusher('d1967d32adc2619d10fb', {
      cluster: 'ap1'
    });

    // var channel = pusher.subscribe('chat');
    var brod_chat = '';
    if (this.usertype == 'students') {
      brod_chat += this.user_id+'_'+this.teachersId;
    } else {
      brod_chat += this.studentsId+'_'+this.user_id;
    }
    var channel = pusher.subscribe('chat_'+brod_chat);
    channel.bind('message', data => {
      // alert(JSON.stringify(data));
      this.messages.push({
        usertype: this.usertype,
        username: data.username,
        msg: data.message,
        time: moment().format('HH:mm A'),
        client_id: this.user_id,
        is_teacher: data.usertype == 'students' ? 0 : 1
      });
      setTimeout(() => {
        var container = document.querySelector("#chat_scroller");
        container.scrollTop = container.scrollHeight - container.clientHeight;
      }, 1000);
    });
    this.fetchMessages();
    //scroll to bottom chat div
    setTimeout(() => {
      var container = document.querySelector("#chat_scroller");
      container.scrollTop = container.scrollHeight - container.clientHeight;
    }, 1000);
  }
}
</script>

<style>
.chat-panel-dv{
  height: 650px;
  max-height: 650px;
}
.msg-convo-left .msg-txt{
  font-size: 12px;
  text-align: left;
  padding: 12px;
  background: #ECE9E6;  /* fallback for old browsers */
  background: -webkit-linear-gradient(to top, #FFFFFF, #ECE9E6);  /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(to top, #FFFFFF, #ECE9E6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  border-radius: 9px;
}
.msg-convo-right .msg-txt{
  font-size: 12px;
  text-align: left;
  padding: 12px;
  background: #ffb347;  /* fallback for old browsers */
  background: -webkit-linear-gradient(to top, #ffcc33, #ffb347);  /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(to top, #ffcc33, #ffb347); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  border-radius: 9px;
  color: #fff;
}
.msg-input{
  height: 150px;
  padding-top: 9px;
}
.msg-input textarea {
  border-radius: 6px !important;
  resize: none;
  height: 60px !important;
  overflow:hidden !important;
}

.h-89{
  height: 89% !important;
}
.ico-sent {
  position: absolute;
  right: 36px;
  bottom: 37px;
  cursor: pointer;
}
#chat_scroller{
  overflow-y: scroll;
  overflow-x: hidden;
}
</style>