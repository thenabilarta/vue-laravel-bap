<template>
  <tr v-if="media">
    <th scope="row">{{ media.media_id }}</th>
    <td>{{ media.image_name }}</td>
    <td>{{ media.type }}</td>
    <td>
      <img :src="`storage/${media.image_path}`" alt="image" id="image-thumbnail" />
    </td>
    <td>{{ media.duration }}</td>
    <td>{{ media.size }}</td>
    <td>media.owner</td>
    <td>null</td>
    <td>{{ media.image_database_name }}</td>
    <td>
      <button @click="toEdit">Edit</button>
    </td>
    <td>
      <button @click="toDelete">Delete</button>
    </td>
    <ModalEdit v-on:updateEdit="testBind" v-if="editing" v-bind:showdata="showdata"></ModalEdit>
  </tr>
</template>

<script>
import axios from "axios";

import ModalEdit from "./ModalEdit";

export default {
  name: "TableRow",
  props: ["media"],
  components: {
    ModalEdit: ModalEdit,
  },
  data() {
    return {
      mediaProps: this.media,
      editing: false,
      showdata: {},
    };
  },
  methods: {
    toDelete() {
      console.log(this.mediaProps.media_id);
      axios
        .get("http://127.0.0.1:8000/panel/delete/" + this.mediaProps.media_id)
        .then(() => this.testBind());
    },
    testBind() {
      this.$emit("update");
      this.editing = false;
    },
    toEdit() {
      this.editing = !this.editing;
      this.toShow();
    },
    toShow() {
      console.log(this.mediaProps.media_id);
      axios
        .get("http://127.0.0.1:8000/panel/edit/" + this.mediaProps.media_id)
        .then((res) => (this.showdata = res.data))
        .then(() => console.log(this.showdata));
    },
  },
};
</script>

<style scoped>
#image-thumbnail {
  max-width: 50px;
}

td,
th {
  word-wrap: break-word;
  max-width: 100px;
  text-overflow: ellipsis;
  overflow: hidden; /* make sure it hides the content that overflows */
  white-space: nowrap;
}
</style>
