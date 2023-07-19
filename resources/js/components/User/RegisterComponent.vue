<template>
  <div class="pt-5">
    <main class="form-register w-100 m-auto">
      <i class="h1 mb-4 bi bi-person-circle"></i>
      <h2 class="h3 mb-3 fw-normal">Please sign up</h2>

      <div v-if="errors.errStatus">
        <div class="alert alert-danger text-center">Please fix the errors</div>
      </div>

      <div class="form-floating">
        <input
          type="name"
          class="form-control"
          id="floatingInput"
          placeholder="username"
          v-model="name"
        />
        <label for="floatingInput">Username</label>
        <div v-for="(error, key) in errors.name" :key="key" class="text-danger">
          <p>{{ error }}</p>
        </div>
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
        <div
          v-for="(error, key) in errors.email"
          :key="key"
          class="text-danger"
        >
          <p>{{ error }}</p>
        </div>
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
        <div
          v-for="(error, key) in errors.password"
          :key="key"
          class="text-danger"
        >
          <p>{{ error }}</p>
        </div>
      </div>
      <div class="form-floating">
        <input
          type="password"
          class="form-control"
          id="floatingPassword"
          placeholder="Password Confirmation"
          v-model="password_confirmation"
        />
        <label for="floatingPassword">Confirm Password</label>
        <div
          v-for="(error, key) in errors.password_confirmation"
          :key="key"
          class="text-danger"
        >
          <p>{{ error }}</p>
        </div>
      </div>

      <div class="form-floating mb-3">
        Already have an account?!
        <router-link :to="{ name: 'user.login' }">Login here</router-link>
        <!-- <a href="#">Login here</a> -->
      </div>

      <button
        @click.prevent="regUser"
        class="w-100 btn btn-lg btn-outline-primary"
        type="submit"
      >
        Register
      </button>
      <p class="mt-5 mb-3 text-body-secondary">&copy; 2023</p>
    </main>
  </div>
</template>

<script>
export default {
  name: "RegisterComponent",

  data() {
    return {
      name: null,
      email: null,
      password: null,
      password_confirmation: null,
      errors: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        errStatus: "",
      },
    };
  },

  methods: {
    regUser() {
      this.errors.errStatus             = "";
      this.errors.name                  = "";
      this.errors.email                 = "";
      this.errors.password              = "";
      this.errors.password_confirmation = "";
      axios
        .post("/api/users/register", {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        })
        .then((res) => {
          this.name                  = null;
          this.email                 = null;
          this.password              = null;
          this.password_confirmation = null;
          localStorage.setItem('access_token', res.data.access_token)
          this.$router.push({ name: "user.login" });
          // this.$router.push({ name: "home" });
          console.log(res);
        })
        .catch((error) => {
          if (error.response.status === 422) {
            console.log(error.response.data.errors);
            this.errors.errStatus             = error.response.status;
            this.errors.name                  = error.response.data.errors.name;
            this.errors.email                 = error.response.data.errors.email;
            this.errors.password              = error.response.data.errors.password;
            this.errors.password_confirmation =
              error.response.data.errors.password_confirmation;
          }
        });
    },
  },

  computed: {
    //по сути валидация и есть
    isDisabled() {
      return this.name && this.email && this.password;
    },
  },
};
</script>

<style>
.form-register {
  max-width: 330px;
  padding: 15px;
}

.form-register .form-floating:focus-within {
  z-index: 2;
}

.form-register input[type="name"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-register input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-register input[type="password"] {
  margin-bottom: -1px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
.form-register input[type="password_confirmation"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
