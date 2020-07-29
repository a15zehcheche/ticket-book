<template>
  <div class="d-flex menu-container align-items-center">
    <Item :link="`/`" :title="'主界面'" />
    <Item :link="`#/store`" :title="'菜品管理'" />
    <Item :link="`#/functions`" :title="'更多操作'" />
    <Item :link="`#/setting`" :title="'设置'" />
  </div>
</template>

<script>
import MenuItem from "@/components/layout/MenuItem";
export default {
  name: "Menu",
  components: {
    Item: MenuItem
  }
};
</script>

<style scoped>
.menu-container {
  height: 5vh;
  color: black;
  background-color: #f8f8f8;
}

.menu-container > a {
  max-height: 28px;
}
.menu-container > a > div {
  max-height: 100%;
}
</style>
