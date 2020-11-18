<template>
  <tr v-if="media">
    <th scope="row">{{ media.mediaId }}</th>
    <td>{{ media.name }}</td>
    <td>{{ media.mediaType }}</td>
    <td>
      <img :src="`storage/uploads/${media.fileName}`" alt="image" id="image-thumbnail" />
    </td>
    <td>{{ media.duration }}</td>
    <td>{{ media.fileSize }}</td>
    <td>{{ media.owner }}</td>
    <td>null</td>
    <td>{{ media.fileName }}</td>
    <td>
      <select name="" id="">
        <option value="">-</option>
        <option value="">Edit</option>
        <option value="">Delete</option>
      </select>
    </td>
  </tr>
</template>

<script>
export default {
  name: "TableRow",
  props: ["media"],
};
</script>

<style scoped>
#image-thumbnail {
  max-width: 50px;
}
</style>
