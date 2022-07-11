<template>
  <!-- Add a login page with tailwind css -->

  <div class="mb-10">
    <div class="flex justify-center">
      <img alt="" class="h-14 w-14"
        src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQ-Oy7Jl2PYVr4xWvuB0GiB6ybMuK8FdcLnDwuuDuv7oDyYS__U" />
    </div>
    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
      Login to your account
    </h2>
    <p class="mt-2 text-center text-sm text-gray-900 mt-5">
      Don't have an account yet?
      <router-link to="/signup" class="block ml-4 mt-4 lg:inline-block lg:mt-0 text-blue-200 hover:text-white">Signup
      </router-link>
    </p>
  </div>

  <form class="mt-8 space-y-6" v-on:submit.prevent="login">
    <div v-if="error" role="alert">
      <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
        Danger
      </div>
      <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
        <p>{{ user.errorMsg }}</p>
      </div>
    </div>
    <div class="-space-y-px">
      <div class="my-5">
        <label for="identity" class="sr-only">
          Phone Number</label>
        <input id="identity"
          class="rounded-md appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
          type="tel" placeholder="Phone" aria-describedby="phoneHelp" @blur="validate('phone')"
          @keypress="validate('phone')" v-model="user.phone" />
            <p 
                class="errors text-red-700" 
                v-if="!!errors.phone"
            >{{errors.phone}}</p>
      </div>

      <div class="my-5">
        <label for="identity" class="sr-only">Password</label>

        <input aria-describedby="passwordHelp" v-model="user.password" @blur="validate('password')"
          @keypress="validate('password')"
          class="rounded-md appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
          id="password" type="password" placeholder="*******" />
            <p 
                class="errors text-red-700" 
                v-if="!!errors.password"
            >{{errors.password}}</p>
      </div>
    </div>
    <div className="flex items-center justify-between ">
      <div className="flex items-center">
        <input id="remember-me" name="remember-me" type="checkbox"
          className="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" />
        <label htmlFor="remember-me" className="ml-2 block text-sm text-gray-900">
          Remember me
        </label>
      </div>

      <div className="text-sm">
        <a href="#" className="font-medium text-purple-600 hover:text-purple-500">
          Forgot your password?
        </a>
      </div>
    </div>
    <button
      class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 mt-10"
      type="submit">
      Login In
    </button>
  </form>
  <router-view />
</template>

<script>
import axios from 'axios';

import * as Yup from "yup";
import YupPassword from 'yup-password'
YupPassword(Yup) // extend yup

const phoneRegExp = /^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/
const LoginSchema = Yup.object().shape({
  phone:  Yup.string().matches(phoneRegExp, 'Phone number is not valid'),
  password: Yup.string().password()
     .min(
      1,
      'password must contain 5 or more characters with at least one of each: uppercase, lowercase, number and special'
    )
    .minLowercase(1, 'Password must contain at least 1 lower case letter')
    .minUppercase(1, 'Password must contain at least 1 upper case letter')
    .minNumbers(1, 'Password must contain at least 1 number')
    .minSymbols(1, 'Password must contain at least 1 special character')
     .required("Password is required")
});



export default {
  name: "Login",
  data() {
    return {
      user: {
        phone: "",
        password: "",
        error: false,
        errorMsg: `An error occurred, please try again`
      },
      errors: {
        phone: "",
        password: ""
      }
    }
  },
  methods: {
    async login(e) {
      e.preventDefault()
      console.log('logging in')
      console.log({
        "phone": this.user.phone,
        "password": this.user.password
      })

      try {
        LoginSchema.validate(this.user, { abortEarly: false })
        const res = await axios.post(`http://localhost:8080/login`, {
          phone: this.user.phone,
          password: this.user.password
        });
        window.localStorage.setItem('jwt', res.data.jwt)
        window.localStorage.setItem('userData', res.data.user)
        this.$router.push('/profile')
      }

      catch (error) {
        console.log('error')
        this.error = true
        this.password = ''
      }
    },
      validate(field) {
      LoginSchema.validateAt(field, this.user)
        .then(() => (this.errors[field] = ""))
        .catch((err) => {
          this.errors[err.path] = err.message;
        });
    },

  },
};
</script>