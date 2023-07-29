<template>
  <!-- start add new todolist modal -->
  <div
    class="modal fade"
    id="addTodolistModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Todolist</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <form
          action="#"
          method="POST"
          id="add_todolist_form"
          enctype="multipart/form-data"
        >
          <div class="modal-body p-4 bg-light">
            <div class="row">
              <div class="col-lg">
                <label class="mb-3 h4" for="title">Todolist</label>
                <input
                  type="text"
                  v-model="title"
                  class="form-control"
                  placeholder="Todolist"
                  required
                />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-outline-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button
              @click.prevent="createTodolist"
              id="add_todolist_btn"
              type="submit"
              class="btn btn-outline-primary"
            >
              Add Todolist
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end add new todolist modal -->

  <div class="form-mainDiv row p-2 col-md-11 shadow mx-auto border rounded">
    <!-- start header todolists -->
    <header class="p-3 mb-3 border-bottom">
      <div class="container">
        <div
          class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start"
        >
          <h2
            class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0"
          >
            Todolists
          </h2>

          <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
            <input
              type="search"
              class="form-control"
              placeholder="Search User..."
              aria-label="Search"
            />
          </form>

          <button
            type="button"
            class="btn btn-outline-primary"
            data-bs-toggle="modal"
            data-bs-target="#addTodolistModal"
          >
            Create Todolist
          </button>
        </div>
      </div>
    </header>
    <!-- end header todolists -->

    <div class="row row-cols-1 row-cols-md-4 text-center">
      <div v-for="todolist in todolists" :key="todolist" class="col">
        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Todolist: {{ todolist.title }}</h4>
          </div>
          <div class="card-body">
            <img
              class="first-image rounded-circle"
              width="75"
              height="75"
              :src="todolist.user.image"
            />

            <h3 class="card-title pricing-card-title mt-3">
              {{ todolist.user.name }}
            </h3>

            <!-- <ul class="list-unstyled mt-3 mb-4">
            <li>10 users included</li>
            <li>2 GB of storage</li>
            <li>Email support</li>
            <li>Help center access</li>
          </ul> -->
            <!--             <button type="button" class="w-50 btn btn-lg btn-outline-primary">
              Sign up for free
            </button>
          -->
            <div class="pt-3">
              <router-link
                class="mx-xl-auto"
                :to="{ name: 'todolist', params: { todolistId: todolist.id } }"
              >
                <i class="bi bi-eye text-info h4"></i>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../../api";

export default {
  name: "HomeComponent",

  data() {
    return {
      todolists: [],
      title: null,
    };
  },

  mounted() {
    this.getTodolist();
  },

  methods: {
    createTodolist() {
      api
        .post("/api/auth/todolist", {
          title: this.title,
        })
        .then((res) => {
          Swal.fire("Added!", "Todolist Added Successfully!", "success");
          $("#addTodolistModal").modal("hide");

          this.title = null;
          this.todolists.push(res.data.data);

          console.log(res);
        });
    },

    getTodolist() {
      //деревянный вариант
      // axios.get("/api/auth/home", {
      //   headers: {
      //     authorization: `Bearer ${localStorage.getItem("access_token")}`,
      //   },
      // })
      api
        .get("/api/auth/home")
        .then((res) => {
          // console.log(res.data.data);
          this.todolists = res.data.data;
        });
    },
  },
};
</script>

<style>
</style>
