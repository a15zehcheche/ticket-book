<template>
  <div class="bg-secondary work-container">
    <div class="h-100" v-bind:class="{ hide: this.add_item_check }">
      <v-location @selectLocation="filerTiket" :data="espacio" />
      <v-summary
        :data="tiket"
        @selectTiket="updateSelect"
        :location="this.espacio"
        :espacio_select="espacio_select_id"
        @refesTiekt="get_tiket"
      />
      <div class="tiket-container d-flex align-items-center overflow-auto">
        <v-tiket
          v-for="(item,index) in tiket"
          :key="index"
          :data="item"
          :index="index"
          :class="{'tiket-active':item.select}"
          @refesTiket="get_tiket"
          @add_item="add_item"
        />
        <div class="ml-2">&nbsp;</div>
      </div>
    </div>

    <div v-if="this.add_item_check" class="work-container d-flex align-items-center overflow-auto">
      <v-tiket-add :data="tiket[this.tiket_select_edit]" @refesTiket="get_tiket" @back="back" />
      <v-add-item :data="tiket[this.tiket_select_edit]" @refesTiket="get_tiket" />
    </div>
  </div>
</template>

<script>
import Tiket from "@/components/work/Tiket";
import Add from "@/components/work/add";
import Summary from "@/components/work/Summary";
import Location from "@/components/work/location";
import Add_item from "@/components/work/tiket/add_item_on_tiket";
import Tiket_Add from "@/components/work/tiket/Tiketforadd";

export default {
  name: "Work-space",
  components: {
    "v-tiket": Tiket,
    "v-tiket-add": Tiket_Add,
    "v-add": Add,
    "v-summary": Summary,
    "v-location": Location,
    "v-add-item": Add_item,
  },
  props: {},
  data() {
    return {
      espacio: [],
      tiket_all: [],
      tiket: [],
      tiket_selected_index: null,
      espacio_select_id: 0,
      add_item_check: 0,
      tiket_select_edit: null,

      tiket_select_add_item: null,
    };
  },
  mounted: function () {
    this.get_espacio();
  },
  methods: {
    get_tiket: function () {
      this.axios.get(this.$hostname + "/tikets").then((response) => {
        this.tiket_all = response.data
          .filter((tiket) => tiket.active == 1)
          .map((tiket) => {
            tiket.select = 0;
            tiket.price_to_pay = this.sumItemPrice(tiket.items);
            tiket.items.map((item) => {
              this.$set(item, "select", 0);
              return item;
            });
            return tiket;
          });
        this.filerTiket(0);
        console.log(this.tiket);
      });
    },
    get_espacio: function () {
      this.axios.get(this.$hostname + "/espacios").then((response) => {
        this.espacio = response.data;
        this.espacio_select_id = this.espacio[0].id;
        this.get_tiket();

        console.log(response.data);
      });
    },
    updateSelect: function (index) {
      if (this.tiket_selected_index != null) {
        this.tiket[this.tiket_selected_index].select = 0;
      }
      this.tiket_selected_index = index;
      this.tiket[index].select = 1;

      // this.tiket = this.tiket.map(tiket => {
      //   if (tiket.id == id) {
      //     tiket.select = 1;
      //   } else {
      //     tiket.select = 0;
      //   }
      //   return tiket;
      // });
    },
    filerTiket: function (espacio_index) {
      this.espacio_select_id = espacio_index;
      if (espacio_index == -1) {
        this.tiket = this.tiket_all;
      } else {
        this.tiket = this.tiket_all
          .filter((tiket) => tiket.id_ESPACIO == this.espacio[espacio_index].id)
          .map((tiket) => {
            tiket.select = 0;
            return tiket;
          });
        // this.tiket = this.tiket_all.filter(
        //   tiket => tiket.id_ESPACIO == espacio_index
        // );
      }
      console.log(this.tiket_all);
      this.tiket_selected_index = null;
    },
    add_item: function (index) {
      // this.tiket_select_add_item = this.tiket_all.filter(
      //   tiket => tiket.id == id
      // )[0];
      this.tiket_select_edit = index;
      this.add_item_check = 1;
    },

    back: function () {
      this.add_item_check = 0;
    },
    sumItemPrice: function (items) {
      if (items.length != 0) {
        let price_to_pay = 0;
        items.forEach((element) => {
          price_to_pay += parseFloat(element.price_producto) * element.quantity;
        });
        return price_to_pay.toFixed(2);
        // return items.reduce((accumulator, currentValue) => {
        //   return (
        //     parseInt(accumulator.price_producto) +
        //     parseInt(currentValue.price_producto)
        //   );
        //});
      } else {
        return 0;
      }
    },
  },
};
</script>

<style scoped>
.work-container {
  width: 100%;
  height: 95vh;
}
.tiket-container {
  height: 86%;
}
.hide {
  display: none !important;
}
</style>
