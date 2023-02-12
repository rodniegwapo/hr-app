<template>
  <div>
    <div class="flex w-full items-center">
      <a-card class="w-4/5 shadow rounded">
        <div class="text-2xl">Account Info</div>
        <div class="flex w-full items-center">
          <div class="w-2/5 border-r flex justify-center">
            <div class="pr-4 mr-2"><upload /></div>
          </div>
          <div class="w-3/5 pl-6">
            <ValidationObserver ref="observer" tag="form">
              <form @submit.prevent="update" action="">
                <div class="px-4 pt-4">
                  <ValidationProvider
                    name="firstname"
                    rules="required"
                    v-slot="{ errors }"
                  >
                    <label
                      for="firstname"
                      class="block text-900 font-medium mb-2"
                      >First Name</label
                    >
                    <a-input
                      :class="{ 'border-error': errors[0] }"
                      id="firstname"
                      v-model="form['firstname']"
                      type="text"
                      class="w-full mb-3"
                    />
                    <span class="error">{{ errors[0] }}</span>
                  </ValidationProvider>
                </div>
                <div class="px-4">
                  <ValidationProvider
                    name="lastname"
                    rules="required"
                    v-slot="{ errors }"
                  >
                    <label
                      for="lastname"
                      class="block text-900 font-medium mb-2"
                      >Last name</label
                    >
                    <a-input
                      :class="{ 'border-error': errors[0] }"
                      id="lastname"
                      v-model="form['lastname']"
                      type="text"
                      class="w-full mb-3"
                    />
                    <span class="error">{{ errors[0] }}</span>
                  </ValidationProvider>
                </div>
                <div class="px-4">
                  <ValidationProvider
                    name="email"
                    rules="required"
                    v-slot="{ errors }"
                  >
                    <label for="email" class="block text-900 font-medium mb-2"
                      >email</label
                    >
                    <a-input
                      :class="{ 'border-error': errors[0] }"
                      id="email"
                      v-model="form['email']"
                      type="text"
                      class="w-full mb-3"
                    />
                    <span class="error">{{ errors[0] }}</span>
                  </ValidationProvider>
                </div>
                <div class="px-4 flex w-full justify-end">
                  <a-button
                    @click="update"
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
        </div>
      </a-card>
    </div>
  </div>
</template>
<script>
import upload from "./__upload";
export default {
  components: {
    upload,
  },
  computed: {},
  methods: {
    async update() {
      const isValid = await this.$refs.observer.validate();
      if (isValid) {
        this.loading = true;
        await this.updateAccountInfo(this.form)
          .then((res) => {
            this.$message.success("Successfully updated");
          })
          .catch((err) => {
            console.log(err);
          });
        this.loading = false;
      }
    },
  },
  data() {
    return {
      form: {
        firstname: this.$store.state.auth.user.firstname,
        lastname: this.$store.state.auth.user.lastname,
        email: this.$store.state.auth.user.email,
        role_id: { value: this.$store.state.auth.user.role_id },
        id: this.$store.state.auth.user.id,
      },
      loading: false,
    };
  },
};
</script>