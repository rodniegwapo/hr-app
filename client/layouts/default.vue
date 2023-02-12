<template>
  <div>
    <a-layout
      id="components-layout-demo-custom-trigger"
      class="h-screen"
      v-if="$auth.$state.loggedIn"
    >
      <sidebar />
      <a-layout>
        <componentHeader />
        <a-layout-content
          :style="{ margin: '24px 16px', padding: '8px', minHeight: '280px' }"
        >
          <Nuxt />
        </a-layout-content>
      </a-layout>
    </a-layout>
    <div v-else>
      <Nuxt />
    </div>
  </div>
</template>
<script>
import sidebar from "../components/Sidebar";
import componentHeader from "../components/Header";
export default {
  components: {
    sidebar,
    componentHeader,
  },
  middleware: ["auth"],
  data() {
    return {
      collapsed: false,
    };
  },
};
</script>
<style>
#components-layout-demo-custom-trigger .trigger {
  font-size: 18px;
  line-height: 64px;
  padding: 0 24px;
  cursor: pointer;
  transition: color 0.3s;
}

#components-layout-demo-custom-trigger .trigger:hover {
  color: #1890ff;
}

#components-layout-demo-custom-trigger .logo {
  height: 32px;
  background: rgba(255, 255, 255, 0.2);
  margin: 16px;
}
</style>