<template>
    <div>
        <!-- @close="close" -->
        <modal :show="show" >
            <b-form-group
                label-cols-lg="3"
                label="Shipping Address"
                label-size="lg"
                label-class="font-weight-bold pt-0"
                class="mb-0"
                >
                <b-form-group
                    label="Street:"
                    label-for="nested-street"
                    label-cols-sm="3"
                    label-align-sm="right"
                >
                    <b-form-input id="nested-street"></b-form-input>
                </b-form-group>
            </b-form-group>
            <button @click="close">Close</button>
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