<template>
  <a-config-provider :locale="locale">
    <a-layout>
      <a-layout-header v-if="$auth.login" class="header">
        <div class="logo"><logo /></div>
        <a-menu
          :selected-keys="selectedKeys"
          class="menu"
          mode="horizontal"
          @select="onSelect"
          @click="onClick"
        >
          <template v-for="item in menus">
            <a-menu-item v-if="!item.children" :key="item.path">
              <a-icon v-if="item.icon" :type="item.icon"></a-icon>
              <span>{{ item.title }}</span>
            </a-menu-item>
            <sub-menu v-else :key="item.path" :menu-info="item"></sub-menu>
          </template>

          <avatar-dropdown></avatar-dropdown>
        </a-menu>
      </a-layout-header>

      <a-layout>
        <a-layout style="min-height: 100vh">
          <a-layout-content
            :style="{
              padding: '24px',
              margin: 0,
              minHeight: 'calc(100vh - 64px)'
            }"
          >
            <nuxt keep-alive />
          </a-layout-content>
        </a-layout>
      </a-layout>
    </a-layout>
  </a-config-provider>
</template>

<script>
// import zhCN from "ant-design-vue/es/locale/zh_CN";

export default {
  middleware: "auth",
  data() {
    return {
      collapsed: false,
      locale: null,
      selectedKeys: [],
      menus: [
        {
          title: "首页",
          icon: "dashboard",
          path: "/dashboard/workplace"
        },
        {
          title: "文章",
          icon: "read",
          path: "/articles"
        },
        {
          title: "项目",
          icon: "project",
          path: "/projects"
        },
        {
          title: "应用",
          icon: "appstore",
          path: "/applications"
        }
      ]
    };
  },
  methods: {
    onSelect({ item, key }) {
      this.selectedKeys = [key];
    },
    onClick({ item, key, keyPath }) {
      this.$router.push(key);
    }
  }
};
</script>

<style lang="less" scoped>
.logo {
  float: left;
  width: 128px;
  height: 64px;
  padding: 12px;
}
.menu {
  line-height: 63px;
  border-bottom: none;
}
</style>
