<template>
  <div>
    <img
      @click="$bvModal.show('modal-tipos')"
      src="../../assets/plus.png"
      alt="add"
      :height="size+`px`"
      width="auto"
    />

    <b-modal
      id="modal-tipos"
      ref="modal"
      title="Submit Your Name"
      @ok="handleOk"
      @cancel="resetModal"
    >
      <template v-slot:modal-header>
        <!-- Emulate built in modal header close button action -->
        <h5>添加类型</h5>
      </template>

      <form ref="formName" @submit.stop.prevent="handleSubmit">
        <b-form-group :state="nameState" label="名称" label-for="name-input" invalid-feedback="请输入名称">
          <b-form-input id="name-input" v-model="name" :state="nameState" required></b-form-input>
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
    tipos: Array
  },
  data() {
    return {
      nameState: null,
      name: ""
    };
  },
  mounted: function() {},
  methods: {
    add_type: function() {
      let element = this;
      this.axios
        .post(this.$hostname + "/productotipos", {
          name: this.name,
        })
        .then(function(response) {
          console.log(response);
          element.$emit("typeAdd");
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

    resetModal() {
      this.name = "";
      this.nameState = null;
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
   
      // Push the name to submitted names
      //this.submittedNames.push(this.name);
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-tipos");
      });
      this.add_type();

      this.resetModal();
    }
  }
};
</script>

<style scoped>
</style>