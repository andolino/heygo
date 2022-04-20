<template>
  <div>
    <div class="card rounded-0 bg-transparent border-0 h-100">
      <div class="card-body pb-5">
        <h5 class="mb-3">Books/Workbooks Shop</h5>
        <div class="row h-100">
          <div class="col-lg-3">
            <div class="card p-4">
              <button class="btn btn-warning btn-md mt-2"><i class="fas fa-angle-left"></i> Dashboard</button>
            </div>
              
             <div class="row">
                <div v-for="(v,i) in workBooks" :key="i" class="m-4 border">
                  <a href="#" @click="renderPages(v.pages,$event)"><img :src="baseurl + '/public/uploads/' +  v.file_name" ></a>
                </div>
              </div>


          </div>
          <div class="col-lg-9">
            <div class="card h-100 p-4">
              <h6>Title of the Book</h6>
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

              <div class="row">
                 
                      <div class="m-4 border" v-for="(v,i) in pages" :key="i">
                          <img :src="baseurl + '/public/uploads/' +  v.file_name">
                      </div>  
                
              </div>


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
    components: {
    },
    name: 'TeacherWorkbooks',
    data(){
      return{
          workBooks : JSON.parse(this.workbooks),  
          baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
          pages : {}
      }
    },
    methods: {

      renderPages(pages,event){
          event.preventDefault()
          this.pages = pages;

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