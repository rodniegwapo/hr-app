<template>
  <div>
    <a-layout-sider
      v-model="collapsed"
      def
      :trigger="null"
      collapsible
      width="230"
    >
      <div class="logo pt-2 p">
        <img class="w-full" src="@/assets/images/logo.png" alt="" />
      </div>
      <a-menu theme="dark" mode="inline" class="h-screen">
        <a-menu-item key="dashboard" @click="to('dashboard')">
          <a-icon type="dashboard" />
          <span>Dashboard</span>
        </a-menu-item>
        <a-menu-item
          v-if="$store.state.auth.user.roles[0].name == 'Admin'"
          key="users"
          @click="to('users')"
        >
          <a-icon type="user" />
          <span>Users</span>
        </a-menu-item>
        <a-menu-item key="timeoff" @click="to('timeoff')">
          <a-icon type="dashboard" />
          <span>Time-offs</span>
        </a-menu-item>
      </a-menu>
    </a-layout-sider>
  </div>
</template>

<script>
export default {
  created() {
    this.key = this.$route.name;
  },
  mounted() {
    this.$nuxt.$on("collapsedMenu", (data) => {
      this.collapsed = data;
    });
  },
  methods: {},
  data() {
    return {
      collapsed: false,
      key: "dashboard",
    };
  },
};
</script>
<style  scoped>
.logo {
  background: transparent !important;
}
</style>