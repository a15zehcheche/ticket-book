import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Home from '@/components/screen/Home'
import Store from '@/components/screen/Store'
import Functions from'@/components/screen/Functions';
import Setting from'@/components/screen/Setting';

import { BootstrapVue, IconsPlugin, InputGroupPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/HelloWorld',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/store',
      name: 'store',
      component: Store
    },
    {
      path: '/functions',
      name: 'functions',
      component: Functions
    },
    {
      path: '/setting',
      name: 'setting',
      component: Setting
    },
  ]
})
