<template>
  <header class="header">
    <div class="header__logo">
      <img
        class="header__logo-image"
        src="http://nccdn-traning-php.test:8080/image/logo.png"
        alt=""
      />
      <span class="header__logo-text">NCC</span>
    </div>

    <nav class="header__navbar">
      <ul class="header__navbar-list">
        <li class="header__navbar-item">
          <a class="header__navbar-link" href="/">Sản phẩm </a>
        </li>
        <li class="header__navbar-item">
          <router-link class="header__navbar-link" :to="{ name: 'admin' }"
            >Quản lý sản phẩm
          </router-link>
        </li>
      </ul>
    </nav>

    <ul class="header__auth-list">
      <h3 v-if="loggedUser" class="user">
        {{ loggedUser.name }}
      </h3>
      <li class="header__auth-item">
        <button v-if="loggedUser" class="btn header__auth-link" @click="logout">
          Đăng xuất
        </button>
        <button v-else class="btn header__auth-link" @click="login">Đăng nhập</button>
      </li>
    </ul>
  </header>
</template>

<script>
import Auth from "../../Auth";

export default {
  data() {
    return {
      loggedUser: Auth.user,
    };
  },
  methods: {
    login() {
      this.$router.push({ name: "login" });
    },
    logout() {
      axios
        .get("/api/logout")
        .then((response) => {
          Auth.logout();
          this.$router.push({ name: "login" });
        })
        .catch((error) => {
          if (error.response.data.message === "Unauthenticated.") {
            this.$router.push("/login");
            Auth.logout();
          }
        });
    },
  },
};
</script>

<style scoped>
.user {
  margin-right: 15px;
  color: var(--white-color);
  font-weight: 500;
  font-size: 2rem;
  margin-top: 5px;
}
</style>
