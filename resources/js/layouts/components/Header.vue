<template>
  <header class="header">
    <div class="header__logo">
      <img class="header__logo-image" :src="`${host}/image/logo.png`" alt="" />
      <span class="header__logo-text">NCC</span>
    </div>

    <nav class="header__navbar">
      <ul class="header__navbar-list">
        <li class="header__navbar-item">
          <a
            class="header__navbar-link"
            href="/"
            :class="$route.path === '/' ? 'active' : 'inactive'"
            >Sản phẩm
          </a>
        </li>
        <li class="header__navbar-item">
          <router-link
            class="header__navbar-link"
            :to="{ name: 'admin' }"
            :class="$route.path === '/admin' ? 'active' : 'inactive'"
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
        <div v-if="loggedUser" class="header__auth-link" @click="logout">Đăng xuất</div>
        <div v-else class="header__auth-link" @click="login">Đăng nhập</div>
      </li>
    </ul>
  </header>
</template>

<script>
import Auth from "../../Auth";
import { googleLogout } from "vue3-google-login";
import { googleSdkLoaded } from "vue3-google-login";

export default {
  data() {
    return {
      loggedUser: Auth.user,
      host: window.location.origin,
    };
  },
  methods: {
    login() {
      this.$router.push({ name: "login" });
    },
    logout() {
      googleSdkLoaded((google) => {
        google.accounts.id.revoke(`${this.loggedUser.email}`);
      });
      googleLogout();
      axios
        .get("/api/logout")
        .then((response) => {
          Auth.logout();
          this.$router.push({ name: "login" });
        })
        .catch((error) => {
          if (error.response.data.message === "Unauthenticated.") {
            Auth.logout();
            this.$router.push("/login");
          }
        });
    },
  },
};
</script>

<style scoped>
span {
  margin-left: 3px;
}
.user {
  margin-right: 15px;
  color: var(--white-color);
  font-weight: 500;
  font-size: 2rem;
  margin-top: 5px;
}

.header__navbar-link:hover {
  color: white;
  opacity: 0.75;
}

.header__auth-link {
  color: white;
  opacity: 0.5;
}

.header__auth-link:hover {
  color: white;
  opacity: 0.75;
}

.active {
  color: white;
}

.inactive {
  color: #ffffff;
  opacity: 0.5;
}
</style>
