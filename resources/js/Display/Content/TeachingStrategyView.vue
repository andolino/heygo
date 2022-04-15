<template>
  <div>
    <div>
      <b-card v-for="ld in lpSData" :key="ld.id">
        <b-button variant="outline-warning" size="sm" class="float-right rounded-0"><i class="fas fa-flag"></i> Report</b-button>
        <b-button variant="outline-default" size="sm" class="float-right rounded-0 mr-1" v-on:click="editStrategyLesson(ld.id)" v-if="ld.teachers_id == ratingsData.user_id"><i class="fas fa-edit"></i> Edit</b-button>
        <h3>{{ ld.title }}</h3>
        <b-card-text class="text-muted">{{ld.lesson_type}}</b-card-text>
        <b-row class="mb-3">
          <b-col class="font-14">
            <span>Ratings &nbsp;</span>
            <i class="fas fa-star font-11 text-warning" v-for="d in $helpers.fnCompRate(ld.sum_rate, ld.count_rate)" :key="d"></i>
          </b-col>
          <b-col cols="2" class="font-14 pr-0">
            <b-button variant="outline-dark" size="sm" class="float-right w-100 rounded-0" v-b-modal.modal-center><i class="fas fa-star font-11"></i> Rate </b-button>
          </b-col>
          <b-col cols="2" class="font-14 pl-1">
            <b-button variant="outline-warning" size="sm" class="float-right w-100 rounded-0" :class="{ 'active': ratingsData.isBooked }" v-on:click="bookmarkThis"><i class="fas fa-bookmark"></i> Bookmark </b-button> 
          </b-col>
        </b-row>
        <b-card-text>Categories</b-card-text>
        <b-card-text>
          <b-badge variant="info" class="mr-1" size="md" v-for="d in category_display" :key="d">{{ d }}</b-badge>
        </b-card-text>
        <b-card-text>Description</b-card-text>
        <b-card-text>
          {{ ld.description }}
        </b-card-text>
        <b-card-text>Videos</b-card-text>
        <b-card-text>
          <video-embed :src="ld.videos"></video-embed>
        </b-card-text>
        <b-card-text>Materials</b-card-text>
        <b-card-text>
          <a :href="ld.materials" target="_blank">{{ ld.materials }}</a>
        </b-card-text>
        <b-card-text>A second paragraph of text in the card.</b-card-text>
        <a href="#" class="card-link font-12">Like</a>
        <b-link href="#" class="card-link font-12">Comments</b-link>
      </b-card>
    </div>

    <div>
      <b-row>
        <b-col>
          <b-card>
            <b-form-textarea
              id="textarea"
              placeholder="Enter comment..."
              rows="3"
              max-rows="6"
              class="mb-2"
            ></b-form-textarea>
            <b-button variant="outline-warning" class="float-right" size="sm">Submit</b-button>
          </b-card>
        </b-col>
      </b-row>
    </div>


    <b-modal id="modal-center" title="" hide-footer>
      <div class="wrapper text-center">
        <div v-if="successRate">
          <h4>Thank you!</h4>
        </div>
        <div v-else>
          <h4>Rate it!</h4>
          <input type="checkbox" id="st5" value="5" />
          <label v-on:click="clickStar('st5')" for="st5"></label>
          <input type="checkbox" id="st4" value="4" />
          <label v-on:click="clickStar('st4')" for="st4"></label>
          <input type="checkbox" id="st3" value="3" />
          <label v-on:click="clickStar('st3')" for="st3"></label>
          <input type="checkbox" id="st2" value="2" />
          <label v-on:click="clickStar('st2')" for="st2"></label>
          <input type="checkbox" id="st1" value="1" />
          <label v-on:click="clickStar('st1')" for="st1"></label>
        </div>
      </div>
      <b-button 
        variant="outline-dark" 
        size="sm" 
        class="float-right w-100 rounded-0" 
        v-on:click="submitFrm"
        v-if="successRate==false"
        v-b-modal.modal-center>Submit <i class="fas fa-paper-plane"></i></b-button>
    </b-modal>

  </div>
