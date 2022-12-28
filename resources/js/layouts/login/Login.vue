<template>
  <div class="login">
    <div class="logo-login">
      <img :src="`${host}/image/logo.png`" class="logo-image" />
    </div>
    <div class="form-login">
      <div class="form-body">
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
          <div class="google-btn" @click="loginGoogle">
            <div class="google-icon-wrapper">
              <img
                class="google-icon"
                src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"
              />
            </div>
            <p class="btn-text"><b>Sign in with google</b></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="process" v-if="loading">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</template>

<script>
import Auth from "../../Auth";
import { googleTokenLogin } from "vue3-google-login";
import axios from "axios";

export default {
  data() {
    return {
      user: {
        email: "",
        password: "",
        remember_me: null,
      },
      errorAuth: "",
      errorValidate: {
        email: "",
        password: "",
      },
      loading: false,
      host: window.location.origin,
    };
  },

  methods: {
    login() {
      this.loading = true;
      axios
        .post("/api/login", this.user)
        .then((response) => {
          Auth.login(response.data.access_token, response.data.user);
          this.loading = false;
          if (this.$route.query.redirect) {
            this.$router.push(this.$route.query.redirect);
            return;
          }
          this.$router.push({ name: "admin" });
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
          if (error.response.status === 422) {
            const errorMessage = error.response.data.errors;
            Object.entries(errorMessage).forEach((error) => {
              console.log(error);
              this.errorValidate[error[0]] = error[1][0];
            });
          } else {
            this.errorAuth = "Email hoặc mật khẩu không đúng";
          }
        });
    },

    loginGoogle() {
      googleTokenLogin().then((response) => {
        axios
          .post("/api/loginGoogle", {
            access_token: response.access_token,
          })
          .then((response) => {
            Auth.login(response.data.access_token, response.data.user);
            this.loading = false;
            if (this.$route.query.redirect) {
              this.$router.push(this.$route.query.redirect);
              return;
            }
            this.$router.push({ name: "admin" });
          })
          .catch((error) => {
            console.log(error);
          });
      });
    },

    clearError() {
      this.errorAuth = "";
      this.errorValidate.email = "";
      this.errorValidate.password = "";
    },
  },
};
</script>

<style scoped>
p {
  color: red;
  height: 16px;
  width: 100%;
}

.google-btn {
  width: 184px;
  height: 42px;
  background-color: #4285f4;
  border-radius: 2px;
  box-shadow: 0 3px 4px 0 rgba(0, 0, 0, 0.25);
  margin-top: 20px;
  cursor: pointer;
}

.google-icon-wrapper {
  position: absolute;
  margin-top: 1px;
  margin-left: 1px;
  width: 40px;
  height: 40px;
  border-radius: 2px;
  background-color: #fff;
}

.google-icon {
  position: absolute;
  margin-top: 11px;
  margin-left: 11px;
  width: 18px;
  height: 18px;
}
.btn-text {
  margin: 11px 11px 0 50px;
  color: #fff;
  font-size: 14px;
  letter-spacing: 0.2px;
  font-family: "Roboto";
}

google-btn:hover {
  box-shadow: 0 0 6px #4285f4;
}
google-btn:active {
  background: #1669f2;
}
</style>
