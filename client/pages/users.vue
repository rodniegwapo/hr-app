<template>
  <div>
    <addModal @addUser="add" @close="close" v-if="display == 'add'" />
    <showModal :user="selectedUser" v-if="display == 'show'" @close="close" />
    <updateModal
      :user="selectedUser"
      v-if="display == 'update'"
      @close="close"
      @updateUserInfo="updateUserInfo"
    />
    <!-- <ConfirmDialog></ConfirmDialog> -->
    <!-- <a-button class="editable-add-btn" @click="handleAdd">
            Add
        </a-button> -->
    <a-card hoverable class="w-full p-6">
      <template #cover>
        <div class="flex w-full justify-between pb-5">
          <div class="w-1/2 flex">
            <a-input
              type="text"
              v-model="search.item"
              placeholder="Search"
              class="w-1/2 mr-2"
            >
            </a-input>
            <a-select
              label-in-value
              :default-value="{ key: `1` }"
              v-model="search['role']"
              class="w-1/2 ml-2"
              placeholder="Role"
              allowClear
            >
              <a-select-option
                :value="role.id"
                v-for="(role, key) in roles"
                :key="key"
                >{{ role.name }}</a-select-option
              >
            </a-select>
          </div>
          <div class="pl-12">
            <a-button
              type="primary"
              @click="showAddModal"
              class="
                w-full
                flex
                items-center
                justify-center
                editable-add-btn
                bg-blue-600
                rounded
              "
            >
              <a-icon type="plus" />
              <span>Add</span>
            </a-button>
          </div>
        </div>
        <a-table
          bordered
          :data-source="users"
          :columns="columns"
          :loading="loading"
        >
          <template slot="action" slot-scope="text, record, index">
            <div class="flex w-full">
              <a-button
                class="bg-blue-500 text-white"
                shape="circle"
                icon="eye"
                @click="showInfo(record)"
              />
              <a-button
                class="bg-green-600 text-white mx-2"
                shape="circle"
                @click="showUpdate(record, index)"
                icon="edit"
              />
              <a-button
                class="bg-red-600 text-white"
                shape="circle"
                icon="delete"
                @click="removeUser(record, index)"
              />
            </div>
          </template>
        </a-table>
        <div class="flex w-full justify-end pt-6">
          <a-pagination
            @change="handlePagination"
            v-model="pagination.current"
            :total="pagination.total"
            show-less-items
          />
        </div>
      </template>
    </a-card>
  </div>
</template>
<script>
import addModal from "../modals/addModal";
import showModal from "../modals/showModal";
import deleteModal from "../modals/deleteModal";
import updateModal from "../modals/updateModal";
export default {
  middleware: "check-user",
  components: {
    addModal,
    showModal,
    deleteModal,
    updateModal,
  },
  created() {},
  mounted() {
    this.allUsers();
    this.allRoles();
    this.allManagers();
  },
  watch: {
    search(val) {
      if (val) {
        this.searchData();
      } else {
        this.users = this.listOfUsers;
      }
    },
    "search.item": {
      handler(val) {
        if (val == "") {
          this.allUsers();
        } else {
          this.searchData();
        }
      },
    },
    "search.role": {
      handler(val) {
        this.searchData();
      },
    },
  },
  methods: {
    showAddModal() {
      this.display = "add";
    },
    close(data) {
      this.display = data;
    },
    async showInfo(data) {
      // this.selectedUser = data;
      // this.display = "show";
      // this.index = key
      // console.log('data',data)
      // console.log('tex',key)
      console.log("data", data);
      let item = await this.getUserDetails(data);
      this.$store.commit("todo/setUserDetails", item);
      this.$router.push("profile");
      if (process.client) {
        localStorage.setItem("selectedUser", JSON.stringify(data));
      }
    },
    showUpdate(data, row) {
      this.selectedUser = data;
      this.user_id = data.id;
      this.display = "update";
      // this.index = row;
      console.log("data", data);
      // console.log("row", row);
    },
    deleteModal(data) {
      this.selectedUser = data;
      this.displayDeleteModal = true;
    },
    updateUserInfo(data) {
      // let user = {
      //   id: this.user_id,
      //   firstname: data.firstname,
      //   lastname: data.lastname,
      //   email: data.email,
      //   role: { role: data.role.label, id: data.role.key },
      // };
      // this.users.splice(this.index, 1, user);
      this.allUsers();
    },
    add(data) {
      this.allUsers();
    },
    async removeUser(data, key) {
      this.$confirm({
        title: "Do you Want to delete these items?",
        okText: "Delete",
        okType: "danger",
        content: (h) => <div style="color:red;"></div>,
        onOk: () => this.delete(data, key),
        onCancel() {
          console.log("Cancel");
        },
      });
    },
    async delete(data, key) {
      await this.deleteUser(data)
        .then((res) => {
          this.$message.success("Deleted successfully");
          this.users.splice(key, 1);
        })
        .catch((err) => {});
      this.allUsers();
    },
    async searchData() {
      this.loading = true;
      let found = await this.$axios.post(`/api/search_user`, this.search);

      this.users = found.data.data;

      this.loading = false;
    },
    async allRoles() {
      this.roles = await this.getRoles();
    },
    async allUsers(page) {
      this.loading = true;
      let data = await this.getUsers(page);
      this.pagination = {
        current: data.current_page,
        total: parseInt(data.last_page + "0"),
      };
      this.users = data.data;
      this.listOfUsers = data;
      this.loading = false;
    },
    async allManagers() {
      let user = await this.getManagers();
      this.$store.commit("todo/setManagers", user);
    },
    async handlePagination(page) {
      this.pagination.current = page;
      await this.allUsers(page);
    },
  },

  data() {
    return {
      current: 2,
      items: null,
      display: null,
      displayAddModal: false,
      users: [],
      selectedUser: null,
      displayUserInfoModal: false,
      displayDeleteModal: false,
      displayUpdateModal: false,
      index: null,
      search: {},
      listOfUsers: null,
      user_id: null,
      loading: false,
      roles: null,
      dataSource: [
        {
          key: "0",
          name: "Edward King 0",
          age: "32",
          address: "London, Park Lane no. 0",
        },
        {
          key: "1",
          name: "Edward King 1",
          age: "32",
          address: "London, Park Lane no. 1",
        },
      ],
      count: 2,
      columns: [
        {
          title: "First name",
          dataIndex: "firstname",
          scopedSlots: { customRender: "name" },
        },
        { title: "Last Name", dataIndex: "lastname" },
        { title: "Email Adress", dataIndex: "email", width: "30%" },
        { title: "Role", dataIndex: "roles[0].name" },
        {
          title: "Action",
          dataIndex: "action",
          scopedSlots: { customRender: "action" },
        },
      ],
      pagination: {
        current: 2,
        total: 10,
      },
    };
  },
};
</script>
<style scoped>
</style>
