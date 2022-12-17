<template>
  <div style="flex: 1">
    <div class="search">
      <img class="search-img" :src="`${host}/image/search.png`" alt="" />
      <input class="search-input" type="text" v-model="q" @input="debounceSearch" />
    </div>
    <p>{{ error }}</p>
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
      timer: 2000,
      timeOut: null,
      q: "",
      loading: false,
      host: window.location.origin,
      error: "",
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
      const regex = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
      if (regex.test(event.target.value)) {
        this.error = "Không được nhập ký tự các [`!@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?~]";
        return;
      }
      this.error = "";
      clearTimeout(this.timeOut);
      this.timeOut = setTimeout(() => {
        if (event.target.value) {
          let query = Object.assign({}, this.$route.query);
          delete query["page"];
          this.$router.push({
            query: Object.assign({}, query, { q: event.target.value }),
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

  mounted() {
    this.q = this.$route.query.q;
  },
};
</script>

<style scoped>
p {
  height: 15px;
  color: red;
}
</style>
