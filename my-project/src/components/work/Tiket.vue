<template>
  <div class="tiket bg-light rounded" :id="'tiket'+data.id">
    <div class="tiket-add m-3" @click="add_item(index)">
      <v-add :size="40" />
    </div>

    <div
      class="text-center h1 title m-3"
      contenteditable="true"
      v-html="ticketName()"
      @blur="editName"
    ></div>
    <div class="item-container ml-3 mr-3">
      <v-item v-for="(item,index) in data.items" :key="index" :data="item" />
    </div>
    <div class="footer w-100">
      <div class="h3 text-right mr-3">Total: {{data.price_to_pay}}</div>
      <div class="w-100 p-2 d-flex justify-content-around">
        <div class="btn btn-danger" @click="disable_tiket(data.id)">删除</div>
        <div class="btn btn-info" @click="print()">打印</div>
        <div class="btn btn-success">付款</div>
      </div>
    </div>
  </div>
</template>

<script>
import Item from "@/components/work/tiket/item";
import Add from "@/components/work/add";

export default {
  name: "Tiket",
  components: {
    "v-item": Item,
    "v-add": Add,
  },
  props: {
    index: Number,
    data: Object,
    tikets: Array,
  },
  data() {
    return {
      items: [],
      ticket_name_copy: this.$props.data.name,
    };
  },
  created: function () {},
  mounted: function () {},
  methods: {
    add_item: function (id) {
      this.$emit("add_item", id);
    },
    disable_tiket: function (id) {
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
              .put(this.$hostname + "/disableTiket/" + id)
              .then((response) => {
                console.log(response);
                this.$swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "已删除",
                  showConfirmButton: false,
                  timer: 1000,
                });
                this.tikets.splice(this.$props.index);
                //this.$emit("refesTiket");
              })
              .catch(function (error) {
                console.log(error);
              });
          }
        });
    },
    print: function () {
      // console.log( {
      //     items:this.$props.data.items,
      //     price_all: this.$props.data.price_to_pay
      //   })

      this.axios
        .post(this.$hostname + ":3000/print", {
          items: this.$props.data.items,
          price_all: this.$props.data.price_to_pay,
        })
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          this.$swal.fire({
            position: "top-end",
            icon: "error",
            title: "无法链接打印机",
            showConfirmButton: false,
            timer: 1000,
          });
          console.log(error);
        });
    },
    editName: function (evt) {
      var src = evt.target.innerText;
      console.log(src);
      this.$props.data.name = "";
      this.axios
        .put(this.$hostname + "/tiket" + "/" + this.$props.data.id, {
          name: src,
        })
        .then((response) => {
          console.log(response);
          this.$props.data.name = src;
          if (!response.data.done) {
            console.log("false");
            this.$props.data.name = this.ticket_name_copy;
          }
        })
        .catch((error) => {
          //console.log(error);
        });
    },
    ticketName: function () {
      var html = this.$props.data.name;

      return html;
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
.item-container {
  background: gainsboro;
  height: 70%;
  overflow-y: scroll;
}
</style>