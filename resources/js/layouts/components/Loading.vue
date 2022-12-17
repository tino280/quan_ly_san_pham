<template>
  <div class="process" v-if="loading">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    loading: "",
  },
};
</script>

<style scoped>
.process {
  z-index: 1000000000;
}
</style>
