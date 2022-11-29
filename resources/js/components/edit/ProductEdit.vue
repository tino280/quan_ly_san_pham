<template>
  <Header />

  <div class="containerrr">
    <div class="grid">
      <div class="grid__row">
        <div class="grid__column-2">
          <Sidebar
            :types="types"
            :producers="producers"
            :ok="false"
            :checkAdmin="false"
          />
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
                            <option
                              v-for="producer in producers"
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
                        <p style="color: red">{{ error.image }}</p>
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
                                    @click="this.$refs.create[i - 1].click()"
                                    :disabled="isDisabled"
                                  >
                                    <img
                                      src="http://nccdn-traning-php.test:8080/image/add-slide.svg"
                                      alt=""
                                    />
                                  </button>
                                  <div v-else style="height: 100%">
                                    <img
                                      class="image-slide"
                                      :src="srcSlide[`slot${i}`]"
                                    />
                                    <button
                                      type="button"
                                      class="my-btn btn-edit-slide"
                                      @click="this.$refs.update[i - 1].click()"
                                      :disabled="isDisabled"
                                    >
                                      Sửa
                                    </button>
                                    <button
                                      type="button"
                                      class="my-btn btn-delete-slide"
                                      @click="handleDeleteSlide(slideId[`slot${i}`], i)"
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
    ref="create"
    @change="handleCreateSlide(i)"
  />

  <input
    type="file"
    hidden
    v-for="i in 4"
    :key="i"
    ref="update"
    @change="handleUpdateSlide(i)"
  />
</template>

