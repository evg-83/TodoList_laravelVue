<template>
  <div v-cloak class="card-body mt-3">
    <table class="table table-bordered table-sm text-center align-middle">
      <tbody>
        <tr>
          <td style="width: 5%"></td>
          <td style="width: 40%">
            <!-- <div>
              {{ task.title }}
            </div> -->
            <input
              class="form-control"
              style="height: 40%"
              placeholder="Add Task..."
              type="text"
              v-model="titleTask"
            />
          </td>
          <td style="width: 20%">
            <!-- <div v-for="tag in task.tags" :key="tag" class="">
              {{ tag["title"] }}
            </div> -->
            <select
              class="form-select form-control"
              name=""
              id=""
              multiple
              aria-label="Tags"
              data-placeholder="Select Tags"
              v-model="tagsArrUp"
            >
              <option selected>Add Tags...</option>
              <option v-for="tag in filteredTags" :key="tag.id">
                {{ tag.titleTag }}
              </option>
            </select>
          </td>
          <td style="width: 13%">
            <input
              type="file"
              class="form-control"
              style="width: 100%"
              @change="onFileImgSelected()"
              ref="file"
            />
          </td>
          <td style="width: 10%" class="">
            <a @click.prevent="editTask(null)" href="">
              <i class="bi bi-plus-circle h4 mx-2"></i>
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
  name: "EditTaskComponent",

  props: [
    "task",
    "todolistId",
    "userId",
    "userIdTodolist",
    "tagsArr",
    "taskId",
  ],

  emits: ["taskChanged"],

  data() {
    return {
      titleTask: null,
      file: null,
      tagsArrUp: [], // This will store the selected tag titles, not tag IDs
      tagIdMap: {}, // Create a mapping of tag names to tag IDs
    };
  },

  computed: {
    filteredTags() {
      // Filter the tags based on the userId
      return this.tagsArr.filter((tag) => tag.user_id === this.userId);
    },
  },

  // Add a watch to set up the tagIdMap when the tagsArr prop changes
  watch: {
    tagsArr: {
      immediate: true,
      handler() {
        this.setupTagIdMap();
      },
    },
  },

  methods: {
    editTask() {
      // Convert the selected tag titles to tag IDs using the tagIdMap
      const tagIds = this.tagsArrUp.map((tagName) => this.tagIdMap[tagName]);

      // Filter out any invalid or undefined tagIds
      const validTagIds = tagIds.filter((id) => Number.isInteger(id));

      console.log("tagIds:", tagIds);
      console.log("validTagIds:", validTagIds);

      if (validTagIds.length !== tagIds.length) {
        console.error("Invalid tag_ids data. Some values are not integers.");
        return; // Don't proceed with the API call if there are invalid tag IDs
      }

      const fd = new FormData();

      // Append the file if available
      if (this.file) {
        fd.append("imageTask", this.file);
      }

      // Check if titleTask is not empty before appending it to FormData
      if (this.titleTask && this.titleTask.trim() !== "") {
        fd.append("titleTask", this.titleTask);
      }

      // tagIds.forEach((id) => {
      // Append the tag_ids only if there are valid tag IDs
      if (validTagIds.length > 0) {
        for (const id of validTagIds) {
          fd.append("tag_ids[]", id); // Append each tag ID separately
        }
      }

      fd.append("_method", "PATCH");

      // Reset the input fields before making the API call
      this.file = null;
      this.titleTask = null;
      this.tagsArrUp = [];
      console.log(fd);
      api
        .post(
          `/api/auth/todolist/tasks/${this.$props.todolistId}/${this.task.id}/update`, fd, {
          headers: {
            "Content-Type": "multipart/form-data",
          }
        })
        .then((res) => {
          // this.$emit("taskChanged");
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // Add a method to set up the tagIdMap with tag titles and IDs
    setupTagIdMap() {
      // Assuming that this.tagsArr is an array of tag objects with "titleTag" and "id" properties
      this.tagsArr.forEach((tag) => {
        this.tagIdMap[tag.titleTag] = tag.id;
      });
    },

    onFileImgSelected() {
      this.file = this.$refs.file.files[0];
      // console.log(this.$refs.file);
    },
  },
};
</script>

<style>
[v-cloak] {
  display: none;
}
</style>
