<template>
    <div>
        <!-- @close="close" -->
        <modal :show="show" >
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="">Hello from modal!</h5>
                    <form autocomplete="off">
                        <div class="d-none">
                            <input type="password"/>
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label font-12">Current Password</label>
                            <input type="password" autocomplete="off" value="" name="current_password" class="form-control" id="current_password">
                        </div>
                        <div class="mb-3">
                            <label for="newpassword" class="form-label font-12">New Password</label>
                            <input type="password" name="newpassword" class="form-control" id="newpassword">
                        </div>
                        <div class="mb-3">
                            <label for="re_typ_newpassword" class="form-label font-12">Re-Type New Password</label>
                            <input type="password" name="re_typ_newpassword" class="form-control" id="re_typ_newpassword">
                        </div>
                    </form>
                    <button type="button" class="btn btn-warning float-right font-12 ml-1">Save</button>
                    <button type="button" @click="close" class="btn btn-warning float-right font-12">Close</button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    import Modal from '../Template/Modal'
    export default {
        props: ['show'],
        components: { Modal },
        methods: {
            close: function() {
                this.$emit('close')
            }
        }
    }
</script>

<style>

</style>