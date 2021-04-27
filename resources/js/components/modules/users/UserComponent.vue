<template>
<!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">{{ __('Clients') }}
                <span class="d-block text-muted pt-2 font-size-sm">{{ __('Client administration') }}</span></h3>
            </div>
            <div class="card-toolbar">
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
                    <!-- <label for="name" style="text-transform: uppercase;"><b>{{ __('Search') }}</b></label> -->
                    <input v-model="searches.search" type="text" class="form-control" name="search" :placeholder="__('Search')">
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

            <div v-if="clients.data.length" class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('validation.attributes.name') }}</th>
                            <th>{{ __('validation.attributes.email') }}</th>
                            <th>{{ __('validation.attributes.phone') }}</th>
                            <th>{{ 'NIF' }}</th>
                            <th class="justify-content-center">{{ __('Status') }}</th>
                            <th class="text-nowrap d-flex justify-content-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(client, index) in clients.data" :key="index" :class="[!client.is_active ? 'text-danger' : '']">
                            <th>{{ index + clients.from }}</th>
                            <td>{{ client.fullName }}</td>
                            <td>{{ client.email }}</td>
                            <td>{{ client.phone }}</td>
                            <td>{{ client.dni }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <vs-tooltip bottom>
                                        <button v-if="client.is_active" class="btn btn-sm btn-clean btn-icon mr-2 text-success">
                                            <i class="fas fa-lock-open"></i>
                                        </button>
                                        <button v-else class="btn btn-sm btn-clean btn-icon mr-2 text-danger">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ client.is_active ? __('To block') : __('Activate') }}
                                        </template>
                                    </vs-tooltip>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <vs-tooltip bottom>
                                        <button  class="btn btn-sm btn-clean btn-icon mr-2" @click="openModalAddEditShow('show', employee)">
                                            <i class="far fa-eye"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Show') }}
                                        </template>
                                    </vs-tooltip>
                                    <vs-tooltip bottom>
                                        <button class="btn btn-sm btn-clean btn-icon mr-2" @click="openModalAddEditShow('edit', employee)">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Edit') }}
                                        </template>
                                    </vs-tooltip>
                                    <vs-tooltip bottom>
                                        <button class="btn btn-sm btn-clean btn-icon mr-2" @click="askDestroy(employee)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Delete') }}
                                        </template>
                                    </vs-tooltip>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="clients" @pagination-change-page="getClients"></pagination>
            </div>
            <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                {{ __('There is no item to display') }}
            </div>

        </div>

        <!-- <employee-form-add-edit ref="employeeFormAddEdit" @updateEmployeeList="updateList()"></employee-form-add-edit> -->

    </div>
<!--end::Card-->
</template>

<script>
// import EmployeeFormAddEdit from './EmployeeFormAddEditComponent';

export default {
    // components: {EmployeeFormAddEdit},

    created() {
        this.getClients();
    },

    watch: {
        'searches.search': function (newValue, oldValue) {
            this.getClients();
        }
    },

    data() {
        return {
            clients: {data:[]},

            searches: {
                search: '',
            },
        }
    },

    methods: {
        getClients(page = 1) {
            const url = `admin/ajax/clients/paginate?page=${page}`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.get(url, {
                params: this.searches
            }).then(res => {
                loading.close();
                this.clients = res.data.data;
            })
            .catch(err => {
                loading.close();
                console.error(err);
            })
        },
        openModalAddEditShow(action, employee = null) {
            // this.$refs.employeeFormAddEdit.showForm(action, employee);
        },
        updateList(action = null) {
            // this.getClients(this.employees.current_page ?? 1 );
        },
        askDestroy(client) {
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
                    self.destroy(client.id);
                }
            });
        },
        destroy(id) {
            const url = `/admin/ajax/users/${id}/destroy`;
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
                this.getClients();
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
                email: ''
            };
        },

    }
}
</script>

<style>
th {
    text-transform: uppercase;
}
</style>
