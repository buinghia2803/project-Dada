<template>
  <!-- <span> -->
    <a-config-provider :autoInsertSpaceInButton="false">
        <a-button v-if="circle" :type="`btn-${color} btn-icon__${size}`" shape="circle" @click="$emit('click')">
            <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="21" cy="21" r="21" fill="black"/>
              <path d="M31.5 10.5L10.5 31.5" stroke="white" stroke-width="2"/>
              <path d="M10.5 10.5L31.5 31.5" stroke="white" stroke-width="2"/>
            </svg>
          </a-button>
          <a-button v-else :type="`btn-${color} btn-icon__${size}`" shape="circle" @click="$emit('click')">
            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M25 1L1 25" stroke="black" stroke-width="2"/>
              <path d="M25 25L1 1" stroke="black" stroke-width="2"/>
            </svg>
          </a-button>
    </a-config-provider>
</template>

<script lang="ts">
export default {
  props: {
    color: {
      type: String,
      default: 'black | white'
    },
    circle: {
      type: Boolean,
      default: true,
      description: 'true | false'
    },
    size: {
      type: String,
      default: 'small',
      description: 'small | large'
    }
  }
}
</script>

<style>

</style>
