<template>
  <div class="bg-light location-item m-2 d-flex align-items-center rounded">
    <div class="pt-0 pb-0 btn position-relative">
      <!--div class="delete bg-danger rounded-circle d-flex align-items-center justify-content-center">
        <span>x</span>
      </div-->
      <p class="h4 m-0">{{name}}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Location-item",
  props:{
    name:String
  }
};
</script>

<style scoped>
.location-item {
  position: relative;
  max-height: 100%;
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
.delete:hover {
  border: 1px solid white;
}

.location-item :hover .delete {
  display: block !important;
}
</style>

