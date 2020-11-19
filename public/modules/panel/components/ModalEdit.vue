<template>
  <div class="modal" v-if="showdata">
    <img :src="`storage/${showdata.image_path}`" alt="image" id="image-thumbnail" />
    <p>{{ showdata.image_name }}</p>
    <p>{{ showdata.media_id }}</p>
    <form @submit="formSubmit">
      <input type="text" v-if="imageString" :placeholder="imageString" v-model="form.name">
      <button>Save</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ModalEdit",
  props: { showdata: Object },
  computed: {
    imageString() {
      if (this.showdata.image_name) {
        let name = this.showdata.image_name;
        let newName = name.split(".");
        return newName[0];
      }
    },
    angka() {
      if (this.showdata.media_id) {
        return this.showdata.media_id;
      }
    },
  },
  data() {
    return {
      form: {
        name: "",
        media_id: "",
      },
    };
  },
  watch: {
    showdata() {
      this.form.media_id = this.showdata;
    },
  },
  methods: {
    formSubmit(e) {
      e.preventDefault();
      axios
        .post("http://127.0.0.1:8000/panel/edit/store", this.form)
        .then(() => this.modalEditBind());
    },
    modalEditBind() {
      this.$emit("updateEdit");
    },
  },
};
</script>

<style scoped>
.modal {
  top: 10%;
  bottom: 10%;
  right: 20%;
  opacity: 0.9;
  left: 0;
  position: absolute;
  background: #f5f5f5;
  min-height: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
}

#image-thumbnail {
  max-width: 50px;
}
</style>
