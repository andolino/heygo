<template>
  <div>
    <div class="card-group b-bot-yellow mb-2" v-for="dsl in dataStrategyList" :key="dsl.id">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title font-16">{{ dsl.title }}</h5>
          <p class="card-text font-12 text-muted">{{ $helpers.limitText(dsl.description)}}</p>
        </div>
        <div class="card-footer">
          <small class="text-muted">Last updated {{moment(dsl.created_at, "YYYYMMDD h:mm:ss a").fromNow()}}</small>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as api from '../../components/backend/api.js';
import TeachingStrategyForm from './TeachingStrategyForm.vue';
import TeachingStrategyView from './TeachingStrategyView.vue';
import moment from 'moment';

export default {
    name: 'TeachingStrategiesCard',
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
        moment: moment
      }
    },
    methods: {
      viewStrategyPlan(id){
        this.viewPanel.id = id; 
        this.showFrmAddStrat=4;
      },
      fetchTeachingStrategy(data){
        this.dataStrategyList=data;
        console.log(data, ' dataStrategyList');
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