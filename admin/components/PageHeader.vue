<template>
  <a-page-header class="page-header" v-bind="$props" :breadcrumb="breadcrumbProps"></a-page-header>
</template>

<script>
import { PageHeader } from 'ant-design-vue'

export default {
  props: {
    ...PageHeader.props,
    routes: {
      type: Array,
      default: () => [],
    },
  },
  computed: {
    breadcrumbProps() {
      return {
        props: {
          routes: this.routes,
          itemRender: this.itemRender,
        },
      }
    },
  },
  methods: {
    itemRender({ route, params, routes, paths }) {
      const isLastItem = routes.indexOf(route) === routes.length - 1
      const name = route.breadcrumbName
      const path = route.path
      return isLastItem ? <span>{name}</span> : <router-link to={path}>{name}</router-link>
    },
  },
}
</script>
