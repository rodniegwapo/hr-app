<template>
  <div class="flex w-full justify-center h-screen items-center bg-gray-100">
    <div>
      <a-card
        :bordered="true"
        class="border rounded-lg shadow py-8"
        style="width: 400px"
      >
        <div class="text-center mb-5">
          <img
            src="images/blocks/logos/hyper.svg"
            alt="Image"
            height="50"
            class="mb-3"
          />
          <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
          <span class="text-600 font-medium line-height-3"
            >Don't have an account?</span
          >
          <a class="font-medium no-underline ml-2 text-blue-500 cursor-pointer"
            >Create today!</a
          >
        </div>
        <div class="pt-6">
          <ValidationObserver ref="observer" tag="form">
            <form action="">
              <div class="px-4">
                <ValidationProvider
                  name="email"
                  rules="required|email"
                  v-slot="{ errors }"
                >
                  <a-input
                    type="email"
                    v-model="form['email']"
                    placeholder="email"
                    class=""
                    :class="{ 'border-error': errors[0] }"
                  />
                  <span class="error">{{ errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="px-4 pt-4">
                <ValidationProvider
                  name="password"
                  rules="required"
                  v-slot="{ errors }"
                >
                  <a-input
                    v-model="form['password']"
                    type="password"
                    placeholder="password"
                    class=""
                  />
                  <span class="error">{{ errors[0] }}</span>
                </ValidationProvider>
              </div>
              <div class="flex items-center justify-between mb-6 px-4 pt-4">
                <div class="flex items-center">
                  <a-checkbox>Checkbox</a-checkbox>
                  <label for="rememberme1">Remember me</label>
                </div>
                <a
                  class="
                    font-medium
                    no-underline
                    ml-2
                    text-blue-500 text-right
                    cursor-pointer
                  "
                  >Forgot password?</a
                >
              </div>
              <span class="text-xs text-red-500 px-4" v-if="errors"
                >* {{ errors && errors.email ? errors.email[0] : "" }}</span
              >
              <div class="px-4 pt-4">
                <a-button
                  @click="login"
                  :loading="loading"
                  type="primary"
                  class="bg-blue-600 w-full text-white"
                  large
                >
                  Sign In
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
export default {
  data() {
    return {
      checked: "",
      form: {
        email: "",
        password: "",
      },
      loading: false,
      errors: null,
    };
  },
  methods: {
    async login() {
      const isValid = await this.$refs.observer.validate();
      this.loading = true;
      let errors = null;
      if (isValid) {
        try {
          await this.$auth
            .loginWith("laravelSanctum", { data: this.form })
            .then((res) => {})
            .catch((err) => {
              if (err.response.status == 422) {
                errors = err.response.data.errors;
                console.log("erros", errors);
              }
            });
          this.errors = errors;
          const isEmpty = Object.keys(this.$route.query).length === 0;
          if (isEmpty) {
            this.$router.push("/dashboard");
          }
        } catch (error) {}
      }
      this.loading = false;
    },
  },
};
</script>