<template>
  <a-config-provider :locale="locale">
    <a-layout class="font-ja">
      <a-layout>

        <a-layout-header class="main-header">
          <TheHeader/>
        </a-layout-header>

        <div style="height: 4900px" class="_wrapper">
          <a-layout-content
            :style="{
              padding: '24px',
              margin: 0,
              minHeight: 'calc(100vh - 64px)'
            }"
          >
            <nuxt keep-alive />
          </a-layout-content>
        </div>

        <a-layout-footer class="main-footer">
          <TheFooter />
        </a-layout-footer>

      </a-layout>
    </a-layout>
  </a-config-provider>
</template>

<script>
// const ja_JP = () => import('ant-design-vue/es/locale/ja_JP')
import { nav } from '~/utils/nav'
const TheFooter = () => import('~/components/organisms/common/TheFooter')
const TheHeader = () => import('~/components/organisms/common/TheHeader')
export default {
  middleware: "auth",

  components: {
    TheHeader,
    TheFooter,
  },

  data() {
    return {
      collapsed: false,
      mode: "inline",
      locale: null,
      selectedKeys: [],
      menus: nav
    };
  },

  methods: {
    onSelect({ item, key }) {
      this.selectedKeys = [key];
    },
    onClick({ item, key, keyPath }) {
      this.$router.push(key);
    },
    toggleCollapsed() {
      this.collapsed = !this.collapsed;
    },
    selectedMenu(menuItem) {
      return this.$route.fullPath.includes(menuItem.path);
    }
  }
};
</script>

<style lang="less" scoped>

.logo {
  position: relative;
  height: 64px;
  padding-left: 24px;
  overflow: hidden;
  transition: all 0.3s;
  line-height: 64px;
  background: #001529;

  svg {
    height: 32px;
    width: 32px;
    vertical-align: middle;
  }
  h1 {
    color: #fff;
    font-size: 18px;
    margin: 0 0 0 8px;
    font-weight: 600;
    vertical-align: middle;
    display: inline;
  }
}
.ant-menu-item {
  a {
    display: inline-block;
    color: currentColor;
  }
}
</style>
