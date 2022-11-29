<template>
  <div class="search">
    <img
      class="search-img"
      src="http://nccdn-traning-php.test:8080/image/search.png"
      alt=""
    />
    <input class="search-input" type="text" v-model="q" @input="debounceSearch" />
  </div>
  <div class="process" v-if="loading">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      timer: 1000,
      timeOut: null,
      q: "",
      loading: false,
    };
  },

  watch: {
    $route: {
      handler: function () {
        if (!this.$route.query.q) {
          this.q = "";
        }
      },
    },
  },

  methods: {
    debounceSearch(event) {
      clearTimeout(this.timeOut);
      this.loading = true;
      this.timeOut = setTimeout(() => {
        this.loading = false;
        if (event.target.value) {
          this.$router.push({
            query: Object.assign({}, this.$route.query, { q: event.target.value }),
          });
        } else {
          this.removeParam("q");
        }
      }, this.timer);
    },

    removeParam(param) {
      let query = Object.assign({}, this.$route.query);
      delete query[param];
      this.$router.replace({ query });
    },
  },
};
</script>
