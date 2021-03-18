<template>
<div class="modal fade" id="modalAddEditOffice" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 v-if="modalType=='add'" class="modal-title">Nueva Sucursal</h5>
                <h5 v-else class="modal-title">Editar Sucursal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="needs-validation" v-on:submit.prevent="actionStoreUpdate()">
            <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-sm-6 col-lg-2">
                            <label :class="['control-label', errors.cif ? 'text-danger' : '']"><b>CIF</b></label>
                            <input v-model="form.cif" type="text" :class="['form-control', errors.cif ? 'is-invalid' : '']" name="cif" placeholder="CIF" required>
                            <small v-if="errors.cif" class="form-control-feedback text-danger">
                                {{ errors.cif[0] }}
                            </small>
                        </div>
                        <div class="form-group col-sm-6 col-lg-3">
                            <label :class="['control-label', errors.name ? 'text-danger' : '']"><b>NOMBRE</b></label>
                            <input v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" placeholder="NOMBRE" required>
                            <small v-if="errors.name" class="form-control-feedback text-danger">
                                {{ errors.name[0] }}
                            </small>
                        </div>
                        <div class="form-group col-6 col-md-6 col-lg-2">
                            <label :class="['control-label', errors.email ? 'text-danger' : '']"><b>EMAIL</b></label>
                            <input  v-model="form.email" type="email" :class="['form-control', errors.email ? 'is-invalid' : '']" name="email" placeholder="EMAIL">
                            <small v-if="errors.email" class="form-control-feedback text-danger">
                                {{ errors.email[0] }}
                            </small>
                        </div>
                        <div class="form-group col-6 col-md-6 col-lg-2">
                            <label :class="['control-label', errors.phone ? 'text-danger' : '']"><b>TELEFONO</b></label>
                            <input v-model="form.phone" type="text" :class="['form-control', errors.phone ? 'is-invalid' : '']" name="phone">
                            <small v-if="errors.phone" class="form-control-feedback text-danger">
                                {{ errors.phone[0] }}
                            </small>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label :class="['control-label', errors.contact_person ? 'text-danger' : '']"><b>GERENTE</b></label>
                            <input v-model="form.contact_person" type="text" :class="['form-control', errors.contact_person ? 'is-invalid' : '']" name="contact_person">
                            <small v-if="errors.phone" class="form-control-feedback text-danger">
                                {{ errors.phone[0] }}
                            </small>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label :class="['control-label', errors.address ? 'text-danger' : '']"><b>DIRECCION</b></label>
                            <input v-model="form.address" type="text" :class="['form-control', errors.address ? 'is-invalid' : '']" name="address" placeholder="DIRECCION">
                            <small v-if="errors.address" class="form-control-feedback text-danger">
                                {{ errors.address[0] }}
                            </small>
                        </div>
                        <div class="form-group col-md-6">
                            <label :class="['control-label', errors.extra_address ? 'text-danger' : '']"><b>DIRECCION EXTRA</b></label>
                            <input v-model="form.extra_address" type="text" :class="['form-control', errors.extra_address ? 'is-invalid' : '']" name="extra_address" placeholder="DIRECCION EXTRA">
                            <small v-if="errors.extra_address" class="form-control-feedback text-danger">
                                {{ errors.extra_address[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6 col-md-3">
                            <label :class="['control-label', errors.city ? 'text-danger' : '']"><b>CIUDAD</b></label>
                            <input v-model="form.city" type="text" :class="['form-control', errors.city ? 'is-invalid' : '']" name="city">
                            <small v-if="errors.city" class="form-control-feedback text-danger">
                                {{ errors.city[0] }}
                            </small>
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <label :class="['control-label', errors.cp ? 'text-danger' : '']"><b>CP</b></label>
                            <input v-model="form.cp" type="text" :class="['form-control', errors.cp ? 'is-invalid' : '']" name="cp">
                            <small v-if="errors.cp" class="form-control-feedback text-danger">
                                {{ errors.cp[0] }}
                            </small>
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <label :class="['control-label', errors.province ? 'text-danger' : '']"><b>PROVINCIA</b></label>
                            <input v-model="form.province" type="text" :class="['form-control', errors.province ? 'is-invalid' : '']" name="province">
                            <small v-if="errors.province" class="form-control-feedback text-danger">
                                {{ errors.province[0] }}
                            </small>
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <label :class="['control-label', errors.country ? 'text-danger' : '']"><b>PAIS</b></label>
                            <input v-model="form.country" type="text" :class="['form-control', errors.country ? 'is-invalid' : '']" name="country">
                            <small v-if="errors.country" class="form-control-feedback text-danger">
                                {{ errors.country[0] }}
                            </small>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            modalType: 'add', //add, edit

            form: {
                name: '',
                cif: '',
                address: '',
                extra_address: '',
                city: '',
                cp: '',
                province: '',
                country: '',
                phone: '',
                email: '',
                contact_person: '',
                id: ''
            },
            errors: {}
        }
    },

    methods: {
        showForm(action, office = null) {

            if(this.modalType != action) {
                this.clearForm();
            }

            this.modalType = action;
            if(this.modalType === 'edit' && office) {
                this.form = {
                    name: office.name,
                    cif: office.cif,
                    address: office.address,
                    extra_address: office.extra_address,
                    city: office.city,
                    cp: office.cp,
                    province: office.province,
                    country: office.country,
                    phone: office.phone,
                    email: office.email,
                    contact_person: office.contact_person,
                    id: office.id,
                };
            }
            this.errors = {};
            $('#modalAddEditOffice').modal('show');
        },
        clearForm() {
            this.form = {
                name: '',
                cif: '',
                address: '',
                extra_address: '',
                city: '',
                cp: '',
                province: '',
                country: '',
                phone: '',
                email: '',
                contact_person: '',
                id: ''
            };
            this.errors = {};
        },
        actionStoreUpdate() {
            if(this.modalType == 'add') {
                this.store();
            }else if(this.modalType == 'edit') {
                this.update();
            }
        },
        store() {
            const url = '/admin/ajax/offices/store';
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: 'Cargando...'
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
                $('#modalAddEditOffice').modal('hide');
                this.clearForm();
                this.$emit('updateOfficeList', 'add');
            })
            .catch(err => {
                loading.close();
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
        update() {
            const url = `/admin/ajax/offices/${this.form.id}/update`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: 'Cargando...'
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
                $('#modalAddEditOffice').modal('hide');
                this.clearForm();
                this.$emit('updateOfficeList', 'add');
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

<style>

</style>
