<template>
<div>
    <div class="row view-panel-tbl">
      <div class="tbl-cont p-4 col-lg-4">
        <h3>Students Payment</h3>
        <div class="controls mb-3">
          <!-- <button type="button" class="btn btn-default btn-md" @click="addBadge">Add Badge</button> -->
        </div>
        <!-- <div class="tableFilters">
          <input class="input" type="text" v-model="tableData.search" placeholder="Search Table"
                  @input="getBadge()">
          <div class="control">
            <div class="select">
              <select v-model="tableData.length" @change="getBadge()">
                <option value="10" selected="selected">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
              </select>
            </div>
          </div>
        </div> -->
        <datatable class="font-14" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
          <tbody>
            <tr v-for="b in badge" :key="b.id" class="cursor" @click="updateBadge(b.id, b.title, b.image)">
              <td>{{ b.title }}</td>
              <td>{{ b.image }}</td>
              <td>{{ b.created_at }}</td>
              
            </tr>
          </tbody>
        </datatable>
        <pagination :pagination="pagination"
                    @prev="getBadge(pagination.prevPageUrl)"
                    @next="getBadge(pagination.nextPageUrl)">
        </pagination>
      </div>
    </div>


  <div id="app">
    <div v-if="showModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{ formTitle }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" @click="showModal = false">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <!-- <form> -->
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Title</label>
                      <input type="text" class="form-control" v-model="form.title" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Image</label>
                        <img :src="defaultImg" ref="prof_display" @click="$refs.uploadImg.click()" class="rounded-circle" width="100" alt="">
                        <input type="file" class="d-none" ref="uploadImg" @change="selectFileUploadImg">
                        <div class="overlay">
                          <!-- <a href="javascript:void(0);" @click="$refs.uploadImg.click()" class="icon" title="User Profile">
                            <i class="fa fa-upload"></i>
                          </a> -->
                        </div>
                      </div>
                    </div>
                    
                    <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                  <!-- </form> -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                  <button type="button" class="btn btn-danger" @click="removeBadge">Remove</button>
                  <button type="button" class="btn btn-primary" @click="saveBadge">Save</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>




  </div>
</template>

<script>
import Datatable from './datatable/Datatable.vue';
import Pagination from './datatable/Pagination.vue';
export default {
  props: { },
  name: 'StudentsPayment',
  components: { datatable: Datatable, pagination: Pagination },
  created(){
    this.getBadge();
  },
  data(){
    let sortOrders = {};
    let columns = [
      {width: '33%', label: 'Title', name: 'title'},
      {width: '33%', label: 'Image', name: 'image'},
      {width: '33%', label: 'Data', name: 'created_at'}
    ];
    columns.forEach((column) => {
      sortOrders[column.name] = -1;
    });
    return{
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
      asset: document.querySelector('meta[name="url-asset"]').getAttribute('content'),
      user_id: document.querySelector('meta[name="user-id"]').getAttribute('content'),
      fadeBool: false,
      toastCount: 0,
      //datatable
      badge: [],
      columns: columns,
      sortKey: 'title',
      sortOrders: sortOrders,
      form: {
        id: '',
        title: '',
        image: ''
      },
      tableData: {
        draw: 0,
        length: 10,
        search: '',
        column: 0,
        dir: 'desc'
      },
      pagination: {
        lastPage: '',
        currentPage: '',
        total: '',
        lastPageUrl: '',
        nextPageUrl: '',
        prevPageUrl: '',
        from: '',
        to: '',
      },
      showModal: false,
      defaultImg: document.querySelector('meta[name="url-asset"]').getAttribute('content') + 'images/default.jpg',
      formTitle: 'Add Badge'
    }
  },
  methods: {
    fnAnimate(){
      this.fadeBool = true;
    },
    makeToast(append = false) {
      this.$toast.success('your message');
    },
    getBadge(url = process.env.MIX_BASE_URL+'/admins/badge-list'){
      this.tableData.draw++;
      axios.get(url, {params: this.tableData})
          .then(response => {
            let data = response.data;
            if (this.tableData.draw == data.draw) {
              this.badge = data.data.data;
              this.configPagination(data.data);
            }
          })
          .catch(errors => {
            console.log(errors);
          });
    },
    configPagination(data){
      this.pagination.lastPage = data.last_page;
      this.pagination.currentPage = data.current_page;
      this.pagination.total = data.total;
      this.pagination.lastPageUrl = data.last_page_url;
      this.pagination.nextPageUrl = data.next_page_url;
      this.pagination.prevPageUrl = data.prev_page_url;
      this.pagination.from = data.from;
      this.pagination.to = data.to;
      console.log(data);
    },
    sortBy(key){
      this.sortKey = key;
      this.sortOrders[key] = this.sortOrders[key] * -1;
      this.tableData.column = this.getIndex(this.columns, 'name', key);
      this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
      this.getBadge();
    },
    getIndex(array, key, value){
      return array.findIndex(i => i[key] == value);
    },
    updateBadge(id, title, image){
      this.formTitle = 'Edit Badge';
      this.form.id = id;
      this.form.title = title;
      let exst = this.$helpers.doesFileExist(this.baseurl + '/public/images/badge/' + image);
      if (exst == true) {
        this.defaultImg = this.baseurl + '/public/images/badge/' + image;
      }
      this.showModal = true;
    },
    addBadge(){
      this.showModal = true;
    },
    removeBadge(){
      axios.post(process.env.MIX_BASE_URL+"/api/remove-badge", {id: this.form.id}).then((res) => {
        this.showModal = false;
        this.getBadge();
      });
    },
    saveBadge(){
      const data = new FormData();
      data.append('id', this.form.id);
      data.append('image', this.form.image);
      const json = JSON.stringify({
          title: this.form.title,
      });
      data.append('data', json);
      axios.post(process.env.MIX_BASE_URL+"/api/upload-badge", data).then((res) => {
        this.defaultImg = this.baseurl + '/public/images/badge/' + res.data.image;
        this.showModal = false;
        this.getBadge();
      });
    },
    selectFileUploadImg(event){
      this.form.image = event.target.files[0];
      this.defaultImg = URL.createObjectURL(this.form.image);
    }
  },
  mounted() {
    this.fnAnimate();
  }
}
</script>

<style>

</style>