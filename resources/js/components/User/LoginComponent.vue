<template>
  <div class="pt-5">
    <main class="form-signin w-100 m-auto">
      <i class="h1 mb-4 bi bi-person-circle"></i>
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <div v-if="errors.errStatus">
        <div class="alert alert-danger text-center">Unauthorised</div>
      </div>

      <div class="form-floating">
        <input
          type="email"
          class="form-control"
          id="floatingInput"
          placeholder="name@example.com"
          v-model="email"
        />
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input
          type="password"
          class="form-control"
          id="floatingPassword"
          placeholder="Password"
          v-model="password"
        />
        <label for="floatingPassword">Password</label>
      </div>

      <div class="form-floating mb-3">
        Don`t have an account?!
        <router-link :to="{ name: 'user.register' }">Signup here</router-link>
        <!-- <a href="#">Login here</a> -->
      </div>

      <!-- <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me" /> Remember me
        </label>
      </div> -->
      <button
        @click.prevent="login"
        class="w-100 btn btn-lg btn-outline-primary"
        type="submit"
      >
        Sign in
      </button>
      <p class="mt-5 mb-3 text-body-secondary">&copy; 2023</p>
    </main>
  </div>
</template>

<script>
export default {
  name: "LoginComponent",

  data() {
    return {
      email: null,
      password: null,
      errors: {
        errStatus: null,
      },
    };
  },

  methods: {
    login() {
      this.errors.errStatus = "";
      axios
        .post("/api/auth/login", { email: this.email, password: this.password })
        .then((res) => {
          this.email = null;
          this.password = null;
          // console.log(res.data.access_token);
          localStorage.setItem('access_token', res.data.access_token)
          // localStorage.access_token = res.data.access_token
          this.$router.push({ name: "home" });
        })
        .catch((error) => {
          if (error.response.status === 404) {
            this.errors.errStatus = error.response.status;
          }
        });
    },
  },

  computed: {
    //по сути валидация и есть
    isDisabled() {
      return this.email && this.password;
    },
  },
};
</script>

<style>
.form-signin {
  max-width: 330px;
  padding: 15px;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
