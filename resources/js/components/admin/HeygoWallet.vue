<template>
<div>
    <div class="row view-panel-tbl">
      <div class="tbl-cont p-4 col-lg-12">
        <h3>Teachers Payment</h3>
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
        <datatable class="font-12" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
          <tbody>
            <!-- @click="updateBadge(b.id, b.title, b.image) -->
            <tr v-for="b in paymentTransData" :key="b.id" class="cursor">
              <td>{{ b.teacher_name }}</td>
              <td>{{ b.student_name }}</td>
              <td>{{ b.title }}</td>
              <td>{{ b.response_date }}</td>
              <td>{{ b.user_id }}</td>
              <td>{{ b.charge_id }}</td>
              <td>{{ $helpers.numberFormat(b.amount) }}</td>
              <td>{{ $helpers.numberFormat(b.refund_amount) }}</td>
              <td>{{ b.currency }}</td>
              <td>{{ b.trans_type }}</td>
            </tr>
          </tbody>
        </datatable>
        <pagination :pagination="pagination"
                    @prev="getPaymentTransData(pagination.prevPageUrl)"
                    @next="getPaymentTransData(pagination.nextPageUrl)">
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
import * as api from './api.js';

export default {
  props: { },
  name: 'TeachersPayment',
  components: { datatable: Datatable, pagination: Pagination },
  created(){
    this.getPaymentTransData();
  },
  data(){
    let sortOrders = {};
    let columns = [
      {width: '10%', label: 'Teacher Name', name: 'teacher_name'},
      {width: '10%', label: 'Student Name', name: 'student_name'},
      {width: '10%', label: 'Lesson Type', name: 'lesson_type'},
      {width: '10%', label: 'Date', name: 'date'},
      {width: '10%', label: 'Transaction ID.', name: 'transaction_id'},
      {width: '10%', label: 'Charge ID.', name: 'charge_id'},
      {width: '10%', label: 'Amount', name: 'amount'},
      {width: '10%', label: 'Refund Amount', name: 'refund_amount'},
      {width: '10%', label: 'Currency', name: 'currency'},
      {width: '10%', label: 'Transaction Type', name: 'transaction_type'}
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
      paymentTransData: [],
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
        length: 5,
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
      formTitle: 'Add'
    }
  },
  methods: {
    fnAnimate(){
      this.fadeBool = true;
    },
    makeToast(append = false) {
      this.$toast.success('your message');
    },
    retrieveDataPaymentTransaction(res){
      let data = res.data;
      if (this.tableData.draw == data.draw) {
        this.paymentTransData = data.data.data;
        this.configPagination(data.data);
      }
    },
    getPaymentTransData(end_point = process.env.MIX_BASE_URL+'/get-heygo-wallet'){ //get-student-payment-transaction
      this.tableData.draw++;
      api.getPaymentTransactionStudent(end_point, {params: this.tableData}, this.retrieveDataPaymentTransaction);
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
      this.getPaymentTransData();
    },
    getIndex(array, key, value){
      return array.findIndex(i => i[key] == value);
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