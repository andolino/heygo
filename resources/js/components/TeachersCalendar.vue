<template>
  <div>
    <h5>Add Availability Date</h5>
    <b-card
      title=""
      img-top
      tag="article"
      style="font-size:14px;"
      class="mb-2"
    >
      <b-row class="w-100">
        <b-col>

          <!-- <b-row>
            <b-col>
              <label for="" class="font-12">Time Start</label>
              <datetime format="YYYY-MM-DD H:i:s" width="" v-model="form.time_start"></datetime>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <label for="" class="font-12" data-tooltip="test">Status</label>
              <b-form-select v-model="form.selected_status" class="rounded-0 font-12" :options="status_options" size="sm"></b-form-select>
            </b-col>
          </b-row> -->


          <b-row class="mb-2">
            <b-col>
              <b-card-text></b-card-text>
              <div v-if="addAvailDateTime">
                <!-- <b-button href="#" @click="saveAddTeacherAvailability" variant="default" class="font-12">Add</b-button> -->
              </div>
              <div v-else>
                <b-button block variant="default" @click="modalShow = !modalShow">Apply this Time</b-button>
                <!-- <b-button href="#" variant="dark" class="font-12" @click="modalShow = !modalShow">Apply this Time</b-button> -->
                <!-- <b-button href="#" variant="default" class="font-12" @click="saveAddTeacherAvailability">Update</b-button>
                <b-button href="#" variant="default" class="font-12" @click="addAvailDateTime = !addAvailDateTime; form.teacher_availability_id = null">Cancel</b-button> -->
              </div>
            </b-col>
          </b-row>
          
          <b-row>
            <b-col>
              <div>
                <b-button block variant="default" @click="saveDistanceAvail">Set as Available</b-button>
                <b-button block variant="default" @click="unsetDistanceAvail">Set as Unavailable</b-button>
              </div>
            </b-col>
          </b-row>


        </b-col>
        <b-col cols="9">
          <label for=""></label>
          <Fullcalendar ref="calendar" :options="calendarOptions"/>
        </b-col>
      </b-row>
      <!-- <b-row>
        <b-col>
          <label for="" class="font-12">Type of Lesson</label>
          <select 
            class="custom-select custom-select-sm font-12 rounded-0" 
            id="lesson_plan_id"
            v-model="form.lesson_plan_id">
            <optgroup v-for="(group, name) in lessonPlan" :label="name" :key="group.id">
              <option v-for="option in group" :value="option.id" :key="option.id">
                {{ option.body }}
              </option>
            </optgroup>
          </select>
        </b-col>
      </b-row> -->
      <b-modal class="p-0" v-model="modalShow" size="sm" title="Apply time to date" @ok="handleOk" ok-only>
        <b-row>
          <b-col>
            <date-picker v-model="range" is-range />
          </b-col>
        </b-row>
      </b-modal>
    </b-card>
    <Toasts
			:show-progress="true"
			:rtl="false"
			:max-messages="5"
			:time-out="3000"
			:closeable="true"
		></Toasts>
  </div>
</template>

