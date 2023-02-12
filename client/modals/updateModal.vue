<template>
  <div>
    <a-modal
      :visible="display"
      title="Update"
      class="flex justify-content-center"
      @cancel="close"
    >
      <ValidationObserver ref="observer" tag="form">
        <form>
          <div class="text-sm">
            <div class="flex">
              <div class="mr-1 w-50">
                <ValidationProvider
                  name="firstname"
                  rules="required"
                  v-slot="{ errors }"
                >
                  <label for="lastname" class="block text-900 font-medium mb-2"
                    >First Name</label
                  >
                  <a-input
                    type="email"
                    v-model="form['firstname']"
                    placeholder="firstname"
                    :class="{ 'border-error': errors[0] }"
                  />
                  <span class="error">{{ errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="ml-1 w-50">
                <ValidationProvider
                  name="lastname"
                  rules="required"
                  v-slot="{ errors }"
                >
                  <label for="lastname" class="block text-900 font-medium mb-2"
                    >Last Name</label
                  >
                  <a-input
                    type="email"
                    v-model="form['lastname']"
                    placeholder="lastname"
                    :class="{ 'border-error': errors[0] }"
                  />
                  <span class="error">{{ errors[0] }}</span>
                </ValidationProvider>
              </div>
            </div>
            <div class="pt-4">
              <ValidationProvider
                name="email"
                rules="required|email"
                v-slot="{ errors }"
              >
                <label for="email" class="block text-900 font-medium"
                  >Email</label
                >
                <a-input
                  v-model="form['email']"
                  type="text"
                  :class="{ 'border-error': errors[0] }"
                  placeholder="email"
                  class="w-full mb-3"
                />
                <span class="error">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
            <ValidationProvider
              name="roles"
              rules="required"
              v-slot="{ errors }"
            >
              <label for="roles" class="block text-900 font-medium mb-2"
                >Roles</label
              >
              <a-select label-in-value v-model="form['role']">
                <a-select-option
                  :value="role.id"
                  v-for="(role, key) in roles"
                  :key="key"
                  >{{ role.name }}</a-select-option
                >
              </a-select>
              <span class="error">{{ errors[0] }}</span>
            </ValidationProvider>
            <div class="mt-4">
              <ValidationProvider
                name="roles"
                rules="required"
                v-slot="{ errors }"
                v-if="
                  form['role'].label != 'Manager' &&
                  form['role'].label != 'Admin'
                "
              >
                <label for="roles" class="block text-900 font-medium mb-2"
                  >Manager</label
                >
                <a-select
                  label-in-value
                  :default-value="{ key: '1' }"
                  v-model="form['manager']"
                >
                  <a-select-option
                    v-if="manager.id !== user.id"
                    :value="manager.id"
                    v-for="(manager, key) in managers"
                    :key="key"
                    >{{
                      manager.firstname + " " + manager.lastname
                    }}</a-select-option
                  >
                </a-select>
                <span class="error">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
        </form>
      </ValidationObserver>
      <template slot="footer" class="px-4">
        <div>
          <a-button @click="close" class=""> Back </a-button>
          <a-button
            class="bg-blue-600 mr-2 bg-green-600 hover:bg-green-500 text-white"
            :loading="loading"
            @click="update"
          >
            Update
          </a-button>
        </div>
      </template>
    </a-modal>
  </div>
</template>




<script>
export default {
  props: {
    user: {
      type: Object,
      default: () => {},
    },
    display: {
      type: Boolean,
      default: true,
    },
  },
  watch: {
    user: {
      //   handler(val) {
      //     this.form = val;
      //   },
    },
  },
  mounted() {
    this.allRoles();
  },
  methods: {
    close(event) {
      this.$emit("close", null);
    },
    dismiss() {
      this.$emit("close", false);
    },
    async allRoles() {
      this.roles = await this.getRoles();
    },
    async update() {
      const isValid = await this.$refs.observer.validate();
      if (
        this.form["role"].label == "Admin" ||
        this.form["role"].label == "Manager"
      ) {
        this.form.manager = { key: "", label: "" };
      }
      console.log(this.form);
      if (isValid) {
        this.loading = true;
        await this.updateUser(this.form)
          .then((res) => {
            this.$message.success("Successfully updated");
            this.$emit("updateUserInfo", this.form);
            this.$emit("close", null);
          })
          .catch((err) => {
            console.log(err);
          });
        this.loading = false;
      }
    },
    managerName(id) {
      let find = this.managers.find((data) => data.id == id);
      console.log("find", find);
      return "Manager";
    },
    handleChange(e) {},
  },
  data() {
    return {
      form: {
        id: this.user.id,
        firstname: this.user.firstname,
        lastname: this.user.lastname,
        email: this.user.email,
        manager: {
          key: this.user.manager_id,
        },
        role: { key: this.user.roles[0].id, label: this.user.roles[0].name },
      },
      //   selectedRole: null,
      roles: null,
      role: null,
      managers: this.$store.state.todo.managers,
      loading: false,
    };
  },
};
</script>