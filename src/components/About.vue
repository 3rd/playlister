<template><div>

<app-header></app-header>

<section class="main">
  <div class="container">
    <div class="content">
      <div class="columns">
        <div class="column is-two-thirds">
            <h1 class="title">About Playlister</h1>
            <h3 class="subtitle">Doesn't YouTube already have playlists?</h3>
            <p>
              I really don't enjoy the user experience YouTube provides. I wanted a simple way of creating a shareable mix that can just be sent to someone and they can enjoy it without any UI noise.
              Is it overkill? Probably.
            </p>
            <h3 class="subtitle">The purpose of the project</h3>
            <p>
              Playlister has been just an exercise for me, as I had to practice some technologies I've just finished a few online classes on. It's built using <a href="https://vuejs.org/">Vue</a> and <a href="http://bulma.io/">Bulma</a>.
            </p>
            <h3 class="subtitle">Can I help?</h3>
            <p>
              Sure! Go ahead and fork the code on <a href="https://github.com/neculaesei/Playlister">GitHub</a>. Pull requests are always welcome.
            </p>
            <h3 class="subtitle">Who are you?</h3>
            <p>
              I'm just a regular dude that likes to build and break stuff. Check out my <a href="https://seclab.co">website</a>.
            </p>
        </div>
      </div>
    </div>
  </div>
</section>

</div></template>

<script>
import AppHeader from './Header'

export default {
  name: 'about',
  components: {
    AppHeader
  }
}
</script>

<style lang="scss" scoped>
</style>
