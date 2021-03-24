<template>
<!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Webs
                <span class="d-block text-muted pt-2 font-size-sm">{{ __('Employee administration') }}</span></h3>
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
                    <label style="text-transform: uppercase;"><b>{{ __('validation.attributes.dprofile_office') }}</b></label>
                        <select class="form-control" v-model="searches.office">
                            <option value=""></option>
                            <option v-for="(o, index) in offices" :key="index" :value="o.id">{{ o.name }}</option>
                        </select>
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

            <div v-if="deceasedProfiles.data.length" class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('validation.attributes.name') }}</th>
                            <th>Acesor</th>
                            <th>Declarante</th>
                            <th class="text-nowrap d-flex justify-content-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(profile, index) in deceasedProfiles.data" :key="index">
                            <th>{{ profile.id }}</th>
                            <td>{{ profile.name }} {{ profile.last_name }}</td>
                            <td>{{ profile.adviser ? profile.adviser.fullName : '' }}</td>
                            <td>{{ profile.admin ? profile.admin.fullName : '' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <vs-tooltip bottom>
                                        <button  class="btn btn-sm btn-clean btn-icon mr-2" @click="openModalAddEditShow('show', profile)">
                                            <i class="far fa-eye"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Show') }}
                                        </template>
                                    </vs-tooltip>
                                    <vs-tooltip bottom>
                                        <button class="btn btn-sm btn-clean btn-icon mr-2" @click="openModalAddEditShow('edit', profile)">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Edit') }}
                                        </template>
                                    </vs-tooltip>
                                    <vs-tooltip bottom>
                                        <button class="btn btn-sm btn-clean btn-icon mr-2" @click="askDestroy(profile)">
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

                <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="deceasedProfiles" @pagination-change-page="getDeceasedProfiles"></pagination>
            </div>
            <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                {{ __('There is no item to display') }}
            </div>

        </div>

        <deceased-profile-form-add-edit ref="deceasedProfileFormAddEdit" @updateDeceasedProfileList="updateList()"></deceased-profile-form-add-edit>

    </div>
<!--end::Card-->
</template>

<script>
import DeceasedProfileFormAddEdit from './DeceasedProfileFormAddEditComponent';

export default {
    components: {DeceasedProfileFormAddEdit},

    created() {
        this.getDeceasedProfiles();
    },

    watch: {
        'searches.office': function (newValue, oldValue) {
            this.getDeceasedProfiles();
        },
        'searches.name': function (newValue, oldValue) {
            this.getDeceasedProfiles();
        },
        'searches.email': function (newValue, oldValue) {
            this.getDeceasedProfiles();
        }
    },

    data() {
        return {
            deceasedProfiles: {data:[]},
            offices: [],

            searches: {
                name: '',
                email: ''
            },
        }
    },

    methods: {
        getDeceasedProfiles(page = 1) {
            const url = `admin/ajax/webs/paginate?page=${page}`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.get(url, {
                params: this.searches
            }).then(res => {
                loading.close();
                this.getOffices()
                this.deceasedProfiles = res.data.data;
                this.deceasedProfiles.data = this.deceasedProfiles.data.map(p => {
                    p.admin = p.clients.find(client => client.pivot.role === 'admin');
                    return p;
                });
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
            this.$refs.deceasedProfileFormAddEdit.showForm(action, employee);
        },
        updateList(action = null) {
            this.getDeceasedProfiles(this.deceasedProfiles.current_page ?? 1 );
        },
        /* askDestroy(employee) {
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
        }, */
        clearSearches() {
            this.searches = {
                name: '',
                email: '',
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
