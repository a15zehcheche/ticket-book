<template>
  <div>
    <img
      @click="$bvModal.show('modal-tiket-add');set_espacio()"
      src="../../../assets/plus.png"
      alt="add"
      :height="size+`px`"
      width="auto"
    />
    <b-modal
      id="modal-tiket-add"
      ref="modal"
      title="Submit Your Name"
      @ok="handleOk"
      @cancel="resetModal"
    >
      <template v-slot:modal-header>
        <!-- Emulate built in modal header close button action -->
        <h5>添加单子</h5>
      </template>

      <form ref="formName" @submit.stop.prevent="handleSubmit">
        <b-form-group :state="nameState" label="名称" label-for="name-input" invalid-feedback="请输入单名">
          <b-form-input id="name-input" v-model="name" :state="nameState" required></b-form-input>
        </b-form-group>
      </form>

      <form ref="formType" @submit.stop.prevent="handleSubmit">
        <b-form-group :state="typeState" label="区域" label-for="name-input" invalid-feedback="请选择区域">
          <select
            class="custom-select"
            v-model="type"
            :state="typeState"
            required
            id="inputGroupSelect01"
          >
            <option :value="type.id" v-for="(type,index) in location" :key="index">{{type.name}}</option>
          </select>
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: "add_item",
  components: {},
  props: {
    size: Number,
    tipos: Array,
    location: Array,
    espacio_select: Number
  },
  data() {
    return {
      nameState: null,
      typeState: null,
      name: "",
      type: "",
    };
  },
  mounted: function() {},
  methods: {
    add_tiket: function() {
      let element = this;
      this.axios
        .post(this.$hostname + "/tiket", {
          name: this.name,
          id_ESPACIO: this.type,
          name_ESPACIO: this.location.filter(espacio=>espacio.id == this.type)[0].name
        })
        .then(function(response) {
          console.log(response);
          element.$emit("tiketAdd");
        })
        .catch(function(error) {
          console.log(error);
        });
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

    resetModal() {
      this.name = "";
      this.nameState = null;
      this.type = "";
      this.typeState = null;
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
        this.$bvModal.hide("modal-tiket-add");
      });
      this.add_tiket();

      this.resetModal();
    },
    set_espacio: function() {
      this.type = this.espacio_select;
    }
  }
};
</script>

<style scoped>
</style>