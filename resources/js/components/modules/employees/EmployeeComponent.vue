<template>
<!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">{{ __('Employees') }}
                <span class="d-block text-muted pt-2 font-size-sm">{{ __('Employee administration') }}</span></h3>
            </div>
            <div class="card-toolbar">

                <vs-tooltip bottom>
                    <vs-switch danger v-model="searches.softDelete" class="mr-5">
                        <template>
                            <i class='fas fa-trash' ></i>
                        </template>
                    </vs-switch>
                    <template #tooltip>
                        Eliminados
                    </template>
                </vs-tooltip>
                <!--begin::Button-->
                <button @click="openModalAddEditShow('add')" class="btn btn-primary font-weight-bolder">
                    <i class="fas fa-plus-square"></i> {{ __('Add') }}
                </button>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">

            <div class="form-row pl-3 align-items-end">

                <div class="col-sm-6 col-lg-4 form-group">
                    <label style="text-transform: uppercase;"><b>{{ __('validation.attributes.dprofile_office') }}</b></label>
                    <vs-select :key="offices.length" filter v-model="searches.office" :placeholder="__('Select')">
                        <vs-option v-for="office in offices" :key="office.id" :label="office.name" :value="office.id">{{ office.name }}</vs-option>
                    </vs-select>
                </div>

                <div class="col-sm-6 col-lg-4 form-group">
                    <label for="name" style="text-transform: uppercase;"><b>{{ __('validation.attributes.name') }}</b></label>
                    <input v-model="searches.name" type="text" class="form-control" name="name" :placeholder="__('validation.attributes.name')">
                </div>

                <div class="col-10 col-sm-5 col-lg-3 form-group">
                    <label for="email" style="text-transform: uppercase;"><b>{{ __('validation.attributes.email') }}</b></label>
                    <input v-model="searches.email" type="text" class="form-control" name="email" :placeholder="__('validation.attributes.email')">
                </div>

                <div class="col-auto form-group">

                    <vs-tooltip top>
                        <button @click="clearSearches" type="button"
                            class="btn waves-effect waves-light btn-danger float-right font-weight-bolder">
                            <i class="fas fa-filter"></i>
                        </button>
                        <template #tooltip>
                            {{ __('Remove Filters') }}
                        </template>
                    </vs-tooltip>
                </div>
            </div>

            <div v-if="employees.data.length" class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('validation.attributes.name') }}</th>
                            <th>{{ __('validation.attributes.last_name') }}</th>
                            <th>{{ __('validation.attributes.email') }}</th>
                            <th>{{ __('validation.attributes.phone') }}</th>
                            <th>{{ __('validation.attributes.role') }}</th>
                            <th class="text-nowrap d-flex justify-content-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(employee, index) in employees.data" :key="index" :class="[!employee.is_active ? 'text-danger' : '']">
                            <th>{{ index + employees.from }}</th>
                            <td>{{ employee.name }}</td>
                            <td>{{ employee.last_name }}</td>
                            <td>{{ employee.email }}</td>
                            <td>{{ employee.phone }}</td>
                            <td>{{ employee.role.name || '' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <template v-if="employee.deleted_at">
                                        <vs-tooltip bottom>
                                            <button  class="btn btn-sm btn-clean btn-icon mr-2 text-success" @click="restore(employee)">
                                                <i class="fas fa-trash-restore-alt"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ __('Restore') }}
                                            </template>
                                        </vs-tooltip>
                                        <vs-tooltip bottom>
                                            <button  class="btn btn-sm btn-clean btn-icon mr-2 text-danger" @click="askForceDelete(employee)">
                                                <i class="fas fa-dumpster-fire"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ __('Destroy') }}
                                            </template>
                                        </vs-tooltip>
                                    </template>
                                    <template v-else >
                                        <vs-tooltip bottom>
                                            <button  class="btn btn-sm btn-clean btn-icon mr-2 text-success" @click="openModalAddEditShow('show', employee)">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ __('Show') }}
                                            </template>
                                        </vs-tooltip>
                                        <vs-tooltip bottom>
                                            <button class="btn btn-sm btn-clean btn-icon mr-2 text-success" @click="openModalAddEditShow('edit', employee)">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ __('Edit') }}
                                            </template>
                                        </vs-tooltip>
                                        <vs-tooltip bottom>
                                                <button @click="changeStatus(employee)" :class="['btn btn-sm btn-clean btn-icon mr-2', employee.is_active ? 'text-success-green' : 'text-danger']">
                                                    <i v-if="employee.is_active" class="fas fa-lock-open"></i>
                                                    <i v-else class="fas fa-lock"></i>
                                                </button>
                                                <template #tooltip>
                                                    {{ employee.is_active ? __('To block') : __('Activate') }}
                                                </template>
                                            </vs-tooltip>
                                        <vs-tooltip bottom>
                                            <button class="btn btn-sm btn-clean btn-icon mr-2 text-danger" @click="askDestroy(employee)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ __('Delete') }}
                                            </template>
                                        </vs-tooltip>
                                    </template>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <pagination :class="'mt-2'" :align="'center'" :limit="5" :data=" employees" @pagination-change-page="getEmployees"></pagination>
            </div>
            <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                {{ __('There is no item to display') }}
            </div>

        </div>

        <employee-form-add-edit ref="employeeFormAddEdit" @updateEmployeeList="updateList()"></employee-form-add-edit>

    </div>
