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
          v-model="form.description"
          placeholder="Description..."
          rows="5"
          max-rows="8"
          class="font-12 mb-3"
        ></b-form-textarea>

        <b-form-group label="Videos:" label-cols-sm="1" class="font-12" label-size="sm">
          <b-form-file id="file-small" v-on:change="onVidChange" class="font-12" size="sm"></b-form-file>
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

        <!-- <b-card class="mt-3" header="Form Data Result">
          <pre class="m-0">{{ form }}</pre>
        </b-card> -->

        <b-button type="submit" size="sm" class="float-right ml-2" variant="warning">Save</b-button>
        <b-button type="reset" size="sm" class="float-right" variant="default">Reset</b-button>
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
      onVidChange(e){
        this.form.video = e.target.files[0];
      },
      onSubmitStrategy(event) {
        event.preventDefault()
        // alert(JSON.stringify(this.form))
        const config = {
          headers : {
            'content-type': 'multipart/form-data'
          }
        }
        const data = new FormData();
        data.append('name', this.form.name);
        data.append('title', this.form.title);
        data.append('lesson_plan', this.form.lesson_plan);
        data.append('student_level', this.form.student_level);
        data.append('description', this.form.description);
        data.append('video', this.form.video);
        data.append('links', this.form.links);
        api.saveTeachingStrategy(data, config);

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