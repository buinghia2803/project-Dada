<template>
    <div class="icon-hamburger">
        <div class="hamburger-menu">
            <input id="menu__toggle" type="checkbox"/>
            <label class="menu__btn" for="menu__toggle">
                <span></span>
            </label>

            <ul class="menu__box">
                <li><a class="menu__item" href="#">Home</a></li>
                <li><a class="menu__item" href="#">About</a></li>
                <li><a class="menu__item" href="#">Team</a></li>
                <li><a class="menu__item" href="#">Contact</a></li>
                <li><a class="menu__item" href="#">Twitter</a></li>
            </ul>
        </div>
    </div>
</template>

<script>


export default {
    name: 'Hamburger',
    auth: false,
    data() {
        return {
            collapsed: false,
            toggleCollapsed: false,
        }
    },
    computed: {},
    methods: {},
    created() {
    }
}
</script>

<style lang="less" src="assets/less/user/top.less"></style>
