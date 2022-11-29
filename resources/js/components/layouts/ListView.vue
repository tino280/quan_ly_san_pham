<template>
  <list-item
    :product="product"
    :checkAdmin="checkAdmin"
    v-for="product in products"
    :key="product.id"
    @product-changed="$emit('reloadList')"
  />
</template>

<script>
export default {
  emits: ["reloadList"],
  props: {
    products: {},
    checkAdmin: "",
  },
};
</script>
