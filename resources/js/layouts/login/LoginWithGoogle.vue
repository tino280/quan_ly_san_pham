<script setup>
import { ref, reactive } from "vue";
import { useRouter, useRoute } from "vue-router";
import Auth from "../../Auth";
import { googleTokenLogin } from "vue3-google-login";

const router = useRouter();
const route = useRoute();

const user = reactive({
  email: "",
  password: "",
  remember_me: null,
});

const errorAuth = ref("");
const errorValidate = reactive({
  email: "",
  password: "",
});
const loading = ref(false);
const host = window.location.origin;

const login = () => {
  loading.value = true;
  axios
    .post("/api/login", user)
    .then((response) => {
      Auth.login(response.data.access_token, response.data.user);
      loading.value = false;
      if (route.query.redirect) {
        router.push(route.query.redirect);
        return;
      }
      router.push({ name: "admin" });
    })
    .catch((error) => {
      loading.value = false;
      console.log(error);
      if (error.response.status === 422) {
        const errorMessage = error.response.data.errors;
        Object.entries(errorMessage).forEach((error) => {
          console.log(error);
          errorValidate[error[0]] = error[1][0];
        });
      } else {
        errorAuth.value = "Email hoặc mật khẩu không đúng";
      }
    });
};

const loginGoogle = () => {
  googleTokenLogin().then((response) => {
    console.log("Handle the response", response);
  });
};
</script>

<template>
  <div class="login">
    <div class="logo-login">
      <img :src="`${host}/image/logo.png`" class="logo-image" />
    </div>
    <div class="form-login">
      <form class="form-body">
        <div>
          <label for="email">Email</label>
          <div class="form-input">
            <input
              class="input"
              type="email"
              v-model="user.email"
              @keydown="clearError"
            />
          </div>
          <p>{{ errorValidate.email }}</p>
        </div>

        <div>
          <label for="password">Mật khẩu</label>
          <div class="form-input">
            <input
              class="input"
              type="password"
              v-model="user.password"
              @keydown="clearError"
            />
          </div>
          <p>{{ errorValidate.password }}</p>
        </div>

        <div style="margin-top: 15px">
          <label for="remember_me" style="display: flex">
            <input type="checkbox" v-model="user.remember_me" />
            <span style="margin-left: 5px">Remember me</span>
          </label>
        </div>

        <p>{{ errorAuth }}</p>

        <div
          style="
            margin-top: 30px;
            display: flex;
            align-items: center;
            flex-direction: column;
          "
        >
          <button class="btn-login" type="button" @click="login">Đăng nhập</button>
          <button @click="loginGoogle">Login Using Google</button>
        </div>
      </form>
    </div>
  </div>
  <div class="process" v-if="loading">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</template>
