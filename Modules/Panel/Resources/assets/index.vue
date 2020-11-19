<template>
  <div>
    <div class="header">
      <button @click="toggleModal">Add Media</button>
    </div>
    <div class="body">
      <Modal v-if="modal" v-on:update="onUpdate"></Modal>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Thumbnail</th>
            <th scope="col">Duration</th>
            <th scope="col">Size (bytes)</th>
            <th scope="col">Owner</th>
            <th scope="col">Permission</th>
            <th scope="col">File Name</th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <TableRow v-for="media in medias" v-bind:key="media.id" v-bind:media="media" v-on:update="onDelete"></TableRow>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";

import TableRow from "./components/TableRow";
import Modal from "./components/Modal";

export default {
  components: {
    TableRow: TableRow,
    Modal: Modal,
  },
  mounted() {
    axios
      .get("http://127.0.0.1:8000/panel/main")
      .then((res) => (this.medias = res.data));
  },
  data() {
    return {
      medias: {},
      modal: false,
    };
  },
  methods: {
    toggleModal() {
      this.modal = !this.modal;
    },
    onUpdate() {
      this.modal = false;
      axios
        .get("http://127.0.0.1:8000/panel/main")
        .then((res) => (this.medias = res.data));
    },
    onDelete() {
      axios
        .get("http://127.0.0.1:8000/panel/main")
        .then((res) => (this.medias = res.data));
    },
  },
};
</script>

<style scoped>
.body {
  position: relative;
}
</style>
