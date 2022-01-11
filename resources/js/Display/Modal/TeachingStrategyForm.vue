<template>
  <div>
    <div>
      <b-form @submit="onSubmitStrategy" @reset="onReset" v-if="show">

        <b-form-group 
          id="input-group-2" 
          class="font-12 mb-1" 
          label="Name:" 
          label-for="input-2">
          <b-form-input
            id="input-2"
            v-model="form.name"
            placeholder="Enter name"
            size="sm"
            class="font-12"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="input-group-1"
          label="Title"
          label-for="input-1"
          class="font-12 mb-1"
        >
          <b-form-input
            id="input-1"
            v-model="form.title"
            type="text"
            placeholder="Enter title"
            size="sm"
            class="font-12"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="input-group-2"
          label="Lesson Plan"
          label-for="select-1"
          class="font-12 mb-1"
        >
          <b-form-select 
            id="select-1" 
            class="font-12" 
            size="sm" 
            v-model="form.lesson_plan" 
            :options="lesson_plan"></b-form-select>
        </b-form-group>
        
        <b-form-group
          id="input-group-2"
          label="Level"
          label-for="select-2"
          class="font-12 mb-3"
        >
          <b-form-select id="select-2" v-model="form.student_level" :options="student_level" size="sm" class="font-12"></b-form-select>
        </b-form-group>

        <b-form-textarea
          id="textarea"
          v-model="description"
          placeholder="Description..."
          rows="3"
          max-rows="6"
          class="font-12 mb-3"
        ></b-form-textarea>

        <b-form-group label="Videos:" label-cols-sm="1" class="font-12" label-size="sm">
          <b-form-file id="file-small" v-model="video" class="font-12" size="sm"></b-form-file>
        </b-form-group>
        
        <b-form-group label="Links:" label-cols-sm="1" class="font-12" label-size="sm">
          <b-form-input
            id="input-3"
            v-model="form.links"
            type="text"
            placeholder="Links"
            size="sm"
            class="font-12"
            required
          ></b-form-input>
        </b-form-group>

        <b-card class="mt-3" header="Form Data Result">
          <pre class="m-0">{{ form }}</pre>
        </b-card>

        <b-button type="submit" size="sm" variant="primary">Submit</b-button>
        <b-button type="reset" size="sm" variant="danger">Reset</b-button>
      </b-form>
     
    </div>
  </div>
</template>

<script>

import * as api from '../api.js';

export default {
  name: 'TeachingStrategyForm',
    data() {
      return {
        form: {
          name: '',
          title: '',
          lesson_plan: null,
          student_level: null,
          description: '',
          video: '',
          links: ''
        },
        lesson_plan: '',
        student_level: '',
        show: true
      }
    },
    methods: {
      onSubmitStrategy(event) {
        event.preventDefault()
        alert(JSON.stringify(this.form))
      },
      getLessonPlanfn(data){
        this.lesson_plan = data;
      },
      getStudentLevelfn(data){
        this.student_level = data;
      },
      onReset(event) {
        event.preventDefault()
        // Reset our form values
        this.form.name = ''
        this.form.title = ''
        this.form.lesson_plan = null
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
      
    },
    mounted(){
      api.getLessonCategory(this.getLessonPlanfn);
      api.getStudentsLevel(this.getStudentLevelfn);
    }
}
</script>

<style>

</style>