<script>
import Auth from "../../Auth";
export default {
  data() {
    return {
      product: {
        id: "",
        name: "",
        type_id: "",
        producer_id: "",
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
      slideImage: "",
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
        image: "",
        slide1: "",
        slide2: "",
        slide3: "",
        slide4: "",
      },
      srcImage: "",
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
      createSlide: {
        slot1: "",
        slot2: "",
        slot3: "",
        slot4: "",
      },
      updateSlide: {
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
    };
  },

  watch: {
    product: {
      handler: function () {
        this.error.name = "";
        this.error.price = "";
        this.error.description = "";
      },
      deep: true,
    },
  },

  methods: {
    getProductById(id) {
      axios
        .get(`/api/products/detail/${id}`)
        .then((response) => {
          this.product = response.data.data;
          this.srcImage = `http://nccdn-traning-php.test:8080/image/description/${this.product.id}/${this.product.image_link}`;
          this.product.image_link = "";
        })
        .catch((error) => {
          console.log(error);
          this.showAlert("Không có sản phẩm", "Delete_file.svg");
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

    getSlideByProductId(product_id) {
      axios
        .get(`/api/slides/${product_id}`)
        .then((response) => {
          this.slides = response.data.data;
          this.slides.forEach((slide) => {
            this.addSlide[`slot${slide.slot}`] = false;
            this.srcSlide[
              `slot${slide.slot}`
            ] = `http://nccdn-traning-php.test:8080/image/slide/${product_id}/${slide.image}`;
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
      let isUpdateSuccess = true;
      // create slide
      for (let i = 1; i <= 4; i++) {
        //create slide
        if (this.createSlide[`slot${i}`]) {
          const formData = new FormData();
          formData.append("slot", i);
          formData.append("image", this.slideImage);
          formData.append("image", this.createSlide[`slot${i}`]);
          formData.append("product_id", this.product.id);
          const headers = { "Content-Type": "multipart/form-data" };
          axios
            .post("/api/slides/store", formData, { headers })
            .then(() => {
              this.addSlide[`slot${i}`] = false;
              this.$refs.create[i - 1].value = null;
            })
            .catch((error) => {
              console.error(error);
              isUpdateSuccess = false;
            });
        }
        //update slide
        if (this.updateSlide[`slot${i}`]) {
          const formData = new FormData();
          formData.append("_method", "put");
          formData.append("slot", i);
          formData.append("image", this.updateSlide[`slot${i}`]);
          formData.append("product_id", this.product.id);
          const headers = { "Content-Type": "multipart/form-data" };
          if (this.slideId[`slot${i}`]) {
            let id = this.slideId[`slot${i}`];
            axios
              .post(`/api/slides/update/${id}`, formData, { headers })
              .then((response) => {
                this.addSlide[`slot${i}`] = false;
                this.$refs.update[i - 1].value = null;
              })
              .catch((error) => {
                console.log(error);
                this.getSlideByProductId(this.$route.params.id);
                this.showAlert("Không có ảnh slide", "Delete_file.svg");
                isUpdateSuccess = false;
              });
          } else {
            formData.delete("_method");
            axios
              .post("/api/slides/store", formData, { headers })
              .then(() => {
                this.addSlide[`slot${i}`] = false;
                this.$refs.update[i - 1].value = null;
              })
              .catch((error) => {
                console.error(error);
                this.showAlert("Không có ảnh slide", "Delete_file.svg");
                this.getSlideByProductId(this.$route.params.id);
                isUpdateSuccess = false;
              });
          }
        }

        //delete slide
        if (this.deleteSlide[`slot${i}`]) {
          if (this.slideId[`slot${i}`]) {
            let id = this.slideId[`slot${i}`];
            axios
              .delete(`/api/slides/delete/${id}`)
              .then((response) => {
                this.addSlide[`slot${i}`] = true;
              })
              .catch((error) => {
                console.log(error);
                isUpdateSuccess = false;
                this.showAlert("Không có ảnh slide", "Delete_file.svg");
                this.getSlideByProductId(this.$route.params.id);
                this.deleteSlide[`slot${i}`] = false;
              });
          }
        }
      }
      //update product
      const formData = new FormData();
      formData.append("name", this.product.name);
      formData.append("type_id", this.product.type_id);
      formData.append("producer_id", this.product.producer_id);
      formData.append("price", this.product.price);
      formData.append("description", this.product.description);
      if (this.product.image_link) {
        formData.append("image_link", this.product.image_link);
      }
      formData.append("_method", "put");
      const headers = { "Content-Type": "multipart/form-data" };
      axios
        .post(`/api/products/update/${this.product.id}`, formData, { headers })
        .then((response) => {
          if (response.data.status === 200) {
            this.$emit("reloadList");
            this.$refs.image.value = null;
          } else {
            this.showAlert("Không có sản phẩm", "Delete_file.svg");
            this.$emit("reloadList");
            setTimeout(() => {
              this.$router.go(-1);
            }, 2000);
          }
        })
        .catch((error) => {
          isUpdateSuccess = false;
          const messageError = error.response.data.errors;
          Object.entries(messageError).forEach((message) => {
            this.error[message[0]] = message[1][0];
          });
        });
      setTimeout(() => {
        if (isUpdateSuccess) {
          this.showAlert("Cập nhập thành công!", "present_1.png");
          setTimeout(() => {
            window.location.href =
              "http://nccdn-traning-php.test:8080/product/detail/" + this.product.id;
          }, 2000);
        } else {
          this.isDisabled = false;
        }
      }, 500);
    },

    handleCreateSlide(i) {
      this.updateSlide[`slot${i}`] = "";
      this.$refs.update[i - 1].value = null;
      this.error[`slide${i}`] = "";
      const validImageTypes = ["image/gif", "image/jpeg", "image/png"];
      const file = this.$refs.create[i - 1]["files"][0];
      this.createSlide[`slot${i}`] = file;
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

    handleUpdateSlide(i) {
      this.createSlide[`slot${i}`] = "";
      this.deleteSlide[`slot${i}`] = "";
      this.$refs.create[i - 1].value = null;
      const validImageTypes = ["image/gif", "image/jpeg", "image/png"];
      const file = this.$refs.update[i - 1]["files"][0];
      this.updateSlide[`slot${i}`] = file;
      const fileType = file["type"];
      if (!validImageTypes.includes(fileType)) {
        this.error[`slide${i}`] = "File vừa chọn không phải là ảnh";
        return;
      }
      const fileReader = new FileReader();
      fileReader.readAsDataURL(file);
      fileReader.onload = () => {
        const url = fileReader.result;
        this.srcSlide[`slot${i}`] = url;
      };
    },

    handleDeleteSlide(id, i) {
      this.addSlide[`slot${i}`] = true;
      this.deleteSlide[`slot${i}`] = true;
      this.createSlide[`slot${i}`] = "";
      this.updateSlide[`slot${i}`] = "";
      this.$refs.create[i - 1].value = null;
      this.$refs.update[i - 1].value = null;
    },

    showAlert(message, image) {
      Swal.fire({
        width: 560,
        html: `<h3>${message}</h3>`,
        imageUrl: `http://nccdn-traning-php.test:8080/image/${image}`,
        imageWidth: 120,
        imageHeight: 120,
        showCloseButton: true,
        showConfirmButton: false,
      });
    },
  },

  mounted() {
    this.getProductById(this.$route.params.id);
    this.getType();
    this.getProducer();
    this.getSlideByProductId(this.$route.params.id);
  },
};
</script>
