<template>
  <div class="modal">
    <form @submit="formSubmit" enctype="multipart/form-data">
      <div class="form-group">
        <label for="">Image Name</label>
        <input type="text" class="form-control" name="image-name">
      </div>
      <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control-file" id="image" name="image" v-on:change="onFileChange" ref="file">
      </div>
      <button class="btn btn-primary">Add</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Modal",
  data() {
    return {
      file: "",
    };
  },
  methods: {
    onFileChange(e) {
      console.log(e.target.files[0]);
      this.file = e.target.files[0];
    },
    testBind() {
      this.$emit("update");
    },
    formSubmit(e) {
      e.preventDefault();
      let currentObj = this;

      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let formData = new FormData();
      formData.append("file", this.file);

      axios
        .post("http://127.0.0.1:8000/panel/addmedia", formData, config)
        .then(function(response) {
          console.log(response);
        })
        .then(() => this.testBind())
        .catch(function(error) {
          currentObj.output = error;
        });
    },
  },
};
</script>

<style scoped>
.modal {
  top: 10%;
  bottom: 10%;
  right: 10%;
  left: 10%;
  position: absolute;
  background: #f5f5f5;
  min-height: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
