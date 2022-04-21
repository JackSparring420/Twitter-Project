<template>
    <header>
        <div class="header-nav">
            <i class="fab fa-twitter"></i>
            <input type="checkbox" id="nav-toggle" class="nav-toggle">
            <nav class="nav-nav">
                <ul class="ul-links">

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
    }
}
</script>