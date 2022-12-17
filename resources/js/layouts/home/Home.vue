<template>
  <Header />

  <div class="containerrr">
    <div class="grid">
      <div class="grid__row">
        <div class="grid__column-2">
          <Sidebar
            :types="types"
            :ok="$route.query.producer_id ? true : false"
            :checkAdmin="false"
          />
        </div>
        <div class="grid__column-10">
          <div class="main">
            <div class="top-block">
              <div class="create"></div>
              <Search />
            </div>

            <div class="content">
              <div class="grid">
                <div class="grid__row" style="padding: 12px; min-height: 570px">
                  <list-view :products="products" :checkAdmin="false" />

                  <div v-if="products.length === 0">
                    <h1>Không có sản phẩm</h1>
                    <a
                      style="color: blue; font-size: 1.4rem; cursor: pointer"
                      @click="$router.go(-1)"
                      >Quay lại</a
                    >
                  </div>

                  <pagination
                    :prev_page="prev_page"
                    :next_page="next_page"
                    :last_page="last_page"
                    :current_page="current_page"
                    :links="links"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Loading :loading="loading" />
</template>

<script>
import Search from "../components/Search.vue";
import Loading from "../components/Loading.vue";
export default {
  components: {
    Search,
    Loading,
  },
  emits: [""],
  data() {
    return {
      types: {},
      producers: {},
      products: {},
      links: [],
      prev_page: "",
      next_page: "",
      current_page: "1",
      last_page: "",
      loading: true,
    };
  },

  watch: {
    $route: {
      handler: function () {
        this.getProduct();
      },
      deep: true,
    },
  },

  methods: {
    getType() {
      axios.get("/api/types").then((response) => {
        this.types = response.data.data;
      });
    },

    getProduct() {
      this.last = 1;
      this.loading = true;
      axios
        .get("/api/products", { params: this.$route.query })
        .then((response) => {
          this.loading = false;
          this.products = response.data.data.data;
          this.makePagination(
            response.data.data.links,
            response.data.data.current_page,
            response.data.data.last_page
          );
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
          this.products = [];
        });
    },

    makePagination(links, current_page, last_page) {
      this.links = links;
      this.prev_page = parseInt(current_page) - 1;
      this.next_page = parseInt(current_page) + 1;
      this.current_page = current_page;
      this.last_page = last_page;
    },
  },

  mounted() {
    this.getType();
    this.getProduct();
  },
};
</script>

<style>
.process {
  width: 100vw;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgba(123, 118, 118, 0.7);
}
</style>
