<template>
  <div class="bg-secondary work-container d-flex align-items-center" v-click-outside="resetData">
    <div class="sidenav bg-light m-2 rounded">
      <div class="store-sidenav-title text-center ml-3 mr-3">
        <h2>分类</h2>
      </div>
      <div class="ml-3 mr-3">
        <a
          :class="{ 'tipos-active': item.active }"
          class="tipos"
          v-for="(item,index) in tipos"
          :key="index"
          @click="productos_filter(index)"
        >{{item.name}}</a>
        <a class="tipos" @click="productos_filter(-1)">Totos</a>
      </div>
    </div>

    <div class="main bg-light m-2 rounded">
      <div class="d-flex justify-content-center store-sidenav-title align-items-center">
        <h2>菜品</h2>
      </div>

      <div class="item-search">
        <div class="d-flex justify-content-around">
          <form ref="formName" @submit.stop.prevent="handleSubmit">
            <b-form-group
              :state="producto_edit.nameState"
              label="名称"
              label-for="name-input"
              invalid-feedback="请输入名称"
            >
              <b-form-input
                id="name-name"
                v-model="producto_edit.name"
                :state="producto_edit.nameState"
                required
                @input="filter_producto"
              ></b-form-input>
            </b-form-group>
          </form>

          <form ref="formType" @submit.stop.prevent="handleSubmit">
            <b-form-group
              :state="producto_edit.quantityState"
              label="数量"
              label-for="name-input"
              invalid-feedback="请输入数量"
            >
              <b-form-input
                :id="'type-quantity'"
                step="1"
                min="1"
                :type="'number'"
                @input="checknum"
                v-model="producto_edit.quantity"
                :state="producto_edit.quantityState"
                required
              ></b-form-input>
            </b-form-group>
          </form>

          <form ref="formPrice" @submit.stop.prevent="handleSubmit">
            <b-form-group
              :state="producto_edit.priceState"
              label="价格"
              label-for="price-input"
              invalid-feedback="请输入价格 格式(00 / 00.00)"
            >
              <b-form-input
                :id="'type-price'"
                step="0.01"
                min="0.00"
                :type="'number'"
                v-model="producto_edit.price"
                :state="producto_edit.priceState"
                @input="selectItem(null)"
                required
              ></b-form-input>
            </b-form-group>
          </form>
          <div>
            <!-- <div class="btn btn-success" @click="handleSubmit()">添加</div> -->
          </div>
        </div>
      </div>
      <div class="productos-container d-flex flex-column">
        <v-l-item
          v-for="(item,index) in productos"
          :key="index"
          :class="{hide: !item.display,select:item.select}"
          :data="item"
          :index="index"
          @addItemToTiket="addItem"
          @selectItem="selectItem"
        />
      </div>
    </div>
  </div>
</template>

<script>
import LineaItem from "@/components/work/tiket/lineaItem";
import ClickOutside from "vue-click-outside";

