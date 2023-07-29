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

  props: [
    "tasks",
    "todolistId",
  ],

  emits: ["reloadList"],

  components: {
    ListTaskComponent,
  },
};
</script>

<style></style>
