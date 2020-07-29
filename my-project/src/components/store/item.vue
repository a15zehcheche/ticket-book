<template>
  <div class="food-item rounded m-2">
    <div class="photo">
      <img src="#" alt="food" srcset />
    </div>
    <div class="title">
        <span>CocaCola  </span>
    </div>
    <div class="action d-flex justify-content-around align-items-center p-1">
      <div class="btn btn-danger">删除</div>
      <div class="btn btn-info">编辑</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "food_item",
  components: {},
  props: {},
  data() {
    return {};
  },
  mounted: function() {},
  methods: {}
};
</script>

<style scoped>
.food-item {
  min-width: 200px;
  height: 250px;
  border: 1px solid;
}
.food-item > .photo {
  height: 65%   ;
}
.food-item > .title {
  height: 15%;
}
.food-item > .action {
  height: 20%;
}
</style>