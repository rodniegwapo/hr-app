<template>
  <div class="flex justify-content-center font-system">
    <div class="surface-card p-4 shadow-2 border-round w-full lg:w-4">
      <div class="px-4 mb-5 mt-5">
        <!-- <img src="images/blocks/logos/hyper.svg" alt="Image" height="50" class="mb-3"> -->
        <!-- <div class="text-900 text-3xl font-medium mb-3">Register</div> -->
        <span class="text-600 text-sm line-height-3"
          >Create your account. It's free and only takes a minute</span
        >
      </div>
      <form @submit.prevent="register">
        <div class="px-4 text-sm">
          <div class="flex">
            <div class="mr-1">
              <label for="firstname" class="block text-900 font-medium mb-2"
                >First Name</label
              >
              <InputText
                v-model="form['firstname']"
                type="text"
                class="w-full mb-3"
              />
            </div>
            <div class="ml-1">
              <label for="lastname" class="block text-900 font-medium mb-2"
                >Lastname</label
              >
              <InputText
                v-model="form['lastname']"
                type="text"
                class="w-full mb-3"
              />
            </div>
          </div>
          <label for="email" class="block text-900 font-medium mb-2"
            >Email</label
          >
          <InputText v-model="form['email']" type="text" class="w-full mb-3" />
          <label for="password1" class="block text-900 font-medium mb-2"
            >Password</label
          >
          <InputText
            v-model="form['password']"
            type="password"
            class="w-full mb-3"
          />
          <label for="password1" class="block text-900 font-medium mb-2"
            >Confirm Passoword</label
          >
          <InputText
            v-model="form['password_confirmation']"
            type="password"
            class="w-full mb-3"
          />

          <div class="flex align-items-center justify-content-between mb-6">
            <div>
              <Checkbox name="city" value="Chicago" v-model="cities" />
              <span>I accept Terms of Use & Privacy Policy</span>
            </div>
          </div>

          <Button
            type="submit"
            label="Sign Up"
            icon="pi pi-user"
            class="w-full"
          ></Button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  middleware: ["class"],
  data() {
    return {
      cities: [],
      form: {
        firstname: "",
        lastname: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      errors: null,
    };
  },
  created() {
    console.log("created");
  },
  mounted() {
    console.log("mounted", this.$auth);
  },
  methods: {
    async register() {
      try {
        let errors = null;
        await this.$axios.$get("sanctum/csrf-cookie");
        await this.$axios
          .$post("/register", this.form)
          .then((res) => {})
          .catch((err) => {
            if (err.response.status == 422) {
              errors = err.response.data.errors;
            }
          });
        this.errors = errors;
        console.log("erros", this.errors);
        await this.$auth.loginWith("laravelSanctum", {
          data: {
            email: this.form["email"],
            password: this.form["password"],
          },
        });
      } catch (error) {}
    },
  },
};
</script>