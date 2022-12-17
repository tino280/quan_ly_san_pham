<template>
  <div
    class="modal fade"
    id="add-product"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
  >
    <div class="modal-dialog" style="top: 30px">
      <div class="modal-content" style="top: -25px">
        <form>
          <div class="modal-header" style="padding: 20px 20px">
            <h5 class="modal-title">THÊM SẢN PHẨM</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="resetModal"
            ></button>
          </div>
          <div class="modal-body" style="margin: 0 20px">
            <div class="container-fluid">
              <div class="row row-name">
                <div class="col-md-4">
                  Tên sản phẩm<span style="color: red">* {{ error.name }} </span>
                </div>
                <input
                  class="modal-input name"
                  type="text"
                  name="name"
                  placeholder="Nhập tên sản phẩm"
                  v-model="product.name"
                />
              </div>
              <div class="row row-type_id">
                <div class="col-md-4">
                  Danh mục sản phẩm<span style="color: red">* {{ error.type_id }} </span>
                </div>
                <select
                  class="modal-input type_id"
                  name="type_id"
                  v-model="product.type_id"
                  @change="handleChange(product.type_id)"
                >
                  <option value="" selected>Chọn danh mục sản phẩm</option>
                  <option v-for="type in types" :key="type.id" :value="type.id">
                    {{ type.name }}
                  </option>
                </select>
              </div>
              <div class="row row-producer_id">
                <div class="col-md-4">
                  Hãng sản xuất<span style="color: red">* {{ error.producer_id }} </span>
                </div>
                <select
                  class="modal-input producer_id"
                  name="producer_id"
                  v-model="product.producer_id"
                >
                  <option value="" :selected="ok">Chọn hãng sản xuất</option>
                  <option
                    v-for="producer in producers"
                    :key="producer.id"
                    :value="producer.id"
                  >
                    {{ producer.name }}
                  </option>
                </select>
              </div>
              <div class="row row-price">
                <div class="col-md-4">
                  Giá<span style="color: red">* {{ error.price }} </span>
                </div>
                <input
                  class="modal-input price"
                  type="text"
                  name="price"
                  placeholder="Nhập giá sản phẩm"
                  v-model="product.price"
                />
              </div>
              <div class="row row-description">
                <div class="col-md-4">
                  Mô tả<span style="color: red">* {{ error.description }} </span>
                </div>
                <textarea
                  class="modal-input description"
                  name="description"
                  placeholder="Nhập mô tả"
                  style="height: 120px"
                  v-model="product.description"
                ></textarea>
              </div>
              <div class="row">
                <div
                  id="add-image"
                  class="col-md-4 btn-add-image"
                  @click="this.$refs.fileInput.click()"
                >
                  <span>Thêm ảnh minh họa</span
                  ><span style="color: red"
                    >* {{ error.image_link }} {{ error.image }}
                  </span>
                </div>
                <input
                  class="modal-input image_link"
                  type="file"
                  name="image_link"
                  hidden
                  ref="fileInput"
                  @change="addImage"
                />
              </div>
              <div class="row" style="margin-bottom: 10px">
                File:
                <span v-if="product.image_link"> {{ product.image_link["name"] }}</span>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="height: 70px">
            <button
              type="button"
              class="my-btn my-btn-modal-reset"
              data-bs-dismiss="modal"
              @click="resetModal"
            >
              Hủy
            </button>
            <button type="button" class="my-btn my-btn-modal-add" @click="handelSubmit">
              Thêm
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <Loading :loading="loading" />
</template>

<script>
import Loading from "../../components/Loading.vue";
export default {
  components: {
    Loading,
  },
  emits: ["reloadList"],
  props: {
    types: {},
  },
  data() {
    return {
      product: {
        name: "",
        type_id: "",
        producer_id: "",
        price: "",
        description: "",
        image_link: "",
      },
      producers: {},
      error: {
        name: "",
        type_id: "",
        producer_id: "",
        price: "",
        description: "",
        image_link: "",
        image: "",
      },
      ok: true,
      host: window.location.origin,
      loading: false,
    };
  },

  watch: {
    "product.name": {
      handler: function () {
        this.error.name = "";
      },
    },
    "product.type_id": {
      handler: function () {
        this.error.type_id = "";
      },
    },
    "product.producer_id": {
      handler: function () {
        this.error.producer_id = "";
      },
    },
    "product.price": {
      handler: function () {
        this.error.price = "";
      },
    },
    "product.description": {
      handler: function () {
        this.error.description = "";
      },
    },
    "product.image_link": {
      handler: function () {
        this.error.image_link = "";
      },
    },
  },

  methods: {
    addImage() {
      const validImageTypes = ["image/gif", "image/jpeg", "image/png"];
      this.product.image_link = this.$refs.fileInput["files"][0];
      if (!this.product.image_link) {
        this.product.image_link = "";
        product.image_link["name"] = "";
        return;
      }
      const fileType = this.product.image_link["type"];
      if (!validImageTypes.includes(fileType)) {
        this.error.image = "File vừa chọn không phải là ảnh";
        return;
      }
    },

    handleChange(typeId) {
      if (!typeId) {
        this.ok = true;
        this.producers = {};
      } else {
        this.product.producer_id = "";
        axios
          .get(`/api/producers/types/${typeId}`)
          .then((response) => {
            this.producers = response.data.data;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },

    handelSubmit() {
      this.loading = true;
      this.resetError();
      this.error.image = "";
      const formData = new FormData();
      formData.append("name", this.product.name);
      formData.append("type_id", this.product.type_id);
      formData.append("producer_id", this.product.producer_id);
      formData.append("price", this.product.price);
      formData.append("description", this.product.description);
      formData.append("image_link", this.product.image_link);
      const headers = { "Content-Type": "multipart/form-data" };
      axios
        .post("api/products/store", formData, { headers })
        .then((response) => {
          this.resetProduct();
          this.$refs.fileInput.value = null;
          const myModalEl = document.getElementById("add-product");
          const modal = bootstrap.Modal.getInstance(myModalEl);
          modal.hide();
          Swal.fire({
            width: 610,
            html: "<h3>Thêm thành công!</h3>",
            imageUrl: `${this.host}/image/present_1.png`,
            imageWidth: 120,
            imageHeight: 120,
            imageAlt: "Hình ảnh hộp quà",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
          });
          this.$emit("reloadList");
          this.loading = false;
          setTimeout(() => {
            window.location.href = `${this.host}/product/detail/${response.data.data.id}`;
          }, 2000);
        })
        .catch((error) => {
          this.loading = false;
          Swal.fire({
            icon: "error",
            title: "Thêm thất bại!",
          });
          const messageError = error.response.data.errors;
          Object.entries(messageError).forEach((error) => {
            this.error[error[0]] = error[1][0];
          });
        });
    },

    resetModal() {
      this.resetProduct();
      this.resetError();
    },

    resetProduct() {
      this.product.name = "";
      this.product.price = "";
      this.product.description = "";
      this.product.image_link = "";
    },

    resetError() {
      this.error.name = "";
      this.error.type_id = "";
      this.error.producer_id = "";
      this.error.price = "";
      this.error.description = "";
      this.error.image_link = "";
      this.error.image = "";
    },
  },
};
</script>

<style scoped>
span {
  height: 15px;
}

.col-md-4 {
  width: 100%;
}

.row {
  display: block;
}

.my-btn {
  width: 140px;
  height: 35px;
}
</style>
