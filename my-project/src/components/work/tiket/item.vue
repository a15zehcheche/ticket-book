<template>
  <div class="tiket-item d-flex flex-row justify-content-between">
    <div class="name">{{data.name}}</div>
    <div>x{{data.quantity}}</div>
    <div>{{data.price_producto}}</div>
  </div>
</template>

<script>
export default {
  name: "tiket_item",
  components: {},
  props: {
    data: Object,
  },
  data() {
    return {};
  },
  mounted: function () {},
  methods: {},
};
</script>

<style scoped>
.tiket-item .name {
  width: 150px;
}
.tiket-item {
  font-size: 1.5rem;
}
</style>