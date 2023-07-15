<template>
  <div class="min-vh-100">
    <header class="p-3 mb-3 border-bottom">
      <div class="container">
        <div
          class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start"
        >
          <!-- <img :src="`${publicPath}img/E.jpeg`" alt=""> -->

          <ul
            class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0"
          >
            <li>
              <router-link
                v-if="token"
                :to="{ name: 'home' }"
                class="nav-link px-2 link-secondary"
                >Home</router-link
              >
            </li>
            <li>
              <a href="#" class="nav-link px-2 link-body-emphasis">Inventory</a>
            </li>
          </ul>

          <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
            <input
              type="search"
              class="form-control"
              placeholder="Search..."
              aria-label="Search"
            />
          </form>

          <div v-for="task in tasks" :key="task" class="dropdown text-end">
            <a
              href="#"
              class="d-block link-dark text-decoration-none dropdown-toggle"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <img
                :src="task.user.imageUser"
                alt="mdo"
                width="32"
                height="32"
                class="rounded-circle"
              />
            </a>
            <ul class="dropdown-menu text-small">
              <li><a class="dropdown-item" href="#">Tasks...</a></li>
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li><a class="dropdown-item" href="#">Profile</a></li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a
                  v-if="token"
                  @click.prevent="logout"
                  class="dropdown-item"
                  href="#"
                  >Sign out</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>

    <router-view :key="$route.path"></router-view>
  </div>
</template>

<script>
export default {
  name: "HeaderComponent",

  data() {
    return {
      token: null,
      tasks: [],
    };
  },

  mounted() {
    this.getToken();
    this.getTasks();
  },

  updated() {
    this.getToken();
  },

  methods: {
    getTasks() {
      axios.get("/api/home").then((res) => {
        console.log(res);
        this.tasks = res.data.data;
      });
    },

    getToken() {
      this.token = localStorage.getItem("x_xsrf_token");
    },

    logout() {
      axios.get("/logout").then((res) => {
        localStorage.removeItem("x_xsrf_token");
        this.$router.push({ name: "login" });
      });
    },
  },
};
</script>

<style>
.form-control-dark {
  border-color: var(--bs-gray);
}

.form-control-dark:focus {
  border-color: #fff;
  box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
}

.text-small {
  font-size: 85%;
}

.dropdown-toggle:not(:focus) {
  outline: 0;
}
</style>
