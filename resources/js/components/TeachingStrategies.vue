<template>
  <div>
    
    <b-container class="bv-example-row">
        <b-row>
          <b-col cols="3">
            <b-button variant="warning" class="font-12 w-100 mb-2 text-left btn-nav" v-on:click="fetchTeachingDashboard">All Lesson Plan</b-button>
            <b-button variant="warning" class="font-12 w-100 mb-2 text-left btn-nav" v-on:click="showFrmAddStrat = 3;">Create Lesson plan/Teaching strategy</b-button>
            <b-button variant="warning" class="font-12 w-100 mb-2 text-left btn-nav" v-on:click="fetchTeachingStrategyLobby">Bookmarks</b-button>

            <!-- <b-button variant="warning" class="font-12 w-100 mb-2">View Own Worksheet</b-button>
            <b-button variant="warning" class="font-12 w-100 mb-2">Booked Worksheet</b-button>
            <b-button variant="warning" class="font-12 w-100">Check Student's Workshee</b-button> -->
          </b-col>
          <b-col cols="9" v-if="showFrmAddStrat==3">
            <TeachingStrategyForm :edit_id="editId" />
          </b-col>
          <b-col cols="9" v-else-if="showFrmAddStrat==4">
            <TeachingStrategyView :teaching_strategy_id="viewPanel.id" @dashboard="backToDashboard" />
          </b-col>
          <b-col cols="9" v-else>
            <b-row>
              <b-col>
                <b-input-group
                  size="sm"
                  class="mb-3"
                >
                  <b-form-input placeholder="Advance search" class="font-12"></b-form-input>
                  <b-input-group-append>
                    <b-button size="sm" text="Button" class="font-12" variant="default">Search</b-button>
                  </b-input-group-append>
                </b-input-group>
              </b-col>
              <b-col cols="7"></b-col>
            </b-row>
            <b-row>
              
              
              <b-col cols="4" class="mb-3" v-for="dsl in dataStrategyList" :key="dsl.id">
                <b-card title="" sub-title="">
                  <label class="text-primary mb-2 cursor" v-on:click="viewStrategyPlan(dsl.id)">{{ dsl.title }}</label>
                  <b-row class="mb-1">
                    <b-col class="pr-0">
                      <b-card-sub-title class="mb-2 font-11"><span class="text-danger">{{ dsl.lesson_type }}</span></b-card-sub-title>
                    </b-col>
                    <b-col class="pl-0">
                      <b-card-sub-title class="mb-2 font-11 text-right">With Materials (Link)</b-card-sub-title>
                    </b-col>
                  </b-row>
                  <b-row>
                    <b-col>
                      <b-card-sub-title class="mb-2 font-11">{{ dsl.level }}</b-card-sub-title>
                    </b-col>
                  </b-row>
                  <b-row class="mb-2">
                    <b-col class="font-12">
                      {{ $helpers.limitText(dsl.description)}}
                    </b-col>
                  </b-row>
                  <b-row class="mb-0">
                    <b-col class="font-12">
                      <i class="fas fa-star font-11 text-warning" v-for="d in $helpers.fnCompRate(dsl.sum_rate, dsl.count_rate)" :key="d"></i>
                    </b-col>
                  </b-row>
                  <a href="#" class="card-link font-11 text-muted">Like</a>
                  <b-link href="#" class="card-link font-11 float-right text-muted">Comment</b-link>
                </b-card>
              </b-col>





            </b-row>
          </b-col>
        </b-row>
      </b-container>
  </div>
  
</template>

<script>
import * as api from './backend/api.js';
import TeachingStrategyForm from '../Display/Content/TeachingStrategyForm.vue';
import TeachingStrategyView from '../Display/Content/TeachingStrategyView.vue';

export default {
    name: 'TeachingStrategies',
    components: {
      TeachingStrategyForm,
      TeachingStrategyView
    },
    data() {
      return {
        showFrmAddStrat: 1,//1 = dashboard, 2 = Bookmarks, 3 = forms, 4 = viewing
        dataStrategyList: '',
        viewPanel: {
          id: ''
        },
        editId: 0,
      }
    },
    methods: {
      backToDashboard(v){
        this.showFrmAddStrat = v;
      },
      viewStrategyPlan(id){
        this.viewPanel.id = id; 
        this.showFrmAddStrat=4;
      },
      fetchTeachingStrategy(data){
        this.dataStrategyList=data;
      },
      fetchTeachingDashboard(){
        api.getTeachingStrategy(this.fetchTeachingStrategy);
        this.showFrmAddStrat = 1;
      },
      fetchTeachingStrategyLobby(){
        api.getTeachingStrategyBookmark(this.fetchTeachingStrategy);
        this.showFrmAddStrat = 1;
      },
      dispatchFilterCategory(data){
        api.getTeachingStrategy(this.fetchTeachingStrategy, {'filter': data});
        console.log(data)
      },
      updateStrategyPlan(id){
        this.editId=id;
        this.showFrmAddStrat = 3
      }
    },
    mounted(){
      api.getTeachingStrategy(this.fetchTeachingStrategy, {});
    },
    created(){
      this.$root.$refs.Stf = this;
    }
}
</script>

<style>
.btn-nav{
  color: #212529 !important;
  background-color: #fff !important;
  border-color: #fcb017 !important;
  border: 2px solid #ffc34b !important;
  padding: 14px !important;
  font-size: 14px !important;
}
</style>