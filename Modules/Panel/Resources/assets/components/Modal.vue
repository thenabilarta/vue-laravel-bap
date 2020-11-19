<template>
  <div class="modal">
    <form @submit="formSubmit" enctype="multipart/form-data">
      <!-- <div class="form-group">
        <label for="">Image Name</label>
        <input type="text" class="form-control" name="image-name">
      </div> -->
      <div class="form-body">
        <input type="file" class="input-file" id="image" name="image" v-on:change="onFileChange" ref="file" multiple>
      </div>
      <div class="form-preview" v-for="(f, index) in file" :key="`f-${index}`">
        <img :src="url" style="width: 50px" />
        <p>{{ f.name }}</p>
      </div>
      <button>Add</button>
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
      url: [],
      kotak: [],
    };
  },
  methods: {
    onFileChange(e) {
      console.log(e.target.files);
      this.file = e.target.files[0];
      this.kotak = [...this.file];
      this.url = URL.createObjectURL(this.file);
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

form {
  width: 100%;
  height: 100%;
  background-color: pink;
  position: absolute;
  display: flex;
  justify-content: space-around;
  align-items: center;
  flex-direction: column;
}

.form-body {
  height: 30%;
  width: 80%;
  background-color: powderblue;
  position: relative;
  cursor: pointer;
  margin-top: 2rem;
}

.form-body:hover {
  background-color: #f5f5f5;
}

.form-preview {
  height: 30%;
  width: 80%;
  background-color: salmon;
}

input {
  width: 100%;
  height: 100%;
  position: absolute;
  cursor: pointer;
  opacity: 0;
  z-index: 3;
}
</style>
