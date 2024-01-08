<template>
    <div></div>
</template>

<script>

export default {
    components: {},
    middleware: ['auth'],
    data() {
        return {}
    },
    mounted() {
        this.$nextTick(() => window.location.href = '/admin/revenue')
    },
    methods: {},
}
</script>

