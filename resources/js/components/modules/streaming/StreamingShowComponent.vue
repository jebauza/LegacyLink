<template>
<div class="modal fade" id="modalShowStreaming" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="text-transform: uppercase;">En Vivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                    <div class="form-row">
                        <vimeo-player v-if="video" ref="player" :video-id="video.vimeo_code" :autoplay="true"/>
                    </div>
            </div>
            <div class="modal-footer">
                <button @click="closeStreaming()" type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import { vueVimeoPlayer } from 'vue-vimeo-player'

export default {
    components: { vueVimeoPlayer },

    mounted() {

    },

    data() {
        return {
            video: null
        }
    },

    methods: {
        showStreaming(video) {
            this.video = video;
            this.$refs.player.update(video.vimeo_code)
            $('#modalShowStreaming').modal('show');
        },
        closeStreaming() {
            this.video = null;
            $('#modalShowStreaming').modal('hide');
        }
    },

}
</script>

<style>

</style>
