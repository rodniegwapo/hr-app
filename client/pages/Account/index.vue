<template>
  <div>
    <a-tabs default-active-key="1" type="tabs">
      <a-tab-pane key="1">
        <span slot="tab"> Account Info </span>
        <div class="bg-gray-100 py-6">
          <profile />
        </div>
      </a-tab-pane>
      <a-tab-pane key="2">
        <span slot="tab"> Change Password </span>
        <div class="bg-gray-100 py-6">
          <password />
        </div>
      </a-tab-pane>
    </a-tabs>
  </div>
</template>
<script>
import profile from "./__account";
import password from "./__password";

export default {
  components: {
    profile,
    password,
  },
  middleware: ["auth"],
  methods: {
    callback(val) {
      console.log(val);
    },
  },
  data() {
    return {
      mode: "left",
      items: [
        {
          label: "Profile",
          icon: "pi pi-fw pi-user",
          command: () => {
            this.tab = 1;
          },
        },
        {
          label: "Password",
          icon: "pi pi-fw pi-cog",
          command: () => {
            this.tab = 2;
          },
        },
      ],
      tab: 1,
    };
  },
};
</script>

<style >
.profile-wrapper {
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 1px -1px rgb(0 0 0 / 20%), 0 1px 1px 0 rgb(0 0 0 / 14%),
    0 1px 3px 0 rgb(0 0 0 / 12%);
  border-radius: 3px;
}
.profile-top-head {
  /* background: rgb(246,246,246);
        background: linear-gradient(212deg, rgba(246,246,246,1) 0%, rgba(255,255,255,1) 30%, rgba(0,0,0,1) 100%); */
  background: #282e38;
  min-height: 200px;
}
.avatar {
  display: flex;
  align-items: center;
  width: 120px;
  height: 120px;
  background: white;
  overflow: hidden;
  border-radius: 300px;
  margin-top: -75px;
  box-shadow: 0 2px 1px -1px rgb(0 0 0 / 20%), 0 1px 1px 0 rgb(0 0 0 / 14%),
    0 1px 3px 0 rgb(0 0 0 / 12%);
}
.avatar-wrapper .title {
  margin-top: -54px;
  margin-left: 20px;
  color: #fff3d1;
}
.avatar-wrapper {
  background: #37404c;
  padding-bottom: 14px;
}
.p-breadcrumb.p-component.p-menuitem-text {
  background-color: transparent;
  border: none;
}
.bread {
  background: red !important;
}
.ant-tabs-bar {
  border-bottom: none !important;
}
.ant-tabs-nav {
  transition: 0 !important;
}
/* .p-menuitem-link {
        color: white !important;
    }
    .profile-wrapper .p-menuitem-text {
        color: #fff3d1 !important;
    } */
</style>