</template>

<script>
import * as api from '../api.js';
import moment from 'moment';

export default {
    name: 'TeachingStrategyView',
    props: {
      teaching_strategy_id : {
        type: Number,
        default: 0
      },
    },
    components: {},
    data() {
      return {
        lpSData: '',
        ratingsData: {
          user_type: document.querySelector('meta[name="user-type"]').getAttribute('content'),
          teaching_strategy_id: this.teaching_strategy_id,
          user_id: document.querySelector('meta[name="user-id"]').getAttribute('content'),
          ratings: 0,
          isBooked: false
        },
        successRate: false,
        category_display: '',
        moment: moment
      }
    },
    methods: {
      clickStar(fr){
        var r = parseInt(fr.slice(-1));
        for (let i = r; i <= 5; i++) {
          document.getElementById('st'+i).checked = false;
        }
        this.ratingsData.ratings = r;
      },
      submitFrm(){
        api.saveRatingsPerStratPlan(this.ratingsData);
        this.successRate=true;
        setTimeout(function(){
          window.location.reload();
        }, 1200)
      },
      viewCardPerStrat(data){
        var bookedId = data[0].bookmarked_by_teachers;
        var lessonCategory = data[0].lesson_category;
        var d = [];
        if (typeof bookedId === 'string') {
          d = bookedId.split(',');
        }
        this.lpSData = data;
        if (typeof lessonCategory === 'string') {
          this.category_display = lessonCategory.split(',');
        }
        // check if user id is in bookedmarked
        if (d.includes(this.ratingsData.user_id)) {
          this.ratingsData.isBooked = true;
        }
      },
      bookmarkThis(){
        this.ratingsData.isBooked = !this.ratingsData.isBooked;
        api.saveBookmark(this.ratingsData);
      },
      editStrategyLesson(id){
        this.$root.$refs.Stf.updateStrategyPlan(id);
      }
    },
    mounted(){
      api.getTeachingStrategyView(this.viewCardPerStrat, this.teaching_strategy_id);
    }
}
</script>

<style>
 .content {
    text-align: center;
  }
  .content h1 {
    font-family: 'Sansita', sans-serif;
    letter-spacing: 1px;
    font-size: 50px;
    color: #282828;
    margin-bottom: 10px;
  }
  .content  i {
    color: #FFC107;
  }
  .content span {
    position: relative;
    display: inline-block;
  }
  .content  span:before, .content  span:after {
    position: absolute;
    content: "";
    background-color: #282828;
    width: 40px;
    height: 2px;
    top: 40%;
  }
  .content  span:before {
    left: -45px;
  }
  .content  span:after {
    right: -45px;
  }
  .content p {
    font-family: 'Open Sans', sans-serif;
    font-size: 18px;
    letter-spacing: 1px;
  }
  .wrapper {
    position: relative;
    display: inline-block;
    border: none;
    font-size: 14px;
    margin: 50px auto;
    left: 50%;
    transform: translateX(-50%);
  }

  .wrapper input {
    border: 0;
    width: 1px;
    height: 1px;
    overflow: hidden;
    position: absolute !important;
    clip: rect(1px 1px 1px 1px);
    clip: rect(1px, 1px, 1px, 1px);
    opacity: 0;
  }

  .wrapper label {
    position: relative;
    float: right;
    color: #C8C8C8;
  }

  .wrapper label:before {
    margin: 5px;
    content: "\f005";
    font-family: "Font Awesome 5 Free";
    display: inline-block;
    font-size: 1.5em;
    color: #ccc;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    font-weight: 900;
  }

  .wrapper input:checked ~ label:before {
    color: #FFC107;
  }

  .wrapper label:hover ~ label:before {
    color: #ffdb70;
  }

  .wrapper label:hover:before {
    color: #FFC107;
  }





</style>