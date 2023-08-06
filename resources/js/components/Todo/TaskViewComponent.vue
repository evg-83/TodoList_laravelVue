<template>
  <div v-cloak class="row col-md-8 shadow mx-auto border rounded mb-2">
    <template v-for="(task, index) in filteredTasks" :key="index">
      <list-task-component
        :task="task"
        :todolistId="todolistId"
        :userId="userId"
        :userIdTodolist="userIdTodolist"
        @changeEditTaskId="editTaskId"
        v-on:taskChanged="$emit('reloadList')"
      />
      <edit-task-component
        :class="isEditTask(task.id) ? '' : 'd-none'"
        :tagsArr="tagsArr"
        :task="task"
        :todolistId="todolistId"
        :userId="userId"
        :userIdTodolist="userIdTodolist"
        :taskId="taskId"
      />
    </template>
  </div>
</template>

<script>
import ListTaskComponent from "./ListTaskComponent.vue";
import EditTaskComponent from "./EditTaskComponent.vue";

export default {
  name: "TaskViewComponent",

  props: ["tasks", "todolistId", "userIdTodolist", "userId", "tagsArr"],

  emits: ["reloadList"],

  components: {
    ListTaskComponent,
    EditTaskComponent,
  },

  data() {
    return {
      taskId: null,
    };
  },

  computed: {
    filteredTasks() {
      // Filter tasks based on the todolistId
      return this.tasks.filter((task) => task.todolistId == this.todolistId);
    },
  },

  methods: {
    editTaskId(taskId) {
      this.taskId = taskId
    },

    isEditTask(taskId) {
      return this.taskId === taskId
    },
  },
};
</script>

<style>
[v-cloak] {
  display: none;
}
</style>
