<template>
  <div class="tiket bg-light rounded" :id="'tiket'+data.id">
    <div class="tiket-add m-3 h1 btn btn-primary" @click="back()">完成</div>

    <div class="text-center h1 title m-3" contenteditable="true">{{data.name}}</div>
    <div class="item-container ml-3 mr-3">
      <v-item v-for="(item,index) in data.items" :key="index" :data="item" />
    </div>
    <div class="footer w-100">
      <div class="h3 text-right mr-3">Total: {{data.price_to_pay}}</div>
    </div>
  </div>
</template>

<script>
import Item from "@/components/work/tiket/item";
import Add from "@/components/work/add";

export default {
  name: "Tiket_add",
  components: {
    "v-item": Item,
    "v-add": Add
  },
  props: {
    data: Object
  },
  data() {
    return {
      items: []
    };
  },
  mounted: function() {},
  methods: {
    back: function() {
      this.$emit("back");
    },
    disable_tiket: function(id) {
      this.$swal
        .fire({
          title: "确定要删除吗?",
          //text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "取消",
          confirmButtonText: "是!"
        })
        .then(result => {
          if (result.value) {
            this.axios
              .put(this.$hostname + "/disableTiket/" + id)
              .then(response => {
                console.log(response);
                this.$swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "已删除",
                  showConfirmButton: false,
                  timer: 1000
                });
                this.$emit("refesTiket");
              })
              .catch(function(error) {
                console.log(error);
              });
          }
        });
    }
  }
};
</script>

<style scoped>
.tiket {
  position: relative;
  min-width: 400px;
  margin: 0 20px;
  height: 90%;
}
.tiket > .tiket-add {
  position: absolute;
  right: 0;
  cursor: pointer;
}
.tiket > .title {
  border-bottom: 2px solid;
}
.tiket > .footer {
  position: absolute;
  bottom: 0;
}

.tiket-active {
  border: 10px solid skyblue;
  box-sizing: content-box;
}
</style>