<template>
  <div>
    <div>
      <b-form @submit="onSubmitStrategy" @reset="onReset" v-if="show">
        <b-form-group
          id="input-group-1"
          label="Title"
          label-for="input-1"
          class="mb-1"
        >
          <b-form-input
            id="input-1"
            v-model="form.title"
            type="text"
            placeholder="Enter title"
            size="lg"
            class=""
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="input-group-2"
          label="Lesson Type"
          label-for="select-1"
          class="mb-1"
        >
          <b-form-select 
            id="select-1" 
            class="" 
            size="lg"
            v-model="form.lesson_type" 
            :options="lesson_type"></b-form-select>
        </b-form-group>
        
        <b-form-group
          id="input-group-3"
          label="Level"
          label-for="select-2"
          class="mb-1"
        >
          <b-form-select id="select-2" v-model="form.student_level" :options="student_level" size="lg" class=""></b-form-select>
        </b-form-group>

        <!-- <div>
          <label class="typo__label font-12">Category</label>
          <multiselect 
            v-model="form.value_category" 
            tag-placeholder="Add this as new tag" 
            label="name" 
            track-by="code" 
            :options="option_category" 
            :multiple="true" 
            :taggable="true" 
            class="font-12 mb-3"
            @tag="addTag"></multiselect> -->
            <!-- <pre class="language-json"><code>{{ form.value_category  }}</code></pre> -->
        <!-- </div> -->

        <div>
          <label class="typo__label">Category</label>
          <multiselect v-model="form.value_category" 
                        :options="option_category" 
                        :multiple="true" 
                        group-values="libs" 
                        group-label="language" 
                        :group-select="true" 
                        placeholder="Type to search" 
                        track-by="name" 
                        label="name"
                        class="mb-3">
          <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
          </multiselect>
        </div>

        <b-form-textarea
          id="textarea"
          v-model="form.description"
          placeholder="Description..."
          rows="5"
          max-rows="8"
          class="mb-3"
        ></b-form-textarea>
        
        <b-form-textarea
          id="textarea"
          v-model="form.video_links"
          placeholder="Video Links..."
          rows="5"
          max-rows="8"
          class="mb-3"
        ></b-form-textarea>
        
        <b-form-textarea
          id="textarea"
          v-model="form.material_links"
          placeholder="Material Links..."
          rows="5"
          max-rows="8"
          class="mb-3"
        ></b-form-textarea>


        <!-- <pre class="language-json"><code>{{ form  }}</code></pre> -->


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
import Multiselect from 'vue-multiselect'

export default {
    name: 'TeachingStrategyForm',
    components: {
      Multiselect,
    },
    data() {
      return {
        form: {
          title: '',
          lesson_type: null,
          student_level: null,
          description: '',
          video_links: '',
          material_links: '',
          value_category: '',
        },
        option_category: [],
        lesson_type: [
          { 
            value: 1,
            text: 'Lesson Plan', 
          },
          { 
            value: 2,
            text: 'Teaching Strategy', 
          },
        ],
        student_level: [],
        show: true,
        
      }
    },
    methods: {
      onSubmitStrategy(event) {
        event.preventDefault()
        api.saveTeachingStrategy(this.form);
      },
      getLessonPlanfn(data){
        // this.lesson_type = data;
        this.option_category = data;
      },
      getStudentLevelfn(data){
        this.student_level = data;
      },
      onReset(event) {
        event.preventDefault()
        // Reset our form values
        this.form.name = ''
        this.form.title = ''
        this.form.lesson_type = null
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
      addTag (newTag) {
        const tag = {
          name: newTag,
          code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
        }
        this.option_category.push(tag)
        this.form.value_category.push(tag)
      }
    },
    mounted(){
      api.getLessonCategory(this.getLessonPlanfn);
      api.getStudentsLevel(this.getStudentLevelfn);
      // console.log('this is here')
    }
}
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
 
</style>