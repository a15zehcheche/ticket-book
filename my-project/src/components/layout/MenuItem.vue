<template>
    <a class="bg-primary summary-item m-2  d-flex align-items-center rounded" :href="link">
      <div v class="pb-0 pt-0 btn"><p class="h5 m-0">{{title}}</p></div>
    </a>
</template>

<script>
export default {
  name: "MenuItem",
  props:{
      link:String,
      title:String
  }
};
</script>

<style scoped>
.menu-container {
  height: 5vh;
  color: black;
  background-color: #f8f8f8;
}

.menu-container > a {
  max-height: 28px;
}
.menu-container > a > div {
  max-height: 100%;
}
</style>
