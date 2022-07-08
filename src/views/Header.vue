<template>
    <div className="mb-10">
            <div className="flex justify-center">
                <img 
                    alt=""
                    className="h-14 w-14"
                    src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQ-Oy7Jl2PYVr4xWvuB0GiB6ybMuK8FdcLnDwuuDuv7oDyYS__U"/>
            </div>
            <h2 className="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {heading}
            </h2>
            <p className="mt-2 text-center text-sm text-gray-600 mt-5">
            {paragraph} {' '}
              <router-link
            to="/login"
            class="block ml-4 mt-4 lg:inline-block lg:mt-0 text-blue-200 hover:text-white"
            >Login</router-link>
            </p>
        </div>
</template>