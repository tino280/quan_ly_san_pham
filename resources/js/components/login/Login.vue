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
            <input class="input" type="email" v-model="user.email" />
          </div>
        </div>

        <div>
          <label for="password">Mật khẩu</label>
          <div class="form-input">
            <input class="input" type="password" v-model="user.password" />
          </div>
        </div>

        <div style="margin-top: 15px">
          <label for="remember_me" style="display: flex">
            <input type="checkbox" v-model="user.remember_me" />
            <span style="margin-left: 5px">Remember me</span>
          </label>
        </div>

        <div style="margin-top: 30px; display: flex; justify-content: center">
          <button class="btn-login" type="button" @click="login">Đăng nhập</button>
        </div>
      </form>
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
      }
    }
  },

  methods: {
    login() {
      axios.post('/api/login', this.user)
        .then(response => {
          Auth.login(response.data.access_token, response.data.user);
          if (this.$route.query.redirect) {
            this.$router.push(this.$route.query.redirect);
            return;
          }
          this.$router.push({ name: "admin"});
        })
        .catch(error => {
          console.log(error);
        })
    },
  },
};
</script>
