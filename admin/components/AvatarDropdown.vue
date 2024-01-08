<template>
    <a-dropdown class="d-right-avatar-drop mr-3">
        <div class="avatar-dropdown-wrapper">
            <a-avatar :size="26" icon="user"/>
            <span>{{ $auth.user.first_name }}</span>
        </div>
        <a-menu slot="overlay" class="d-box-avatar-warp">
            <a-menu-item key="account-center">
                <nuxt-link to="/change-password">
                    {{ $t('menu.change_password.default') }}
                </nuxt-link>
            </a-menu-item>
            <a-menu-divider/>
            <a-menu-item key="logout">
                <nuxt-link to="/logout">
                    ログアウト
                </nuxt-link>
            </a-menu-item>
        </a-menu>
    </a-dropdown>
</template>

<style lang="less" scoped>
.avatar-dropdown-wrapper {
    cursor: pointer;
    padding: 0 12px;

    &:hover {
        background: rgba(0, 0, 0, 0.025);
    }
}

.ant-avatar {
    margin: 8px;
}

.d-box-avatar {
    align-self: flex-end;
}
</style>
