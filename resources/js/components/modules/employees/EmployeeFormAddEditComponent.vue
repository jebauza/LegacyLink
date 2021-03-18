<template>
<div class="modal fade" id="modalAddEditEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 v-if="modalType=='add'" class="modal-title">Nuevo Empleado</h5>
                <h5 v-else class="modal-title">Editar Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="needs-validation" v-on:submit.prevent="actionStoreUpdate()">
            <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label :class="['control-label', errors.name ? 'text-danger' : '']"><b>NOMBRE</b></label>
                            <input v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" placeholder="NOMBRE" required>
                            <small v-if="errors.name" class="form-control-feedback text-danger">
                                {{ errors.name[0] }}
                            </small>
                        </div>
                        <div class="form-group col-sm-6">
                            <label :class="['control-label', errors.last_name ? 'text-danger' : '']"><b>APELLIDOS</b></label>
                            <input v-model="form.cif" type="text" :class="['form-control', errors.last_name ? 'is-invalid' : '']" name="cif" placeholder="APELLIDOS" required>
                            <small v-if="errors.last_name" class="form-control-feedback text-danger">
                                {{ errors.last_name[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label :class="['control-label', errors.name ? 'text-danger' : '']"><b>NOMBRE</b></label>
                            <input v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" placeholder="NOMBRE" required>
                            <small v-if="errors.name" class="form-control-feedback text-danger">
                                {{ errors.name[0] }}
                            </small>
                        </div>
                        <div class="form-group col-sm-6">
                            <label :class="['control-label', errors.last_name ? 'text-danger' : '']"><b>APELLIDOS</b></label>
                            <input v-model="form.cif" type="text" :class="['form-control', errors.last_name ? 'is-invalid' : '']" name="cif" placeholder="APELLIDOS" required>
                            <small v-if="errors.last_name" class="form-control-feedback text-danger">
                                {{ errors.last_name[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6 col-md-4">
                            <label :class="['control-label', errors.email ? 'text-danger' : '']"><b>EMAIL</b></label>
                            <input  v-model="form.email" type="email" :class="['form-control', errors.email ? 'is-invalid' : '']" name="email" placeholder="EMAIL">
                            <small v-if="errors.email" class="form-control-feedback text-danger">
                                {{ errors.email[0] }}
                            </small>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label :class="['control-label', errors.phone ? 'text-danger' : '']"><b>TELEFONO</b></label>
                            <input v-model="form.phone" type="text" :class="['form-control', errors.phone ? 'is-invalid' : '']" name="phone">
                            <small v-if="errors.phone" class="form-control-feedback text-danger">
                                {{ errors.phone[0] }}
                            </small>
                        </div>
                        <div class="form-group col-md-4">
                            <label :class="['control-label', errors.password ? 'text-danger' : '']"><b>PASSWORD</b></label>
                            <input  v-model="form.password" type="password" :class="['form-control', errors.password ? 'is-invalid' : '']" name="password" placeholder="PASSWORD">
                            <small v-if="errors.password" class="form-control-feedback text-danger">
                                {{ errors.password[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label :class="['control-label', errors.offices ? 'text-danger' : '']"><b>Sucursales</b></label>
                            <vs-select
                                :key="offices.length"
                                filter
                                v-model="form.offices"
                                multiple
                            >
                                <vs-option
                                v-for="o in offices"
                                :key="o.value"
                                :label="o.text"
                                :value="o.value"
                                >
                                {{ o.text }}
                                </vs-option>
                            </vs-select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label :class="['control-label', errors.offices ? 'text-danger' : '']"><b>Sucursales</b></label>
                            <vs-select
                                :key="offices.length"
                                filter
                                v-model="form.offices"
                                multiple
                            >
                                <vs-option
                                v-for="o in offices"
                                :key="o.value"
                                :label="o.text"
                                :value="o.value"
                                >
                                {{ o.text }}
                                </vs-option>
                            </vs-select>
                        </div>

                        <!-- <div class="form-group col-sm-6">
                            <label :class="['control-label', errors.rol ? 'text-danger' : '']"><b>ROL</b></label>
                            <vs-select
                                filter
                                placeholder="ROL"
                                v-model="form.rol"
                            >
                                <vs-option label="Vuesax" value="1">Super admin</vs-option>
                                <vs-option label="Vue" value="2">Admin sucursal</vs-option>
                                <vs-option label="Javascript" value="3">Asesor</vs-option>
                            </vs-select>
                            <small v-if="errors.rol" class="form-control-feedback text-danger">
                                {{ errors.rol[0] }}
                            </small>
                        </div> -->
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label :class="['control-label', errors.extra_info ? 'text-danger' : '']"><b>INFORMACION ADICIONAL</b></label>
                            <input v-model="form.extra_info" type="text" :class="['form-control', errors.extra_info ? 'is-invalid' : '']" name="extra_info">
                            <small v-if="errors.extra_info" class="form-control-feedback text-danger">
                                {{ errors.extra_info[0] }}
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
    created() {
        this.getOffices();
    },
    data() {
        return {
            modalType: 'add', //add, edit

            offices: [],
            roles: [],

            form: {
                name: '',
                last_name: '',
                email: '',
                phone: '',
                password: '',
                extra_info: '',
                offices: [],
                rol: '',
                id: ''
            },
            errors: {}
        }
    },

    methods: {
        getOffices() {
            const url = `/admin/ajax/offices`;

            axios.get(url)
            .then(res => {
                this.offices = res.data.data.map((office) => {
                    return {text: office.name, value: office.id};
                });
            })
            .catch(err => {
                console.error(err);
            })
        },
        showForm(action, employee = null) {

            if(this.modalType != action) {
                this.clearForm();
            }

            this.modalType = action;
            if(this.modalType === 'edit' && employee) {
                this.form = {
                    name: employee.name,
                    last_name: employee.last_name,
                    email: employee.email,
                    phone: employee.phone,
                    password: '',
                    extra_info: employee.extra_info,
                    id: employee.id
                };
            }
            this.errors = {};
            $('#modalAddEditEmployee').modal('show');
        },
        clearForm() {
            this.form = {
                name: '',
                last_name: '',
                email: '',
                phone: '',
                password: '',
                extra_info: '',
                offices: [],
                rol: '',
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
            const url = '/admin/ajax/employees/store';
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
                $('#modalAddEditEmployee').modal('hide');
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
        /* update() {
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
        }, */
    },
}
</script>

<style lang="css">
.vs-select-content {
    max-width: none;
}
</style>
