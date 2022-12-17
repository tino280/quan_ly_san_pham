<template>
  <Header />

  <div class="containerrr">
    <div class="grid">
      <div class="grid__row">
        <div class="grid__column-2">
          <Sidebar :types="types" :ok="false" :checkAdmin="false" />
        </div>

        <div class="grid__column-10">
          <div class="main">
            <div class="content">
              <div class="grid">
                <div class="grid__row" style="padding: 12px; min-height: 530px">
                  <div
                    style="margin-top: 10px; margin-left: 30px; width: 100%"
                    class="form-edit"
                  >
                    <div style="flex: 2">
                      <div style="margin-bottom: 13px">
                        <span style="font-size: 1.4rem; font-weight: 500"
                          >Thông tin sản phẩm
                        </span>
                      </div>
                      <div>
                        <div class="mb6" style="font-size: 1.4rem">
                          Tên sản phẩm<span style="color: red">*</span>
                        </div>
                        <div class="mb15">
                          <input
                            class="input-edit"
                            type="text"
                            style="padding-left: 15px"
                            v-model="product.name"
                          />
                          <p style="color: red" id="error-name">
                            {{ error.name }}
                          </p>
                        </div>
                      </div>
                      <div>
                        <div class="mb6" style="font-size: 1.4rem">
                          Danh mục sản phẩm<span style="color: red">*</span>
                        </div>
                        <div class="mb15">
                          <select
                            class="input-edit"
                            style="padding-left: 10px"
                            v-model="product.type_id"
                            @change="handleChangeTypeId(product.type_id)"
                          >
                            <option v-for="type in types" :key="type.id" :value="type.id">
                              {{ type.name }}
                            </option>
                          </select>
                          <p style="color: red">{{ error.type_id }}</p>
                        </div>
                      </div>
                      <div>
                        <div class="mb6" style="font-size: 1.4rem">
                          Hãng sản xuất<span style="color: red">*</span>
                        </div>
                        <div class="mb15">
                          <select
                            class="input-edit"
                            style="padding-left: 10px"
                            v-model="product.producer_id"
                          >
                            <option value="">Chọn hãng sản xuất</option>
                            <option
                              v-for="producer in producerInput"
                              :key="producer.id"
                              :value="producer.id"
                            >
                              {{ producer.name }}
                            </option>
                          </select>
                          <p style="color: red">{{ error.producer_id }}</p>
                        </div>
                      </div>
                      <div>
                        <div class="mb6" style="font-size: 1.4rem">
                          Giá<span style="color: red">*</span>
                        </div>
                        <div class="mb15">
                          <input
                            class="input-edit"
                            type="text"
                            style="padding-left: 10px"
                            v-model="product.price"
                          />
                          <p style="color: red">{{ error.price }}</p>
                        </div>
                      </div>
                      <div>
                        <div style="font-size: 1.4rem">
                          Mô tả<span style="color: red">*</span>
                        </div>
                        <div class="textbox">
                          <textarea
                            class="input-textbox"
                            type="text"
                            v-model="product.description"
                          ></textarea>
                          <p style="color: red">{{ error.description }}</p>
                        </div>
                      </div>
                      <div class="group-btn">
                        <button
                          class="my-btn my-btn-add"
                          type="button"
                          style="width: 90px"
                          @click="$router.go(-1)"
                          :disabled="isDisabled"
                        >
                          Hủy
                        </button>
                        <button
                          class="my-btn my-btn-blue"
                          type="button"
                          @click="handleUpdateProduct"
                          :disabled="isDisabled"
                        >
                          Lưu
                        </button>
                      </div>
                    </div>

                    <div style="flex: 3">
                      <div style="position: relative">
                        <div class="mb6 edit-image-description">
                          Ảnh minh họa<span style="color: red">*</span>
                        </div>
                        <img class="edit-image" :src="srcImage" />
                        <p style="color: red">{{ error.image }} {{ error.image_link }}</p>
                        <button
                          type="button"
                          class="my-btn btn-edit-image"
                          @click="this.$refs.image.click()"
                          :disabled="isDisabled"
                        >
                          Sửa
                        </button>
                        <input type="file" hidden @change="addImage" ref="image" />
                      </div>

                      <div style="font-size: 1.4rem; margin-top: 26px">Ảnh slide</div>
                      <div style="width: 100%; margin-top: 26px">
                        <div class="grid">
                          <div class="grid__row">
                            <div v-for="i in 4" :key="i" class="grid__column-6">
                              <div>Ảnh {{ i }}</div>
                              <div style="height: 100%">
                                <p style="color: red">{{ error[`slide${i}`] }}</p>
                                <div
                                  style="
                                    height: 120px;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                  "
                                >
                                  <button
                                    v-if="addSlide[`slot${i}`]"
                                    type="button"
                                    class="add-slide"
                                    @click="this.$refs.slide[i - 1].click()"
                                    :disabled="isDisabled"
                                  >
                                    <img :src="`${host}/image/add-slide.svg`" alt="" />
                                  </button>
                                  <div v-else style="height: 100%; position: relative">
                                    <img
                                      class="image-slide"
                                      :src="srcSlide[`slot${i}`]"
                                    />
                                    <button
                                      type="button"
                                      class="my-btn btn-edit-slide"
                                      @click="this.$refs.slide[i - 1].click()"
                                      :disabled="isDisabled"
                                    >
                                      Sửa
                                    </button>
                                    <button
                                      type="button"
                                      class="my-btn btn-delete-slide"
                                      @click="handleDeleteSlide(i)"
                                      :disabled="isDisabled"
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
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <input
    type="file"
    hidden
    v-for="i in 4"
    :key="i"
    ref="slide"
    @change="handleChangeSlide(i)"
  />
  <Loading :loading="loading" />
