<template>
  <div>
    <div class="card rounded-0 bg-transparent border-0 h-100">
      <div class="card-body pb-5">
        <h5 class="mb-3">Books/Workbooks Shop</h5>
        <div class="row h-100">
          <div class="col-lg-2">
            <div class="card p-3">
              <button class="btn btn-warning btn-md mt-2"><i class="fas fa-angle-left"></i> Dashboard</button>
            </div>
              
             <div class="row">
              <div v-if="workBook != null">
                <div v-for="(v,i) in workBook.pages" :key="i" class="m-4 border" >
                  <a href="#" @click="renderPages(workBook,i,$event)"><img :src="baseurl + '/public/uploads/' +  v.file_name" ></a>
                </div>
              </div>
              </div>


          </div>
          <div class="col-lg-7">
            <div class="card p-3">
              
              
              

              <div class="row">
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
              </div>

              

              <div class="row mt-3" style="position:relative;">  
                      <div class="col" v-show="toggle">
                        <input type="text"  class="form-control" :value="title"  @blur="saveTitle()" ref="workbookTitle">
                        
                      </div>
                      <div class="col" v-show="toggle">
                        <button class="btn btn-default btn-md w-50"><i class="fas fa-edit font-24" ></i> <br>Update Worksheet</button>
                      </div>
                     
                       <div class="w-100 text-center m-4 border"  style="position: relative;" v-if="toggle">
                                    
                          <vue-draggable-resizable :x="v.positionX" :w="100" :h="30" @dragging="onDrag(x,y,i)" @resizing="onResize" :parent="true" v-for="(v,i) in inputs[this.preview.index].elements" :key="i">
                            
                            <input type="text" class="w-100 h-100">

                            <!-- X: {{ x }} / Y: {{ y }} - Width: {{ width }} / Height: {{ height }} -->
                          </vue-draggable-resizable> 

                          <img :src="baseurl + '/public/uploads/' +  preview.file_name">
                      </div>    
                     




                          
              </div>


            </div>
          </div>
          <div class="col-lg-3">
            <div class="card h-100 p-3">
                <h6 class="mb-3 text-center">Components</h6>

                  <button @click="cloneInput()"> Add input</button>
                
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
      workbook : {} 
    },
    components: {},
    name: 'TeacherWorkbooks',
    data(){
      return{
          workBook : JSON.parse(this.workbook),  
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
      /**
       * Resizable
       */
      onResize: function (x, y, width, height) {
        this.x = x
        this.y = y
        this.width = width
        this.height = height
      },
      onDrag: function (x, y,index) {
        this.x = x
        this.y = y

        console.log(index)

        this.inputs[this.preview.index].elements[index].positionX = this.x
        this.inputs[this.preview.index].elements[index].positionY = this.y


      },

      cloneInput(){
  
        let tempInput = [];
        let existing = this.inputs[this.preview.index].elements;  


        existing.push({
          workbookId: this.preview.workbook_id,  
          page_id: this.preview.id,
          positionX : 0,
          positionY : 0,
        });

        tempInput.elements = existing;    

        this.inputs[this.preview.index].elements = tempInput.elements;

      },


      renderPages(v,i,event){

          this.pages = v.pages;
          this.preview = v.pages[i];
          this.preview.index = i;

          event.preventDefault();
          this.workbookID = v.id;
          this.title = (v.title == null) ? 'Untitled Workbook' : v.title ;
          this.toggle = true;

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
          console.log(error)
        });



      },


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