<style lang="scss">

/* Overwrite Bulma variables */
$size-normal: 16px;
$link-visited: #000;

/* Import Bulma */
@import '~bulma';

/* Hardcoded Bulma overwrites */
.nav-item {
  border-bottom: 2px solid rgba(255,255,255,0.1);
}
.nav-item a.is-active, a.nav-item.is-active, .router-link-active {
  border-bottom: 2px solid #ccc;
}
.has-text-centered .control {
  text-align: center;
}
.swal2-modal hr.swal2-spacer {
  background: transparent;
  height: 1px;
}

/* Custom generic */
html, body {
  margin: 0;
  padding: 0;
  background: white;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
section.main {
  margin-top: 100px;
  padding: 40px 20px;
  margin-bottom: 40px;
}
iframe {
  max-width: 100%;
}
.footer {
  background: white;
  padding: 16px 0;

  .container {
    font-size: 14px;
    opacity: 0.6;

    /*i {
      font-size: 46px;
      opacity: 0.6;
    }*/
    i {
      font-size: 18px;
      margin: 0 4px;
    }
  }
}
.delete {
  width: 20px;
  height: 20px;
}

#youtube-player-1 {
  position: absolute;
  top: 0;
  left: 0;
  width: 100% !important;
  height: 100% !important;
}

/* Custom utils */
.is-custom-gradient-1 {
  background: linear-gradient(270deg, #eaeaea, #ffffff, #fefefe);
  background-size: 600% 600%;    
}

/* Mobile */
@media (max-width: 979px) {
  section.main {
    margin-top: 40px;
  }
  .nav-item a.is-active, a.nav-item.is-active, a.nav-item.router-link-active {
    border-bottom: 0;
    color: #00d1b2;
  }
}

</style>
