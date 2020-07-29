<template>
  <div class="store">
    <Menu />
    <WorkSpace />
  </div>
</template>

<script>
import Menu from "@/components/layout/Menu";
import WorkSpace from "@/components/store/WorkSpace";


export default {
  name: "Store",
  components: {
    'Menu': Menu,
    'WorkSpace':WorkSpace,
  },
  props: {

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

<style>
  .col{
    padding: 0;
  }
  .row{
    margin:0;
  }
</style>
