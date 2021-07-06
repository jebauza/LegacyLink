<template>
<div class="modal fade" id="modalAddEditUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 v-if="modalType=='add'" class="modal-title" style="text-transform: uppercase;">{{ __('Add') }} {{ __('Client') }}</h5>
                <h5 v-else-if="modalType=='edit'" class="modal-title">{{ __('Edit') }} {{ __('Client') }}</h5>
                <h5 v-else class="modal-title">{{ __('Client') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="needs-validation" v-on:submit.prevent="'actionStoreUpdate()'">
            <div class="modal-body">

                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label :class="['control-label', errors.name ? 'text-danger' : '']"><b>{{ __('validation.attributes.name') }}</b></label>
                        <input  v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" :placeholder="__('validation.attributes.name')" :disabled="modalType=='show'">
                        <small v-if="errors.name" class="form-control-feedback text-danger">
                            {{ errors.name[0] }}
                        </small>
                    </div>
                    <div class="form-group col-sm-6">
                        <label :class="['control-label', errors.lastname ? 'text-danger' : '']"><b>{{ __('validation.attributes.last_name') }}</b></label>
                        <input  v-model="form.lastname" type="text" :class="['form-control', errors.lastname ? 'is-invalid' : '']" name="lastname" :placeholder="__('validation.attributes.last_name')" :disabled="modalType=='show'">
                        <small v-if="errors.lastname" class="form-control-feedback text-danger">
                            {{ errors.lastname[0] }}
                        </small>
                    </div>
                    <div class="form-group col-sm-6 col-lg-4">
                        <label :class="['control-label', errors.dni ? 'text-danger' : '']"><b>DNI</b></label>
                        <input  v-model="form.dni" type="text" :class="['form-control', errors.dni ? 'is-invalid' : '']" name="dni" placeholder="dni" :disabled="modalType=='show'">
                        <small v-if="errors.dni" class="form-control-feedback text-danger">
                            {{ errors.dni[0] }}
                        </small>
                    </div>
                    <div class="form-group col-sm-6 col-lg-4">
                        <label :class="['control-label', errors.email ? 'text-danger' : '']"><b>{{ __('validation.attributes.email') }}</b></label>
                        <input  v-model="form.email" type="email" :class="['form-control', errors.email ? 'is-invalid' : '']" name="email" :placeholder="__('validation.attributes.email')" :disabled="modalType=='show'">
                        <small v-if="errors.email" class="form-control-feedback text-danger">
                            {{ errors.email[0] }}
                        </small>
                    </div>
                    <div class="form-group col-sm-6 col-lg-4">
                        <label :class="['control-label', errors.phone ? 'text-danger' : '']"><b>{{ __('validation.attributes.phone') }}</b></label>
                        <input  v-model="form.phone" type="text" :class="['form-control', errors.phone ? 'is-invalid' : '']" name="phone" :placeholder="__('validation.attributes.phone')" :disabled="modalType=='show'">
                        <small v-if="errors.phone" class="form-control-feedback text-danger">
                            {{ errors.phone[0] }}
                        </small>
                    </div>
                </div>
            </div>
            <div v-if="modalType != 'show'" class="modal-footer">
                <button type="button" @click="actionStoreUpdate()" class="btn btn-primary">{{ __('Save') }}</button>
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

    data() {
        return {
            modalType: 'add', //add, edit, show

            form: {
                dni: '',
                name: '',
                lastname: '',
                email: '',
                phone: '',
                id: ''
            },
            errors: {},
        }
    },

    methods: {
        showForm(action, user = null) {

            if(this.modalType != action) {
                this.clearForm();
            }

            this.modalType = action;
            if( user && (action.includes('edit') || action.includes('show'))) {
                this.form = {
                    dni: user.dni,
                    name: user.name,
                    lastname: user.lastname,
                    email: user.email,
                    phone: user.phone,
                    id: user.id
                };
            }
            this.errors = {};
            $('#modalAddEditUser').modal('show');
        },
        clearForm() {
            this.form = {
                dni: '',
                name: '',
                lastname: '',
                email: '',
                phone: '',
                id: ''
            };
            this.errors = {};
        },
        actionStoreUpdate() {
            if(this.modalType == 'add') {
                this.store();
            } else if(this.modalType == 'edit') {
                this.update();
            }
        },
        store() {
            const url = '/admin/ajax/clients/store';
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.post(url, this.form)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#modalAddEditUser').modal('hide');
                this.clearForm();
                this.$emit('updateUserList', 'add');
            })
            .catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                } else if(err.response.data.message) {
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
        update() {
            const url = `/admin/ajax/clients/${this.form.id}/update`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.put(url, this.form)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#modalAddEditUser').modal('hide');
                this.clearForm();
                this.$emit('updateUserList', 'edit');
            }).catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                }else if(err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: '#ee2d41',
                    });
                }
            });
        },
    },
}
</script>

<style scoped>
.vs-select-content {
    max-width: none;
}
form label {
    text-transform: uppercase;
}
</style>
