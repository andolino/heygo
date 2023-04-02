<template>
  <div>
    <div>
      <b-form @submit="onSubmitStrategy" @reset="onReset" v-if="show">
        <b-form-group
          id="input-group-1"
          label="Title"
          label-for="input-1"
          class="mb-1"
          invalid-feedback="Title is required"
          :state="!v$.form.title.$error"
        >
          <b-form-input
            id="input-1"
            v-model="form.title"
            type="text"
            placeholder="Enter title"
            size="lg"
            class=""
            :state="v$.form.title.$error ? !v$.form.title.$error : null"
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="input-group-2"
          label="Lesson Type"
          label-for="select-1"
          class="mb-1"
          invalid-feedback="Lesson type is required"
          :state="!v$.form.lesson_type.$error"
        >
          <b-form-select
            id="select-1"
            class=""
            size="lg"
            v-model="form.lesson_type"
            :options="lesson_type"
            :state="
              v$.form.lesson_type.$error ? !v$.form.lesson_type.$error : null
            "
          ></b-form-select>
        </b-form-group>

        <b-form-group
          id="input-group-3"
          label="Level"
          label-for="select-2"
          class="mb-1"
          invalid-feedback="Level is required"
          :state="!v$.form.student_level.$error"
        >
          <b-form-select
            id="select-2"
            v-model="form.student_level"
            :options="student_level"
            size="lg"
            class=""
            :state="
              v$.form.student_level.$error
                ? !v$.form.student_level.$error
                : null
            "
          ></b-form-select>
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

        <div :class="{ 'invalid-feedback': v$.form.value_category.$error }">
          <label class="typo__label" style="color: initial">Category</label>
          <multiselect
            v-model="form.value_category"
            :options="option_category"
            :multiple="true"
            group-values="libs"
            group-label="language"
            :group-select="true"
            placeholder="Type to search"
            track-by="name"
            label="name"
            class="mb-3"
          >
            <span slot="noResult"
              >Oops! No elements found. Consider changing the search
              query.</span
            >
          </multiselect>
          <label
            class="typo__label form__label"
            v-if="v$.form.value_category.$error"
            >Category must have at least one value</label
          >
        </div>
        <b-form-group
          id="input-group-4"
          label="Description"
          label-for="description"
          class="mb-1"
          invalid-feedback="Description is required"
          :state="!v$.form.description.$error"
        >
          <b-form-textarea
            id="description"
            v-model="form.description"
            placeholder="Description..."
            rows="5"
            max-rows="8"
            class="mb-3"
            :state="
              v$.form.description.$error ? !v$.form.description.$error : null
            "
          ></b-form-textarea>
        </b-form-group>

        <b-form-group
          id="input-group-4"
          label="Video Links"
          label-for="video_links"
          class="mb-1"
          invalid-feedback="Video Links is required"
          :state="!v$.form.video_links.$error"
        >
          <b-form-textarea
            id="textarea"
            v-model="form.video_links"
            placeholder="Video Links..."
            rows="5"
            max-rows="8"
            class="mb-3"
            invalid-feedback="Video Links is required"
            :state="!v$.form.video_links.$error"
          ></b-form-textarea>
        </b-form-group>

        <b-form-group
          id="input-group-4"
          label="Materials"
          label-for="materials"
          class="mb-1"
          invalid-feedback="Material Links is required"
          :state="!v$.form.material_links.$error"
        >
          <b-form-textarea
            id="textarea"
            v-model="form.material_links"
            placeholder="Material Links..."
            rows="5"
            max-rows="8"
            class="mb-3"
            invalid-feedback="Material Links is required"
            :state="!v$.form.material_links.$error"
          ></b-form-textarea>
        </b-form-group>

        <!-- <pre class="language-json"><code>{{ form  }}</code></pre> -->

        <!-- <b-card class="mt-3" header="Form Data Result">
          <pre class="m-0">{{ form }}</pre>
        </b-card> -->

        <b-button
          type="submit"
          size="sm"
          class="float-right ml-2"
          variant="warning"
          :disabled="disabled"
          >Save</b-button
        >
        <b-button type="reset" size="sm" class="float-right" variant="default"
          >Reset</b-button
        >
      </b-form>
      <p v-for="error of v$.form.$errors" :key="error.$uid">
        <!-- Same as above -->
      </p>
    </div>
  </div>
</template>

<script>
import * as api from "../api.js";
import Multiselect from "vue-multiselect";
import { required } from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";

export default {
  name: "TeachingStrategyForm",
  components: {
    Multiselect,
  },
  props: {
    edit_id: {
      type: Number,
      default: 0,
    },
  },
  validations: {
    form: {
      value_category: { required, $autoDirty: true },
      lesson_type: { required, $autoDirty: true },
      student_level: { required, $autoDirty: true },
      title: { required, $autoDirty: true },
      description: { required, $autoDirty: true },
      video_links: { required, $autoDirty: true },
      material_links: { required, $autoDirty: true },
    },
  },
  data() {
    return {
      form: {
        id: this.edit_id,
        title: "",
        lesson_type: null,
        student_level: null,
        description: "",
        video_links: "",
        material_links: "",
        value_category: "",
      },
      option_category: [],
      lesson_type: [
        {
          value: 1,
          text: "Lesson Plan",
        },
        {
          value: 2,
          text: "Teaching Strategy",
        },
      ],
      student_level: [],
      show: true,
      disabled: false,
    };
  },
  methods: {
    async onSubmitStrategy(event) {
      event.preventDefault();
      const isFormCorrect = await this.v$.$validate();
      if (!isFormCorrect) return;
      this.disabled = true;
      api.saveTeachingStrategy(this.form);
    },
    getLessonPlanfn(data) {
      // this.lesson_type = data;
      this.option_category = data;
    },
    getStudentLevelfn(data) {
      this.student_level = data;
    },
    onReset(event) {
      event.preventDefault();
      // Reset our form values
      this.form.name = "";
      this.form.title = "";
      this.form.lesson_type = null;
      // Trick to reset/clear native browser form validation state
      this.show = false;
      this.$nextTick(() => {
        this.show = true;
      });
    },
    addTag(newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
      };
      this.option_category.push(tag);
      this.form.value_category.push(tag);
    },
    viewCardPerStrat(data) {
      const lesson_category = data[0].lesson_category;
      const lesson_plan_id = data[0].lesson_plan_id;
      var explLessonCat = [];
      var explLessonId = [];
      if (typeof lesson_category === "string") {
        var explLessonCat = lesson_category.split(",");
      }
      if (typeof lesson_plan_id === "string") {
        var explLessonId = lesson_plan_id.split(",");
      }
      var catId = [];
      for (let i = 0; i < explLessonId.length; i++) {
        catId.push({
          name: explLessonCat[i],
          id: explLessonId[i],
        });
      }
      this.form.title = data[0].title;
      this.form.lesson_type = data[0].id_lesson_type;
      this.form.student_level = data[0].students_level_id;
      this.form.description = data[0].description;
      this.form.video_links = data[0].videos;
      this.form.material_links = data[0].materials;
      this.form.value_category = catId;
      console.log(this.form);
    },
  },
  mounted() {
    api.getLessonCategory(this.getLessonPlanfn);
    api.getStudentsLevel(this.getStudentLevelfn);
    // console.log('this is here')
    if (this.edit_id > 0) {
      api.getTeachingStrategyView(this.viewCardPerStrat, this.edit_id);
    }
  },
  setup: () => ({ v$: useVuelidate() }),
};
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
</style>