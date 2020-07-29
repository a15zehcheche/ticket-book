<template>
  <div class="bg-secondary work-container d-flex align-items-center">
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
        <div class="w-100 d-flex justify-content-center">
          <tipos-add class="btn p-0" @typeAdd="get_productosTipos" :size="40" />
        </div>
      </div>
    </div>

    <div class="main bg-light m-2 rounded">
      <div class="d-flex justify-content-between store-sidenav-title align-items-center">
        <div></div>
        <h2>菜品</h2>
        <v-add class="btn p-0" @productAdd="get_productos" :size="40" :tipos="tipos" />
      </div>
      <div class="d-flex flex-wrap">
        <v-l-item
          v-for="(item,index) in productos"
          :key="index"
          :data="item"
          @edit="select_update_producto"
          @delete="delete_producto"
        />
      </div>
    </div>

    <b-modal
      id="modal-product-update"
      ref="modal"
      title="Submit Your Name"
      @ok="handleOk"
      @cancel="resetModal"
    >
      <template v-slot:modal-header>
        <!-- Emulate built in modal header close button action -->
        <h5>添加食品</h5>
      </template>

      <form ref="formName" @submit.stop.prevent="handleSubmit">
        <b-form-group
          :state="producto_edit.nameState"
          label="名称"
          label-for="name-input"
          invalid-feedback="请输入名称"
        >
          <b-form-input
            id="name-input"
            v-model="producto_edit.name"
            :state="producto_edit.nameState"
            required
          ></b-form-input>
        </b-form-group>
      </form>

      <form ref="formType" @submit.stop.prevent="handleSubmit">
        <b-form-group
          :state="producto_edit.typeState"
          label="类型"
          label-for="name-input"
          invalid-feedback="请选择类型"
        >
          <select
            class="custom-select"
            v-model="producto_edit.type"
            :state="producto_edit.typeState"
            required
            id="inputGroupSelect01"
          >
            <option :value="type.id" v-for="(type,index) in tipos" :key="index">{{type.name}}</option>
          </select>
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
            :id="'type-number'"
            step="0.01"
            min="0.00"
            :type="'number'"
            v-model="producto_edit.price"
            :state="producto_edit.priceState"
            required
          ></b-form-input>
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
import Add from "@/components/store/productAdd";
import TypeAdd from "@/components/store/tiposAdd";

import Item from "@/components/store/item";
import LineaItem from "@/components/store/lineaItem";

export default {
  name: "Work-space",
  components: {
    "v-add": Add,
    "tipos-add": TypeAdd,
    "v-s-item": Item,
    "v-l-item": LineaItem
  },
  data() {
    return {
      productos_all: [],
      productos: [],
      tipos: [],

      producto_edit: {
        nameState: null,
        typeState: null,
        priceState: null,
        name: "",
        type: "",
        price: ""
      }
    };
  },
  mounted: function() {
    this.get_productos();
    this.get_productosTipos();
  },
  methods: {
    get_productos: function() {
      this.axios.get(this.$hostname + "/productos").then(response => {
        this.productos = this.productos_all = response.data;
        console.log(response.data);
      });
    },
    get_productosTipos: function() {
      this.axios.get(this.$hostname + "/productostipos").then(response => {
        this.tipos = response.data.map(item => {
          let container = {};
          container = item;
          container.active = 0;
          return container;
        });
        console.log(response.data);
      });
    },
    productos_filter: function(index) {
      this.tipos = this.tipos.map(item => {
        let container = {};
        container = item;
        container.active = 0;
        return container;
      });
      if (index == -1) {
        this.productos = this.productos_all;
      } else {
        this.productos = this.productos_all.filter(
          producto => producto.id_tipos == this.tipos[index].id
        );
        this.tipos[index].active = true;
      }
    },
    //producto update
    select_update_producto: function(id) {
      let producto_edit = this.productos_all.filter(
        producto => producto.id == id
      )[0];
      this.producto_edit.id = producto_edit.id;
      this.producto_edit.name = producto_edit.name;
      this.producto_edit.type = producto_edit.id_tipos;
      this.producto_edit.price = producto_edit.price;

      console.log(producto_edit);
    },
    update_producto: function() {
      let element = this;
      this.axios
        .put(this.$hostname + "/producto/" + this.producto_edit.id, {
          name: this.producto_edit.name,
          detall: "",
          price: this.producto_edit.price,
          id_tipos: this.producto_edit.type
        })
        .then(function(response) {
          console.log(response);
          element.get_productos();
        })
        .catch(function(error) {
          console.log(error);
        });
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
      this.producto_edit.typeState = valid;
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
      let valid = true;
      if (!this.checkNameValidity()) {
        valid = false;
      }
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
        this.$bvModal.hide("modal-product-update");
      });
      this.update_producto();
    },
    //delete producto
    delete_producto: function(id) {
      let element = this;
      this.axios
        .delete(this.$hostname + "/producto/" + id)
        .then(function(response) {
          console.log(response);
          element.get_productos();
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  }
};
</script>

<style scoped>
.work-container {
  width: 100%;
  height: 95vh;
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
  overflow: auto;
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
</style>
