<template>
  <table class="table is-bordered data-table">
    <thead>
      <tr>
        <th v-for="column in columns" :key="column.name" @click="$emit('sort', column.name)" :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 
          'sorting_asc' : 'sorting_desc') : 'sorting'" v-bind:style="{ 'background-image' : 'url('+ (sortKey === column.name ? (sortOrders[column.name] > 0 ? 
          ico_sort_asc : ico_sort_desc) : ico_sort_both) +')', 'width' : column.width, 'cursor': 'pointer' }">
          {{ column.label }}
        </th>
      </tr>
    </thead>
    <slot></slot>
  </table>
</template>

<script>
export default {
  props: ['columns', 'sortKey', 'sortOrders'],
  data(){
    return {
      ico_sort_both: process.env.MIX_BASE_URL + '/public/images/sort_both.png',
      ico_sort_asc: process.env.MIX_BASE_URL + '/public/images/sort_asc.png',
      ico_sort_desc: process.env.MIX_BASE_URL + '/public/images/sort_desc.png'
    }
  },
  mounted(){
    console.log(this.bgImage);
  }
}
</script>

<style>

</style>