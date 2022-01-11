<template>
  <div>
    <div>
      <b-form @submit="onSubmit" @reset="onReset" v-if="show">
        <b-form-group id="input-group-2" class="font-12" label="Name:" label-for="input-2">
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
          description="Lesson Plan"
          class="font-12"
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
        <!-- <b-form-group id="input-group-3" class="font-12" label="Category:" label-for="input-3">
          <b-form-select
            id="input-3"
            v-model="form.category"
            :options="category"
            required
            size="sm"
            class="font-12"
          ></b-form-select>
        </b-form-group> -->
        <b-form-select v-model="selected" :options="options"></b-form-select>
        <div class="mt-3">Selected: <strong>{{ selected }}</strong></div>

        <!-- <b-button type="submit" variant="primary">Submit</b-button> -->
        <!-- <b-button type="reset" variant="danger">Reset</b-button> -->
      </b-form>
      <b-card class="mt-3" header="Form Data Result">
        <pre class="m-0">{{ form }}</pre>
        
      </b-card>

      

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
          category: [],
          checked: []
        },
        category: '',
        show: true,
        selected: null,
        options: [
          {
            label: 'Label 1',
            options: [
              {
                value: 1,
                text: "label 1.1",
              },
              {
                value: 2,
                text: "label 1.2",
              },
            ]
          }
        ]
      }
    },
    methods: {
      onSubmit(event) {
        event.preventDefault()
        alert(JSON.stringify(this.form))
      },
      onReset(event) {
        event.preventDefault()
        // Reset our form values
        this.form.name = ''
        this.form.title = ''
        this.form.category = null
        this.form.checked = []
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
      getCategory(){
        this.category = api.getLessonCategory();
        // this.options = api.getLessonCategory();
        
      }
    },
    mounted(){
      this.getCategory();
      console.log(this.category);
// console.log(this.options);
    }
}
</script>

<style>

</style>