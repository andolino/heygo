<template>
  <div>
    <div class="card rounded-0 bg-transparent border-0 h-100">
      <div class="card-body pb-5">
        <h5 class="mb-3">Answer Workbooks</h5>
        <div class="row h-100">
          <div class="col-lg-2">
            <div class="card p-3">
              <button class="btn btn-warning btn-md mt-2"><i class="fas fa-angle-left"></i> Dashboard</button>
            </div>
            <div class="row">
              <div v-if="workBook != null">
                <div v-for="(v,i) in workBook.pages" :key="i" class="m-4 border" >
                  <a href="#" @click="renderPages(workBook, i, $event)"><img :src="baseurl + '/public/uploads/' +  v.file_name" ></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="card p-3">
              <!-- <div class="row">
                <div class="col">
                  <button class="btn btn-default btn-md mt-2 w-100"><i class="fas fa-check font-24"></i> <br> Check Answers</button>
                </div>
                <div class="col">
                  <button class="btn btn-default btn-md mt-2 w-100"><i class="fas fa-save font-24"></i> <br> Save Answers</button>
                </div>
                <div class="col">
                  <button class="btn btn-default btn-md mt-2 w-100" @click="$refs.file.click()"><i class="fas fa-upload font-24"></i> <br> Upload new</button>
                  <input style="display:none" accept=".pdf" type="file" ref="file" id="workbook" name="workbook"  @change="signalChange">
                </div>
                <div class="col">
                  <button class="btn btn-default btn-md mt-2 w-100"><i class="fas fa-angle-left font-24"></i> <br> Link</button>
                </div>
              </div> -->
              <div class="row mt-3" style="position:relative;">  
                  <div class="col" v-show="toggle">
                    <input type="text"  class="form-control" :value="title"  @blur="saveTitle()" ref="workbookTitle">
                  </div>
                  <!-- <div class="col" v-show="toggle">
                    <button class="btn btn-default btn-md w-50"  @click="saveWorkbook()"><i class="fas fa-edit font-24"></i> <br>Update Worksheet</button>
                  </div> -->
                    <div class="w-100 text-center m-4 border dragCont"  style="position: relative;" v-if="toggle">
                      <vue-draggable-resizable 
                        @activated="onActivated(i)"
                        :x="v.positionX" 
                        :y="v.positionY" 
                        :w="v.width" :h="v.height"
                        @dragging="onDrag"
                        @resizing="onResize" 
                        :parent="true" 
                        v-for="(v,i) in inputs[this.preview.index].elements" :key="i">
                        
                        <input v-if="v.type == 'input'" type="text" placeholder="Input answer" class="w-100 h-100" @change="setValue">
                        
                        <div v-if="v.type == 'radio'" style="display:flex">
                          <input style="width:40%" class="h-100 radio" type="radio"   :name="v.name" @change="setValueRadio">
                        </div>
                        <!-- X: {{ x }} / Y: {{ y }} - Width: {{ width }} / Height: {{ height }} -->
                      </vue-draggable-resizable> 

                      <img :src="baseurl + '/public/uploads/' +  preview.file_name">
                  </div>    
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="card h-100 p-3">
                
                  <button @click="submit()"> Submit</button>
                 
                
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  

</template>




