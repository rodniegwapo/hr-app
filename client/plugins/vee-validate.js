import Vue from 'vue';
import { ValidationObserver,ValidationProvider,extend } from 'vee-validate';
import { required, email } from 'vee-validate/dist/rules';


extend('email', email);

// Override the default message.
extend('required', {
  ...required,
  message: 'This field is required'
});

// Register it globally
Vue.component('ValidationProvider', ValidationProvider,)
Vue.component('ValidationObserver', ValidationObserver,)

