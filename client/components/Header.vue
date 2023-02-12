<template>
  <div>
    <a-layout-header style="background: #fff; padding: 0">
      <div class="flex w-full justify-between item-center">
        <div class="flex items-center">
          <a-icon
            class="trigger"
            :type="collapsed ? 'menu-unfold' : 'menu-fold'"
            @click="collapsedMenu"
          />
          <span class="text-lg">{{ capitalize($route.name) }}</span>
        </div>
        <div class="flex items-center mr-6">
          <div class="mr-6"><a-icon type="bell" class="text-2xl" /></div>
          <div>
            <a-dropdown class="font-bold">
              <a class="ant-dropdown-link" @click="(e) => e.preventDefault()">
                <a-avatar icon="user" />
                {{
                  capitalize($store.state.auth.user.firstname) +
                  " " +
                  firstLetter($store.state.auth.user.lastname) +
                  "."
                }}
                <a-icon type="down" />
              </a>
              <a-icon type="bell" />
              <a-menu slot="overlay">
                <a-menu-item
                  key="1"
                  class="flex items-center"
                  @click="to('account')"
                >
                  <a-icon type="setting" />
                  Settings
                </a-menu-item>
                <a-menu-item key="2" class="flex items-center" @click="logout">
                  <a-icon type="logout" />
                  Logout
                </a-menu-item>
              </a-menu>
            </a-dropdown>
          </div>
        </div>
      </div>
    </a-layout-header>
  </div>
</template>
<script>
import { eventBus } from "../bus/eventbus";
export default {
  data() {
    return {
      collapsed: false,
    };
  },
  methods: {
    async logout() {
      await this.$axios.$post("/logout");
      window.location.reload(true);
    },

    collapsedMenu() {
      this.collapsed = !this.collapsed;
      this.$nuxt.$emit("collapsedMenu", this.collapsed);
    },
  },
};
</script>