<script>
  import * as api from '../api.js';
  import VueDraggableResizable from 'vue-draggable-resizable'

  export default {
    props: { 
      workbook : {
        type: Object
      },
    },
    components: {},
    name: 'AnswerMaterials',
    data(){
      return{
          workBook : this.workbook,//JSON.parse(this.workbook),  
          baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
         
          pages: [],
          preview: {},
          title : '',
          workbookID : 0,
          titleN : '',
          toggle: false,
          rendered : false,

          positions: {
            clientX: undefined,
            clientY: undefined,
            movementX: 0,
            movementY: 0,

          },
          counter: 0,
          inputs: [],
          input : {},
          inputIndex: 0,


          /**
           * Resizable
           */
          width: 0,
          height: 0,
          x: 0,
          y: 0

      }
    },
    methods: {

      submit(){
        console.log('answers',this.inputs) // save database
        console.log('correct',JSON.parse(this.workBook?.inputs?.data)) //lookup

      },

      /**
       * Resizable
       */
      onResize: function (x, y, width, height) {
        this.x = x
        this.y = y
        this.width = width
        this.height = height

        this.inputs[this.preview.index].elements[this.inputIndex].width = this.width
        this.inputs[this.preview.index].elements[this.inputIndex].height = this.height
      },
      onDrag: function (x, y) {
        this.x = x
        this.y = y
        this.inputs[this.preview.index].elements[this.inputIndex].positionX = this.x
        this.inputs[this.preview.index].elements[this.inputIndex].positionY = this.y
      
      },
      onActivated: function(index){
          this.inputIndex = index
      },

      setValue(event){     
        this.inputs[this.preview.index].elements[this.inputIndex].value = event.target.value
      },

      setValueRadio(event){  
        let siblings = this.inputs[this.preview.index].elements;
        
        siblings.forEach((element,index) => {
          if(element.name == event.target.name){
            
            this.inputs[this.preview.index].elements[index].value = false
          }
        });

        this.inputs[this.preview.index].elements[this.inputIndex].value = event.target.checked
      },

      setGroup(event){  

        let checked = event.target.closest('div').getElementsByTagName('input')[0].checked

        console.log(checked)

        this.inputs[this.preview.index].elements[this.inputIndex].name = event.target.value
        this.inputs[this.preview.index].elements[this.inputIndex].value = checked

        console.log(this.inputs)

      },


      cloneInput(type){
  
        let tempInput = [];
        let existing = this.inputs[this.preview.index].elements;  


        existing.push({
          workbookId: this.preview.workbook_id,  
          page_id: this.preview.id,
          positionX : 0,
          positionY : 0,
          width : 180,
          height : 30,
          value : "",
          name : "",
          type: type
        });

        tempInput.elements = existing;    
        this.inputs[this.preview.index].elements = tempInput.elements;

      },


      renderPages(v,i,event){

          console.log(v);
        
          this.pages = v.pages;
          this.preview = v.pages[i];
          this.preview.index = i;

          event.preventDefault();
          this.workbookID = v.id;
          this.title = (v.title == null) ? 'Untitled Workbook' : v.title ;
          this.toggle = true;



          //get inputs frim database
          if(v.inputs != null){
            this.inputs = JSON.parse(v.inputs.data);
            this.rendered = true;
          }


          //create container for input boxes
          if(!this.rendered){
            for (let i = 0; i < this.pages.length; i++) {
              this.inputs.push({elements : []})
            } 
            this.rendered = true;
          }
          
      },


      signalChange(event){

        let formData = new FormData();
        formData.append('file', event.target.files[0]);
        axios.post(process.env.MIX_BASE_URL+'/upload-workbook', formData
        ).then((res) => {
          
           window.location.reload();        
        }).catch((error) => {
          console.log(error)
        }); 

      },
      
      saveTitle(event){

        let formData = new FormData();
        formData.append('id',this.workbookID);
        formData.append('title', this.$refs.workbookTitle.value); 

        axios.post(process.env.MIX_BASE_URL+'/save-workbook-title', formData
        ).then((res) => {
              this.title = this.$refs.workbookTitle.value;
        }).catch((error) => {
          console.log(error);
        });
      },

       saveWorkbook(){
          let formData = new FormData();
          formData.append('data',JSON.stringify(this.inputs));
          formData.append('workbookID',this.preview.workbook_id);
          axios.post(process.env.MIX_BASE_URL+'/save-workbook-inputs', formData
            ).then((res) => {
                  window.location.reload();  
            }).catch((error) => {
              console.log(error);
            });
       }


    },
    mounted() {
    
    }
  }
</script>

<style>

.font-24{
  font-size: 24px;
}


</style>