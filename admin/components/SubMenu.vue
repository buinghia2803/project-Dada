<template>
  <a-sub-menu
    v-if="menuInfo.roles"
    :key="menuInfo.key"
    v-bind="$props"
    v-on="$listeners"
  >
    <span slot="title">
      <a-icon v-if="menuInfo.icon" :type="menuInfo.icon"></a-icon>
      <span>{{ menuInfo.title }}</span>
    </span>
    <template v-for="item in menuInfo.children">
      <a-menu-item v-if="!item.children" :key="item.path" :class="{ 'ant-menu-item-selected' : selectedMenu(item) }">
        <span>{{ $t(item.title) ? $t(item.title) : item.title }}</span>
      </a-menu-item>
      <sub-menu :key="item.path" :menu-info="item" />
    </template>
  </a-sub-menu>
</template>

<script>
import { Menu } from 'ant-design-vue'

export default {
  name: 'SubMenu',
  // must add isSubMenu: true
  isSubMenu: true,
  props: {
    ...Menu.SubMenu.props,
    // Cannot overlap with properties within Menu.SubMenu.props
    menuInfo: {
      type: Object,
      default: () => ({}),
    },
  },
  methods: {
    selectedMenu(menuItem){
      return this.$route.fullPath.includes(menuItem.path)
    }
  }
}
</script>
