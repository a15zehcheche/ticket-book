<template>
  <div>
      <img src="../../assets/plus.png" alt="add" :height="size+`px`" width="auto">
  </div>
</template>

<script>

export default {
  name: "add_item",
  components: {
    
  },
  props: {
      size:Number
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

</style>