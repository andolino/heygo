<template>
  <div>
    <div class="row pl-5 pr-5 cont-payment-methods pt-3">
      <div class="col-lg-12 mb-2">
        <button type="button" class="btn w-100 text-left p-3"><img :src="asset + 'images/gpay.png'" alt=""></button>
      </div>
      <div class="col-lg-12 mb-2">
        <button type="button" class="btn w-100 text-left p-3"><img :src="asset + 'images/apay.png'" alt=""></button>
      </div>
      <div class="col-lg-12 mb-3">
        <button type="button" class="btn w-100 text-left p-3"><img :src="asset + 'images/ppay.png'"></button>
      </div>
      <div class="col-lg-12">
        <hr>
      </div>
      <div class="col-lg-4 mb-3 pr-0">
        <button type="button" class="btn w-100 text-left font-12 p-2 rounded-0">Eastwest <br> **** **** **** *015</button>
      </div>
      <div class="col-lg-4 mb-3 pr-0">
        <button type="button" class="btn w-100 text-left font-12 p-2 rounded-0">Account 2 <br> Bpi</button>
      </div>
      <div class="col-lg-4 mb-3 pr-0">
        <button type="button" class="btn w-100 text-left p-2 rounded-0 font-12 h-100" v-on:click="showFrm = !showFrm">+ Add Account</button>
      </div>
      
    </div>
    <form @submit.prevent="submitStudentBankAccouts">
      <div class="frm-add-bnk-acct" v-if="showFrm">
        <div class="row mt-3">
          <div class="col-lg-3"></div>
          <div class="col-lg-6">
            <div class="cont-form-card">
                <div class="form-group">
                  <label for="" class="font-14">Card Holder Name</label>
                  <input type="text" 
                        v-model="form.account_name" 
                        :class="{'is-invalid' : form.errors.has('account_name')}" 
                        class="form-control text-center input-custom font-14 mb-3" 
                        name="account_name">
                </div>
                <div class="form-group">
                  <label for="" class="font-14">Card Number</label>
                  <input type="text" 
                        v-model="form.card_number" 
                        :class="{'is-invalid' : form.errors.has('card_number')}" 
                        class="form-control text-center input-custom font-14 mb-3" 
                        name="card_number">
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <label for="" class="font-14">Expiry Date</label>
                    <input type="text" 
                          v-model="form.expiry_date" 
                          :class="{'is-invalid' : form.errors.has('expiry_date')}" 
                          class="form-control text-center input-custom font-14 mb-3" 
                          name="expiry_date">
                  </div>
                  <div class="col-lg-6">
                    <label for="" class="font-14">CVV Code</label>
                    <input type="text" 
                          v-model="form.cvv_code" 
                          :class="{'is-invalid' : form.errors.has('cvv_code')}" 
                          class="form-control text-center input-custom font-14 mb-3" 
                          name="cvv_code">
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="font-14">Add Card Name</label>
                  <input type="text" 
                        v-model="form.card_name" 
                        :class="{'is-invalid' : form.errors.has('card_name')}" 
                        class="form-control text-center input-custom font-14 mb-3" 
                        name="card_name">
                </div>
            </div>
          </div>
          <div class="col-lg-3"></div>
        </div>
        <div class="row mt-3 mb-3">
          <div class="col-lg-5"></div>
          <div class="col-lg-2">
            <button type="submit" class="btn btn-default btn-md font-14 w-100 p-2">Add</button>
          </div>
          <div class="col-lg-5"></div>
        </div>
      </div>
    </form>


  </div>
</template>



<script>
    export default {
      name: "StudentPaymentMethods",
      props: [ 'base_url' ],
			data(){
				return{
          showFrm: false,
					form: new Form({
            account_name : '',
            card_number : '',
            expiry_date : '',
            cvv_code : ''
					}),
          csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
          asset: document.querySelector('meta[name="url-asset"]').getAttribute('content'),
          user_id: document.querySelector('meta[name="user-id"]').getAttribute('content')
				}
			},
			methods: {
      	fetchAllBankAccount(){
          axios.post(process.env.MIX_BASE_URL+'/get-bank-acct-per-student', data).then((res) => {
            // if (typeof res.data.errors === 'undefined') {
            //   window.location.reload();
            // }

					}).catch((error) => {
            console.log(error);
						this.form.errors.record(error.response.data.errors);
					});
        },
      	submitStudentBankAccouts(){
					let data = new FormData();
					data.append('account_name', this.form.account_name);
					data.append('card_number', this.form.card_number);
					data.append('expiry_date', this.form.expiry_date);
					data.append('cvv_code', this.form.cvv_code);
					data.append('card_name', this.form.card_name);
					data.append('user_id', this.user_id);
					data.append('_token', this.csrf);
					axios.post(process.env.MIX_BASE_URL+'/save-student-bank-acct', data).then((res) => {
            // if (typeof res.data.errors === 'undefined') {
            //   window.location.reload();
            // }

					}).catch((error) => {
            console.log(error);
						this.form.errors.record(error.response.data.errors);
					});
				},
			},
			mounted() { 
        this.getCountries();
        this.getStudentsData();
      }
	  }
</script>


<style>
.cont-payment-methods hr{
  border-top: 2px solid rgba(0, 0, 0, 0.24);
}
.cont-payment-methods{
  width: 80%;
  margin: auto !important;
}
.cont-payment-methods button {
  background: #ddd;
  display: block;
  padding: 23px;
  border-radius: 20px;
}
</style>