</template>

<script>
import Auth from "../../Auth";
import Loading from "../components/Loading.vue";
export default {
  components: {
    Loading,
  },
  data() {
    return {
      product: {
        id: "",
        name: "",
        type_id: "",
        producer_id: " ",
        price: "",
        description: "",
        image_link: "",
      },
      types: {
        id: "",
        name: "",
      },
      producers: {
        id: "",
        name: "",
      },
      slides: [],
      slideId: {
        slot1: "",
        slot2: "",
        slot3: "",
        slot4: "",
      },
      error: {
        name: "",
        type_id: "",
        producer_id: "",
        price: "",
        description: "",
        image_link: "",
        image: "",
        slide1: "",
        slide2: "",
        slide3: "",
        slide4: "",
      },
      srcImage: "",
      originImage: "",
      addSlide: {
        slot1: true,
        slot2: true,
        slot3: true,
        slot4: true,
      },
      srcSlide: {
        slot1: "",
        slot2: "",
        slot3: "",
        slot4: "",
      },
      isDisabled: false,
      inputSlide: {
        slot1: "",
        slot2: "",
        slot3: "",
        slot4: "",
      },
      deleteSlide: {
        slot1: false,
        slot2: false,
        slot3: false,
        slot4: false,
      },
      host: window.location.origin,
      producerInput: {},
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
    "srcSlide.slot1": {
      handler: function () {
        this.error.slide1 = "";
      },
    },
    "srcSlide.slot2": {
      handler: function () {
        this.error.slide2 = "";
      },
    },
    "srcSlide.slot3": {
      handler: function () {
        this.error.slide3 = "";
      },
    },
    "srcSlide.slot4": {
      handler: function () {
        this.error.slide4 = "";
      },
    },
  },

  methods: {
    getProductById(id) {
      this.loading = true;
      axios
        .get(`/api/products/detail/${id}`)
        .then((response) => {
          this.product = response.data.data;
          this.srcImage = `${this.host}/image/description/${this.product.id}/${this.product.image_link}`;
          this.originImage = this.srcImage;
          this.product.image_link = "";
          axios
            .get(`/api/producers/types/${this.product.type_id}`)
            .then((response) => {
              this.loading = false;
              this.producerInput = response.data.data;
            })
            .catch((error) => {
              this.loading = false;
              console.log(error);
            });
        })
        .catch((error) => {
          console.log(error);
          Swal.fire({
            icon: "error",
            title: error.response.data.message,
          });
          this.$emit("reloadList");
          setTimeout(() => {
            this.$router.go(-1);
          }, 2000);
        });
    },

    getType() {
      axios
        .get("/api/types")
        .then((response) => {
          this.types = response.data.data;
        })
        .catch((error) => {
          console.log(error);
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

    getProducerByTypeId(typeId) {
      axios
        .get(`/api/producers/types/${typeId}`)
        .then((response) => {
          this.producerInput = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getSlideByProductId(product_id) {
      axios
        .get(`/api/slides/${product_id}`)
        .then((response) => {
          this.slides = response.data.data;
          this.slides.forEach((slide) => {
            this.addSlide[`slot${slide.slot}`] = false;
            this.srcSlide[
              `slot${slide.slot}`
            ] = `${this.host}/image/slide/${product_id}/${slide.image}`;
            this.slideId[`slot${slide.slot}`] = slide.id;
          });
        })
        .catch((error) => {
          if (error.response.data.message === "Unauthenticated.") {
            this.$router.push("/login");
          }
        });
    },

    addImage() {
      const validImageTypes = ["image/gif", "image/jpeg", "image/png"];
      const file = this.$refs.image["files"][0];
      this.product.image_link = file;
      const fileType = file["type"];
      if (!validImageTypes.includes(fileType)) {
        this.error.image = "File vừa chọn không phải là ảnh";
        return;
      }
      this.error.image = "";
      const fileReader = new FileReader();
      fileReader.readAsDataURL(file);
      fileReader.onload = () => {
        const url = fileReader.result;
        this.srcImage = url;
      };
    },

    handleUpdateProduct() {
      Auth.updateToken();
      this.isDisabled = true;
      this.loading = true;
      this.error = {};
      const formData = new FormData();
      formData.append("name", this.product.name);
      formData.append("type_id", this.product.type_id);
      formData.append("producer_id", this.product.producer_id);
      formData.append("price", this.product.price);
      formData.append("description", this.product.description);
      if (this.product.image_link) {
        formData.append("image_link", this.product.image_link);
        this.product.image_link = "";
      }
      for (let i = 1; i <= 4; i++) {
        let slide;
        if (this.$refs.slide[i - 1]["files"][0]) {
          slide = this.$refs.slide[i - 1]["files"][0];
          this.$refs.slide[i - 1].value = null;
        } else {
          slide = "";
        }
        formData.append(`slide${i}`, slide);

        if (this.slideId[`slot${i}`]) {
          if (this.deleteSlide[`slot${i}`]) {
            formData.append(`deleteSlide${i}`, 1);
          }
        }
      }
      const headers = { "Content-Type": "multipart/form-data" };
      axios
        .post(`/api/products/update/${this.product.id}`, formData, { headers })
        .then((response) => {
          this.$emit("reloadList");
          this.loading = false;
          this.$refs.image.value = null;
          Swal.fire({
            width: 560,
            html: `<h3>${response.data.message}</h3>`,
            imageUrl: `${this.host}/image/present_1.png`,
            imageWidth: 120,
            imageHeight: 120,
            showCloseButton: false,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
          });
          setTimeout(() => {
            this.isDisabled = false;
            window.location.href = `${this.host}/product/detail/` + this.product.id;
          }, 2000);
        })
        .catch((error) => {
          this.isDisabled = false;
          this.loading = false;
          if (error.response.status === 400) {
            if (error.response.data.status === 401) {
              Swal.fire({
                icon: "error",
                title: error.response.data.message,
              });
              this.$emit("reloadList");
              setTimeout(() => {
                this.$router.go(-1);
              }, 2000);
            } else {
              Swal.fire({
                icon: "error",
                title: error.response.data.message,
              });
              this.getSlideByProductId(this.product.id);
            }
          } else if (error.response.status === 422) {
            this.srcImage = this.originImage;
            Swal.fire({
              icon: "error",
              title: "Cập nhập thất bại",
            });
            const messageError = error.response.data.errors;
            Object.entries(messageError).forEach((message) => {
              this.error[message[0]] = message[1][0];
            });
          }
        });
    },

    handleChangeSlide(i) {
      const validImageTypes = ["image/gif", "image/jpeg", "image/png"];
      this.deleteSlide[`slot${i}`] = false;
      const file = this.$refs.slide[i - 1]["files"][0];
      const fileType = file["type"];
      if (!validImageTypes.includes(fileType)) {
        this.error[`slide${i}`] = "File vừa chọn không phải là ảnh";
        return;
      }
      this.addSlide[`slot${i}`] = false;
      const fileReader = new FileReader();
      fileReader.readAsDataURL(file);
      fileReader.onload = () => {
        const url = fileReader.result;
        this.srcSlide[`slot${i}`] = url;
      };
    },

    handleDeleteSlide(i) {
      this.addSlide[`slot${i}`] = true;
      this.deleteSlide[`slot${i}`] = true;
      this.inputSlide[`slot${i}`] = "";
      this.srcSlide[`slot${i}`] = "";
      this.$refs.slide[i - 1].value = null;
    },

    handleChangeTypeId(typeId) {
      this.product.producer_id = "";
      this.getProducerByTypeId(typeId);
    },
  },

  mounted() {
    this.getProductById(this.$route.params.id);
    this.getType();
    this.getProducer();
    this.getSlideByProductId(this.$route.params.id);
    console.log(axios.defaults.headers);
  },
};
</script>

<style scoped>
p {
  height: 15px;
}
</style>
