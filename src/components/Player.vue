<template><div>

<app-header></app-header>

<section class="title">
  <div class="container">
    <input v-model="playlistTitle" spellcheck="false" :disabled="!isEditor"/>
  </div>
</section>

<section class="player">
  <div class="container">
    <div class="columns is-gapless">
      <div class="column is-half left">
        <div class="content embed">
          <youtube
            v-if="playlistLoaded && videos.length > 0"
            :video-id="currentVideoId"
            :player-vars="{
              autoplay: 1,
              controls: 1,
              disablekb: 0,
              iv_load_policy: 3,
              rel: 0,
              showinfo: 0
            }"
            @ready="onPlayerReady"
            @playing="onPlayerPlaying"
            @paused="onPlayerPaused"
            @ended="onPlayerEnded"
          ></youtube>
          <div class="control is-grouped primary">
            <p class="control">
              <button class="button" @click="playPreviousVideo()" :disabled="currentVideoIndex === 0">
                <span class="icon">
                  <i class="fa fa-step-backward"></i>
                </span>
              </button>
            </p>
            <p class="control">
              <button class="button" v-if="!isPlaying" @click="play()">
                <span class="icon">
                  <i class="fa fa-play"></i>
                </span>
              </button>
              <button class="button" v-if="isPlaying" @click="pause()">
                <span class="icon">
                  <i class="fa fa-pause"></i>
                </span>
              </button>
            </p>
            <p class="control">
              <button class="button" @click="playNextVideo()" :disabled="currentVideoIndex === videos.length - 1">
                <span class="icon">
                  <i class="fa fa-step-forward"></i>
                </span>
              </button>
            </p>
          </div>
          <div class="control is-grouped secondary">
            <p class="control">
              <button class="button repeat" :class="{ active: isOnRepeat }" @click="toggleRepeat">
                <span class="icon">
                  <i class="fa fa-repeat"></i>
                </span>
              </button>
            </p>
            <p class="control">
              <button class="button" @click="openExternalVideo()">
                <span class="icon">
                  <i class="fa fa-youtube"></i>
                </span>
              </button>
            </p>
          </div>
          <hr/>
          <div class="content actions has-text-centered">
            <p class="control" v-if="isEditor">
              <button class="button" @click="addVideo()">
                <span class="icon">
                  <i class="fa fa-plus"></i>
                </span>
                <span>Add video from YouTube URL</span>
              </button>
            </p>
            <p class="control" v-if="isEditor">
              <button class="button" @click="savePlaylist()">
                <span class="icon">
                  <i class="fa fa-floppy-o"></i>
                </span>
                <span>Save as shareable playlist</span>
              </button>
            </p>
            <!-- <p class="control" v-if="!isEditor">
              <button class="button">
                <span class="icon">
                  <i class="fa fa-share"></i>
                </span>
                <span>Share playlist</span>
              </button>
            </p> -->
            <p class="control" v-if="!isEditor">
              <button class="button" @click="remixPlaylist()">
                <span class="icon">
                  <i class="fa fa-code-fork"></i>
                </span>
                <span>Remix this playlist</span>
              </button>
            </p>
          </div>
        </div>
      </div>
      <div class="column is-half right">
        <ul id="playlist">
          <li
            class="columns is-mobile"
            v-for="(video, index) in videos"
            :class="{ active: index == currentVideoIndex }"
            @click="playVideoFromIndex(index)"
          >
            <div class="column is-1-desktop is-2-mobile has-text-centered">{{ index + 1 }}</div>
            <div class="column">{{ video.title }}</div>
            <div class="column is-1-desktop is-2-mobile has-text-centered" v-if="isEditor">
              <a class="button delete" @click.stop="deleteVideoAtIndex(index)"></a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<app-footer></app-footer>

</div></template>

<script>
import Vue from 'vue'
import VueYouTubeEmbed from 'vue-youtube-embed'
import AppHeader from './Header'
import AppFooter from './Footer'

Vue.use(VueYouTubeEmbed)

