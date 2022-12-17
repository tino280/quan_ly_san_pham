<template>
  <Header />

  <div class="containerrr">
    <div class="grid">
      <div class="grid__row">
        <div class="grid__column-2">
          <Sidebar :types="types" :ok="ok" :checkAdmin="true" />
        </div>
        <div class="grid__column-10">
          <div class="main">
            <div class="top-block">
              <div class="create">
                <button
                  type="button"
                  class="my-btn my-btn-add"
                  data-bs-toggle="modal"
                  data-bs-target="#add-product"
                  data-bs-keyboard="false"
                >
                  Thêm sản phẩm
                </button>
                <modal-create-product :types="types" @reload-list="getProduct" />
              </div>
              <Search />
            </div>

            <div class="content">
              <div class="grid">
                <div class="grid__row" style="padding: 20px; min-height: 570px">
                  <list-view
                    :products="products"
                    :checkAdmin="true"
                    @reload-list="getProduct"
                  />

                  <div v-if="products.length === 0">
                    <h1>Không có sản phẩm</h1>
                    <a class="back" @click="$router.go(-1)">
                      <img
                        class="image-back"
                        :src="`${host}/image/Left_Arrow_2.svg`"
                        alt=""
                      />
                      Quay lại</a
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
      ok: false,
      loading: true,
      host: window.location.origin,
    };
  },

  watch: {
    $route: {
      handler: function () {
        this.loading = true;
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

    getProducer() {
      axios
        .get("/api/producers")
        .then((response) => {
          this.producers = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getProduct() {
      this.last_page = 1;
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
    this.getProducer();
    this.getProduct();
  },
};
</script>

<style scoped>
.back {
  color: var(--blue-color);
  font-size: 1.5rem;
  cursor: pointer;
  text-decoration: none;
}

.image-back {
  width: 12px;
  height: 12px;
}
</style>
