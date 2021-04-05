<template>
<div class="modal fade" id="modalAddEditEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 v-if="modalType=='add'" class="modal-title" style="text-transform: uppercase;">{{ __('Add') }} {{ __('Employee') }}</h5>
                <h5 v-else-if="modalType=='edit'" class="modal-title">{{ __('Edit') }} {{ __('Employee') }}</h5>
                <h5 v-else class="modal-title">{{ __('Employee') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="needs-validation" v-on:submit.prevent="'actionStoreUpdate()'">
            <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label :class="['control-label', errors.name ? 'text-danger' : '']"><b>{{ __('validation.attributes.name') }}</b></label>
                            <input v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" :placeholder="__('validation.attributes.name')" required :disabled="modalType=='show'">
                            <small v-if="errors.name" class="form-control-feedback text-danger">
                                {{ errors.name[0] }}
                            </small>
                        </div>
                        <div class="form-group col-sm-6">
                            <label :class="['control-label', errors.last_name ? 'text-danger' : '']"><b>{{ __('validation.attributes.last_name') }}</b></label>
                            <input v-model="form.last_name" type="text" :class="['form-control', errors.last_name ? 'is-invalid' : '']" name="last_name" :placeholder="__('validation.attributes.last_name')" required :disabled="modalType=='show'">
                            <small v-if="errors.last_name" class="form-control-feedback text-danger">
                                {{ errors.last_name[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6 col-md-4">
                            <label :class="['control-label', errors.email ? 'text-danger' : '']"><b>{{ __('validation.attributes.email') }}</b></label>
                            <input  v-model="form.email" type="email" :class="['form-control', errors.email ? 'is-invalid' : '']" name="email" :placeholder="__('validation.attributes.email')" :disabled="modalType=='show'">
                            <small v-if="errors.email" class="form-control-feedback text-danger">
                                {{ errors.email[0] }}
                            </small>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label :class="['control-label', errors.phone ? 'text-danger' : '']"><b>{{ __('validation.attributes.phone') }}</b></label>
                            <input v-model="form.phone" type="text" :class="['form-control', errors.phone ? 'is-invalid' : '']" name="phone" :placeholder="__('validation.attributes.phone')" :disabled="modalType=='show'">
                            <small v-if="errors.phone" class="form-control-feedback text-danger">
                                {{ errors.phone[0] }}
                            </small>
                        </div>
                        <div class="form-group col-md-4">
                            <label :class="['control-label', errors.password ? 'text-danger' : '']"><b>{{ __('validation.attributes.password') }}</b></label>
                            <div class="input-group">
                                <input  v-model="form.password" :type="[hasVisiblePassword ? 'text' : 'password']" :class="['form-control', errors.password ? 'is-invalid' : '']" name="password" :placeholder="__('validation.attributes.password')" :disabled="modalType=='show'">
                                <div class="input-group-append">
                                    <span @click="hasVisiblePassword = !hasVisiblePassword" class="input-group-text" style="cursor: pointer">
                                        <i v-if="hasVisiblePassword" class="la la-eye-slash icon-lg"></i>
                                        <i v-else class="la la-eye icon-lg"></i>
                                    </span>
                                </div>
                            </div>
                            <small v-if="errors.password" class="form-control-feedback text-danger">
                                {{ errors.password[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label :class="['control-label', errors.role ? 'text-danger' : '']"><b>{{ __('validation.attributes.role') }}</b></label>
                            <vs-select :key="roles.length" filter :placeholder="__('Select')" v-model="form.role" state="primary" :disabled="modalType=='show'">
                                <vs-option v-for="role in roles" :key="role.id" :label="role.name" :value="role.id">
                                    {{ role.name }}
                                </vs-option>
                            </vs-select>
                            <small v-if="errors.role" class="form-control-feedback text-danger">
                                {{ errors.role[0] }}
                            </small>
                        </div>

                        <div v-if="form.role != 1" class="form-group col-sm-6">
                            <label :class="['control-label', errors.offices ? 'text-danger' : '']"><b>{{ __('validation.attributes.offices') }}</b></label>
                            <vs-select :key="offices.length" filter v-model="form.offices" multiple :placeholder="__('Select')" state="primary" :disabled="modalType=='show'">
                                <vs-option v-for="office in offices" :key="office.id" :label="office.name" :value="office.id">{{ office.name }}</vs-option>
                            </vs-select>
                            <small v-if="errors.offices" class="form-control-feedback text-danger">
                                {{ errors.offices[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label :class="['control-label', errors.extra_info ? 'text-danger' : '']"><b>{{ __('validation.attributes.extra_info') }}</b></label>
                            <input v-model="form.extra_info" type="text" :class="['form-control', errors.extra_info ? 'is-invalid' : '']" name="extra_info" :disabled="modalType=='show'" :placeholder="__('validation.attributes.extra_info')">
                            <small v-if="errors.extra_info" class="form-control-feedback text-danger">
                                {{ errors.extra_info[0] }}
                            </small>
                        </div>
                    </div>

            </div>
            <div v-if="modalType!='show'" class="modal-footer">
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
        this.getOffices();
        this.getRoles();
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
                role: '',
                id: ''
            },
            errors: {},

            hasVisiblePassword: false
        }
    },

    methods: {
        getOffices() {
            const url = `/admin/ajax/offices`;

            axios.get(url)
            .then(res => {
                this.offices = res.data.data;
            })
            .catch(err => {
                console.error(err);
            });
        },
        getRoles() {
            const url = `/admin/ajax/roles`;

            axios.get(url)
            .then(res => {
                this.roles = res.data.data;
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
            if( employee && (action.includes('edit') || action.includes('show'))) {
                this.form = {
                    name: employee.name,
                    last_name: employee.last_name,
                    email: employee.email,
                    phone: employee.phone,
                    password: '',
                    extra_info: employee.extra_info,
                    offices: employee.offices.map(o => o.id),
                    role: employee.role ? employee.role.id : '',
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
                role: '',
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
                $('#modalAddEditEmployee').modal('hide');
                this.clearForm();
                this.$emit('updateEmployeeList', 'add');
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
            const url = `/admin/ajax/employees/${this.form.id}/update`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
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
                $('#modalAddEditEmployee').modal('hide');
                this.clearForm();
                this.$emit('updateEmployeeList', 'edit');
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
.vs-select-content {
    max-width: none;
}
form label {
    text-transform: uppercase;
}
</style>
