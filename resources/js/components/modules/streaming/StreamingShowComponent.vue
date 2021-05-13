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


                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    created() {

    },

    data() {
        return {
            ceremony: null,

            form: {
                vimeo_code: '',
                vimeo_url: '',
                vimeo_rmtp_url: '',
                vimeo_rmtp_key: '',
            },
            errors: {}
        }
    },

    methods: {
        showForm(ceremony) {
            this.clearForm();
            this.getCeremony(ceremony.id)
            $('#modalAddEditStreaming').modal('show');
        },

        getCeremony(ceremony_id) {
            const url = `/admin/ajax/ceremonies/${ceremony_id}/show`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.get(url)
            .then(res => {
                loading.close();
                this.ceremony = res.data.data;
                if (this.ceremony.streaming) {
                    if (this.ceremony.video) {
                        this.form = {
                            vimeo_code: this.ceremony.video.vimeo_code,
                            vimeo_url: this.ceremony.video.vimeo_url,
                            vimeo_rmtp_url: this.ceremony.video.vimeo_rmtp_url,
                            vimeo_rmtp_key: this.ceremony.video.vimeo_rmtp_key,
                        }
                    }
                } else {
                    this.$emit('updateStreamingList');
                }
            })
            .catch(err => {
                loading.close();
                console.error(err);
            })
        },

        clearForm() {
            this.ceremony = null;

            this.form = {
                vimeo_code: '',
                vimeo_url: '',
                vimeo_rmtp_url: '',
                vimeo_rmtp_key: '',
            };
            this.errors = {};
        },

        saveConfig() {
            const url = `/admin/ajax/streaming/${this.ceremony.id}/save`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.post(url,this.form)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#modalAddEditStreaming').modal('hide');
                this.clearForm();
                this.$emit('updateStreamingList');
            })
            .catch(err => {
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                }else if(err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }
            })
        }
    },
}
</script>

<style>
form label {
    text-transform: uppercase;
}
</style>
