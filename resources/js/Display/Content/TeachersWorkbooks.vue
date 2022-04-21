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
                <div v-for="(v,i) in workBooks" :key="i" class="m-4 border">
                  <a href="#" @click="renderPages(v,$event)"><img :src="baseurl + '/public/uploads/' +  v.file_name" ></a>
                </div>
              </div>


          </div>
          <div class="col-lg-7">
            <div class="card h-100 p-3">
              
              
              

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
                     

                   


                      <div class="w-100 text-center m-4 border" v-for="(v,i) in pages" :key="i">
                          <img :src="baseurl + '/public/uploads/' +  v.file_name">
                      </div>         
              </div>


            </div>
          </div>
          <div class="col-lg-3">
            <div class="card h-100 p-3">
                <h6 class="mb-3 text-center">Components</h6>

                
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  

</template>




<script>
  import * as api from '../api.js';
  
  export default {
    props: { 
      workbooks : {} 
    },
    components: {},
    name: 'TeacherWorkbooks',
    data(){
      return{
          workBooks : JSON.parse(this.workbooks),  
          baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
          pages : {},
          title : '',
          workbookID : 0,
          titleN : '',
          toggle: false,

          positions: {
            clientX: undefined,
            clientY: undefined,
            movementX: 0,
            movementY: 0,

          },
          counter: 0,
          inputs: [{
            id: 'choice0',
            value: '',
          }],


      }
    },
    methods: {




      renderPages(v,event){
          event.preventDefault()
          this.pages = v.pages;
          this.workbookID = v.id;
          this.title = (v.title == null) ? 'Untitled Workbook' : v.title ;
          this.toggle = true;
          console.log(v);
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

.resizable-content {
    height: 100%;
    width: 100%;
    background-color: aqua;
}


.font-24{
  font-size: 24px;
}


#draggable-container {
  position: absolute;
  z-index: 9;
  cursor: pointer;
}

.draggable-input{
  z-index: 10;
}







</style>