<template>
  <div class="bg-light location-item-add m-2 d-flex align-items-center rounded">
    <div class="p-1 btn position-relative">
      <div class="delete bg-danger rounded-circle d-flex align-items-center justify-content-center"> <span>x</span></div>
      <p class="h4 m-0">Terrasa</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Location-item-add"
};
</script>

<style scoped>
.location-item-add {
  position: relative;
}
.delete {
  height: 25px;
  width: 25px;
  position: absolute;
  top: -10px;
  right: -13px;
  cursor: pointer;
  color: white;
  display: none !important;
}
 .delete:hover{
   border: 1px solid white;
}

.location-item-add :hover .delete {
  display: block  !important;
}
</style>