export default {
  name: "add-item",
  components: {
    "v-l-item": LineaItem,
  },
  props: {
    data: Object,
  },
  data() {
    return {
      productos_all: [],
      productos: [],
      tipos: [],

      producto_edit: {
        nameState: null,
        quantityState: null,
        priceState: null,
        name: "",
        quantity: 1,
        price: "",
      },

      item_select_index: null,
    };
  },
  mounted: function () {
    this.get_productos();
    this.get_productosTipos();
    this.popupItem = this.$el;
  },

  directives: {
    ClickOutside,
  },
  created() {
    window.addEventListener("keydown", this.keymonitor);
  },
  destroyed() {
    window.removeEventListener("keydown", this.keymonitor);
  },
  methods: {
    checknum: function (event) {
      this.producto_edit.price = this.producto_edit.price.replace(
        /[^0-9]/g,
        ""
      );
    },
    get_productos: function () {
      this.axios.get(this.$hostname + "/productos").then((response) => {
        this.productos = this.productos_all = response.data.map((producto) => {
          producto.display = 1;
          producto.select = 0;
          return producto;
        });
        console.log(response.data);
      });
    },
    get_productosTipos: function () {
      this.axios.get(this.$hostname + "/productostipos").then((response) => {
        this.tipos = response.data.map((item) => {
          let container = {};
          container = item;
          container.active = 0;
          return container;
        });
        console.log(response.data);
      });
    },
    productos_filter: function (index) {
      this.tipos = this.tipos.map((item) => {
        let container = {};
        container = item;
        container.active = 0;
        return container;
      });
      if (index == -1) {
        this.productos = this.productos_all;
      } else {
        this.productos = this.productos_all.filter(
          (producto) => producto.id_tipos == this.tipos[index].id
        );
        this.tipos[index].active = true;
      }
    },

    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.producto_edit.nameState = valid;
      return valid;
    },
    checkNameValidity() {
      const valid = this.$refs["formName"].checkValidity();
      this.producto_edit.nameState = valid;
      return valid;
    },
    checkTypeValidity() {
      const valid = this.$refs["formType"].checkValidity();
      this.producto_edit.quantityState = valid;
      return valid;
    },
    checkPriceValidity() {
      const valid = this.$refs["formPrice"].checkValidity();
      this.producto_edit.priceState = valid;
      return valid;
    },
    resetModal() {},
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      // Exit when the form isn't valid
      //if (!this.checkFormValidity()) {
      //return;
      //}
      if (this.producto_edit.name == "") {
        this.producto_edit.name = "varis";
      }

      let valid = true;
      // if (!this.checkNameValidity()) {
      //   valid = false;
      // }
      if (!this.checkPriceValidity()) {
        valid = false;
      }
      if (!this.checkTypeValidity()) {
        valid = false;
      }
      if (valid == false) {
        return;
      }
      // Push the name to submitted names
      //this.submittedNames.push(this.name);
      // Hide the modal manually
      this.$nextTick(() => {
        //this.$bvModal.hide("modal-product-update");
        //console.log("add");
        let item = {
          id: 0,
          name: this.producto_edit.name,
          price: this.producto_edit.price,
        };

        this.addItem(item);
        this.resetData();
      });
      //this.update_producto();
    },

    addItem: function (item) {
      //console.log(item);
      let data = {
        tiket: this.data,
        item: item,
        quantity: this.producto_edit.quantity,
      };
      //console.log(data);
      this.axios
        .post(this.$hostname + "/tiketitem", data)
        .then((response) => {
          console.log(response);
          let item = this.itemFormater(response.data.data);
          //this.$props.data.items.push(item);
          this.$props.data.items.unshift(item);
          this.$props.data.price_to_pay = this.sumItemPrice(
            this.$props.data.items
          );
          //this.$emit("refesTiket");
        })
        .catch(function (error) {
          console.log(error);
        });
      this.producto_edit.quantity = 1;
    },
    itemFormater(item) {
      item.select = 0;
      //this.$set(item, "select", 0);
      item.price_producto = item.price_producto.toFixed(2);
      return item;
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
    resetData: function () {
      this.producto_edit = {
        nameState: null,
        quantityState: null,
        priceState: null,
        name: "",
        quantity: 1,
        price: "",
      };
      this.item_select_index = null;
      this.filter_producto();
      window.removeEventListener("keydown", this.keymonitor);
    },
    filter_producto: function () {
      //console.log(this.producto_edit.name);
      // this.productos.map((producto) => {
      //   if (producto.name.includes(this.producto_edit.name)) {
      //     producto.display = 1;
      //   } else {
      //     producto.display = 0;
      //   }
      // });
      window.addEventListener("keydown", this.keymonitor);
      this.productos = this.productos_all.filter((producto) => {
        if (producto.name.includes(this.producto_edit.name)) {
          producto.select = 0;
          return producto;
        }
      });
      this.item_select_index = null;
    },
    keymonitor: function () {
      //console.log(event.keyCode);
      //if (this.item_select_index != null) {
      if (event.keyCode == 38) {
        this.selectPreviouItem();
      } else if (event.keyCode == 40) {
        this.selectNextItem();
        //code 13 enter
      } else if (event.keyCode == 13 && this.item_select_index != null) {
        this.setItem(this.productos[this.item_select_index]);
      }
      // }
    },
    selectNextItem: function () {
      if (this.item_select_index == null) {
        //console.log(this.productos.length);
        if (this.productos.length != 0) {
          this.selectItem(0);
          this.item_select_index = 0;
        } else {
          this.item_select_index = null;
        }
      } else if (this.item_select_index < this.productos.length - 1) {
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
    selectItem: function (index) {
      if (this.item_select_index != null && index >= 0) {
        this.productos[this.item_select_index].select = 0;
      }

      if (index != null) {
        this.productos[index].select = 1;
      }
      this.item_select_index = index;
      window.addEventListener("keydown", this.keymonitor);
    },
    setItem(item) {
      // console.log(item)
      this.producto_edit = {
        name: item.name,
        quantity: 1,
        price: item.price,
      };
      //this.item_select_index = null;
    },
  },
};
</script>

<style scoped>
.work-container {
  width: 100%;
  height: 95%;
  position: relative;
}

.sidenav {
  height: 95%;
  min-width: 250px;
  z-index: 1;
  overflow-x: hidden;
  padding-top: 10px;
}

.sidenav a {
  padding: 6px 8px 6px 6px;
  text-decoration: none;
  font-size: 25px;
  color: black;
  display: block;
  border-bottom: 2px solid rgba(255, 255, 255, 0);
}

.sidenav a:hover {
  border-bottom: 2px solid;
}

.main {
  height: 95%;
  font-size: 28px; /* Increased text to enable scrolling */
  padding: 10px;

  width: 100%;
}
.store-sidenav-title {
  border-bottom: 2px solid;
}

.tipos {
  cursor: pointer;
}
.tipos-active {
  border-bottom: 2px solid black !important;
}
.item-search > div {
  min-width: 30%;
}
.hide {
  display: none !important;
}
.productos-container {
  height: 75%;
  overflow: auto;
}
.select {
  border: 3px solid rgba(0, 123, 255, 0.5) !important;
  box-sizing: border-box;
}
</style>
