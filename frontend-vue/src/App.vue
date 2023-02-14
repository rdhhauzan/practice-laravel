<script>
import { RouterView } from "vue-router";
import { mapWritableState, mapActions } from "pinia";

export default {
  name: "App",
  beforeMount() {
    if (localStorage.getItem("role") == "guest") {
      this.$router.push("/guest");
    } else if (localStorage.getItem("role") == "admin") {
      this.$router.push("/");
    } else {
      this.$router.push("/login");
    }
  },
};
</script>

<template>
  <RouterView />
</template>
