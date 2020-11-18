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

td,
th {
  word-wrap: break-word;
  max-width: 100px;
  text-overflow: ellipsis;
  overflow: hidden; /* make sure it hides the content that overflows */
  white-space: nowrap;
}
</style>
