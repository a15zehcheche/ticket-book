<template>
  <div class="bg-warning tool-container d-flex align-items-center">
    <div @click="selectLocation(index)" v-for="(item,index) in data" :key="index">
      <v-l-item :name="item.name" />
    </div>
    <!--div  @click="selectLocation(-1)" >
       <v-l-item :name="'Totos'" />
    </div-->
    <!--div @click="test()">
      <v-add class="btn" :size="35" />
    </div-->
  </div>
</template>

<script>
import Add from "@/components/work/add";
import Item from "@/components/work/location_item.vue";
export default {
  name: "Location",
  components: {
    "v-l-item": Item,
    "v-add": Add
  },
  props: {
    data: Array
  },
  methods: {
    test: function() {
      console.log("location");
    },
    selectLocation: function(value) {
      this.$emit("selectLocation", value);
    }
  }
};
</script>

<style scoped>
.tool-container {
  height: 7%;
}
</style>

