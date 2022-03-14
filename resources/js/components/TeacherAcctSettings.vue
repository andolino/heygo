<template>
  <div>
    <form @submit.prevent="submitTeachersAcctSettings">
      <div class="row mt-5">
        <div class="col-lg-7 m-auto">
          <div class="">
            <label for="" class="text-left w-100">Email</label>
            <div class="form-group input-group mb-0">
                <input 
                  type="text" 
                  v-model="form.email" 
                  :class="{'is-invalid' : form.errors.has('email')}" 
                  class="form-control text-center input-custom font-14 mb-3" 
                  id="email" 
                  name="email">
            </div>
            <p class="text-danger text-center" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></p>
            <label for="" class="text-left w-100">Account Type</label>
            <div class="form-group input-group mb-0">
                  <select name="account_type" 
                          id="account_type" 
                          :class="[{'is-invalid' : form.errors.has('account_type')}, selectCountryClass]" 
                          v-model="form.account_type" 
                          :required="true">
                          <option 
                            :value="t.id"
                            v-for="(t, i) in countries" 
                            :key="i">{{ t.country_name }}</option>
                  </select>
            </div>
            <p class="text-danger text-center" v-if="form.errors.has('account_type')" v-text="form.errors.get('account_type')"></p>
            <button 
              type="button" 
              class="btn btn-default font-14 float-right text-center btn-cust-radius pr-4 pl-4 mt-4 mb-4" 
              @click.stop="toggleModal('forgotpassword')">Reset Password</button>
            <button type="submit" class="btn btn-default font-14 float-right text-center btn-cust-radius pr-4 pl-4 mt-4 mb-4 mr-2">Okay</button>
          </div>
        </div>
        <div class="col-lg-5 offset-lg-6">
            
        </div>
      </div>
    </form>


    <div>
      <!-- v-for="user in users" :key="user.id" -->
        <div>
            <reset-password-modal
                :show="showModal('forgotpassword')" 
                @close="toggleModal('forgotpassword')" />
            <!-- <a class="text-sm" href="#" @click.stop="toggleModal(1)">Show</a> -->
        </div>
    </div>


  </div>
  
</template>

