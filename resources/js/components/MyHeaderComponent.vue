<template>
    <header>
        <div class="header-nav">
            <img src="https://cdn.pixabay.com/photo/2017/08/23/11/30/twitter-2672572_960_720.jpg" alt="">
            <input type="checkbox" id="nav-toggle" class="nav-toggle">
            <nav class="nav-nav">
                <ul class="ul-links">
                    <li>
                        <span @click="goHome">Home</span>
                    </li>

                    <li>
                        <span @click="userProfile">Profilo</span>
                    </li>

                </ul>
            </nav>
            <label for="nav-toggle" class="nav-toggle-label">
                <span></span>
            </label>    
        </div>
    </header>
</template>

<script>
export default {
    props: {
        user: String,
    },
    methods: {
        // redirect to user profile
        userProfile(){
            window.location.href = '/profile';
        },
        // redirect to homepage
        goHome() {
            window.location.href = '/';
        }
    }
}
</script>