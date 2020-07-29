<template>
  <div class="food-item rounded d-flex justify-content-between align-items-center">
    <div class="title ml-3 mr-3 food-item-name">
      <span>{{data.name}}</span>
    </div>
    <div class="price ml-3 mr-3">
      <span>{{data.price}}</span>
    </div>
    <div class="action p-1">
      <div @click="delete_producto(data.id)" class="btn btn-danger">删除</div>
      <div @click="$bvModal.show('modal-product-update'); update(data.id)" class="btn btn-info">编辑</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "food_item",
  components: {},
  props: {
    data: Object
  },
  data() {
    return {};
  },
  mounted: function() {},
  methods: {
    update: function(id) {
      this.$emit("edit", id);
    },
    delete_producto: function(id) {
      this.$emit("delete", id);
    }
  }
};
</script>

<style scoped>
.food-item {
  min-width: 98%;
  max-height: 50px;
  border: 1px solid;
  margin: 1%;
}
.food-item-name {
  width: 200px;
  white-space: nowrap;
}
.food-item > .title {
}
.food-item > .action {
}
</style>