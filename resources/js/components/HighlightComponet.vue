<template>
  <vue-highlights
    v-model="text"
    :extractUrlsWithoutProtocol="true"
    caretColor="#ccc"
    placeholder="My custom placeholder..."
    usernameClass="my-username-class"
    hashtagClass="my-hash-class"
    urlClass="my-url-class"
  />
</template>

<script>
export default {
  name: 'MyComponent',
  data () {
    return {
      text: text
    }
  }
}
</script>