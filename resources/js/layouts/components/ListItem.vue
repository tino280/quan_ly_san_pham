<template>
  <div class="grid__column-4">
    <div class="product" style="padding: 20px">
      <router-link
        :to="{
          path: `product/detail/${product.id}`,
        }"
      >
        <img
          class="mb-2 product-image"
          :src="`${host}/image/description/${product.id}/${product.image_link}`"
          alt=""
        />
      </router-link>
      <p
        class="name"
        style="font-weight: bold; font-size: 1.4rem; margin: 10px 20px 10px 0"
      >
        {{ product.name }}
      </p>
      <p style="font-size: 1.4rem; margin: 10px 20px 10px 0; color: #62677a">
        {{
          "$ " +
          parseInt(product.price).toLocaleString("en-US", {
            currency: "VND",
          })
        }}
      </p>
      <p style="font-size: 1.4rem; margin: 10px 20px 10px 0; color: #62677a">
        {{ product.user.name }}
      </p>
      <div v-if="checkAdmin" class="btn-group">
        <router-link
            class="my-btn my-btn-success"
            :to="`/product/edit/${product.id}`"
        >
          Cập nhập
        </router-link>

        <button
          class="my-btn my-btn-danger"
          type="button"
          data-bs-toggle="modal"
          :data-bs-target="`#delete-product-${product.id}`"
        >
          Xóa
        </button>

        <div
          class="modal fade"
          :id="`delete-product-${product.id}`"
          tabindex="-1"
          aria-labelledby="deleteproduct"
          aria-hidden="true"
        >
          <div class="modal-dialog" style="top: 30px">
            <div class="modal-content" style="border-radius: 16px">
              <div class="modal-delete">
                <div style="margin-bottom: 30px">
                  <img :src="`${host}/image/delete_file.svg`" alt="" />
                </div>
                <div>
                  <p>
                    <span>Bạn có chắc muốn xóa sản phẩm </span>
                    <span class="product-name" style="color: var(--red-color)">{{
                      product.name
                    }}</span
                    >?
                  </p>
                </div>
                <div>
                  <p>
                    <span>Sản phẩm sẽ bị </span>
                    <span style="color: var(--red-color)">xóa vĩnh viễn</span>.
                  </p>
                </div>
                <div
                  style="
                    width: 75%;
                    display: flex;
                    justify-content: space-around;
                    margin-top: 20px;
                  "
                >
                  <button class="my-btn w my-btn-destroy-modal" data-bs-dismiss="modal">
                    Hủy
                  </button>
                  <button
                    class="my-btn w my-btn-delete-product"
                    type="button"
                    @click="deleteProduct(product.id)"
                  >
                    Xóa
                  </button>
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
import Auth from "../../Auth";
import Loading from "../components/Loading.vue";
export default {
  components: {
    Loading,
  },
  emits: ["productChanged"],
  props: {
    product: {},
    checkAdmin: "",
  },

  data() {
    return {
      host: window.location.origin,
      loading: false,
    };
  },

  methods: {
    deleteProduct(id) {
      this.loading = true;
      this.closeModal(id);
      Auth.updateToken();
      axios
        .delete(`/api/products/delete/${id}`)
        .then((response) => {
          this.reloadListProduct();
          this.loading = false;
          this.showAlert("Xóa sản phẩm thành công!", "Delete_file.svg");
        })
        .catch((error) => {
          this.loading = false;
          // console.log(error);
          // this.showAlert("Không có sản phẩm!", "Delete_file.svg");
          Swal.fire({
            icon: "error",
            title: "Xóa thất bại",
            text: error.response.data.message,
          });
          this.reloadListProduct();
        });
    },

    showAlert(message, image) {
      Swal.fire({
        width: 610,
        html: `<h3>${message}</h3>`,
        imageUrl: `http://nccdn-traning-php.test:8080/image/${image}`,
        imageWidth: 120,
        imageHeight: 120,
        imageAlt: "Hình ảnh thùng rác",
        showCloseButton: true,
        showConfirmButton: false,
      });
    },

    closeModal(id) {
      const myModalEl = document.getElementById(`delete-product-${id}`);
      const modal = bootstrap.Modal.getInstance(myModalEl);
      modal.hide();
    },

    reloadListProduct() {
      axios
        .get("/api/products", { params: this.$route.query })
        .then((response) => {
          this.$emit("productChanged");
        })
        .catch((error) => {
          console.error(error);
          if (this.$route.query.page > 1) {
            let query = Object.assign({}, this.$route.query);
            query.page = this.$route.query.page - 1;
            this.$router.replace({ query });
          } else if (!this.$route.query.page) {
            this.$emit("productChanged");
          }
        });
    },
  },
};
</script>

<style scoped>
.my-btn {
  width: 140px;
  height: 40px;
}

.my-btn:hover {
  color: white;
}

.w {
  width: 90px;
}

.my-btn-destroy-modal:hover {
  color: black;
}
</style>
