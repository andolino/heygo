<template>
    <div>
        <!-- @close="close" -->
        <modal :show="show" >
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="mb-3">Reset Password</h5>
                    <form autocomplete="off">
                        <div class="d-none">
                            <input type="password"/>
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label font-12">Current Password</label>
                            <input type="password" v-model="forms.current_password" autocomplete="off" value="" name="current_password" class="form-control" id="current_password">
                        </div>
                        <div class="mb-3">
                            <label for="newpassword" class="form-label font-12">New Password</label>
                            <input type="password" v-model="forms.newpassword" name="newpassword" class="form-control" id="newpassword">
                        </div>
                        <div class="mb-3">
                            <label for="newpassword_confirmation" class="form-label font-12">Re-Type New Password</label>
                            <input type="password" v-model="forms.newpassword_confirmation" name="newpassword_confirmation" class="form-control" id="newpassword_confirmation">
                        </div>
                        
                    </form>
                    <button type="button" @click="submitPasswordReset" class="btn btn-warning float-right font-12 ml-1">Save</button>
                    <button type="button" @click="close" class="btn btn-warning float-right font-12">Close</button>
                </div>
            </div>
        </modal>
          <Toasts
            :show-progress="true"
            :rtl="false"
            :max-messages="5"
            :time-out="10000"
            :closeable="true"
          ></Toasts>
    </div>
</template>

<script>
    import Modal from '../Template/Modal';
    import * as api from '../../api.js';
    
    export default {
        props: ['show'],
        components: { Modal },
        data(){
            return {
                forms: {
                    current_password: '',
                    newpassword: '',
                    newpassword_confirmation: ''
                }
            }
        },
        methods: {
            close: function() {
                this.$emit('close');
            },
            resetPasswordCallback(res){
                for (var key in res.data) {
                    if (res.data.hasOwnProperty(key)) {
                        let exp = res.data[key].toString().split(',');
                        for (let i = 0; i < exp.length; i++) {
                            if (exp[i] === 'Success') {
                                this.$toast.success(exp[i]);
                                this.$emit('close');
                                this.forms.current_password = '';
                                this.forms.newpassword = '';
                                this.forms.newpassword_confirmation = '';
                            } else {
                                this.$toast.error(exp[i]);
                            }
                            console.log(exp[i]);
                        }
                    }
                }
            },
            submitPasswordReset: function(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true, 
                    confirmButtonColor: '#df9509',
                    cancelButtonColor: '#353333',
                    cancelButtonText: 'Wait',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        api.savePasswordResetTeacher(this.forms, this.resetPasswordCallback);
                        // setTimeout(function(){
                        //     res.forEach(e => {
                        //         console.log(e);
                        //     });
                        // }, 500)
                    }
                });
            }
        },
        mounted(){
        }
    }
</script>

<style>
    .swal2-container {
        z-index: 10000;
    }
</style>