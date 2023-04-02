<template>
  <div>
    <label class="typo__label">Search by Category</label>
    <multiselect v-model="form.value_category" 
                  :options="option_category" 
                  :multiple="true" 
                  group-values="libs" 
                  group-label="language" 
                  :group-select="true" 
                  placeholder="Type to search" 
                  track-by="name" 
                  label="name"
                  class="mb-3 h-100"
                  @input="assignFilterData">
    <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
    </multiselect>
  </div>
</template>

<script>

import * as api from '../api.js';
import Multiselect from 'vue-multiselect'

export default {
    name: 'StrategyFilter',
    components: {
      Multiselect,
    },
    data() {
      return {
        form: {
          value_category: ''
        },
        option_category: [],
      }
    },
    methods: {
      getLessonPlanfn(data){
        this.option_category = data;
      },
      addTag (newTag) {
        const tag = {
          name: newTag,
          code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
        }
        this.option_category.push(tag)
      },
      getFilteredCategory(){
        return this.form.value_category;
      },
      assignFilterData(){
        this.$root.$refs.Stf.dispatchFilterCategory(this.form.value_category);
      }
    },
    mounted(){
      api.getLessonCategory(this.getLessonPlanfn);
    }
}
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
 #mCSB_2_container{
   height: 100%;
 }
</style>