<script>
    import ResetPasswordModal from '../Display/Modal/AccountSettings/ResetPasswordModal.vue'

    export default {
      name: "TeacherAcctSettings",
      components:{ ResetPasswordModal },
      props: [ 'base_url' ],
			data(){
				return{
          // selected: 'Selected Country',
          selectCountryClass: 'w-100 input-custom font-14 pb-2 pr-2 pt-2 mb-3',
          countries: [],
          teachersData: [],
          lessonTypeRate: [],
          lessonPlan: [],
          currencyRate: [],
					form: new Form({
            firstname: '',
            lastname: '',
            contact_no: '',
            rate_per_hr: '',
            country_id: '',
            email: '',
            lesson_plan_id: '',
            lesson_rate_type_id: '',
            objective_title: '',
            objective_text: '',
            currency_rate_id: ''
					}),
          csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
          asset: document.querySelector('meta[name="url-asset"]').getAttribute('content'),
          user_id: document.querySelector('meta[name="user-id"]').getAttribute('content'),
          dataImage: {
            photo: null,
            description: ''
          },
          dataVideo: {
            video: null,
            description: ''
          },
          defaultImg: document.querySelector('meta[name="url-asset"]').getAttribute('content') + 'images/ellipse-4.png',
          vp_selected: 'radio1',
          options: [
            { text: 'Display Picture', value: '0' },
            { text: 'Diplay Video', value: '1' }
          ],
          // defaultVid: document.querySelector('meta[name="url-asset"]').getAttribute('content') + 'images/ellipse-4.png',


          activeModal: 0,
				}
			},
			methods: {
        getCountries(){
          axios.get(process.env.MIX_BASE_URL+'/get-countries', {}).then((res) => {
            this.countries = res.data;
            
          }).catch((error) => {});
        },
        getLessonTypeRate(){
          axios.get(process.env.MIX_BASE_URL+'/get-lesson-type-rate', { 'user_id': this.user_id }).then((res) => {
            this.lessonTypeRate = res.data;
          }).catch((error) => {});
        },
        getLessonPlan(){
          axios.get(process.env.MIX_BASE_URL+'/get-lesson-plan', { 'user_id': this.user_id }).then((res) => {
            this.lessonPlan = res.data;
          }).catch((error) => {});
        },
        getCurrencyRate(){
          axios.get(process.env.MIX_BASE_URL+'/get-curreny-rate', { 'user_id': this.user_id }).then((res) => {
            this.currencyRate = res.data;
          }).catch((error) => {});
        },
        getTeachersData(){
          axios.post(process.env.MIX_BASE_URL+'/get-teachers-details', { 'user_id': this.user_id }).then((res) => {
            this.form.firstname = res.data[0].firstname;
            this.form.lastname = res.data[0].lastname;
            this.form.contact_no = res.data[0].contact_no;
            this.form.rate_per_hr = res.data[0].rate_per_hr;
            this.form.country_id = res.data[0].country_id;
            this.form.email = res.data[0].email;
            this.form.lesson_plan_id = res.data[0].lesson_plan_id;
            this.form.lesson_rate_type_id = res.data[0].lesson_rate_type_id;
            this.form.currency_rate_id = res.data[0].currency_rate_id;
            this.form.objective_title = res.data[0].objective_title;
            this.form.objective_text = res.data[0].objective_text;
            if (res.data[0].picture != null) {
              this.defaultImg = this.baseurl + '/public/images/profile/teachers/thumb/' + res.data[0].picture;
            }
            // this.defaultVid = this.baseurl + '/public/videos/teachers/' + res.data[0].video;
            this.$refs.videoRef.src = this.baseurl + '/public/videos/teachers/' + res.data[0].video; //"http://iandevlin.github.io/mdn/video-player/video/tears-of-steel-battle-clip-medium.mp4",
            this.$refs.videoRef.play();
          }).catch((error) => {});
        },
				submitTeachersAcctSettings(){
					let data = new FormData();
					data.append('firstname', this.form.firstname);
					data.append('lastname', this.form.lastname);
					data.append('contact_no', this.form.contact_no);
					data.append('rate_per_hr', this.form.rate_per_hr);
					data.append('country_id', this.form.country_id);
					data.append('email', this.form.email);
					data.append('lesson_plan_id', this.form.lesson_plan_id);
					data.append('lesson_rate_type_id', this.form.lesson_rate_type_id);
					data.append('currency_rate_id', this.form.currency_rate_id);
					data.append('objective_title', this.form.objective_title);
					data.append('objective_text', this.form.objective_text);
					data.append('user_id', this.user_id);
					data.append('_token', this.csrf);
					axios.post(process.env.MIX_BASE_URL+'/update-teacher-settings', data).then((res) => {
            if (typeof res.data.errors === 'undefined') {
              window.location.reload();
            }
					}).catch((error) => {
            console.log(error);
						this.form.errors.record(error.response.data.errors);
					});
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
        selectFileUploadVid(event){
          this.dataVideo.video = event.target.files[0];
          const data = new FormData();
          data.append('video', this.dataVideo.video);
          const json = JSON.stringify({
              description: 'teachers',
              type: 'video',
              teachers_id: this.user_id,
          });
          data.append('data', json);
          axios.post(process.env.MIX_BASE_URL+"/api/upload-img", data).then((res) => {
            // this.defaultVid = this.baseurl + '/public/videos/teachers/' + res.data.videoname;
            this.$refs.videoRef.src = this.baseurl + '/public/videos/teachers/' + res.data.videoname;
          });
        },
        setDisplayTeacher(){
          axios.post(process.env.MIX_BASE_URL+"/update-default-dp", { 'display_status' : this.vp_selected }).then((res) => {});
        },

        showModal: function(id) {
          return this.activeModal === id 
        },
        toggleModal: function (id) {
          if(this.activeModal !== 0) {
              this.activeModal = 0
              return false
          }
          this.activeModal = id
        }
			},
			mounted() { 
        this.getCountries();
        this.getLessonTypeRate();
        this.getLessonPlan();
        this.getTeachersData();
        this.getCurrencyRate();
        // var elem = document.querySelector('input[type="range"]');
        // var rangeValue = function(){
        //   var newValue = elem.value;
        //   var target = document.querySelector('.value');
        //   target.innerHTML = newValue;
        // }
        // elem.addEventListener("input", rangeValue);
        
      },
	  }
</script>



<style>
  .value {
    border-bottom: 4px dashed #bdc3c7;
    text-align: center;
    font-weight: bold;
    font-size: 20px;
    width: 174px;
    height: 35px;
    margin: -4px auto;
    letter-spacing: -.07em;
    text-shadow: white 2px 2px 2px;
  }
  input[type="range"] {
    display: block;
    -webkit-appearance: none;
    background-color: #bdc3c7;
    width: 174px;
    height: 5px;
    border-radius: 5px;
    margin: 0 auto;
    outline: 0;
  }
  input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    background-color: #e74c3c;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 2px solid white;
    cursor: pointer;
    transition: .3s ease-in-out;
  }​
  input[type="range"]::-webkit-slider-thumb:hover {
    background-color: white;
    border: 2px solid #e74c3c;
  }
  input[type="range"]::-webkit-slider-thumb:active {
    transform: scale(1.6);
  }

  /* checkbox switch */
  .switch {
    position: relative;
    display: inline-block;
    width: 90px;
    height: 34px;
  }

  .switch input {display:none;}

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ca2222;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 8px;
    bottom: 6px;
    background-color: white;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: #2ab934;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(55px);
    -ms-transform: translateX(55px);
    transform: translateX(55px);
  }

  /*------ ADDED CSS ---------*/
  .on
  {
    display: none;
  }

  .on, .off
  {
    color: white;
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    font-size: 10px;
    font-family: Verdana, sans-serif;
  }

  input:checked+ .slider .on
  {display: none;}

  input:checked + .slider .off
  {display: block;}

  /*--------- END --------*/

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;}

  .row.up-trial-ctrl {
    background: #eaeaea;
    margin: 20px;
    border-radius: 19px;
    text-align: left;
  }

  .vid-container {
    position: relative;
    width: 100%;
    max-width: 400px;
  }

  .vid-container .image {
    display: block;
    width: 100%;
    height: auto;
  }

  .vid-container .overlay {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    width: 100%;
    opacity: 0;
    transition: .3s ease;
    background-color: rgba(217, 160, 25, 0.33);
    margin: auto;
    /* border-radius: 93px; */
  }

  .vid-container .overlay a {
    color: #f0f0f0;
  }

  .vid-container:hover .overlay {
    opacity: 1;
  }

  .vid-container .row {
    color: white;
    font-size: 100px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
    font-size: 29px;
  }

  .fa-upload:hover {
    color: #eee;
  }

  .img-card {
    padding: 21px;
    margin: 29px;
    margin-top: 29px;
    margin-top: 0;
    border: solid 0.5px #ccc;
    border-radius: 13px;
  }




  .img-container {
    position: relative;
    width: 100%;
    max-width: 400px;
  }

  .img-container .image{
    display: block;
    width: 100%;
    height: auto;
  }

  .img-container .overlay {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    width: 73%;
    opacity: 0;
    transition: .3s ease;
    background-color: rgba(79, 73, 73, 0.7);
    margin: auto;
    border-radius: 93px;
  }

  .img-container .overlay a {
    color: #f0f0f0;
  }

  .img-container:hover .overlay {
    opacity: 1;
  }

  .img-container .icon{
    color: white;
    font-size: 100px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
    font-size: 29px;
  }


</style>