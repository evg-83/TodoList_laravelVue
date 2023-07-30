<template>
  <div class="row col-md-8 shadow mx-auto border rounded mb-2">
    <div class="border-bottom mt-3">
      <div
        class="container-fluid d-flex justify-content-between align-items-center mb-3 mt-3"
      >
        <input
          type="text"
          class="form-control w-50"
          placeholder="Create tag..."
          v-model="tags.titleTag"
        />
        <a @click.prevent="createTag" href="">
          <i class="bi bi-plus-circle h4"></i>
        </a>
        <!-- <button type="button" class="btn btn-outline-primary">
          <i class="bi bi-plus-circle"></i>
        </button> -->
      </div>
    </div>
    <div
      class="container-fluid d-flex justify-content-between align-items-center"
    >
      <input
        class="form-control"
        style="width: 30%; height: 40%"
        placeholder="Add Task..."
        type="text"
        v-model="titleTask"
      />
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
        <!-- <div v-for="tag in tags" :key="tag"> -->
        <option v-for="tag in tagsArr" :key="tag">
          {{ tag.titleTag }}
        </option>
        <!-- </div> -->
      </select>

      <input
        type="file"
        class="form-control"
        style="width: 35%"
        @change="onFileImgSelected()"
        ref="file"
      />

      <!-- <button type="button" class="btn btn-outline-primary mx-2"> -->
      <a @click.prevent="createTask()" href="">
        <i class="bi bi-plus-circle h4 mx-2"></i>
      </a>
      <!-- </button> -->
    </div>
  </div>
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
    };
  },

  mounted() {
    this.getTags();
  },

  methods: {
    getTags() {
      api
        .get("/api/auth/todolist/tags/showTag")
        .then((res) => {
          // this.tagsArr = res.data.data;

          const tags = res.data.data;
          this.tagIdMap = tags.reduce((map, tag) => {
            map[tag.titleTag] = tag.id;
            return map;
          }, {});
          // console.log(this.tagIdMap);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    createTag() {
      api
        .post("/api/auth/todolist/tags/storeTag", {
          titleTag: this.tags.titleTag,
        })
        .then((res) => {
          console.log(res);
          this.tags.titleTag = null;
          // this.$emit("reloadListTags");

          // Update the tagsArr locally to add the newly created tag
          const newTag = res.data.data;
          this.tagsArr.push(newTag); // Store the new tag locally
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
      // console.log(fd);
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
          // this.tags.push(res.data)
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
      // console.log(this.$refs.file);
    },
  },
};
</script>

<style></style>