export default {
  name: 'player',
  components: {
    AppHeader,
    AppFooter,
    VueYouTubeEmbed
  },
  data () {
    return {
      videos: [], // { title: '', id: '' },
      isEditor: false,
      currentVideoIndex: 0,
      player: null,
      sortable: null,
      isPlaying: false,
      isOnRepeat: false,
      playlistLoaded: false,
      playlistTitle: 'My new playlist',
//      apiURL: 'http://localhost:3000/server/api/'
      apiURL: '/api/'
    }
  },
  computed: {
    currentVideoId () {
      if (this.videos.length > 0) {
        return this.videos[this.currentVideoIndex].id
      } else {
        return 'dQw4w9WgXcQ'
      }
    }
  },
  methods: {
    loadPlaylist (hash) {
      this.$http.get(this.apiURL + '?hash=' + hash)
        .then((response) => {
          this.playlistTitle = response.data.title
          this.videos = response.data.videos
          this.currentVideoIndex = 0
          this.playlistLoaded = true
        }, (response) => {
          this.$router.push('/')
        })
    },
    playVideoFromIndex (index) {
      if (index >= 0 && index <= this.videos.length - 1) {
        this.currentVideoIndex = index
      }
    },
    playNextVideo () {
      if (this.isOnRepeat) {
        this.player.playVideo()
      } else if (this.currentVideoIndex < this.videos.length - 1) {
        this.currentVideoIndex++
      }
    },
    playPreviousVideo () {
      if (this.currentVideoIndex > 0) {
        this.currentVideoIndex--
      }
    },
    onPlayerReady (player) {
      this.player = player
      this.isPlaying = false
    },
    onPlayerPlaying () {
      this.isPlaying = true
    },
    onPlayerPaused () {
      this.isPlaying = false
    },
    onPlayerEnded () {
      this.isPlaying = false
      this.playNextVideo()
    },
    play () {
      this.player.playVideo()
    },
    pause () {
      this.player.pauseVideo()
    },
    toggleRepeat () {
      this.isOnRepeat = !this.isOnRepeat
    },
    openExternalVideo () {
      window.open(this.player.getVideoUrl())
    },
    addVideo () {
      var self = this
      this.$swal({
        title: 'Add YouTube video',
        input: 'text',
        inputPlaceholder: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        showCancelButton: true,
        confirmButtonText: 'Add video'
      }).then(url => {
        if (/^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/.test(url)) {
          var videoId = url.match(/^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/)[1]
          this.$http.jsonp(
            'https://www.googleapis.com/youtube/v3/videos',
            {
              params: {
                id: videoId,
                key: 'AIzaSyDCF5xUj5GTFCqoF3qRYGx40SC5-JHqvds',
                fields: 'items(snippet(title))',
                part: 'snippet'
              }
            })
          .then((data) => {
            try {
              var title = data.body.items[0].snippet.title
              if (!title.length) {
                throw new Error('Invalid video.')
              }
              this.videos.push({
                title: title,
                id: videoId
              })
              self.$swal({
                type: 'success',
                title: 'Your video has been added to the playlist.'
              })
              if (this.videos.length === 1) {
                this.playVideoFromIndex(0)
              }
            } catch (error) {
              console.log('Error:', error)
              self.$swal({
                type: 'error',
                title: 'There has been an issue while fetching your video.'
              })
            }
          }, (error) => {
            console.log('Error:', error)
            self.$swal({
              type: 'error',
              title: 'There has been an issue while fetching your video.'
            })
          })
        } else {
          self.$swal({
            type: 'error',
            title: 'Invalid YouTube URL.'
          })
        }
      }).catch(this.$swal.noop)
    },
    deleteVideoAtIndex (index) {
      this.videos.splice(index, 1)
      if (index < this.currentVideoIndex) {
        this.currentVideoIndex--
      } else if (index > this.currentVideoIndex) {
        // do nothing
      } else {
        if (this.currentVideoIndex <= this.videos.length - 1) {
          this.playVideoFromIndex(this.currentVideoIndex)
        } else {
          if (this.videos.length) {
            this.currentVideoIndex = this.videos.length - 1
            this.playVideoFromIndex(this.currentVideoIndex)
          }
        }
      }
    },
    remixPlaylist () {
      this.$router.push('/play/remix')
    },
    savePlaylist () {
      var self = this
      var playlist = {
        title: this.playlistTitle,
        videos: this.videos
      }
      this.$http.post(this.apiURL, playlist)
        .then((response) => {
          if (response.body.error) {
            self.$swal({
              type: 'error',
              title: 'Unexpected error occured while saving your playlist.'
            })
          } else {
            self.$swal({
              type: 'success',
              title: 'Your playlist is live, time to share it!'
            })
            this.$router.push('/play/' + response.body.hash)
          }
        })
    },
    parseRoute () {
      var playlistHash = this.$route.params.hash
      if (/[^a-zA-Z0-9]/.test(playlistHash)) {
        this.$router.push('/')
      } else {
        if (playlistHash === 'remix') {
          this.isEditor = true
          this.playlistLoaded = true
          if (this.sortable !== null) {
            this.sortable.option('disabled', !this.isEditor)
          }
        } else if (playlistHash === 'new') {
          this.playlistTitle = 'My new playlist'
          this.isEditor = true
          this.playlistLoaded = true
          this.currentVideoIndex = 0
          this.videos = [{
            title: 'Rick Astley - Never Gonna Give You Up',
            id: 'dQw4w9WgXcQ'
          }]
          if (this.sortable !== null) {
            this.sortable.option('disabled', !this.isEditor)
          }
        } else {
          this.isEditor = false
          this.loadPlaylist(playlistHash)
        }
      }
    }
  },
  watch: {
    '$route' (to, from) {
      this.parseRoute()
    }
  },
  mounted () {
    var self = this
    this.$nextTick(() => {
      self.sortable = window.Sortable.create(document.getElementById('playlist'), {
        onEnd: (e) => {
          var clonedItems = self.videos.filter((item) => {
            return item
          })
          clonedItems.splice(e.newIndex || 0, 0, clonedItems.splice(e.oldIndex, 1)[0])
          self.videos = []
          self.$nextTick(() => {
            self.videos = clonedItems
            self.currentVideoIndex = e.newIndex || 0
          })
        }
      })
      self.sortable.option('disabled', !self.isEditor)
    })
    this.parseRoute()
  }
}
</script>

