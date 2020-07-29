<template>
  <div class="bg-light summary-item m-2  d-flex align-items-center rounded">
     <a :href="'#tiket' + data.id"> <div class="pb-0 pt-0 btn"><p class="h4 m-0">{{data.name}}</p></div></a>
  </div>
</template>

<script>
export default {
  name: "Summary-item",
  props:{
    data:Object
  },
  
};
</script>

<style scoped>
.summary-item{
  max-height: 100%;
}
</style>

