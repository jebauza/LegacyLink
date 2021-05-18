<template>
<div class="modal fade" id="modalShowStreaming" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="text-transform: uppercase;">En Vivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" ref="content">
                    <div class="form-row">
                        <div v-if="(video && !errorVideo)" class="col-12 embed-container">
                            <vimeo-player ref="player" :video-id="video.vimeo_code" @ready="onReadyVideo" @error="error"/>
                        </div>
                        <div v-else class="col-12">
                            <div class="alert alert-custom alert-danger fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">El video no existe en el servidor, revise los datos de la configuración</div>
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button @click="updateStreaming()" type="button" class="btn btn-primary">Actualizar</button>
                <button @click="closeVideo()" type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import { vueVimeoPlayer } from 'vue-vimeo-player'

export default {
    components: { vueVimeoPlayer },

    watch: {
        'playerReady': function (newValue, oldValue) {
            if (newValue) {
                this.$refs.player.play();
            }
        }
    },

    data() {
        return {
            video: null,
            playerReady: false,
            errorVideo: false
        }
    },

    methods: {
        showStreaming(video) {
            this.playerReady = false;
            this.video = video;
            this.errorVideo = false;
            $('#modalShowStreaming').modal('show');
        },
        onReadyVideo() {
            this.playerReady = true;
        },
        closeVideo() {
            this.video = null;
            $('#modalShowStreaming').modal('hide');
            this.$refs.player.pause();
        },
        updateStreaming() {
            this.$refs.player.update(this.video.vimeo_code);
            this.$refs.player.play();
        },
        error(e) {
            // this.errorVideo = true;
        }
    },

}
</script>

<style>
.embed-container {
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
  max-width: 100%;
}

.embed-container iframe,
.embed-container object,
.embed-container embed {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>
