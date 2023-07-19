<template>
  <div class="row p-2 col-md-11 shadow mx-auto border rounded">
    <main class="form-register w-100 m-auto mb-3">
      <img
        :src="image"
        alt="no image"
        width="100"
        height="100"
        class="rounded-circle mb-3"
      />
      <!-- <i class="h1 mb-4 bi bi-person-circle"></i> -->
      <h2 class="h3 mb-3 fw-normal">Please Upgrate Yourself</h2>

      <!-- <div v-if="errors.errStatus">
        <div class="alert alert-danger text-center">Please fix the errors</div>
      </div> -->

      <form @submit="upgradeUser(id)" enctype="multipart/form-data" ref="formRef">
        <div class="form-floating">
          <input
            type="name"
            class="form-control"
            id="floatingInput"
            v-model="name"
          />
          <!-- <div v-for="(error, key) in errors.name" :key="key" class="text-danger">
          <p>{{ error }}</p>
        </div> -->
        </div>
        <div class="form-floating">
          <input
            type="file"
            class="form-control"
            id="floatingInput"
            v-on:change="onFileSelected"
          />
          <!-- <div
          v-for="(error, key) in errors.email"
          :key="key"
          class="text-danger"
        >
          <p>{{ error }}</p>
        </div> -->
        </div>

        <button class="w-100 btn btn-lg btn-outline-primary">Upgrade</button>
        <!-- <button
          @click.prevent="upgradeUser(id)"
          class="w-100 btn btn-lg btn-outline-primary"
          type="submit"
        >
          Upgrade
        </button> -->
      </form>
    </main>
  </div>
</template>

<script>
import api from "../../api";

export default {
  name: "ProfileComponent",

  data() {
    return {
      id: null,
      name: null,
      image: null,
      imageUp: null,
      // selectedFile: null,
    };
  },

  mounted() {
    this.getUser();
  },

  methods: {
    getUser() {
      api.get(`/api/auth/profile`).then((res) => {
        // console.log(res);
        this.id = res.data.data[0].id;
        this.name = res.data.data[0].name;
        this.image = res.data.data[0].image;
      });
    },

    upgradeUser(user) {
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      const fd = new FormData();
      fd.append("image", this.imageUp);
      // console.log(fd);
      api
        .patch(`/api/auth/${user}`, {
          name: this.name,
          fd, config
        })
        .then((res) => {
          // Swal.fire("Added!", "User Upgrade Successfully!", "success");

          console.log(res);
          // this.name.push(res.data.data[0].name);
          // this.image.push(res.data.data[0].image);
          // this.$router.push({name: 'home'})
        });
    },

    onFileSelected(e) {
      // console.log(e);
      this.imageUp = e.target.files[0];
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
</style>
