<template>
  <div class="row p-2 col-md-11 shadow mx-auto border rounded"><h2>Todolist</h2></div>
</template>

<script>
import axios from 'axios';

export default {
  name: "TodolistComponent",

  data() {
    return {
      todolist: [],
    }
  },

  methods: {
    getTodolist() {
      axios.get('/api/auth/')
    },
  },
};
</script>

<style></style>
