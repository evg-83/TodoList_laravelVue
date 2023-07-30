<template>
  <div class="row p-2 col-md-11 shadow mx-auto border rounded">
    <div class="row p-2 mt-3 col-md-8 shadow mx-auto border rounded">
      <div
        class="container-fluid d-flex justify-content-between align-items-center mt-2"
      >
        <h2 class="mx-5" id="title">Todolist: {{ title }}</h2>
        <a @click.prevent="destroyTodolist" href="">
          <i class="bi bi-trash text-danger h4 mx-3"></i>
        </a>
      </div>
    </div>
    <addtask-component
      v-on:reloadList="getTask()"
      :todolistId="todolistId"
      :tagsArr="tagsArr"
      @reloadListTags="updateTagsArr"
    />
    <task-view-component
      :todolistId="todolistId"
      :tasks="tasks"
      v-on:reloadList="getTask()"
    />
  </div>
</template>

<script>
import api from "../../api";
import AddtaskComponent from "./AddtaskComponent.vue";
import TaskViewComponent from "./TaskViewComponent.vue";

export default {
  name: "TodolistComponent",

  components: {
    AddtaskComponent,
    TaskViewComponent,
  },

  props: ["todolistId"],

  data() {
    return {
      title: null,
      tasks: [],
      tagsArr: [],
    };
  },

  mounted() {
    this.getTodolist();
    this.getTask();
    this.getTags();
  },

  methods: {
    getTodolist() {
      api
        .get(`/api/auth/todolist/${this.$props.todolistId}/show`)
        .then((res) => {
          // console.log(res.data.data);
          this.title = res.data.data.title;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    destroyTodolist() {
      api
        .delete(`/api/auth/todolist/${this.$props.todolistId}`)
        .then((res) => {
          // console.log(res);
          this.$router.push({ name: "home" });
        })
        .catch((err) => {
          console.log(err);
        });
    },

    getTask() {
      api
        .get("/api/auth/todolist/tasks")
        .then((res) => {
          // console.log(res.data.data);
          this.tasks = res.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    getTags() {
      api
        .get("/api/auth/todolist/tags/showTag")
        .then((res) => {
          this.tagsArr = res.data.data;
          // console.log(res.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // Add this method to update the tagsArr after receiving the event
    updateTagsArr() {
      this.getTags();
    },
  },
};
</script>

<style></style>
