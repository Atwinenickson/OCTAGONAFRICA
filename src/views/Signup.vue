<template>
<!-- Add in the sign up page with it's header -->
    <div class="mb-10">
        <div class="flex justify-center">
            <img alt="" class="h-14 w-14"
                src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQ-Oy7Jl2PYVr4xWvuB0GiB6ybMuK8FdcLnDwuuDuv7oDyYS__U" />
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Signup to create an account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-900 mt-5">
            Already have an account?
            <router-link to="/" class="block ml-4 mt-4 lg:inline-block lg:mt-0 text-blue-200 hover:text-white">
                Login</router-link>
        </p>
    </div>

    <form class="mt-8 space-y-6" v-on:submit.prevent="register">
        <div v-if="error" role="alert">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Danger
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                <p>{{ errorMsg }}</p>
            </div>
        </div>
        <div class="-space-y-px">

            <div class="my-5">
                <label for="identity" class="sr-only">
                    First Name</label>
                <input id="identity"
                    class="rounded-md appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
                    type="text" placeholder="First Name" aria-describedby="firstnameHelp"  @blur="validate('firstname')"
          @keypress="validate('firstname')" v-model="user.firstname" />
            <p 
                class="errors text-red-700" 
                v-if="!!errors.firstname"
            >{{errors.firstname}}</p>
           </div>

            <div class="my-5">
                <label for="identity" class="sr-only">
                    Last Name</label>
                <input id="identity"
                    class="my-4 rounded-md appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
                    type="text" placeholder="Last Name" aria-describedby="lastnameHelp"  @blur="validate('lastname')"
          @keypress="validate('lastname')" v-model="user.lastname" />
            <p 
                class="errors text-red-700" 
                v-if="!!errors.lastname"
            >{{errors.lastname}}</p>
           </div>


            <div class="my-16">
                <label for="identity" class="sr-only">
                    Phone Number</label>
                <input id="identity"
                    class="my-4 rounded-md appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
                    type="tel" placeholder="Phone" aria-describedby="phoneHelp"  @blur="validate('phone')"
          @keypress="validate('phone')" v-model="user.phone" />
            <p 
                class="errors text-red-700" 
                v-if="!!errors.phone"
            >{{errors.phone}}</p>
           </div>

            <div class="my-16">
                <label for="identity" class="sr-only">Password</label>

                <input aria-describedby="passwordHelp"  @blur="validate('password')"
          @keypress="validate('password')" v-model="user.password"
                    class="my-4 rounded-md appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
                    id="password" type="password" placeholder="*******" />
             <p 
                class="errors text-red-700" 
                v-if="!!errors.password"
            >{{errors.password}}</p>
            </div>

              <div class="my-16">
                <label for="identity" class="sr-only">Confirm Password</label>

                <input aria-describedby="passwordHelp"  @blur="validate('passwordConfirmation')"
          @keypress="validate('passwordConfirmation')" v-model="user.passwordConfirmation"
                    class="my-4 rounded-md appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
                    id="passwordconfirmation" type="password" placeholder="*******" />
             <p 
                class="errors text-red-700" 
                v-if="!!errors.passwordConfirmation"
            >{{errors.passwordConfirmation}}</p>
            </div>
        </div>
        <button
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 mt-10"
            type="submit"
           >
            SignUp
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
const SignUpSchema = Yup.object().shape({
     firstname: Yup.string()
    .min(3, "First Name should be less than 3 characters")
    .max(25, "First Name should not exceed 25 characters")
    .required("First Name is required"),
  lastname: Yup.string()
    .min(3, "Last Name should be less than 3 characters")
    .max(25, "Last Name should not exceed 25 characters")
    .required("Last Name is required"),
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
     .required("Password is required"),
     passwordConfirmation: Yup.string()
     .oneOf([Yup.ref('password'), null], 'Passwords must match')
});

export default {
    name: "Signup",
    // create dataobject that binds to the form with v-model
    data() {
        return {
        
          user: {
        firstname: "",
            lastname: "",
            phone: "",
            password: "",
            passwordConfirmation: "",
            error: false,
            errorMsg: `An Error occurred, please try again`
      },
      errors: {
        firstname: "",
            lastname: "",
            phone: "",
            password: "",
            passwordConfirmation: ""
      }
        }
    },
    methods: {
        // add users to the database
        async register() {
            try {
                console.log('clicked')
                SignUpSchema.validate(this.user, { abortEarly: false })
               await axios.post(`http://localhost:8080/users/add`,  {
                    firstname: this.user.firstname,
                    lastname: this.user.lastname,
                    phone: this.user.phone,
                    password: this.user.password
                })
                this.$router.push('/')
            } catch (e) {
                console.log('error')
                this.error = true
                this.email = ''
            }
        },
      validate(field) {
      SignUpSchema.validateAt(field, this.user)
        .then(() => (this.errors[field] = ""))
        .catch((err) => {
          this.errors[err.path] = err.message;
        });
    },
    },
};
</script>