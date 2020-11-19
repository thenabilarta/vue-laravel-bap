<template>
  <div class="modal">
    <form @submit="formSubmit" enctype="multipart/form-data">
      <!-- <div class="form-group">
        <label for="">Image Name</label>
        <input type="text" class="form-control" name="image-name">
      </div> -->
      <div class="form-body">
        <input type="file" class="input-file" id="image" name="image" v-on:change="onFileChange" ref="file" multiple>
        <span>Put your image here</span>
      </div>
      <div class="form-preview">
        <div v-for="(u, index) in url" :key="`u-${index}`">
          <img :src="u" style="width: 50px" />
        </div>
        <div v-for="(f, index) in file" :key="`f-${index}`">
          <p>{{ f.name }}</p>
        </div>
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
      file: [],
      url: [],
      kotak: [],
      imageName: "",
    };
  },
  methods: {
    onFileChange(e) {
      console.log(e.target.files[1]);
      let i = 0;
      for (i = 0; i < e.target.files.length; i++) {
        console.log(e.target.files[i]);
        this.file.push(e.target.files[i]);
        this.url.push(URL.createObjectURL(e.target.files[i]));
        console.log(this.file);
        console.log(this.url);
      }
      // this.file = e.target.files;
      console.log(this.file);
      // console.log(e.target.files[0].name);
      // this.file = e.target.files[0];
      // this.imageName = e.target.files[0].name;
      // this.kotak = [...this.file];
      // console.log(this.kotak);
      // this.url = URL.createObjectURL(this.file);
    },
    testBind() {
      this.$emit("update");
    },
    formSubmit(e) {
      e.preventDefault();
      let currentObj = this;

      console.log(this.file[0]);

      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let i = 0;
      for (i = 0; i < this.file.length; i++) {
        let formData = new FormData();
        formData.append("file", this.file[i]);

        console.log(this.file[i]);

        axios
          .post("http://127.0.0.1:8000/panel/addmedia", formData, config)
          .then(function(response) {
            console.log(response);
          });
      }

      // axios
      //   .post("http://127.0.0.1:8000/panel/addmedia", formData, config)
      //   .then(function(response) {
      //     console.log(response);
      //   });
      // .then(() => this.testBind())
      // .catch(function(error) {
      //   currentObj.output = error;
      // });
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
  display: flex;
  justify-content: center;
  align-items: center;
}

.form-body:hover {
  background-color: #f5f5f5;
}

.form-preview {
  height: 30%;
  width: 80%;
  background-color: salmon;
  display: flex;
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
