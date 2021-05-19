<template>
<!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">{{ __('Clients') }}
                <span class="d-block text-muted pt-2 font-size-sm">{{ __('Client administration') }}</span></h3>
            </div>
            <div class="card-toolbar">
                <!-- <vs-checkbox danger v-model="searches.softDelete" class="mr-5">
                    <template #icon>
                        <i class='fas fa-trash text-white'></i>
                    </template> Eliminados
                </vs-checkbox> -->

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
                            <th class="text-center">{{ __('Status') }}</th>
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
                                    <template v-if="client.email_verified_at" >
                                        <span v-if="client.is_active" class="label label-light-success-green label-inline font-weight-bold py-4">{{ __('Active') }}</span>
                                        <span v-else class="label label-light-danger label-inline font-weight-bold py-4">{{ __('Locked') }}</span>
                                    </template>
                                    <template v-else >
                                        <span class="label label-light-warning label-inline font-weight-bold py-4">{{ __('Unverified') }}</span>
                                    </template>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <template v-if="client.deleted_at">
                                        <vs-tooltip bottom>
                                            <button  class="btn btn-sm btn-clean btn-icon mr-2 text-success" @click="restore(client)">
                                                <i class="fas fa-trash-restore-alt"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ __('Restore') }}
                                            </template>
                                        </vs-tooltip>
                                        <vs-tooltip bottom>
                                            <button  class="btn btn-sm btn-clean btn-icon mr-2 text-danger" @click="askForceDelete(client)">
                                                <i class="fas fa-dumpster-fire"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ __('Destroy') }}
                                            </template>
                                        </vs-tooltip>
                                    </template>
                                    <template v-else >
                                        <vs-tooltip bottom>
                                            <button  class="btn btn-sm btn-clean btn-icon mr-2 text-success" @click="openModalAddEditShow('show', client)">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ __('Show') }}
                                            </template>
                                        </vs-tooltip>
                                        <vs-tooltip bottom>
                                            <button class="btn btn-sm btn-clean btn-icon mr-2 text-success" @click="openModalAddEditShow('edit', client)">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ __('Edit') }}
                                            </template>
                                        </vs-tooltip>
                                        <vs-tooltip v-if="!client.email_verified_at" bottom>
                                            <button @click="resendVerificationMail(client)" class="btn btn-sm btn-clean btn-icon mr-2 text-warning">
                                                <i class="far fa-envelope"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ __('Resend verification email') }}
                                            </template>
                                        </vs-tooltip>
                                        <vs-tooltip v-if="!client.deleted_at" bottom>
                                            <button v-if="client.is_active" @click="changeStatus(client)" class="btn btn-sm btn-clean btn-icon mr-2 text-success-green">
                                                <i class="fas fa-lock-open"></i>
                                            </button>
                                            <button v-else @click="changeStatus(client)" class="btn btn-sm btn-clean btn-icon mr-2 text-danger">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                            <template #tooltip>
                                                {{ client.is_active ? __('To block') : __('Activate') }}
                                            </template>
                                        </vs-tooltip>
                                        <vs-tooltip bottom>
                                            <button class="btn btn-sm btn-clean btn-icon mr-2 text-danger" @click="askDestroy(client)">
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

                <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="clients" @pagination-change-page="getClients"></pagination>
            </div>
            <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                {{ __('There is no item to display') }}
            </div>

        </div>

        <user-form-add-edit ref="userFormAddEdit" @updateUserList="updateList()"></user-form-add-edit>

    </div>
<!--end::Card-->
</template>

<script>
import UserFormAddEdit from './UserFormAddEditComponent';

export default {
    components: {UserFormAddEdit},

    created() {
        this.getClients();
    },

    watch: {
        'searches.search': function (newValue, oldValue) {
            this.getClients();
        },
        'searches.softDelete': function (newValue, oldValue) {
            this.getClients();
        }
    },

    data() {
        return {
            clients: {data:[]},

            searches: {
                search: '',
                softDelete: false
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
        openModalAddEditShow(action, user = null) {
            this.$refs.userFormAddEdit.showForm(action, user);
        },
        updateList(action = null) {
            this.getClients(this.clients.current_page ?? 1 );
        },
        askDestroy(client) {
            const self = this;
            Swal.fire({
                title: this.__('Are you sure you want to delete this record?'),
                // text: this.__('If you delete this record, you will not be able to recover it'),
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
            const url = `/admin/ajax/clients/${id}/destroy`;
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
        askForceDelete(client) {
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
                    self.forceDelete(client);
                }
            });
        },
        forceDelete(client) {
            const url = `/admin/ajax/clients/${client.id}/destroy/force-delete`;
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
        restore(client) {
            const url = `/admin/ajax/clients/${client.id}/restore`;
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
        changeStatus(client) {
            const url = `/admin/ajax/clients/${client.id}/status`;
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
        resendVerificationMail(client) {
            const url = `/admin/ajax/clients/${client.id}/send/verification-mail`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.get(url)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
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
                search: '',
                softDelete: false
            };
        },

    }
}
</script>

<style scoped>
th {
    text-transform: uppercase;
}
</style>
