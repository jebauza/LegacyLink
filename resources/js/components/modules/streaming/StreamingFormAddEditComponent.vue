<template>
<div class="modal fade" id="modalAddEditStreaming" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="text-transform: uppercase;">Configuración</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="needs-validation" v-on:submit.prevent="saveConfig()">
            <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label :class="['control-label', errors.vimeo_url ? 'text-danger' : '']"><b>Vimeo URL</b></label>
                            <input v-model="form.vimeo_url" type="text" :class="['form-control', errors.vimeo_url ? 'is-invalid' : '']" name="vimeo_url" placeholder="Vimeo URL" required>
                            <small v-if="errors.vimeo_url" class="form-control-feedback text-danger">
                                {{ errors.vimeo_url[0] }}
                            </small>
                        </div>

                        <div class="form-group col-12">
                            <label :class="['control-label', errors.vimeo_code ? 'text-danger' : '']"><b>Vimeo CODIGO</b></label>
                            <input v-model="form.vimeo_code" type="text" :class="['form-control', errors.vimeo_code ? 'is-invalid' : '']" name="vimeo_url" placeholder="Vimeo CODIGO" required>
                            <small v-if="errors.vimeo_code" class="form-control-feedback text-danger">
                                {{ errors.vimeo_code[0] }}
                            </small>
                        </div>

                        <div class="form-group col-12">
                            <label :class="['control-label', errors.vimeo_rmtp_url ? 'text-danger' : '']"><b>Vimeo RMTP URL</b></label>
                            <input v-model="form.vimeo_rmtp_url" type="text" :class="['form-control', errors.vimeo_rmtp_url ? 'is-invalid' : '']" name="vimeo_rmtp_url" placeholder="Vimeo RMTP URL" required>
                            <small v-if="errors.vimeo_rmtp_url" class="form-control-feedback text-danger">
                                {{ errors.vimeo_rmtp_url[0] }}
                            </small>
                        </div>

                        <div class="form-group col-12">
                            <label :class="['control-label', errors.vimeo_rmtp_key ? 'text-danger' : '']"><b>Vimeo RMTP KEY</b></label>
                            <input v-model="form.vimeo_rmtp_key" type="text" :class="['form-control', errors.vimeo_rmtp_key ? 'is-invalid' : '']" name="vimeo_rmtp_key" placeholder="Vimeo RMTP KEY" required>
                            <small v-if="errors.vimeo_rmtp_key" class="form-control-feedback text-danger">
                                {{ errors.vimeo_rmtp_key[0] }}
                            </small>
                        </div>

                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <button v-if="ceremony && ceremony.video" @click="askDelete()" type="button" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    created() {

    },

    watch: {
        'form.vimeo_url': function (newValue, oldValue) {
            let code = (newValue.split('/'))[(newValue.split('/').length - 1)];
            if (code) {
              this.form.vimeo_code = code;
            }
        }
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
            const url = `/admin/ajax/ceremonies/streaming/${this.ceremony.id}/save`;
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
        },

        askDelete() {
            const self = this;
            Swal.fire({
                title: this.__('Are you sure you want to delete this setting?'),
                text: this.__('If you delete this data, will it not be able to recover it?'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#187de4',
                cancelButtonColor: '#d33',
                confirmButtonText: this.__("Yes, I'm sure!"),
                cancelButtonText: this.__('Cancel'),
            }).then((result) => {
                if (result.isConfirmed) {
                    self.deleteVideo();
                }
            });
        },

        deleteVideo() {
            const url = `/admin/ajax/ceremonies/streaming/${this.ceremony.id}/save`;

            console.log('eliminar video');
        }
    },
}
</script>

<style>
form label {
    text-transform: uppercase;
}
</style>
