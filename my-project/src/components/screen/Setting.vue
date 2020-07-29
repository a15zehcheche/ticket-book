<template>
  <div class="base">
    <Menu />
    setting
  </div>
</template>

<script>
import Menu from "@/components/layout/Menu";

export default {
  name: "Setting",
  components: {
    Menu: Menu
  },
  props: {},
  data() {
    return {};
  },
  mounted: function() {},
  methods: {}
};
</script>

<style>
.col {
  padding: 0;
}
.row {
  margin: 0;
}
</style>
