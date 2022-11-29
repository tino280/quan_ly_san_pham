<template>
  <div v-if="last_page != 1" class="pagination">
    <nav
      aria-label="Page navigation example"
      class="mx-auto pagination"
      style="width: auto"
    >
      <ul class="pagination">
        <li class="page-item" v-bind:class="[{ disabled: !prev_page }]">
          <a
            class="page-link"
            @click="
              this.$router.push({
                query: Object.assign({}, this.$route.query, {
                  page: prev_page,
                }),
              })
            "
            aria-label="Previous"
          >
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <div v-for="(link, id) in links" :key="link.label">
          <li
            class="page-item"
            v-if="id > 0 && id < links.length - 1"
            :class="[
              {
                disabled: link.label === '...' || link.label === current_page.toString(),
              },
            ]"
          >
            <a
              class="page-link"
              @click="
                this.$router.push({
                  query: Object.assign({}, this.$route.query, {
                    page: link.label,
                  }),
                })
              "
            >
              {{ link.label }}
            </a>
          </li>
        </div>
        <li class="page-item" v-bind:class="[{ disabled: next_page > last_page }]">
          <a
            class="page-link"
            aria-label="Next"
            @click="
              this.$router.push({
                query: Object.assign({}, this.$route.query, {
                  page: next_page,
                }),
              })
            "
          >
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  props: {
    prev_page: "",
    next_page: "",
    last_page: "",
    current_page: "",
    links: {},
  },
};
</script>