<style lang="scss" scoped>

// Variables
$left-bg: #2E2F33;


hr {
  height: 1px;
  background: #eee;
}

section.title {
  margin: 14px 0;

  input {
    border: 0;
    border: 1px solid white;
    border-radius: 4px;
    font-size: 32px;
    color: #bebebe;
    padding: 10px;
    box-sizing: border-box;
    background: white;

    &:focus {
      border: 1px solid #ccc;
      outline: 0;
    }
  }
}

section.player {
  margin-bottom: 30px;

  > .container {
    border: 1px solid #eee;
  }
}

.left {
  overflow: hidden;
  background: $left-bg;

  .content {
    padding-bottom: 20px;
  }

  .embed {

    > div:first-child {
      position: relative;
      padding-bottom: 56.25%;
      height: 0;
      overflow: hidden;
    }
  }

  .control.is-grouped {
    justify-content: center;

    .button .icon:last-child, .button .tag:last-child,
    .button .icon:first-child, .button .tag:first-child {
      margin: 0;
    }

    button {
      background: transparent;
      border: 0;
      color: #C4C4C4;

      &:hover {
        &:not(.active) {
          color: white;
        }
      }
    }

    &.primary {
      margin-top: 30px;

      button i {
        font-size: 36px;
      }
    }

    &.secondary {
      margin-top: 20px;
      margin-bottom: 30px;
    }
  }

  button.repeat {
    &.active {
      color: red;
    }
  }

  .actions {
    margin-top: 40px;

    button {
      display: block;
      margin: auto;
      width: 50%;
      padding: 8px;
      height: auto;
      text-align: center;
    }
  }
}

.right {
  flex: 1 1 auto;

  ul {
    height: 100%;
    overflow-y: auto;

    li {
      box-sizing: border-box;
      margin: 0;
      border-bottom: 1px solid #eee;
      padding: 10px 0;

      > div {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      &:hover {
        background: #eee;
        cursor: pointer;
      }

      &.active {
        background: #22509b;
        color: white;

        .delete {
          background-color: rgba(255, 255, 255, 0.2);
        }
      }
    }
  }
}

@media (max-width: 979px) {
  section.title input {
    font-size: 24px;
    width: 100%;
    text-align: center;
  }
  section.player {
    margin-bottom: 0;

    > .container {
      border: 0;
    }
  }
  .left {
    border-radius: 0;

    .content {
      padding-bottom: 10px;
    }
    .control.is-grouped {
      &.primary {
        margin-top: 20px;

        button i {
          font-size: 36px;
        }
      }
      &.secondary {
        margin-top: 20px;
        margin-bottom: 20px;
      }
    }
    .actions {
      margin-top: 20px;

      button {
        width: auto;
      }
    }
  }
  .right {
    ul {

      li {
        > div {
          white-space: normal;
        }
      }
    }
  }
}
</style>
