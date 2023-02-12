<template>
  <div>
    <a-modal
      :visible="display"
      title="Add User"
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
                    type="text"
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
                    type="text"
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
                  type="email"
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
              <a-select
                label-in-value
                :default-value="{ key: `1` }"
                v-model="form['role']"
              >
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
                v-if="role != 'Manager' && role != 'Admin'"
              >
                <label for="roles" class="block text-900 font-medium mb-2"
                  >Manager</label
                >
                <a-select
                  label-in-value
                  :default-value="{ key: `1` }"
                  v-model="form.manager"
                >
                  <a-select-option
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
      <template slot="footer">
        <a-button key="back" @click="close"> Back </a-button>
        <a-button
          key="submit"
          class="bg-blue-600 text-white mr-2"
          :loading="loading"
          @click="saveUser"
        >
          Submit
        </a-button>
      </template>
    </a-modal>
  </div>
</template>

<script>
export default {
  props: {
    display: {
      type: Boolean,
      default: true,
    },
  },
  watch: {
    "form.role": {
      handler(val) {
        this.role = val.label;
      },
    },
  },
  mounted() {
    this.allRoles();
  },
  methods: {
    close(event) {
      this.$emit("close", null);
    },
    setRole(data) {
      // let found = this.roles.find(data => data.value == this.form['role_id'].value)
      // this.form.role = found.label

      console.log("data", data);
    },
    async allRoles() {
      this.roles = await this.getRoles();
    },
    async saveUser() {
      const isValid = await this.$refs.observer.validate();
      if (
        this.form["role"].label == "Manager" ||
        this.form["role"].label == "Admin"
      ) {
        this.form.manager = { key: "", label: "" };
      }
      if (isValid) {
        this.loading = true;
        try {
          await this.addUser(this.form)
            .then((res) => {
              this.$emit("close", null);
              this.form.id = res.id;
              this.$emit("addUser", this.form);
              this.$message.success("Added Successfully");
              this.loading = false;
            })
            .catch((err) => {
              if (err.response.status == 422) {
                if (err.response.data.errors.email) {
                  this.$message.error(err.response.data.errors.email[0]);
                }
              }

              this.loading = false;
            });
          this.reset();
        } catch (error) {}
      }
    },
    reset() {
      this.form = {
        firstname: "",
        lastname: "",
        email: "",
        password: "",
        role_id: "",
        role: "",
        manager: { key: "", label: "" },
      };
    },
  },
  data() {
    return {
      selectedCity: "RM",
      role: "",
      cities: [
        { name: "New York", code: "NY" },
        { name: "Rome", code: "RM" },
        { name: "London", code: "LDN" },
        { name: "Istanbul", code: "IST" },
        { name: "Paris", code: "PRS" },
      ],
      form: {
        firstname: "",
        lastname: "",
        email: "",
        password: "",
        role_id: "",
        manger: { key: "", label: "" },
      },
      selectedRole: "",
      roles: null,
      loading: false,
      managers: this.$store.state.todo.managers,
    };
  },
};
</script>