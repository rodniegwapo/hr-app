<template>
  <div>
    <div class="flex w-full">
      <a-card class="w-1/2 shadow rounded">
        <div class="text-2xl px-4">Password</div>
        <div class="w-full">
          <ValidationObserver ref="observer" tag="form">
            <form @submit.prevent="update" action="">
              <div class="px-4 pt-4">
                <ValidationProvider
                  name="Old Password"
                  rules="required"
                  v-slot="{ errors }"
                >
                  <label
                    for="old_password"
                    class="block text-900 font-medium mb-2"
                    >Old Password</label
                  >
                  <a-input
                    :class="{ 'border-error': errors[0] }"
                    id="old_password"
                    v-model="form['old_password']"
                    type="text"
                    class="w-full mb-3"
                  />
                  <span class="error">{{ errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="px-4">
                <ValidationProvider
                  name="New Password"
                  rules="required"
                  v-slot="{ errors }"
                >
                  <label
                    for="new_password"
                    class="block text-900 font-medium mb-2"
                    >New Password</label
                  >
                  <a-input
                    :class="{ 'border-error': errors[0] }"
                    id="new_password"
                    v-model="form['new_password']"
                    type="text"
                    class="w-full mb-3"
                  />
                  <span class="error">{{ errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="px-4">
                <ValidationProvider
                  name="Confirm Password"
                  rules="required"
                  v-slot="{ errors }"
                >
                  <label for="email" class="block text-900 font-medium mb-2"
                    >Confirm Password</label
                  >
                  <a-input
                    :class="{ 'border-error': errors[0] }"
                    id="confirm_password"
                    v-model="form['confirm_password']"
                    type="text"
                    class="w-full mb-3"
                  />
                  <span class="error">{{ errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="px-4 flex w-full justify-end">
                <a-button
                  @click="updatePassword"
                  :loading="loading"
                  class="
                    bg-green-600
                    hover:bg-green-500 hover:text-white
                    text-white
                  "
                  large
                >
                  Update
                </a-button>
              </div>
            </form>
          </ValidationObserver>
        </div>
      </a-card>
    </div>
  </div>
</template>

<script>
// import Toast from "primevue/toast";
// import ToastService from "primevue/toastservice";
export default {
  components: {
    // Toast,
    // ToastService
  },
  methods: {
    async updatePassword() {
      const isValid = await this.$refs.observer.validate();
      if (isValid) {
        this.loading = true;
        await this.changePassword(this.form)
          .then((res) => {
            if (res["error"]) {
              this.$message.error(res["error"]);
            } else {
              this.$message.success("Password successfully updated");
            }
          })
          .catch((err) => {
            if (err.response.status == 422) {
              this.$message.error(
                err.response.data.errors["confirm_password"][0]
              );
            }
          });
        this.loading = false;
      }
    },
  },
  data() {
    return {
      form: {
        old_password: "",
        new_password: "",
        confirm_password: "",
      },
      loading: false,
    };
  },
};
</script>