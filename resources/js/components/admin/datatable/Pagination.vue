<style lang="scss">
  .pagination{
    justify-content: flex-end !important;
    .page-stats{
      align-items: center;
      margin-right: 5px;
    }
    i{
      color: #3273dc !important;
    }
  }
</style>

<template>
  <nav class="pagination">
    <span class="page-stats">{{pagination.from}} - {{pagination.to}} of {{pagination.total}}</span>
    <a v-if="pagination.prevPageUrl" class="btn btn-default btn-sm button is-small pagination-previous" @click="$emit('prev');">
      Prev
    </a>
    <a class="btn btn-default btn-sm button is-small pagination-previous" v-else :disabled="true">
      Prev
    </a>
    <a v-if="pagination.nextPageUrl" class="btn btn-default btn-sm button is-small pagination-next" @click="$emit('next');">
      Next
    </a>
    <a class="btn btn-default btn-sm button is-small pagination-next" v-else :disabled="true">
      Next
    </a>
  </nav>
</template>

<script>
export default {
  props: ['pagination']
}
</script>

<style>

</style>