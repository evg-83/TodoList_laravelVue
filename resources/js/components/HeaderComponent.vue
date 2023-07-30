<template>
  <div class="min-vh-100">
    <header class="p-3 mb-3 col-md-11 mx-auto border-bottom shadow">
      <div class="container">
        <div
          class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start"
        >
          <!-- <img :src="`${publicPath}img/E.jpeg`" alt=""> -->

          <ul
            class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 h5 mx-5"
          >
            <li>
              <router-link
                :to="{ name: 'home' }"
                class="nav-link px-2 link-secondary"
                >Home</router-link
              >
            </li>
            <!-- <li>
              <router-link
                :to="{ name: 'home' }"
                class="nav-link px-2 link-body-emphasis"
                >Todolist</router-link
              >
            </li> -->
          </ul>

          <!-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
            <input
              type="search"
              class="form-control"
              placeholder="Search..."
              aria-label="Search"
            />
          </form> -->

          <div class="dropdown text-end mx-5">
            <a
              href="#"
              class="d-block link-dark text-decoration-none dropdown-toggle"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <img
                :src="image"
                alt="no img"
                width="50"
                height="50"
                class="rounded-circle"
              />
            </a>
            <ul class="dropdown-menu text-primary">
              <!-- <li><a class="dropdown-item" href="#">Tasks...</a></li>
              <li><a class="dropdown-item" href="#">Settings</a></li> -->
              <!-- <li>
                <a
                  @click.prevent="pushEditUserId(id)"
                  class="dropdown-item"
                  href="#"
                  >Profile</a
                >
              </li> -->
              <li>
                <router-link
                  class="dropdown-item"
                  :to="{ name: 'user.profile' }"
                  >Profile</router-link
                >
              </li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a @click.prevent="logout" class="dropdown-item" href="#"
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
import api from "../api";

export default {
  name: "HeaderComponent",

  data() {
    return {
      id: null,
      image: null,
    };
  },

  mounted() {
    this.getUserAuth();
  },

  methods: {
    getUserAuth() {
      api
        .get("/api/auth/showAuthUser")
        .then((res) => {
          // console.log(res.data.data[0].image);
          this.id = res.data.data[0].id;
          this.image = res.data.data[0].image;
          // this.image = res.data.data.image;
          // this.userAuthImage = res.data[1][0];
        })
        .catch((error) => {
          console.log(error);
        });
    },

    logout() {
      api.post("/api/auth/logout").then((res) => {
        localStorage.removeItem("access_token");
        this.$router.push({ name: "user.login" });
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
