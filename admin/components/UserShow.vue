<template>
  <a-descriptions :column="column">
    <a-descriptions-item label="用户名">{{ item.login }}</a-descriptions-item>
    <a-descriptions-item label="手机号">{{ item.phone }}</a-descriptions-item>
  </a-descriptions>
</template>

<script>
import { Descriptions } from 'ant-design-vue'

export default {
  props: {
    ...Descriptions.props,
    column: {
      type: Number,
      default: 1,
    },
    item: {
      type: Object,
      default: () => ({}),
    },
  },
}
</script>
