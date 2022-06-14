<template>
  <div>
    <div class="card rounded-0 bg-transparent border-0 h-100">
      <div class="card-body pb-5">
        <h5 class="mb-3">Workbook Shop</h5>
        <div class="row h-100">
          <div class="col-lg-2">
            <div class="card p-3">
              <button class="btn btn-warning btn-md mt-2"><i class="fas fa-angle-left"></i> Dashboard</button>
              <button class="btn btn-default btn-md mt-2"> My Materials</button>
              <button class="btn btn-default btn-md mt-2"> Purchased Materials</button>
              <button class="btn btn-default btn-md mt-2"> Wishlist</button>
              <button class="btn btn-default btn-md mt-2"> Followed Teachers</button>
              <hr>
              <button class="btn btn-default btn-md mt-2" onclick="redirectWorkbooks"> Create New Material</button>
              <button class="btn btn-default btn-md mt-2"> Sales Report</button>
            </div>
            


          </div>
          <div class="col-lg-7">
            <div class="card p-3">
              <div class="form-group">
                <input type="email" class="form-control" placeholder="Search..." id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>
              <b-row>
                <b-col cols="4" v-for="v in workbook" :key="v.id" class="mb-3">
                  <b-card title="" sub-title="">
                    <div class="wb-img">
                      <b-img :src="baseurl+'/public/uploads/'+v.file_name" fluid alt="Responsive image"></b-img>
                    </div>
                    <label class="text-primary mb-2 cursor">Lorem Ipsum</label>
                    <b-row class="mb-1">
                      <b-col class="pr-0">
                        <b-card-sub-title class="mb-2 font-11"><span class="text-danger">Title</span></b-card-sub-title>
                      </b-col>
                    </b-row>
                    <b-row class="mb-0">
                      <b-col class="font-12">
                        $5
                      </b-col>
                    </b-row>
                    <b-row class="mb-0">
                      <b-col class="font-12">
                        <i class="fas fa-star font-11 text-warning"></i>
                        <i class="fas fa-star font-11 text-warning"></i>
                        <i class="fas fa-star font-11 text-warning"></i>
                      </b-col>
                    </b-row>
                  </b-card>
                </b-col>
              </b-row>
            

            </div>
          </div>
          <div class="col-lg-3">
            
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
      workbook: {
        type: Object,
      }
    },
    components: {},
    name: 'WorkbookMaterials',
    data(){
      return{
        baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
        // workBook : JSON.parse(this.workbook),  
      }
    },
    methods: {
      redirectWorkbooks(){
        window.location.href = this.baseurl = '/teachers-workbooks';
      }
    },
    mounted() {
      console.log(this.workbook);
    }
  }
</script>

<style>

.font-24{
  font-size: 24px;
}
.wb-img img{
  width: 100%;
  height: 200px;
  object-fit: cover;
}

</style>