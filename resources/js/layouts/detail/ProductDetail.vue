<template>
  <Header />

  <div class="containerrr">
    <div class="grid">
      <div class="grid__row">
        <div class="grid__column-2">
          <Sidebar
            :types="types"
            :producers="producers"
            :ok="ok"
            :type_product="product.type_id"
            :producer_product="product.producer_id"
          />
        </div>
        <div class="grid__column-10">
          <div class="main">
            <div class="content">
              <div class="grid">
                <div class="grid__row" style="padding: 12px; min-height: 530px">
                  <div style="width: 100%; margin-left: 30px; margin-right: 30px">
                    <div class="btn-back">
                      <button type="button" class="back-link" @click="$router.go(-1)">
                        <img
                          class="img-back"
                          :src="`${host}/image/Left_Arrow_2.svg`"
                          alt=""
                        />
                        Quay lại
                      </button>
                    </div>

                    <div class="info-detail">
                      <div class="info">
                        <p style="font-weight: 600; margin-bottom: 15px">
                          {{ product.name }}
                        </p>
                        <p>Danh mục: {{ product.type_name }}</p>
                        <p>Hãng sản xuất: {{ product.producer_name }}</p>
                        <p style="margin-bottom: 15px">Giá: $ {{ product.price }}</p>
                        <p>Mô tả sản phẩm:</p>
                        <p class="description">
                          {{ product.description }}
                        </p>
                      </div>
                      <div class="slide" v-if="Object.keys(slides).length">
                        <div v-for="(slide, index) in slides" :key="slide.id">
                          <img
                            v-show="index === current"
                            class="image-slide-edit"
                            :src="`${host}/image/slide/${slide.product_id}/${slide.image}`"
                          />
                        </div>
                        <div class="dot-slide" :hidden="Object.keys(slides).length <= 1">
                          <span
                            class="dot"
                            :class="index === current ? 'active-slide' : ''"
                            v-for="(slide, index) in slides"
                            :key="slide.id"
                            @click="changeCurrentSlide(index)"
                          ></span>
                        </div>
                      </div>
                      <div v-else class="slide">
                        <img
                          class="image-slide-edit"
                          :src="`${host}/image/description/${product.id}/${product.image_link}`"
                        />
                      </div>
                    </div>

                    <div
                      class="hint"
                      style="margin-top: 50px"
                      v-if="Object.keys(relativeProducts).length > 0"
                    >
                      <p style="font-size: 1.4rem; font-weight: 500">Gợi ý cho bạn:</p>
                      <div style="display: flex; margin-left: -12px; margin-right: -12px">
                        <div
                          class="grid__column-4"
                          v-for="relativeProduct in relativeProducts"
                          :key="relativeProduct.id"
                        >
                          <div class="product">
                            <router-link :to="`/product/detail/${relativeProduct.id}`">
                              <img
                                class="image-detail"
                                :src="`${host}/image/description/${relativeProduct.id}/${relativeProduct.image_link}`"
                              />
                            </router-link>
                            <p
                              style="
                                font-weight: bold;
                                font-size: 1.4rem;
                                margin: 10px 10px;
                              "
                            >
                              {{ relativeProduct.name }}
                            </p>
                            <p
                              style="font-size: 1.4rem; margin: 10px 10px; color: #62677a"
                            >
                              {{
                                "$ " +
                                parseInt(relativeProduct.price).toLocaleString("en-US", {
                                  currency: "VND",
                                })
                              }}
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
import Loading from "../components/Loading.vue";
export default {
  components: {
    Loading,
  },
  data() {
    return {
      types: {
        id: "",
        name: "",
      },
      producers: {
        id: "",
        name: "",
      },
      product: {
        name: "",
        type_id: "",
        producer_id: "",
        price: "",
        description: "",
      },
      slides: [],
      timer: null,
      current: 0,
      relativeProducts: {},
      ok: true,
      host: window.location.origin,
      loading: "",
    };
  },

  watch: {
    $route: {
      handler: function () {
        window.scrollTo(0, 0);
        this.current = 0;
        this.getProduct(this.$route.params.id);
        this.getRelativeProducts(this.$route.params.id);
        this.getSlideByProductId(this.$route.params.id);
      },
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

    getProduct(id) {
      this.loading = true;
      axios
        .get(`/api/products/detail/${id}`)
        .then((response) => {
          this.product = response.data.data;
          this.product.price = parseInt(this.product.price).toLocaleString("en-US", {
            currency: "VND",
          });
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
          this.products = {};
          Swal.fire({
            width: 610,
            icon: "error",
            title: "Không có sản phẩm",
            allowOutsideClick: false,
            allowEscapeKey: false,
          });
          setTimeout(() => {
            this.$router.go(-1);
          }, 2000);
        });
    },

    getRelativeProducts(id) {
      axios
        .get(`/api/products/relative/${id}`)
        .then((response) => {
          this.relativeProducts = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getSlideByProductId(product_id) {
      this.slides = {};
      axios
        .get(`/api/slides/${product_id}`)
        .then((response) => {
          this.slides = response.data.data;
        })
        .catch((error) => {
          this.slides = {};
        });
    },

    next() {
      this.current++;
      if (this.current === this.slides.length) {
        this.current = 0;
      }
    },

    slideLoop() {
      this.timer = setInterval(this.next, 2000);
    },

    changeCurrentSlide(i) {
      this.current = i;
    },
  },

  mounted() {
    this.getSlideByProductId(this.$route.params.id);
    this.getType();
    this.getProducer();
    this.getProduct(this.$route.params.id);
    this.getRelativeProducts(this.$route.params.id);
    this.slideLoop();
  },
};
</script>

<style scoped>
.description {
  overflow: hidden;
  line-height: 2rem;
  max-height: 264px;
  -webkit-box-orient: vertical;
  display: block;
  display: -webkit-box;
  overflow: hidden !important;
  text-overflow: ellipsis;
  -webkit-line-clamp: 4;
}
</style>
