<template>
  <div
    class="row col-md-8 shadow mx-auto border rounded mb-2"
    v-for="(task, index) in tasks"
    :key="index"
  >
    <list-task-component
      :task="task"
      :todolistId="todolistId"
      v-on:taskChanged="$emit('reloadList')"
    />
  </div>
</template>

<script>
import ListTaskComponent from "./ListTaskComponent.vue";

export default {
  name: "TaskViewComponent",

  props: ["tasks", "todolistId"],

  emits: ["reloadList"],

  components: {
    ListTaskComponent,
  },

  // computed: {
  //   filteredTasks() {
  //     // Filter tasks based on the todolistId
  //     return this.tasks.filter((task) => task.todolist_id === this.todolistId);
  //   },
  // },
};
</script>

<style></style>
