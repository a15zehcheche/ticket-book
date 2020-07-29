<template>
  <div>
    <img
      @click="$bvModal.show('modal-prevent-closing')"
      src="../../assets/plus.png"
      alt="add"
      :height="size+`px`"
      width="auto"
    />

    <b-modal
      id="modal-prevent-closing"
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
        <b-form-group :state="nameState" label="名称" label-for="name-input" invalid-feedback="请输入名称">
          <b-form-input id="name-input" v-model="name" :state="nameState" required></b-form-input>
        </b-form-group>
      </form>

      <form ref="formType" @submit.stop.prevent="handleSubmit">
        <b-form-group :state="typeState" label="类型" label-for="name-input" invalid-feedback="请选择类型">
          <select
            class="custom-select"
            v-model="type"
            :state="typeState"
            required
            id="inputGroupSelect01"
          >
            <option :value="type.id" v-for="(type,index) in tipos" :key="index">{{type.name}}</option>
          </select>
        </b-form-group>
      </form>

      <form ref="formPrice" @submit.stop.prevent="handleSubmit">
        <b-form-group
          :state="priceState"
          label="价格"
          label-for="price-input"
          invalid-feedback="请输入价格 格式(00 / 00.00)"
        >
          <b-form-input
            :id="'type-number'"
            step="0.01"
            min="0.00"
            :type="'number'"
            v-model="price"
            :state="priceState"
            required
          ></b-form-input>
        </b-form-group>
      </form>
    </b-modal>

    <b-modal id="modal-scoped" size="lg">
      <template v-slot:modal-header>
        <!-- Emulate built in modal header close button action -->
        <h5>添加食品</h5>
      </template>

      <template v-slot:default="{  }">
        <span>名称</span>
        <div class="input-group mb-3">
          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" />
        </div>
        <span>类型</span>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">选项</label>
          </div>
          <select class="custom-select" id="inputGroupSelect01">
            <option selected>Choose...</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
        <span>价格</span>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">€</span>
            <span class="input-group-text">0.00</span>
          </div>
          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" />
        </div>
      </template>

      <template v-slot:modal-footer="{ ok, cancel }">
        <!-- Emulate built in modal footer ok and cancel button actions -->
        <b-button size="sm" variant="success" @click="ok();add_producto()">OK</b-button>
        <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
      </template>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: "add_item",
  components: {},
  props: {
    size: Number,
    tipos:Array
  },
  data() {
    return {
      nameState: null,
      typeState: null,
      priceState: null,
      name: "",
      type: "",
      price: ""
    };
  },
  mounted: function() {},
  methods: {
    add_producto: function() {
      let element = this;
      this.axios
        .post(this.$hostname + "/producto", {
          name: this.name,
          detall: "",
          price: this.price,
          id_tipos: this.type
        })
        .then(function(response) {
          console.log(response);
          element.$emit("productAdd");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    checkNameValidity() {
      const valid = this.$refs["formName"].checkValidity();
      this.nameState = valid;
      return valid;
    },
    checkTypeValidity() {
      const valid = this.$refs["formType"].checkValidity();
      this.typeState = valid;
      return valid;
    },
    checkPriceValidity() {
      const valid = this.$refs["formPrice"].checkValidity();
      this.priceState = valid;
      return valid;
    },
    resetModal() {
      this.name = "";
      this.nameState = null;
      this.type = "";
      this.typeState = null;
      this.price = "";
      this.priceState = null;
    },
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
        this.$bvModal.hide("modal-prevent-closing");
      });
      this.add_producto();

      this.resetModal();
    }
  }
};
</script>

<style scoped>
</style>