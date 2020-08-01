<template>
  <div class="bg-primary tool-container d-flex align-items-center">
    <div
      @click="selectTiket(index)"
      v-for="(item,index) in data"
      :key="index"
      :class="{hide:!item.display}"
    >
      <v-s-item :data="item" />
    </div>
    <v-t-add
      class="btn"
      :size="35"
      :location="location"
      :espacio_select="espacio_select"
      :data="data"
      @tiketAdd="refesTiekt"
    />
  </div>
</template>

<script>
import Item from "@/components/work/summary_item.vue";
import TiketAdd from "@/components/work/tiket/tiketAdd.vue";

export default {
  name: "Summary",
  components: {
    "v-s-item": Item,
    "v-t-add": TiketAdd,
  },
  props: {
    data: Array,
    location: Array,
    espacio_select: Number,
  },
  data() {
    return {
      //data: this.$props.data,
    };
  },
  methods: {
    selectTiket: function (value) {
      this.$emit("selectTiket", value);
    },
    refesTiekt: function () {
      this.$emit("refesTiekt");
    },
  },
};
</script>

<style scoped>
.tool-container {
  height: 7%;
}
.hide {
  display: none;
}
</style>

