<template>
  <div v-cloak class="row col-md-8 shadow mx-auto border rounded mb-2">
    <list-task-component
      v-for="(task, index) in filteredTasks"
      :key="index"
      :task="task"
      :todolistId="todolistId"
      :userId="userId"
      :userIdTodolist="userIdTodolist"
      v-on:taskChanged="$emit('reloadList')"
    />
  </div>
</template>

<script>
import ListTaskComponent from "./ListTaskComponent.vue";

export default {
  name: "TaskViewComponent",

  props: ["tasks", "todolistId", "userIdTodolist", "userId"],

  emits: ["reloadList"],

  components: {
    ListTaskComponent,
  },

  computed: {
    filteredTasks() {
      // Filter tasks based on the todolistId
      return this.tasks.filter((task) => task.todolistId == this.todolistId);
    },
  },
};
</script>

<style>
[v-cloak] {
  display: none;
}
</style>