<script>
  import moment from 'moment';
  import Fullcalendar from "@fullcalendar/vue";
  import dayGridPlugin from "@fullcalendar/daygrid";
  import interactionPlugin from "@fullcalendar/interaction";
  import timeGridPlugin from "@fullcalendar/timegrid";
  import axios from "axios";
  import datetime from 'vuejs-datetimepicker';

  export default {
    props: {},
    components: {
      Fullcalendar, datetime
    },
    name: 'TeachersCalendar',
    data(){
      return {
        range: {
          start: '',
          end: '',
        },
        selectedDate: [],
        lessonPlan: [],
        form: {
          // lesson_plan_id: '',
          time_start: "",
          time_end: "",
          selected_status: null,
          teacher_availability_id: null,
          user_id: '',
        },
        modalShow: false,
        status_options: [
          { value: 0, text: 'Open' },
          { value: 3, text: 'Closed' }
        ],
        addAvailDateTime: true,
        calendarOptions: {
          plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin ],
          initialView: 'timeGridWeek',
          navLinks: true, // can click day/week names to navigate views
          // editable: true,
          selectable: true,
          nowIndicator: true,
          dayMaxEvents: true, // allow "more" link when too many events
          expandRows: true,
          contentHeight: '1900px',
          events: [
            {
              time_start: this.time_start,
              selected_date: this.selectedDate
            }
          ],
          // eventColor: '#fff',
          eventContent: function (arg, createElement){
            let ht = '';
                ht+='<div class="card" style="height:100%;" role="button">';
                  ht+='<div class="card-body pt-2 pr-2 pl-2 pb-2" style="font-size:12px;">';
                      ht+='<p class="m-0">Time: '+arg.timeText+'</p>';
                      ht+='<p class="text-muted m-0">Current Enrolled: '+0+'</p>';
                  ht+='</div>';
              ht+='</div>';
            arg.backgroundColor = 'rgba(0, 0, 0, 0)';
            arg.borderColor = 'rgba(0, 0, 0, 0)';
            arg.textColor = '#000';
            console.log(arg, ' arg')
            return { html: ht } 
          },
          eventClick: (calEvent, jsEvent, view) => {
            //if status is OPEN or ClOSED you can update your date availability
            if (calEvent.event.extendedProps.status == 0 || calEvent.event.extendedProps.status == 3) {
              this.addAvailDateTime = false;
              this.form.teacher_availability_id = calEvent.event.id;
              this.form.time_start = moment(calEvent.event.start).format('YYYY-MM-DD HH:mm:ss');
              this.form.time_end = moment(calEvent.event.end).format('YYYY-MM-DD HH:mm:ss');
              this.form.selected_status = calEvent.event.extendedProps.status;
              this.range.start = Date(2022, 0, 5)
            }
          },
          dateClick: function(info) {
            
            if(moment(info.date).isBefore(moment().toDate())) return false; // disable previous selection
           
            Swal.fire({
                title: 'Confirm',
                html: "Are you sure on this date? </br>" + moment(info.date).format('lll'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fcb017',
                cancelButtonColor: '#212222',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Wait'
              }).then((result) => {
                if (result.isConfirmed) {
                  axios.post(process.env.MIX_BASE_URL+'/save-teacher-availability', {
                    time_start : moment(info.date).format('YYYY-MM-DD h:mm:ss'),
                    user_id : document.querySelector('meta[name="user-id"]').getAttribute('content'),
                    selected_status : 0
                  } ).then((res) => {
                    window.location.reload(false);
                    }).catch((error) => {
                      console.log(error);
                  });
                } else {
                  
                }
              });
          },
          select: (info) => {
            const vm = [];
            var a = moment(info.startStr);
            var b = moment(info.endStr);
            // If you want an exclusive end date (half-open interval)
            for (var m = moment(a); m.isBefore(b); m.add(1, 'hours')) {
              vm.push(m.format('YYYY-MM-DD H:mm A'));
            }
            this.selected_date = vm
          }
        },
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
        asset: document.querySelector('meta[name="url-asset"]').getAttribute('content'),
        user_id: document.querySelector('meta[name="user-id"]').getAttribute('content')
      }
    },
    methods: {
      handleOk(){

        Swal.fire({
          title: 'Are you sure?',
          text: "",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#fcb017',
          cancelButtonColor: '#212222',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            const start = moment(this.range.start).format('YYYY-MM-DD');
            const end   = moment(this.range.end).format('YYYY-MM-DD');
            const user_id = document.querySelector('meta[name="user-id"]').getAttribute('content');
            axios.post(process.env.MIX_BASE_URL+'/save-time-to-date', {
              start, 
              end,
              user_id,
              time: this.form.time_start
            }).then((res) => {
              this.$toast.success('Schedule is already Updated!');
            }).catch((error) => {
                console.log(error);
            });
          } else {
            
          }
        });

        
      },
      getTeachersAvailability(){
        axios.get(process.env.MIX_BASE_URL+'/get-teachers-availability', { 'teachers_id' : this.user_id }).then((res) => {
            this.calendarOptions.events = res.data[0];
          }).catch((error) => {
            console.log(error);
        });
      },
      getLessonPlan(){
        axios.get(process.env.MIX_BASE_URL+'/get-lesson-plan', { 'user_id': this.user_id }).then((res) => {
          this.lessonPlan = res.data;
        }).catch((error) => {});
      },
      assignStartData(start_date){
        this.form.time_start = start_date;
      },
      saveAddTeacherAvailability(){

        Swal.fire({
          title: 'Adding this to your availability?',
          text: "",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#fcb017',
          cancelButtonColor: '#212222',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post(process.env.MIX_BASE_URL+'/save-teacher-availability', this.form ).then((res) => {
              // console.log(res);
              this.calendarOptions.events = res.data[0];
              console.log(res);
              // this.$refs.calendar.$emit('rerenderEvents');
              }).catch((error) => {
                console.log(error);
            });
          } else {
            
          }
        });
      },
      saveDistanceAvail(){
        // this.selected_date
        Swal.fire({
          title: 'Adding this to your availability?',
          text: "",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#fcb017',
          cancelButtonColor: '#212222',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post(process.env.MIX_BASE_URL+'/save-batch-time-avail', {selected_date: this.selected_date, data: this.form} ).then((res) => {
              window.location.reload();
            }).catch((error) => {
                console.log(error);
            });
          } else {
            
          }
        });
      },
      unsetDistanceAvail(){
        Swal.fire({
          title: 'Removing this to your availability?',
          text: "",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#fcb017',
          cancelButtonColor: '#212222',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post(process.env.MIX_BASE_URL+'/unset-batch-time-avail', {selected_date: this.form.time_start, data: this.form} ).then((res) => {
              window.location.reload();
            }).catch((error) => {
                console.log(error);
            });
          } else {
            
          }
        });
      }
    },
    mounted(){
      var self = this;
      this.form.user_id = this.user_id;
      this.getLessonPlan();
      this.getTeachersAvailability();
    }
  }
</script>


<style>
  .year-month-wrapper {
    background: #fcb017 !important;
  }
  .month-setter > .nav-r, .month-setter > .nav-l {
    background: #fcb017 !important;
  }
  .activePort {
    background: #fcb017 !important;
  }
  .scroll-hider ul {
    width: 62px !important;
  }
  .scroll-hider li.active {
    background: #fcb017 !important;
  }
</style>