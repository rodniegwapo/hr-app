<template>
  <!-- <form @submit.prevent="greet">
      <InputText type="text" v-model="text"/>
      <Button type="submit" label="Submit"/>
  </form> -->
  <div></div>
</template>

<script>
export default {
  name: 'IndexPage',
  middleware: 'auth',
  created() {
    this.$router.push('/dashboard')
  }
}
</script>
