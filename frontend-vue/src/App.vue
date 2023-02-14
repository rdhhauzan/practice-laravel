<script>
import { RouterView } from "vue-router";
import { mapWritableState, mapActions } from "pinia";

export default {
  name: "App",
  beforeMount() {
    if (localStorage.getItem("role") == "guest" && localStorage.getItem('access_token')) {
      this.$router.push("/guest");
    } else if (localStorage.getItem("role") == "admin" && localStorage.getItem('access_token')) {
      this.$router.push("/");
    }
  },
};
</script>

<template>
  <RouterView />
</template>
