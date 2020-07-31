<template>
  <div class="d-flex flex-row justify-content-between">
      <div class="tiket-item">{{data.name}}</div>
      <div>x{{data.quantity}}</div>
      <div>{{data.price_producto}}</div>
  </div>
</template>

<script>

export default {
  name: "tiket_item",
  components: {
    
  },
  props: {
    data:Object
  },
  data() {
    return {
    };
  },
  mounted: function() {
  },
  methods: {

  }
};
</script>

<style scoped>
.tiket-item{
  width: 150px;
}
</style>