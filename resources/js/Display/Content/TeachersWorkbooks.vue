<template>
  <div>
    <div class="card rounded-0 bg-transparent border-0 h-100">
      <div class="card-body pb-5">
        <h5 class="mb-3">Books/Workbooks Shop</h5>
        <div class="row h-100">
          <div class="col-lg-3">
            <div class="card h-100 p-4">
              <button class="btn btn-warning btn-md mt-2"><i class="fas fa-angle-left"></i> Dashboard</button>
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
                  <button class="btn btn-default btn-md mt-2 w-100"><i class="fas fa-angle-left font-24"></i> <br> Link</button>
                </div>
                <div class="col">
                  <button class="btn btn-default btn-md mt-2 w-100"><i class="fas fa-angle-left font-24"></i> <br> Link</button>
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
    },
    components: {
    },
    name: 'TeacherWorkbooks',
    data(){
      return{
        
      }
    },
    methods: {
    
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