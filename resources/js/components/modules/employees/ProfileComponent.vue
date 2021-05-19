<template>
<!--begin::Profile Personal Information-->
<div class="d-flex flex-row">
    <!--begin::Content-->
    <div class="flex-row-fluid">
        <!--begin::Card-->
        <div class="card card-custom card-stretch">
            <!--begin::Header-->
            <div class="card-header py-3">
                <div class="card-title align-items-start flex-column">
                    <h3 class="card-label font-weight-bolder text-dark">Perfil</h3>
                    <span class="text-muted font-weight-bold font-size-sm mt-1">Actualice su información personal</span>
                </div>
                <div class="card-toolbar">
                    <button @click="updateEmployee()" type="reset" class="btn btn-success mr-2">Guardar cambios</button>
                </div>
            </div>
            <!--end::Header-->

            <!--begin::Form-->
            <form class="form">
                <!--begin::Body-->
                <div class="card-body">

                    <div class="form-group row">
                        <label :class="['col-xl-3 col-lg-3 col-form-label ', errors.name ? 'text-danger' : '']"><b>Nombre</b></label>
                        <div class="col-lg-9 col-xl-6">
                            <input :class="['form-control form-control-lg form-control-solid ', errors.name ? 'is-invalid' : '']" type="text" v-model="form.name" />
                            <small v-if="errors.name" class="form-control-feedback text-danger">
                                {{ errors.name[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label :class="['col-xl-3 col-lg-3 col-form-label ', errors.last_name ? 'text-danger' : '']"><b>Apellidos</b></label>
                        <div class="col-lg-9 col-xl-6">
                            <input :class="['form-control form-control-lg form-control-solid ', errors.last_name ? 'is-invalid' : '']" type="text" v-model="form.last_name" />
                            <small v-if="errors.last_name" class="form-control-feedback text-danger">
                                {{ errors.last_name[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label :class="['col-xl-3 col-lg-3 col-form-label ', errors.email ? 'text-danger' : '']"><b>Correo</b></label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i :class="['fas fa-envelope icon-md ', errors.email ? 'text-danger' : '']"></i>
                                    </span>
                                </div>
                                <input type="text" :class="['form-control form-control-lg form-control-solid ', errors.email ? 'is-invalid' : '']"
                                    v-model="form.email" />
                            </div>
                            <small v-if="errors.email" class="form-control-feedback text-danger">
                                {{ errors.email[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label :class="['col-xl-3 col-lg-3 col-form-label ', errors.phone ? 'text-danger' : '']"><b>Teléfono</b></label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i :class="['fas fa-phone-alt icon-md ', errors.phone ? 'text-danger' : '']"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control form-control-lg form-control-solid" v-model="form.phone" >
                            </div>
                            <small v-if="errors.phone" class="form-control-feedback text-danger">
                                {{ errors.phone[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label :class="['col-xl-3 col-lg-3 col-form-label ', errors.password ? 'text-danger' : '']" ><b>Contraseña</b></label>
                        <div class="col-lg-9 col-xl-6">
                            <input :class="['form-control form-control-lg form-control-solid ', errors.password ? 'is-invalid' : '']" type="password"
                                v-model="form.password" />
                            <small v-if="errors.password" class="form-control-feedback text-danger">
                                {{ errors.password[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label :class="['col-xl-3 col-lg-3 col-form-label ', errors.password_confirmation ? 'text-danger' : '']"><b>Re-Contraseña</b></label>
                        <div class="col-lg-9 col-xl-6">
                            <input :class="['form-control form-control-lg form-control-solid ', errors.password_confirmation ? 'is-invalid' : '']" type="password"
                                v-model="form.password_confirmation" />
                            <small v-if="errors.password_confirmation" class="form-control-feedback text-danger">
                                {{ errors.password_confirmation[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <!--end::Body-->
            </form>
            <!--end::Form-->
        </div>
    </div>
    <!--end::Content-->
</div>
<!--end::Profile Personal Information-->
</template>

<script>


export default {
    props: ['employee'],

    mounted() {
        this.loadForm(this.employee);
    },

    data() {
        return {
            form: {
                name: '',
                last_name: '',
                phone: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: {},
        }
    },

    methods: {
        updateEmployee() {
            const url = `/admin/ajax/employees/profile`;
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
                const employee = res.data.data;
                this.loadForm(employee);
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
        loadForm(employee) {
            this.form = {
                name: employee.name,
                last_name: employee.last_name,
                phone: employee.phone,
                email: employee.email,
                password: '',
                password_confirmation: ''
            },
            this.errors = {}
        }
    },

}
</script>

<style>

</style>
