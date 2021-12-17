<template>
<div>
    <div class="row view-panel-tbl">
      <div class="tbl-cont p-4 col-lg-9">
        <h3>Teachers Setup</h3>
        <div class="controls mb-3">
          <!-- <button type="button" class="btn btn-default btn-md" @click="addBadge">Add Badge</button> -->
        </div>
        <div class="tableFilters">
          <input class="input" type="text" v-model="tableData.search" placeholder="Search Table"
                  @input="getTeachersSetupList()">
          <div class="control">
            <div class="select">
              <select v-model="tableData.length" @change="getTeachersSetupList()">
                <option value="10" selected="selected">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
              </select>
            </div>
          </div>
        </div>
        <datatable class="font-14" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
          <tbody>
            <!-- @click="updateBadge(b.id, b.title, b.image)" -->
            <tr v-for="b in dtaTbl" :key="b.id" class="cursor" @click="getLessonAndBadges(b.id)">
              <td><img :src="asset + 'images/profile/teachers/thumb/' + b.picture" width="50" alt=""></td>
              <td>{{ b.lastname }}</td>
              <td>{{ b.firstname }}</td>
              <td>{{ b.middlename }}</td>
              <td>{{ b.rate_per_hr }}</td>
              <td>{{ b.contact_no }}</td>
              <td>{{ b.number_of_lesson }}</td>
            </tr>
          </tbody>
        </datatable>
        <pagination :pagination="pagination"
                    @prev="getTeachersSetupList(pagination.prevPageUrl)"
                    @next="getTeachersSetupList(pagination.nextPageUrl)">
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
                  <div class="row">
                    <div class="col-lg-12">
                      <label for="">Current Lesson</label>
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Lesson Type</th>
                            <th>Student</th>
                            <th>Count</th>
                            <th>Badges</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="lab in lessonAndBadges" :key="lab.id">
                            <template v-if="lab.no_of_lesson > 0">
                              <td>{{ lab.title }}</td>
                              <td>{{ lab.student_name }}</td>
                              <td>{{ lab.no_of_lesson }}</td>
                              <td></td>
                            </template>
                            <template v-else>
                            </template>
                          </tr>
                        </tbody>
                      </table>
                      <label for="">Current Badges</label>
                    </div>
                  </div>
                  
                </div>
                <div class="modal-footer">
                  <!-- <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                  <button type="button" class="btn btn-danger" @click="removeBadge">Remove</button>
                  <button type="button" class="btn btn-primary" @click="saveBadge">Save</button> -->
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
  name: 'TeachersSetup',
  components: { datatable: Datatable, pagination: Pagination },
  created(){
    this.getTeachersSetupList();
  },
  data(){
    let sortOrders = {};
    let columns = [
      {width: '', label: 'Image', name: 'picture'},
      {width: '', label: 'Lastname', name: 'lastname'},
      {width: '', label: 'firstname', name: 'firstname'},
      {width: '', label: 'Middlename', name: 'middlename'},
      {width: '', label: 'Rate Per Hr', name: 'rate_per_hr'},
      {width: '', label: 'Contact No', name: 'contact_no'},
      {width: '', label: 'No. Of Lesson', name: 'number_of_lesson'},
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
      dtaTbl: [],
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
      formTitle: 'Teacher Details',
      lessonAndBadges: ''
    }
  },
  methods: {
    fnAnimate(){
      this.fadeBool = true;
    },
    makeToast(append = false) {
      this.$toast.success('your message');
    },
    getTeachersSetupList(url = process.env.MIX_BASE_URL+'/admins/teachers-list-setup'){
      this.tableData.draw++;
      axios.get(url, {params: this.tableData})
          .then(response => {
            let data = response.data;
            if (this.tableData.draw == data.draw) {
              this.dtaTbl = data.data.data;
              this.configPagination(data.data);
            }
            // console.log(data);
          })
          .catch(errors => {
            console.log(errors);
      });
    },
    getLessonAndBadges(id){
      axios.post(process.env.MIX_BASE_URL+'/get-lesson-and-badges', { 'id' : id })
          .then(response => {
            let data = response.data;
            this.lessonAndBadges = data.data;
            this.showModal = true;
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
      this.getTeachersSetupList();
    },
    getIndex(array, key, value){
      return array.findIndex(i => i[key] == value);
    },
    update(id){
      // this.formTitle = 'Edit Badge';
      // this.form.id = id;
      // this.form.title = title;
      // let exst = this.$helpers.doesFileExist(this.baseurl + '/public/images/badge/' + image);
      // if (exst == true) {
      //   this.defaultImg = this.baseurl + '/public/images/badge/' + image;
      // }
      this.showModal = true;
    },
    addBadge(){
      this.showModal = true;
    },
    removeBadge(){
      // axios.post(process.env.MIX_BASE_URL+"/api/remove-badge", {id: this.form.id}).then((res) => {
      //   this.showModal = false;
      //   this.getTeachersSetupList();
      // });
    },
    saveBadge(){
      // const data = new FormData();
      // data.append('id', this.form.id);
      // data.append('image', this.form.image);
      // const json = JSON.stringify({
      //     title: this.form.title,
      // });
      // data.append('data', json);
      // axios.post(process.env.MIX_BASE_URL+"/api/upload-badge", data).then((res) => {
      //   this.defaultImg = this.baseurl + '/public/images/badge/' + res.data.image;
      //   this.showModal = false;
      //   this.getTeachersSetupList();
      // });
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