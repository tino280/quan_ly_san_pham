<template>
  <div class="login">
    <div class="logo-login">
      <img src="http://nccdn-traning-php.test:8080/image/logo.png" class="logo-image" />
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

        <div style="margin-top: 30px; display: flex; justify-content: center">
          <button class="btn-login" type="button" @click="login">Đăng nhập</button>
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

<script lang="js">
import Auth from '../../Auth';

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
    }
  },

  methods: {
    login() {
      this.loading = true;
      axios.post('/api/login', this.user)
        .then(response => {
          Auth.login(response.data.access_token, response.data.user);
          this.loading = false;
          if (this.$route.query.redirect) {
            this.$router.push(this.$route.query.redirect);
            return;
          }
          this.$router.push({ name: "admin"});
        })
        .catch(error => {
          this.loading = false;
          console.log(error);
          if (error.response.status === 422) {
            const errorMessage = error.response.data.errors;
            Object.entries(errorMessage).forEach((error) => {
              console.log(error);
              this.errorValidate[error[0]] = error[1][0];
            })
          } else {
            this.errorAuth = "Email hoặc mật khẩu không đúng";
          }
        })
    },

    clearError() {
      this.errorAuth = "";
      this.errorValidate.email = "";
      this.errorValidate.password = "";
    }
  },
};
</script>

<style scoped>
p {
  color: red;
  height: 16px;
  width: 100%;
}
</style>
