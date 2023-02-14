import { createRouter, createWebHistory } from "vue-router";
import AdminHomeView from "../views/AdminHomeView.vue";
import LoginView from "../views/LoginView.vue";
import RegisterView from "../views/RegisterView.vue";
import AdminShowBooks from "../views/AdminShowBooks.vue";
import AdminAddBook from "../views/AdminAddBook.vue";
import AdminShowOrder from "../views/AdminShowOrder.vue";
import AdminShowGenres from "../views/AdminShowGenres.vue";
import AdminAddGenre from "../views/AdminAddGenre.vue";
import AdminShowUsers from "../views/AdminShowUsers.vue";
import AdminAddUser from "../views/AdminAddUser.vue";
import GuestHomeView from "../views/GuestHomeView.vue";
import GuestShowBooks from "../views/GuestShowBooks.vue";
import GuestUserBooks from "../views/GuestUserBooks.vue";
import GuestShowWishlist from "../views/GuestShowWishlist.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "AdminHome",
      component: AdminHomeView,
      meta: {
        title: "Admin Homepage",
      },
    },
    {
      path: "/login",
      name: "Login",
      component: LoginView,
      meta: {
        title: "Login Page",
      },
    },
    {
      path: "/register",
      name: "Register",
      component: RegisterView,
      meta: {
        title: "Register Page",
      },
    },
    {
      path: "/books",
      name: "ShowBooks",
      component: AdminShowBooks,
      meta: {
        title: "Admin Book List Page",
      },
    },
    {
      path: "/book/add",
      name: "AddBook",
      component: AdminAddBook,
      meta: {
        title: "Admin Add Book Page",
      },
    },
    {
      path: "/orders",
      name: "Orders",
      component: AdminShowOrder,
      meta: {
        title: "Admin Order List Page",
      },
    },
    {
      path: "/genres",
      name: "ShowGenres",
      component: AdminShowGenres,
      meta: {
        title: "Admin Genre List Page",
      },
    },
    {
      path: "/genre/add",
      name: "AddGenre",
      component: AdminAddGenre,
      meta: {
        title: "Admin Add Book Page",
      },
    },
    {
      path: "/users",
      name: "ShowUsers",
      component: AdminShowUsers,
      meta: {
        title: "Admin User list page",
      },
    },
    {
      path: "/user/add",
      name: "AddUser",
      component: AdminAddUser,
      meta: {
        title: "Admin Add User Page",
      },
    },
    {
      path: "/guest",
      name: "GuestHome",
      component: GuestHomeView,
      meta: {
        title: "Guest Home",
      },
    },
    {
      path: "/guest/books",
      name: "GuestShowBooks",
      component: GuestShowBooks,
      meta: {
        title: "Guest Books List Page",
      },
    },
    {
      path: "/guest/userBooks",
      name: "GuestUserBooks",
      component: GuestUserBooks,
      meta: {
        title: "Guest User books list Page",
      },
    },
    {
      path: "/guest/wishlist",
      name: "GuestWishlist",
      component: GuestShowWishlist,
      meta: {
        title: "Guest User Wishlist Page",
      },
    },
  ],
});

router.beforeEach((to, from) => {
  if (
    localStorage.getItem("access_token") &&
    to.fullPath == "/register" &&
    localStorage.getItem("role") == "admin"
  ) {
    return { name: "AdminHome" };
  } else if (
    localStorage.getItem("access_token") &&
    to.fullPath == "/login" &&
    localStorage.getItem("role") == "admin"
  ) {
    return { name: "AdminHome" };
  } else if (
    localStorage.getItem("access_token") &&
    to.fullPath == "/login" &&
    localStorage.getItem("role") == "guest"
  ) {
    return { name: "GuestHome" };
  } else if (
    localStorage.getItem("access_token") &&
    to.fullPath == "/register" &&
    localStorage.getItem("role") == "guest"
  ) {
    return { name: "GuestHome" };
  } else if (!localStorage.getItem("access_token") && to.fullPath == "/") {
    return { name: "Login" };
  } else if (!localStorage.getItem("access_token") && to.fullPath == "/guest") {
    return { name: "Login" };
  }

  const title = to.meta.title;
  if (title) {
    document.title = title;
  }
});

export default router;
