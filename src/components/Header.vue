<template><div>

<section class="hero header">
  <div class="hero-head">
    <header class="nav">
      <div class="container">
        <div class="nav-left">
          <a class="nav-item is-brand" href="/">
            <img src="/static/logo.png" alt="playlister logo"/>
          </a>
        </div>
        <span class="nav-toggle" :class="{ 'is-active': menuVisible }" @click="toggleMenu">
          <span></span>
          <span></span>
          <span></span>
        </span>
        <div class="nav-right nav-menu" :class="{ 'is-active': menuVisible }">
          <router-link class="nav-item" to="/" exact>Home</router-link>
          <router-link class="nav-item" to="/play/new">Create new playlist</router-link>
          <router-link class="nav-item" to="/about">About the project</router-link>
          <span class="nav-item is-hidden-mobile">
            <a class="button is-primary" href="https://github.com/neculaesei/Playlister">
              <span class="icon">
                <i class="fa fa-github"></i>
              </span>
              <span>GitHub</span>
            </a>
          </span>
        </div>
      </div>
    </header>
  </div>
</section>

</div></template>

<script>
export default {
  name: 'header',
  data () {
    return {
      menuVisible: false
    }
  },
  methods: {
    toggleMenu () {
      this.menuVisible = !this.menuVisible
    }
  }
}
</script>

<style lang="scss" scoped>
</style>
