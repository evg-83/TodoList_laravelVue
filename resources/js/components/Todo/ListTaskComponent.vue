<template>
  <!-- <div
    class="container-fluid d-flex justify-content-between align-items-center mt-3"
  > -->
  <div v-cloak class="card-body mt-3">
    <table class="table table-bordered table-sm text-center align-middle">
      <tbody>
        <tr>
          <td v-if="userId === userIdTodolist" style="width: 5%;">
            <input
              type="checkbox"
              @change="updateCheck()"
              v-model="task.completed"
            />
          </td>
          <td style="width: 40%;">
            <div :class="[task.completed ? 'completed' : '']">
              {{ task.title }}
            </div>
          </td>
          <td style="width: 20%;">
            <div
              v-for="tag in task.tags"
              :key="tag"
              class=""
            >
              {{ tag["title"] }}
            </div>
          </td>
          <td  style="width: 13%;">
            <a class="" href="">
              <img
                v-if="task.imageTask"
                :src="task.imageTask"
                style="width: 100px; height: 100px; object-fit: cover"
                class="img-thumbnail"
                alt=""
              />
            </a>
          </td>
          <td v-if="userId === userIdTodolist" style="width: 10%;" class="">
            <a v-if="!task.completed" href="" class="text-success mx-1 editIcon">
              <i class="bi bi-pencil-square h4"></i>
            </a>
            <a
            @click.prevent="deleteTask()"
            class="text-danger mx-1 deleteIcon"
            href=""
            >
              <i class="bi bi-trash h4"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import api from "../../api";

export default {
  name: "ListTaskComponent",

  props: ["task", "todolistId", "userId", "userIdTodolist"],

  emits: ["taskChanged"],

  methods: {
    updateCheck() {
      api
        .patch(
          `/api/auth/todolist/tasks/${this.$props.todolistId}/${this.task.id}`,
          {
            task: this.task,
          }
        )
        .then((res) => {
          // this.$emit("taskChanged");
          // console.log(res);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    deleteTask() {
      api.delete(`/api/auth/todolist/tasks/${this.$props.todolistId}/${this.task.id}`)
        .then(res => {
          this.$emit("taskChanged")
        })
        .catch(error => {
        console.log(error);
      })
    },
  },
};
</script>

<style>
.completed {
  text-decoration: line-through;
  color: #999999;
}

[v-cloak] {
  display: none;
}
</style>
