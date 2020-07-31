<template>
  <div class="tiket bg-light rounded" :id="'tiket'+data.id">
    <div class="tiket-add m-3 h1 btn btn-primary" @click="back()">完成</div>

    <div class="text-center h1 title m-3" contenteditable="true">{{data.name}}</div>
    <div class="item-container ml-3 mr-3">
      <div
        class="item-add"
        v-for="(item,index) in data.items"
        :key="index"
        @click="selectItem(index)"
        v-bind:class="{ 'item-select': item.select }"
      >
        <v-item :data="item" />
      </div>
    </div>
    <div class="footer w-100">
      <div class="h3 text-right mr-3">Total: {{data.price_to_pay}}</div>
    </div>
  </div>
</template>

<script>
import ItemAdd from "@/components/work/tiket/itemAdd";
import Add from "@/components/work/add";

export default {
  name: "Tiket_add",
  components: {
    "v-item": ItemAdd,
    "v-add": Add
  },
  props: {
    data: Object
  },
  data() {
    return {
      items: [],
      item_select_index: null
    };
  },
  created() {
    // this.$set(this.user, 'last_name', 'Doe')

    this.$props.data.items.map(item => {
      this.$set(item, "select", 0);
      return item;
    });
    window.addEventListener("keydown", this.keymonitor);
  },
  destroyed() {
    window.removeEventListener("keydown", this.keymonitor);
  },
  mounted: function() {},
  methods: {
    back: function() {
      this.$emit("back");
    },
    disable_tiket: function(id) {},
    selectItem: function(index) {
      if (this.item_select_index != null && index >= 0) {
        this.$props.data.items[this.item_select_index].select = 0;
      }
      if (index == null) {
        this.item_select_index = null;
      } else {
        this.item_select_index = index;
        this.$props.data.items[index].select = 1;
      }

      //console.log(this.$props.data.items[index]);
    },
    selectNextItem: function() {
      if (this.item_select_index < this.$props.data.items.length - 1) {
        this.selectItem(this.item_select_index + 1);
      }
      //console.log("next");
    },
    selectPreviouItem: function() {
      if (this.item_select_index > 0) {
        this.selectItem(this.item_select_index - 1);
      }
      //console.log("previou");
    },
    keymonitor: function(event) {
      //let cmd = String.fromCharCode(event.keyCode).toLowerCase();
      //console.log(event.keyCode);
      if (this.item_select_index != null) {
        if (event.keyCode == 38) {
          this.selectPreviouItem();
        } else if (event.keyCode == 40) {
          this.selectNextItem();
        } else if (event.keyCode == 8) {
          this.dropItem(this.item_select_index);
        }
      }
    },
    dropItem: function(index) {
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
            if (index == 0) {
            } else {
              this.selectItem(this.item_select_index - 1);
            }
            this.$props.data.items.splice(index, 1);
this.$swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "已删除",
                  showConfirmButton: false,
                  timer: 400
                });
            // this.axios
            //   .put(this.$hostname + "/disableTiket/" + id)
            //   .then(response => {
            //     console.log(response);
            //     this.$swal.fire({
            //       position: "top-end",
            //       icon: "success",
            //       title: "已删除",
            //       showConfirmButton: false,
            //       timer: 1000
            //     });
            //     this.$emit("refesTiket");
            //   })
            //   .catch(function(error) {
            //     console.log(error);
            //   });
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

.item-add {
  cursor: pointer;
}
.item-select {
  background-color: rgba(0, 123, 255, 0.5);
}
</style>