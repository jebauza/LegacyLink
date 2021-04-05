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
                    <vs-select :key="offices.length" filter v-model="searches.office" :placeholder="__('Select')">
                        <vs-option v-for="office in offices" :key="office.id" :label="office.name" :value="office.id">{{ office.name }}</vs-option>
                    </vs-select>
                </div>

                <div class="col-sm-6 col-lg-4 form-group">
                    <label for="name" style="text-transform: uppercase;"><b>{{ __('validation.attributes.name') }}</b></label>
                    <input v-model="searches.name" type="text" class="form-control" name="name" :placeholder="__('validation.attributes.name')">
                </div>

                <div class="col-10 col-sm-5 col-lg-3 form-group">
                    <label for="declarant" style="text-transform: uppercase;"><b>declarante</b></label>
                    <input v-model="searches.declarant" type="text" class="form-control" name="declarant" placeholder="nif, email, nombre, teléfono">
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
                            <td>{{ profile.declarant ? profile.declarant.fullName : '' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <!-- <vs-tooltip bottom>
                                        <button  class="btn btn-sm btn-clean btn-icon mr-2" @click="openModalAddEditShow('show', profile)">
                                            <i class="far fa-eye"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Show') }}
                                        </template>
                                    </vs-tooltip>-->
                                    <vs-tooltip bottom>
                                        <button class="btn btn-sm btn-clean btn-icon mr-2" @click="openModalAddEditShow('edit', profile)">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Edit') }}
                                        </template>
                                    </vs-tooltip>
                                    <vs-tooltip bottom>
                                        <button class="btn btn-sm btn-clean btn-icon mr-2" @click="sendNotification(profile)">
                                            <i class="fa fa-comment-alt"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Send notification') }}
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

        <add-profile ref="AddFormProfile" @updateDeceasedProfileList="updateList()"></add-profile>

        <edit-profile ref="EditFormProfile" @updateDeceasedProfileList="updateList()"></edit-profile>

    </div>
<!--end::Card-->
</template>

<script>
import AddProfile from './AddProfileComponent';
import EditProfile from './EditProfileComponent';

export default {
    components: {AddProfile, EditProfile},

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
        'searches.declarant': function (newValue, oldValue) {
            this.getDeceasedProfiles();
        }
    },

    data() {
        return {
            deceasedProfiles: {data:[]},
            offices: [],

            searches: {
                office: '',
                name: '',
                declarant: ''
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
                    p.declarant = p.clients.find(client => client.pivot.declarant == true);
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
        openModalAddEditShow(action, profile = null) {

            if (action == 'add') {
                this.$refs.AddFormProfile.showForm(action, null);
            } else {
                this.$refs.EditFormProfile.showForm(action, profile);
            }
        },
        updateList(action = null) {
            this.getDeceasedProfiles(this.deceasedProfiles.current_page ?? 1 );
        },
        sendNotification(profile) {
            const url = `/admin/ajax/webs/${profile.id}/send-notification`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Sending') + '...'
            });

            axios.get(url)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    text: res.data.data ? res.data.data.message : '',
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                });
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
        askDestroy(profile) {
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
                    self.destroy(profile);
                }
            });
        },
        destroy(profile) {
            const url = `/admin/ajax/webs/${profile.id}/destroy`;
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
                this.getDeceasedProfiles();
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
                declarant: ''
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
