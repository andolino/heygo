<template>
  <div>
    <div class="container">
    <table class="table font-12">
      <thead class="bg-warning">
        <tr>
          <th scope="col">Sunday</th>
          <th scope="col">Monday</th>
          <th scope="col">Tuesday</th>
          <th scope="col">Wednesday</th>
          <th scope="col">Thursday</th>
          <th scope="col">Friday</th>
          <th scope="col">Saturday</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="v in teachersSchedule" :key="v.id">
          <td>{{ moment(v.d_week).format('dddd') == 'Sunday' ? getSdEd(v.l_date) : '--' }}</td>
          <td>{{ moment(v.d_week).format('dddd') == 'Monday' ? getSdEd(v.l_date) : '--' }}</td>
          <td>{{ moment(v.d_week).format('dddd') == 'Tuesday' ? getSdEd(v.l_date) : '--' }}</td>
          <td>{{ moment(v.d_week).format('dddd') == 'Wednesday' ? getSdEd(v.l_date) : '--' }}</td>
          <td>{{ moment(v.d_week).format('dddd') == 'Thursday' ? getSdEd(v.l_date) : '--' }}</td>
          <td>{{ moment(v.d_week).format('dddd') == 'Friday' ? getSdEd(v.l_date) : '--' }}</td>
          <td>{{ moment(v.d_week).format('dddd') == 'Saturday' ? getSdEd(v.l_date) : '--' }}</td>
        </tr>
      </tbody>
    </table>
        <!-- <div class="col-schd-1" v-for="v in teachersSchedule" :key="v.id"> -->
          <!-- <span></span> -->
          <!-- {{ v.d_week }} -->
        <!-- </div> -->
        <!-- <div class="col-schd-1">
          Monday 1
        </div>
        <div class="col-schd-1">
          Tuesday 1
        </div>
        <div class="col-schd-1">
          Wednesday 1
        </div>
        <div class="col-schd-1">
          Thursday 1
        </div>
        <div class="col-schd-1">
          Friday 1
        </div>
        <div class="col-schd-1">
          Saturday 1
        </div> -->
    </div>
  </div>
</template>

<script>
  import moment from 'moment';
  export default {
    props: {

    },
    name: 'TeacherSchedule',
    data(){
      return{
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
        asset: document.querySelector('meta[name="url-asset"]').getAttribute('content'),
        user_id: document.querySelector('meta[name="user-id"]').getAttribute('content'),
        slide: 0,
        sliding: null,
        teachersSchedule: '',
        moment: moment
      }
    },
    methods: {
      getTeacherSchedule(){
        axios.post(process.env.MIX_BASE_URL+'/get-teacher-schedule', { 'teachers_id' : this.user_id } ).then((res) => {
          // this.calendarOptions.events = res.data[0];
          // this.$refs.calendar.$emit('rerenderEvents');
          this.teachersSchedule = res.data;
          console.log(res.data);
          }).catch((error) => {
            console.log(error);
        });
      },
      getSdEd(date){
        let d = date.split(',')[0];
        let sd = moment(d).format('LT');
        return sd;
      }
      
    },
    mounted() {
      this.getTeacherSchedule();
    }
  }
</script>

<style>
/* .container-sched {
  overflow-x: scroll;
} */

div.container-sched {
  background-color: rgb(243, 225, 144);
  overflow: auto;
  white-space: nowrap;
}

div.container-sched .col-schd-1 {
  display: inline-block;
  color: rgb(27, 27, 27);
  text-align: center;
  padding: 10px;
  text-decoration: none;
  font-size: 12px;
}

/* div.container-sched div {
  background-color: #777;
} */
/* @media (min-width: 768px){
  .seven-cols .col-md-1,
  .seven-cols .col-sm-1,
  .seven-cols .col-lg-1  {
    max-width: 100% !important;
    width: 100%;
    *width: 100%;
  }

}

@media (min-width: 992px) {
  .seven-cols .col-md-1,
  .seven-cols .col-sm-1,
  .seven-cols .col-lg-1 {
    max-width: 100% !important;
    width: 14.285714285714285714285714285714%;
    *width: 14.285714285714285714285714285714%;
  }
} */

/**
 *  The following is not really needed in this case
 *  Only to demonstrate the usage of @media for large screens
 */    
/* @media (min-width: 1200px) {
  .seven-cols .col-md-1,
  .seven-cols .col-sm-1,
  .seven-cols .col-lg-1 {
    max-width: 100% !important;
    width: 14.285714285714285714285714285714%;
    *width: 14.285714285714285714285714285714%;
  }
} */
</style>