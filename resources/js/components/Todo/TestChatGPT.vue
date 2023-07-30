<template>
  <!-- ... (other code) ... -->
  <select
    class="form-select form-control"
    style="width: 20%; height: 33%"
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
  <!-- ... (other code) ... -->
</template>

<script>
import api from "../../api";

export default {
  name: "AddtaskComponent",

  props: ["todolistId", "tagsArr"],

  emits: ["reloadList"],

  data() {
    return {
      tags: {
        titleTag: null,
      },
      titleTask: null,
      file: null,
      tagsArrUp: [], // This will store the selected tag titles, not tag IDs
      tagIdMap: {}, // Create a mapping of tag names to tag IDs
      userId: null, // Store the authenticated user ID
    };
  },

  async mounted() {
    await this.getTags();
  },

  computed: {
    filteredTags() {
      // Filter the tags based on the userId
      return this.tagsArr.filter((tag) => tag.user_id === this.userId);
    },
  },

  methods: {
    async getTags() {
      try {
        const res = await api.get("/api/auth/todolist/tags/showTag");
        const tags = res.data.data;

        // Set the userId from a prop or another method, wherever it is available
        this.userId = 1; // Replace 1 with the actual user ID

        // Create the tagIdMap
        this.tagIdMap = tags.reduce((map, tag) => {
          map[tag.titleTag] = tag.id;
          return map;
        }, {});
      } catch (error) {
        console.log(error);
      }
    },

    createTag() {
      api
        .post("/api/auth/todolist/tags/storeTag", {
          titleTag: this.tags.titleTag,
        })
        .then((res) => {
          console.log(res);
          this.tags.titleTag = null;
          this.tagsArr.push(res.data.data); // Store the new tag locally
        })
        .catch((error) => {
          console.log(error);
        });
    },

    createTask() {
      // Convert the selected tag titles to tag IDs using the tagIdMap
      const tagIds = this.tagsArrUp.map((tagName) => this.tagIdMap[tagName]);

      // Check if the tagIds array contains only integers
      if (!tagIds.every((id) => Number.isInteger(id))) {
        console.error("Invalid tag_ids data. All values must be integers.");
        return; // Return early to prevent making the API call with invalid data
      }

      const fd = new FormData();

      if (this.file) {
        fd.append("imageTask", this.file);
      }

      fd.append("titleTask", this.titleTask);

      tagIds.forEach((id) => {
        fd.append("tag_ids[]", id); // Append each tag ID separately
      });

      fd.append("_method", "POST");

      // Reset the input fields before making the API call
      this.file = null;
      this.titleTask = null;
      this.tagsArrUp = [];

      api
        .post(`/api/auth/todolist/tasks/${this.$props.todolistId}`, fd, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          // Clear the file input field
          this.clearFileInput();

          this.$emit("reloadList");
        })
        .catch((error) => {
          console.log(error);
        });
    },

    clearFileInput() {
      const fileInput = this.$refs.file;

      if (fileInput) {
        // Create a new input element
        const newFileInput = document.createElement("input");
        newFileInput.type = "file";
        newFileInput.setAttribute("style", fileInput.getAttribute("style"));
        newFileInput.setAttribute("class", fileInput.getAttribute("class"));

        // Replace the current file input with the new one
        fileInput.parentNode.replaceChild(newFileInput, fileInput);

        // Add the change event listener to the new file input
        newFileInput.addEventListener("change", this.onFileImgSelected);

        // Clear the file property
        this.file = null;
      }
    },

    onFileImgSelected() {
      this.file = this.$refs.file.files[0];
    },
  },
};
</script>

