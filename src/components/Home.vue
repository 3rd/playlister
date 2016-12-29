<template><div>

<section class="hero header is-fullheight is-custom-gradient-1 is-bold">
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
              <span>Fork me</span>
            </a>
          </span>
        </div>
      </div>
    </header>
  </div>
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        Meet Playlister
      </h1>
      <h2 class="subtitle">
        Instantly create shareable playlists
      </h2>
      <div class="content">
        <p>
          <i>Playlister</i> takes the songs you add and creates an online music player you can share with your friends.
        </p>
        <p>
          Every part of <i>Playlister</i> is open-sourced, feel free to fork it and create pull requests on <a href="https://github.com/neculaesei/Playlister">GitHub</a>.
        </p>
        <p class="cta">
          <router-link class="button is-primary is-medium is-outlined" to="/play/new">
            <span class="icon">
              <i class="fa fa-play" aria-hidden="true"></i>
            </span>
            <span>Create a new playlist</span>
          </router-link>
        </p>
      </div>
    </div>
  </div>
  <div class="hero-foot">
    <div class="container footer has-text-centered">
      <div class="content">
        <span>Made with</span>
        <i class="fa fa-heart-o" aria-hidden="true"></i>
        <span>by</span>
        <a target="_blank" href="https://seclab.co">Andrew</a>
      </div>
      <!-- <i class="fa fa-angle-double-down" aria-hidden="true"></i> -->
    </div>
  </div>
</section>

</div></template>

<script>
export default {
  name: 'home',
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
section.header {
  color: white;

  .hero-body {
    h1.title {
      font-size: 54px;
      margin-bottom: 30px;
    }
    h2.subtitle {
      font-size: 24px;
      margin-bottom: 40px;
    }
    a.button {
      margin-top: 20px;
    }
  }
}

@media (max-width: 979px) {
  section.header {
    p.cta {
      text-align: center;
    }
  }
}
</style>