<!--end::Card-->
</template>

<script>
import EmployeeFormAddEdit from './EmployeeFormAddEditComponent';

export default {
    components: {EmployeeFormAddEdit},

    created() {
        this.getEmployees();
    },

    watch: {
        'searches.office': function (newValue, oldValue) {
            this.getEmployees();
        },
        'searches.name': function (newValue, oldValue) {
            this.getEmployees();
        },
        'searches.email': function (newValue, oldValue) {
            this.getEmployees();
        },
        'searches.softDelete': function (newValue, oldValue) {
            this.getEmployees();
        }
    },

    data() {
        return {
            employees: {data:[]},
            offices: [],

            searches: {
                office: '',
                name: '',
                email: '',
                softDelete: false
            },
        }
    },

    methods: {
        getEmployees(page = 1) {
            const url = `admin/ajax/employees/paginate?page=${page}`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: this.__('Loading') + '...'
            });

            axios.get(url, {
                params: this.searches
            }).then(res => {
                loading.close();
                this.employees = res.data.data;
                this.getOffices();
            })
            .catch(err => {
                loading.close();
                console.error(err);
            })
        },
        getOffices() {
            const url = `/admin/ajax/offices`;

            axios.get(url)
            .then(res => {
                this.offices = res.data.data;
            })
            .catch(err => {
                console.error(err);
            })
        },
        openModalAddEditShow(action, employee = null) {
            this.$refs.employeeFormAddEdit.showForm(action, employee);
        },
        updateList(action = null) {
            this.getEmployees(this.employees.current_page ?? 1 );
        },
        askDestroy(employee) {
            const self = this;
            Swal.fire({
                title: this.__('Are you sure you want to delete this record?'),
                text: this.__('If you delete this record, you will not be able to recover it'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#187de4',
                cancelButtonColor: '#d33',
                confirmButtonText: this.__("Yes, I'm sure!"),
                cancelButtonText: this.__('Cancel'),
            }).then((result) => {
                if (result.isConfirmed) {
                    self.destroy(employee.id);
                }
            });
        },
        destroy(id) {
            const url = `/admin/ajax/employees/${id}/destroy`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: this.__('Deleting') + '...'
            });

            axios.delete(url)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getEmployees();
            }).catch(err => {
                loading.close();
                if(err.response.data.message) {
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
        clearSearches() {
            this.searches = {
                office: '',
                name: '',
                email: '',
                softDelete: false
            };
        },
        changeStatus(employee) {
            const url = `/admin/ajax/employees/${employee.id}/status`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.put(url)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getEmployees();
            }).catch(err => {
                loading.close();
                if(err.response.data.message) {
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
        askForceDelete(employee) {
            const self = this;
            Swal.fire({
                title: this.__('Are you sure you want to delete this record?'),
                text: this.__('If you delete this record, you will not be able to recover it'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#187de4',
                cancelButtonColor: '#d33',
                confirmButtonText: this.__("Yes, I'm sure!"),
                cancelButtonText: this.__('Cancel'),
            }).then((result) => {
                if (result.isConfirmed) {
                    self.forceDelete(employee);
                }
            });
        },
        forceDelete(employee) {
            const url = `/admin/ajax/employees/${employee.id}/destroy/force-delete`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Deleting') + '...'
            });

            axios.delete(url)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getEmployees();
            }).catch(err => {
                loading.close();
                if(err.response.data.message) {
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
        restore(employee) {
            const url = `/admin/ajax/employees/${employee.id}/restore`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.put(url)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getEmployees();
            }).catch(err => {
                loading.close();
                if(err.response.data.message) {
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

    }
}
</script>

<style>
th {
    text-transform: uppercase;
}
.vs-select-content {
    max-width: none;
}
</style>
