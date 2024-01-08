<template>
    <a-config-provider :locale="locale">
        <a-layout>
            <a-drawer :placement="placement"
                      :closable="false"
                      :visible="visible"
                      class="d-layout-pd0"
                      @close="onClose">

                <div class="logo">
                    <nuxt-link to="/">
                        <h1>DadA</h1>
                    </nuxt-link>
                </div>
                <a-menu :selected-keys="selectedKeys"
                        :mode="mode"
                        class="d-layout-menu"
                        @select="onSelect"
                        @click="onClick">

                    <template v-for="item in menus">
                        <a-menu-item v-if="!item.children"
                                     :key="item.path"
                                     :class="{ 'ant-menu-item-selected': selectedMenu(item) }">
                            <li role="menuitem" class="ant-menu-item" style="padding-left: 24px;">
                                <a :href="`/admin${item.path}`" class="" norel="true">
                                    <span>{{ $t(item.title) ? $t(item.title) : item.title }}</span>
                                </a>
                            </li>
                        </a-menu-item>

                        <sub-menu v-else
                                  :key="item.key"
                                  :menu-info="item"/>
                    </template>
                </a-menu>
            </a-drawer>

            <a-layout-sider v-if="$auth.login && !isMobile"
                            v-model="collapsed"
                            :class="['d-layout-sider', {'d-hidden-nav': collapsed}]"
                            :width="256">

                <div class="logo">
                    <nuxt-link to="/">
                        <h1>DadA</h1>
                    </nuxt-link>
                </div>

                <a-menu :selected-keys="selectedKeys"
                        :mode="mode"
                        class="d-layout-menu"
                        @select="onSelect">
                    <template v-for="item in menus">
                        <a-menu-item v-if="!item.children"
                                     :key="item.path"
                                     :class="{ 'ant-menu-item-selected': selectedMenu(item) }">
                            <li role="menuitem" class="ant-menu-item" style="padding-left: 24px;">
                                <a :href="`/admin${item.path}`" class="" norel="true">
                                    <span>{{ $t(item.title) ? $t(item.title) : item.title }}</span>
                                </a>
                            </li>
                        </a-menu-item>

                        <sub-menu v-else
                                  :key="item.key"
                                  :menu-info="item"/>
                    </template>
                </a-menu>
            </a-layout-sider>

            <a-layout>
                <a-layout-header class="d-layout-header">
                    <a-icon :type="collapsed ? 'menu-unfold' : 'menu-fold'"
                            :style="{ fontSize: '20px' }"
                            @click="toggleCollapsed"/>
                    <avatar-dropdown/>
                </a-layout-header>

                <a-layout-content :style="layoutContent">
                    <nuxt/>
                </a-layout-content>

            </a-layout>
        </a-layout>
    </a-config-provider>
</template>

<script>
import {nav} from "~/utils/nav";

export default {
    middleware: "auth",
    components: {
        AvatarDropdown: () => import('~/components/AvatarDropdown')
    },
    data() {
        return {
            layoutContent: {
                padding: '24px',
                margin: 0,
                minHeight: 'calc(100vh - 64px)'
            },
            collapsed: false,
            mode: "inline",
            locale: null,
            visible: false,
            placement: "left",
            selectedKeys: [],
            menus: nav,
            isMobile: false
        };
    },
    created() {
        if (process.client) {
            window.addEventListener('resize', this.handlerResize, true);
        }
    },
    mounted() {
        this.checkMobile();
    },
    methods: {
        handlerResize() {
            this.checkMobile()
        },
        onSelect({item, key}) {
            this.selectedKeys = [key];
            this.visible = false;
        },
        onClick({item, key, keyPath}) {
            this.$router.push(key);
        },
        toggleCollapsed() {
            this.collapsed = !this.collapsed;

            if (this.isMobile) {
                this.visible = true;
            }
        },
        selectedMenu(menuItem) {
            return this.$route.fullPath.includes(menuItem.path);
        },
        showDrawer() {
            this.visible = true;
        },
        onClose() {
            this.visible = false;
        },
        onChange(e) {
            this.placement = e.target.value;
        },
        checkMobile() {
            /* eslint-disable no-useless-escape */
            this.isMobile = window.innerWidth < 960 &&  /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
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
    background: @bgLayout;
    color: @colorLayout;

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

.ant-drawer-body {
    padding: 0px !important;
}
</style>
