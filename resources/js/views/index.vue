<template>
    <div class="flex flex-column justify-center items-center h-screen">
        <p class="text-red-600">Homepage</p>
        <span
            >Redirect to page
            <router-link :to="{ name: 'About' }" class="text-blue-600"
                >About</router-link
            ></span
        >
    </div>
</template>

<script>
export default {};
</script>

<style></style>
