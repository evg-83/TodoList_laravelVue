<template>
  <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
    <div v-for="task in tasks" :key="task" class="col">
      <div class="card mb-4 rounded-3 shadow-sm">
        <div class="card-header py-3">
          <h4 class="my-0 fw-normal">Todo List: {{ task.user.name }}</h4>
        </div>
        <div class="card-body">
          <img
            class="first-image rounded-circle"
            width="100"
            height="100"
            :src="task.user.imageUser"
          />
          <!-- <h1 class="card-title pricing-card-title"> -->

          <!-- <ul class="list-unstyled mt-3 mb-4">
            <li>10 users included</li>
            <li>2 GB of storage</li>
            <li>Email support</li>
            <li>Help center access</li>
          </ul> -->
          <button type="button" class="w-100 btn btn-lg btn-outline-primary">
            Sign up for free
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomeComponent",

  data() {
    return {
      tasks: [],
    };
  },

  mounted() {
    this.getTasks();
  },

  methods: {
    getTasks() {
      axios.get("/api/home").then((res) => {
        console.log(res);
        this.tasks = res.data.data;
      });
    },
  },
};
</script>

<style></style>
