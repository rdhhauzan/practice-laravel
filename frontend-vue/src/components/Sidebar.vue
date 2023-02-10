<script>
import { RouterLink } from "vue-router";
import Swal from "sweetalert2";

export default {
  name: "Sidebar",
  methods: {
    getActiveNavLink(name) {
      let classString = "list-group-item list-group-item-action py-2 ripple ";

      if (this.$route.name == name) {
        classString += "active";
      }

      return classString;
    },
    closeSidebar() {
      document.getElementById("sidebar-menu").style.display = "none";
      document.getElementById("sidebar-menu").style.width = "0";
    },
    openSidebar() {
      document.getElementById("sidebar-menu").style.display = "";
      document.getElementById("sidebar-menu").style.width = "180px";
    },
    logout() {
      localStorage.clear();
      Swal.fire({
        icon: "success",
        title: "Logout Success",
        text: `Logout Successfully!`,
      });
      this.$router.push("/login");
    },
  },
};
</script>

<template>
  <!-- eslint-disable -->
  <!--Main Navigation-->
  <!-- Sidebar -->
  <div
    id="sidebar-wrapper"
    class="collapse d-lg-block sidebar collapse bg-white"
  >
    <div class="position-sticky" id="sidebar-menu">
      <div class="list-group list-group-flush mx-3 mt-4">
        <RouterLink
          to="/"
          aria-current="true"
          :class="getActiveNavLink('AdminHome')"
        >
          <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
        </RouterLink>
        <RouterLink to="/books" :class="getActiveNavLink('ShowBooks')">
          <i class="fas fa-chart-area fa-fw me-3"></i><span>Show Books</span>
        </RouterLink>
        <RouterLink to="/book/add" :class="getActiveNavLink('AddBook')"
          ><i class="fas fa-lock fa-fw me-3"></i
          ><span>Add Book</span></RouterLink
        >
        <RouterLink to="/orders" :class="getActiveNavLink('Orders')"
          ><i class="fas fa-chart-line fa-fw me-3"></i
          ><span>Order</span></RouterLink
        >
        <RouterLink to="/genres" :class="getActiveNavLink('ShowGenres')"
          ><i class="fas fa-chart-line fa-fw me-3"></i
          ><span>Show Genres</span></RouterLink
        >
        <RouterLink to="/genre/add" :class="getActiveNavLink('AddGenre')"
          ><i class="fas fa-chart-line fa-fw me-3"></i
          ><span>Add Genre</span></RouterLink
        >
        <RouterLink to="/users" :class="getActiveNavLink('ShowUsers')"
          ><i class="fas fa-chart-line fa-fw me-3"></i
          ><span>Show Users</span></RouterLink
        >
        <RouterLink to="/user/add" :class="getActiveNavLink('AddUser')"
          ><i class="fas fa-chart-line fa-fw me-3"></i
          ><span>Add User</span></RouterLink
        >
        <RouterLink
          to="#"
          @click.prevent="logout()"
          :class="getActiveNavLink('')"
          ><i class="fas fa-chart-line fa-fw me-3"></i
          ><span>Logout</span></RouterLink
        >
      </div>
    </div>
  </div>
  <!-- Sidebar -->

  <!-- Navbar -->
  <nav
    id="main-navbar"
    class="navbar navbar-expand-lg navbar-light bg-white fixed-top"
  >
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
      <button
        class="navbar-toggler"
        type="button"
        data-mdb-toggle="collapse"
        data-mdb-target="#sidebarMenu"
        aria-controls="sidebarMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <i class="fas fa-bars"></i>
      </button>

      <!-- Brand -->
      <a class="navbar-brand mx-3 mt-3" href="#">
        <h3>Sidebar</h3>
      </a>
      <button
        type="button"
        data-mdb-toggle="collapse"
        data-mdb-target="#sidebarMenu"
        aria-controls="sidebarMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
        id="sidebarToggle"
        class="btn btn-primary mx-3"
      >
        <i class="fas fa-bars" @click.prevent="closeSidebar()">Close Sidebar</i>
      </button>
      <button
        type="button"
        data-mdb-toggle="collapse"
        data-mdb-target="#sidebarMenu"
        aria-controls="sidebarMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
        id="sidebarToggle"
        class="btn btn-primary mx-3"
      >
        <i class="fas fa-bars" @click.prevent="openSidebar()">Open Sidebar</i>
      </button>
      <ul class="navbar-nav ms-auto d-flex flex-row"></ul>
    </div>
  </nav>
</template>

<style scoped>
body {
  background-color: #fbfbfb;
}
@media (min-width: 991.98px) {
  main {
    padding-left: 240px;
  }
}

/* Sidebar */
.sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  padding: 58px 0 0; /* Height of navbar */
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
  z-index: 600;
}

@media (max-width: 991.98px) {
  .sidebar {
    width: 100%;
  }
}
.sidebar .active {
  border-radius: 5px;
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: 0.5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}
</style>
