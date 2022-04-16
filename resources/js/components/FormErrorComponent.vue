<template>
    <section id="errors">
        <ul class="alert alert-danger">
            <li v-for="error, i in validationErrors" :key="i">{{ error }}</li>
        </ul>
    </section>
</template>

<script>
export default {
    data: function() {
        return {

        }
    },
    props: {
        errors: Object,
    },
    computed: {
        validationErrors() {
            let errors = Object.values(this.errors);
            errors = errors.flat();
            return errors;
        }
    }
}
</script>