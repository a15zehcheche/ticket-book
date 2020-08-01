<template>
  <div class="tiket bg-light rounded" :id="'tiket'+data.id">
    <div class="tiket-add m-3 h1 btn btn-primary" @click="back()">完成</div>

    <div class="text-center h1 title m-3" contenteditable="true">{{data.name}}</div>
    <div class="item-container ml-3 mr-3" v-click-outside="stop">
      <div
        id="tiket-add-container"
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
import ClickOutside from "vue-click-outside";

export default {
  name: "Tiket_add",
  components: {
    "v-item": ItemAdd,
    "v-add": Add,
  },
  props: {
    data: Object,
  },
  data() {
    return {
      items: [],
      item_select_index: null,
    };
  },
  created() {
    // this.$set(this.user, 'last_name', 'Doe')
    console.log(this.$props.data);
    this.$props.data.items.map((item) => {
      this.$set(item, "select", 0);
      return item;
    });
    window.addEventListener("keydown", this.keymonitor);
  },
  destroyed() {
    window.removeEventListener("keydown", this.keymonitor);
  },
  mounted: function () {
    // prevent click outside event with popupItem.
    this.popupItem = this.$el;
  },
  directives: {
    ClickOutside,
  },
  methods: {
    back: function () {
      this.$emit("back");
    },
    disable_tiket: function (id) {},
    selectItem: function (index) {
      window.addEventListener("keydown", this.keymonitor);
      if (this.item_select_index != null && index >= 0) {
        this.$props.data.items[this.item_select_index].select = 0;
      }
      if (index != null) {
        this.$props.data.items[index].select = 1;
      }
      this.item_select_index = index;

      //console.log(this.$props.data.items[index]);
    },
    selectNextItem: function () {
      if (this.item_select_index < this.$props.data.items.length - 1) {
        this.selectItem(this.item_select_index + 1);
      }
      //console.log("next");
    },
    selectPreviouItem: function () {
      if (this.item_select_index > 0) {
        this.selectItem(this.item_select_index - 1);
      }
      //console.log("previou");
    },
    keymonitor: function (event) {
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
    dropItem: function (index) {
      this.$swal
        .fire({
          title: "确定要删除吗?",
          //text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "取消",
          confirmButtonText: "是!",
        })
        .then((result) => {
          if (result.value) {
            this.axios
              .delete(
                this.$hostname +
                  "/tiketitem/" +
                  this.$props.data.items[index].id
              )
              .then((response) => {
                if (response.data.done) {
                  this.$swal.fire({
                    position: "top-end", // top-start
                    icon: "success",
                    title: "已删除",
                    showConfirmButton: false,
                    timer: 500,
                  });
                  this.$props.data.items.splice(index, 1);

                  if (index == 0 && this.$props.data.items.length >= 1) {
                    this.$props.data.items[0].select = 1;
                    //this.selectItem(0);
                  } else if (index == 0 && this.$props.data.items.length == 0) {
                    this.item_select_index = null;
                  } else {
                    this.item_select_index -= 1;
                    this.$props.data.items[this.item_select_index].select = 1;

                    //this.selectItem(this.item_select_index - 1);
                  }

                  this.$props.data.price_to_pay = this.sumItemPrice(
                    this.$props.data.items
                  );
                  //this.$emit("refesTiket");
                } else {
                  this.$swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "错误",
                    showConfirmButton: false,
                    timer: 400,
                  });
                }
                //console.log(response);
              })
              .catch(function (error) {
                console.log(error);
              });
          }
        });
    },
    sumItemPrice: function (items) {
      if (items.length != 0) {
        let price_to_pay = 0;
        items.forEach((element) => {
          price_to_pay += parseFloat(element.price_producto) * element.quantity;
        });
        return price_to_pay.toFixed(2);
      } else {
        return 0;
      }
    },
    stop: function (event) {
      //console.log("click out side");
      //console.log(event.srcElement.className)
      if (!event.srcElement.className.includes("swal2-styled")) {
        //console.log("out click exception Sweetalert");
        if (this.item_select_index != null) {
          this.$props.data.items[this.item_select_index].select = 0;
          this.item_select_index = null;
        }
        window.removeEventListener("keydown", this.keymonitor);
      }
    },
  },
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