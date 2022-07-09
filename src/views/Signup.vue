<template>

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
            <router-link to="/login" class="block ml-4 mt-4 lg:inline-block lg:mt-0 text-blue-200 hover:text-white">
                Login</router-link>
        </p>
    </div>

    <form class="mt-8 space-y-6">
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
                    type="text" placeholder="First Name" aria-describedby="firstnameHelp" v-model="firstname" />
            </div>

            <div class="my-5">
                <label for="identity" class="sr-only">
                    Last Name</label>
                <input id="identity"
                    class="rounded-md appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
                    type="text" placeholder="Last Name" aria-describedby="lastnameHelp" v-model="lastname" />
            </div>


            <div class="my-16">
                <label for="identity" class="sr-only">
                    Phone Number</label>
                <input id="identity"
                    class="rounded-md appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
                    type="tel" placeholder="Phone" aria-describedby="phoneHelp" v-model="phone" />
            </div>

            <div class="my-16">
                <label for="identity" class="sr-only">Password</label>

                <input aria-describedby="passwordHelp" v-model="password"
                    class="rounded-md appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
                    id="password" type="password" placeholder="*******" />
            </div>
        </div>
        <button
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 mt-10"
            type="submit" v-on:click="register()"
            :disabled="firstname.length < 6 || lastname.length < 6 || password.length < 6 || phone.length < 10">
            SignUp
        </button>
        <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
            Forgot Password?
        </a>
    </form>
    <router-view />
</template>

<script>
export default {
    name: "Signup",
    data() {
        return {
            firstname: "",
            lastname: "",
            phone: "",
            password: "",
            error: false,
            errorMsg: `An Error occurred, please try again`
        };
    },
    methods: {
        async register(e) {
            try {
                e.preventDefault()
                console.log('clicked')
                await this.axios.post(`http://localhost:8080/users/new`, {
                    firstname: this.firstname,
                    lastname: this.lastname,
                    phone: this.phone,
                    password: this.password
                })
                this.$router.push('/login')
            } catch (e) {
                console.log('error')
                this.error = true
                this.email = ''
            }
        }
    },
};
</script>